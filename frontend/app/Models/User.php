<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use LdapRecord\Laravel\Traits\LdapUser;
use LdapRecord\Models\Concerns\HasAttributes;

class User extends Authenticatable
{
    // formulario
    protected $fillable = [
        'name', 'password',
    ];

    //  ocultos para los arrays
    protected $hidden = [
        'password', 'remember_token',
    ];

    // atributos LDAP que deben ser sincronizados
    protected $ldapAttributes = [
        'name' => 'cn',
    ];
}
