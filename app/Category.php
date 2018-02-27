<?php

namespace App;

use App\Http\Helpers;
use Cache;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
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
     * Products relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
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
