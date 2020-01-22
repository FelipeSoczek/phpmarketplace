<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable; //serve para enviar notificações pro usuario: Ex sms, email etc

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [ //Quando eu chamo o all tudo que tiver aqui dentro é escondido, ex senha e token.
        'password', 'remember_token',
    ];

    protected $casts = [ //Tudo que for colocado aqui pode ser convertido. Ex 'name' => 'boolean'
        'email_verified_at' => 'datetime',
    ];

    public function store() { //aqui ele procura la dentro da base de dados o id
        return $this->hasOne(Store::class);
    }

    public function orders() {
        return $this->hasMany(UserOrder::class);
    }

}
