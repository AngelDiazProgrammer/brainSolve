from ldap3 import Server, Connection, ALL

# Configuración del servidor LDAP
server_address = 'ldap://172.27.163.36:389'
admin_user_dn = 'CN=admin,CN=Managed Service Accounts,DC=angel,DC=col'  # Distinguished Name (DN) del administrador LDAP
admin_password = 'Colombia2024'

# Establecer conexión con el servidor LDAP
try:
    server = Server(server_address, get_info=ALL)
    conn = Connection(server, user=admin_user_dn, password=admin_password, auto_bind=True)
    print("Conexión exitosa al servidor LDAP")
except Exception as e:
    print(f"Error al conectar al servidor LDAP: {e}")
    exit(1)

# Definir la base de búsqueda y el filtro para buscar un usuario de prueba
search_base = 'DC=angel,DC=col'
search_filter = '(sAMAccountName=admin)'

# Realizar la búsqueda
conn.search(search_base, search_filter, attributes=['cn', 'mail'])

if conn.entries:
    print(f"Usuario encontrado: {conn.entries[0]}")
else:
    print("Usuario no encontrado")
