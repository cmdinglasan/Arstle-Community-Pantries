<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['facebook', 'twitter', 'instagram'];

    protected $hidden = ['id', 'created_at', 'updated_at'];
}
