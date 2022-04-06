<?php

namespace App\Console\Commands;

use App\Models\Repasse;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        $this->consumeSupport->function('conta_splits', 'app.ms_cobrancas.table.conta_splits.created', $rules, function ($data) {
            $this->synchronizeTableSupport->sync('contas', "credencial", $data["credencial"], [
                'credencial' => $data['credencial'],
                'nome' => $data['nome'],
                'cpfcnpj' => $data['cpfcnpj'],
                'banco_codigo' => $data['banco'],
                'banco_agencia' => $data['agencia'],
                'banco_conta' => $data['conta'],
            ]);

            Repasse::create([
                'credencial' => $data['credencial'],
                'valor_repasse' => 0.01,
                'data_credito' => Carbon::now()->format('Y-m-d'),
                'aprovado' => true,
            ]);
        });
    }
}
