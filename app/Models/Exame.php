<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'consulta_id',
        'medico',
        'descricao',
        'prescricao',
        'data',
    ];
}
