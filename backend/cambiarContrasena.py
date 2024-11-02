from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from ldap3 import Server, Connection, ALL, MODIFY_REPLACE
import logging

app = FastAPI()

# Configurar el registro de logs
logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger('ldap3')

# Modelo de los datos que recibirás desde Laravel
class PasswordChangeRequest(BaseModel):
    username: str
    new_password: str

# Función para cambiar la contraseña usando LDAP
def cambiar_contrasena_ldap(username: str, new_password: str):
    # Configuración del servidor LDAP
    server_address = 'ldap://172.27.163.36'
    admin_user_dn = 'CN=admin,CN=Managed Service Accounts,DC=angel,DC=col'  # Distinguished Name (DN) del administrador LDAP
    admin_password = 'Colombia2024'

    # Establecer conexión con el servidor LDAP
    try:
        server = Server(server_address, get_info=ALL)
        conn = Connection(server, user=admin_user_dn, password=admin_password, auto_bind=True)
    except Exception as e:
        logger.error("Error al conectar al servidor LDAP: %s", str(e))
        raise HTTPException(status_code=500, detail="Error al conectar al servidor LDAP.")

    # Definir la base de búsqueda y el filtro para encontrar al usuario
    search_base = 'DC=angel,DC=col'  # Base DN del dominio
    search_filter = f'(sAMAccountName={username})'

    # Buscar al usuario en el LDAP
    conn.search(search_base, search_filter, attributes=['distinguishedName'])

    if conn.entries:
        # Obtener el DN del usuario encontrado
        user_dn = conn.entries[0].distinguishedName.value
        logger.debug("DN del usuario encontrado: %s", user_dn)

        # Formatear la nueva contraseña en formato Unicode y UTF-16LE (requerido por Active Directory)
        new_password_formatted = f'"{new_password}"'.encode('utf-16-le')

        # Cambiar la contraseña del usuario
        try:
            conn.modify(user_dn, {'unicodePwd': [(MODIFY_REPLACE, [new_password_formatted])]})
        except Exception as e:
            logger.error("Error al cambiar la contraseña: %s", str(e))
            raise HTTPException(status_code=400, detail="Error al cambiar la contraseña: " + str(e))

        # Verificar si el cambio fue exitoso
        if conn.result['description'] == 'success':
            return {"status": "success", "message": "Contraseña cambiada con éxito"}
        else:
            logger.error("Resultado del cambio de contraseña: %s", conn.result['message'])
            raise HTTPException(status_code=400, detail=conn.result['message'])
    else:
        logger.warning("Usuario no encontrado: %s", username)
        raise HTTPException(status_code=404, detail="Usuario no encontrado")

# Ruta de la API para recibir la solicitud de cambio de contraseña
@app.post("/cambiarContrasena")
async def cambiar_contrasena(request: PasswordChangeRequest):
    try:
        resultado = cambiar_contrasena_ldap(request.username, request.new_password)
        return resultado
    except HTTPException as e:
        logger.error("HTTPException: %s", str(e.detail))
        raise HTTPException(status_code=e.status_code, detail=str(e.detail))
    except Exception as e:
        logger.error("Error inesperado: %s", str(e))
        raise HTTPException(status_code=400, detail="Error inesperado: " + str(e))
