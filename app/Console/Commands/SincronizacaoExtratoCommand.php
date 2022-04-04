<?php

namespace App\Console\Commands;

use App\Services\ExtratoService;
use Illuminate\Console\Command;
use PJBank\Package\Support\ConsumeSupport;

class SincronizacaoExtratoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extrato:sincronizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronização do extrato';

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
        $consumeSupport->service(
            "app.ms_extratos.table.extratos.created",
            ExtratoService::class,
            'cadastrarNovoRepasse'
        );
    }
}
