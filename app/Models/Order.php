<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    protected $fillable = [
        'user_id', 'offer_id', 'total_amount', 'to_city', 'to_street', 'order_price', 'status'
    ];



    public function offer()
    {
        return $this->belongsTo(offer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

