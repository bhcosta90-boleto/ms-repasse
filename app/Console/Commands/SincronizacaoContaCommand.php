<?php

namespace App\Console\Commands;

use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Console\Command;
use PJBank\Package\Services\ValidateTrait;
use PJBank\Package\Support\ConsumeSupport;

class SincronizacaoContaCommand extends Command
{
    use ValidateTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conta:sincronizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronização das contas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ConsumeSupport $consumeSupport)
    {
        $consumeSupport->consume('contas', [
            'credencial' => 'required',
            'status' => 'required',
            'banco_codigo' => 'required',
            'banco_agencia' => 'required',
            'banco_conta' => 'required',
        ], "app.ms_contas.table.contas.*", 'credencial');
    }
}
