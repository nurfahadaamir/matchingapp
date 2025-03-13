<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedMatch extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'blocked_user_id'];
}

