<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repasses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('credencial', 40);
            $table->uuid('extrato_id')->nullable();
            $table->uuid('cobranca_id')->nullable();
            $table->unsignedDouble('valor_repasse');
            $table->date('data_credito');
            $table->boolean('aprovado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repasses');
    }
};
