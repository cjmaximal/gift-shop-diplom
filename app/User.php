<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'name',
        'email',
        'phone',
        'password',
        'address_index',
        'address_city',
        'address_street',
        'address_home',
        'address_block',
        'address_apartment',
        'address_porch',
        'address_comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = title_case($value);
    }

    public function setSurnameAttribute($value)
    {
        $this->attributes['surname'] = title_case($value);
    }

    public function setPatronymicAttribute($value)
    {
        $this->attributes['patronymic'] = title_case($value);
    }
}
