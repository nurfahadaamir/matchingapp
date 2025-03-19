<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IneligibleUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reasons'];

    protected $casts = [
        'reasons' => 'array' // Convert JSON data into an array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
