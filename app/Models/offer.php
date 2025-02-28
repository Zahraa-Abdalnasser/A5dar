<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class offer extends Model
{
    use HasFactory;

    protected $fillable = ['offer_name', 'amount', 'unit_price', 'status', 'unit_id', 'cat_id', 'image_path'];

    protected $appends = ['image_url']; // Automatically add image_url to the JSON response
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    // Accessor to generate the full image URL
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }
}
