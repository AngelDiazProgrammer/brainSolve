#recibir variables desde Python
param (
    [string]$username,
    [SecureString]$new_password
)
#Cambio de contraseña
Set-ADAccountPassword -Identity $username -NewPassword (ConvertTo-SecureString -AsPlainText $new_password -Force)

#Desbloquear usuario
Unlock-ADAccount -Identity $username
