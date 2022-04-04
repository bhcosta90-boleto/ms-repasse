<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PJBank\Package\Models\Traits\UuidGenerate;

class Repasse extends Model
{
    use UuidGenerate;

    public $fillable = [
        'credencial',
        'extrato_id',
        'cobranca_id',
        'valor_repasse',
        'valor_extrato',
        'data_credito',
    ];
}
