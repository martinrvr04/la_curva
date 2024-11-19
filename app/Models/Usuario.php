<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * Tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'usuarios'; // Asegúrate de que esto coincida con el nombre de tu tabla de usuarios

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'pais',
        'ciudad_nacimiento',
        'fecha_nacimiento',
        'rol',
        'email_verified_at',
    ];

    /**
     * Atributos que deben estar ocultos para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Configura el mutador para encriptar la contraseña.
     *
     * @param string $value
     * @return void
     */
  //  public function setPasswordAttribute($value)
    //{
      //  $this->attributes['password'] = bcrypt($value);
    //}


    // app/Models/User.php

public function reservas()
{
    
    return $this->hasMany(Reserva::class, 'usuario'); // <-- Usar 'usuario' aquí
}
}
