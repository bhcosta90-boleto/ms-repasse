<?php

use App\Models\Conta;
use Illuminate\Support\Facades\Lang;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class ContaControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_cadastrar()
    {
        $response = $this->json('POST', 'contas', [
            'nome' => 'teste',
            'email' => 'teste@email.com',
            'cpfcnpj' => '99999999999',
            'telefone' => '99999999',
        ]);

        $response->assertResponseStatus(201);

        $this->seeInDatabase('contas', [
            'credencial' => $response->response->json('data.credencial'),
            'chave' => sha1($response->response->json('data.chave')),
        ]);
    }

    public function test_banco_emissor_erro()
    {
        $conta = Conta::factory()->create();

        $response = $this->json('PUT', 'contas/' . $conta->uuid . '/bancoemissor', []);

        $response->seeJson([
            Lang::get('validation.required', ['attribute' => 'banco emissor'])
        ]);

        $response = $this->json('PUT', 'contas/' . $conta->uuid . '/bancoemissor', ['banco_emissor' => 'a']);

        $response->seeJson([
            Lang::get('validation.uuid', ['attribute' => 'banco emissor'])
        ]);
    }

    public function test_banco_emissor()
    {
        $conta = Conta::factory()->create();

        $response = $this->json('PUT', 'contas/' . $conta->credencial . '/bancoemissor', [
            'banco_emissor' => $bancoEmissor = str()->uuid(),
        ]);

        $response->assertResponseStatus(200);

        $this->seeInDatabase('contas', [
            'credencial' => $conta->credencial,
            'banco_emissor_id' => $bancoEmissor,
        ]);
    }

}
