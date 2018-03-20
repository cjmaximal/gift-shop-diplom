<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_SHIPPED = 3;
    const STATUS_PROCESSED = 4;
    const STATUS_CANCELLED = 5;

    protected static $statuses = [
        1 => 'Новый',
        2 => 'В работе',
        3 => 'Отправлен',
        4 => 'Завершен',
        5 => 'Отменен',
    ];

    protected $fillable = [
        'address',
        'comment',
        'full_name',
        'phone',
        'status',
    ];


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
        return $this->belongsToMany(Product::class)->withPivot('count', 'price');
    }

    /**
     * Get statuses
     *
     * @return array
     */
    public static function getStatuses(): array
    {
        return self::$statuses;
    }
}
