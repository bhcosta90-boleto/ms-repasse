<?php

namespace App\Services;

use App\Models\Repasse;
use PJBank\Package\Services\ValidateTrait;

final class RepasseService
{
    use ValidateTrait;

    public function __construct(private Repasse $repasse)
    {
        //
    }

    public function cadastrarNovoRepasse($data)
    {
        $newData = $this->validate($data, [
            'valor_extrato' => 'required|numeric',
            'credencial' => 'required|string|min:40|max:40',
            'uuid' => 'required|uuid',
            'cobranca_id' => 'required|uuid',
            'data_creditocliente' => 'required|date_format:Y-m-d',
            'movimentacao' => 'required',
        ]);

        return $this->repasse->create([
            'credencial' => $newData['credencial'],
            'extrato_id' => $newData['uuid'],
            'cobranca_id' => $newData['cobranca_id'],
            'valor_repasse' => $newData['valor_extrato'],
            'data_credito' => $newData['data_creditocliente'],
        ]);
    }
}
