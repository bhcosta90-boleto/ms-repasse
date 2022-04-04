<?php

use App\Models\Conta;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ContaControllerErrorTest extends TestCase
{
    public function test_obrigatorio()
    {
        $response = $this->json('POST', 'contas', []);

        $response->seeJson([
            Lang::get('validation.required', ['attribute' => 'nome'])
        ]);

        $response->seeJson([
            Lang::get('validation.required', ['attribute' => 'email'])
        ]);

        $response->seeJson([
            Lang::get('validation.required', ['attribute' => 'cpfcnpj'])
        ]);

        $response->seeJson([
            Lang::get('validation.required', ['attribute' => 'telefone'])
        ]);
    }

    public function test_min()
    {
        $response = $this->json('POST', 'contas', [
            'nome' => 'a',
            'email' => 'a',
            'cpfcnpj' => 'a',
            'telefone' => 'a',
        ]);

        $response->seeJson([
            Lang::get('validation.min.string', ['attribute' => 'nome', 'min' => 3])
        ]);

        $response->seeJson([
            Lang::get('validation.min.string', ['attribute' => 'email', 'min' => 3])
        ]);

        $response->seeJson([
            Lang::get('validation.min.string', ['attribute' => 'cpfcnpj', 'min' => 11])
        ]);

        $response->seeJson([
            Lang::get('validation.min.string', ['attribute' => 'telefone', 'min' => 8])
        ]);
    }

    public function test_max()
    {
        $response = $this->json('POST', 'contas', [
            'nome' => str_repeat('a', 500),
            'email' => str_repeat('a', 500),
            'cpfcnpj' => str_repeat('a', 500),
            'telefone' => str_repeat('a', 500),
        ]);

        $response->seeJson([
            Lang::get('validation.max.string', ['attribute' => 'nome', 'max' => 150])
        ]);

        $response->seeJson([
            Lang::get('validation.max.string', ['attribute' => 'email', 'max' => 100])
        ]);

        $response->seeJson([
            Lang::get('validation.max.string', ['attribute' => 'cpfcnpj', 'max' => 14])
        ]);

        $response->seeJson([
            Lang::get('validation.max.string', ['attribute' => 'telefone', 'max' => 20])
        ]);
    }

    public function test_email()
    {
        $response = $this->json('POST', 'contas', [
            'nome' => str_repeat('a', 500),
            'email' => str_repeat('a', 500),
            'cpfcnpj' => str_repeat('a', 500),
            'telefone' => str_repeat('a', 500),
        ]);

        $response->seeJson([
            Lang::get('validation.email', ['attribute' => 'email'])
        ]);
    }
}
