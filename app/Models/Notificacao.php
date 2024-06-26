<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;
    protected $table = 'notificacao';
    protected $fillable = [
        'user_id',
        'title',
        'data',
        'hora',
    ];
}
