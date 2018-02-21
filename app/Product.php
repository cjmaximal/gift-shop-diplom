<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Categories relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
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
     * Name attribute mutator
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * Slug attribute mutator
     *
     * @param null $value
     */
    public function setSlugAttribute($value = null)
    {
        if (empty($value)) {
            $slug = str_slug($this->attributes['name'], '-');
        } else {
            $slug = str_slug($value, '-');
        }

        $this->attributes['slug'] = $slug;
    }

}
