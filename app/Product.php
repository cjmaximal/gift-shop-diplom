<?php

namespace App;

use App\Http\Helpers;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_available',
    ];

    protected $dates = [
        'deleted_at',
    ];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = str_slug($model->name);
            Cache::forget('categories');
        });
    }

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Categories relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->orderBy('name');
    }

    /**
     * Orders relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    /**
     * Images relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class)->orderBy('is_default', 'desc');
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

}
