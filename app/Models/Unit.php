<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    public $timestamps = false; // ✅ Prevents Laravel from inserting timestamps
    protected $fillable = ['name'];
}
