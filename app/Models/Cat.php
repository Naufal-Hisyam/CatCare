<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name', 
        'breed', 
        'age', 
        'gender', 
        'description', 
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}