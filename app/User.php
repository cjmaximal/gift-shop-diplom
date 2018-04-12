<?php

namespace App;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
        'is_admin',
        'password',
        'address_index',
        'address_city',
        'address_street',
        'address_home',
        'address_block',
        'address_porch',
        'address_apartment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];


    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Orders relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Products relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count');
    }

    /**
     * Name attribute mutator
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Helpers::ucfirst_utf8($value);
    }

    /**
     * Surname attribute mutator
     *
     * @param $value
     */
    public function setSurnameAttribute($value = null)
    {
        if ($value) {
            $this->attributes['surname'] = Helpers::ucfirst_utf8($value);
        }
    }

    /**
     * Patronymic attribute mutator
     *
     * @param $value
     */
    public function setPatronymicAttribute($value = null)
    {
        if ($value) {
            $this->attributes['patronymic'] = Helpers::ucfirst_utf8($value);
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function getFullNameAttribute()
    {
        return trim(implode(' ', [
            $this->surname,
            $this->name,
            $this->patronymic,
        ]));
    }
}
