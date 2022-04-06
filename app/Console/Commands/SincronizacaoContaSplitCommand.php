<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PJBank\Package\Support\ConsumeSupport;
use PJBank\Package\Support\SynchronizeTableSupport;

class SincronizacaoContaSplitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contasplit:sincronizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronização de conta split';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private ConsumeSupport $consumeSupport,
        private SynchronizeTableSupport $synchronizeTableSupport
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rules = [
            'credencial' => 'required',
            'nome' => 'required',
            'cpfcnpj' => 'required',
            'banco' => 'required',
            'agencia' => 'required',
            'conta' => 'required',
        ];

        $this->consumeSupport->function('conta_splits', 'app.ms_cobrancas.table.conta_splits.*', $rules, function ($data) {
            $this->synchronizeTableSupport->sync('contas', "credencial", $data["credencial"], [
                'credencial' => $data['credencial'],
                'nome' => $data['nome'],
                'cpfcnpj' => $data['cpfcnpj'],
                'banco_codigo' => $data['banco'],
                'banco_agencia' => $data['agencia'],
                'banco_conta' => $data['conta'],
            ]);
        });
    }
}
