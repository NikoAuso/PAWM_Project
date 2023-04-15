<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TavoliEventiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tavoli_eventi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->string('nome', 50);
            $table->integer('persone');
            $table->string('etaMedia', 10)->nullable();
            $table->string('dettagli', 100)->nullable();
            $table->foreignId('fattoDa');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
            $table->string('created_at');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fattoDa')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tavoli_eventi');
    }
}
