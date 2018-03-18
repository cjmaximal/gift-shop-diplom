<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_PROCESSED = 3;
    const STATUS_CANCELLED = 4;

    protected $statuses = [
        1 => 'Новый',
        2 => 'В работе',
        3 => 'Завершен',
        4 => 'Отменен',
    ];

    protected $fillable = [
        'address',
        'comment',
        'full_name',
        'phone',
        'status',
        'total',
    ];


    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $products = $model->products;
            $model->total = collect($products)->map(function ($item) {
                $sum = round($item['orderItem']['price'] * $item['orderItem']['count'], 2);

                return [$sum];
            })->sum();
        });
    }

    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Products relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->as('orderItem')
            ->withPivotValue('count')
            ->withPivotValue('price');
    }

    /**
     * Get statuses
     *
     * @return array
     */
    public function getStatuses(): array
    {
        return $this->statuses;
    }
}
