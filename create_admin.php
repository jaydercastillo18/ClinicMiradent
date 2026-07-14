<?php
use App\Models\User;
use App\Models\Doctora;

$user = User::updateOrCreate(
    ['email' => 'miradentdentalclinic@gmail.com'],
    [
        'name' => 'Dra. Miranda',
        'password' => bcrypt('admin1234'),
        'role' => 'doctora'
    ]
);

Doctora::updateOrCreate(
    ['user_id' => $user->id],
    [
        'especialidad' => 'Odontología General',
        'COP' => '50039'
    ]
);

echo "¡Usuario Administrador Creado Exitosamente!\n";
