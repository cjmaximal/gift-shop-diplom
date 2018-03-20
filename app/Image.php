<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    const DEFAULT_IMAGE = 'no-image.png';

    protected $fillable = [
        'src',
        'is_default',
    ];

    public static function boot()
    {
        static::deleting(function ($model) {
            \Storage::disk('public')->delete($model->src);
        });

        parent::boot();
    }

    /**
     * Product relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
