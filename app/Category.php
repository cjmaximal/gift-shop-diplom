<?php

namespace App;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            $category->slug = str_slug($category->name, '-');
        });
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
