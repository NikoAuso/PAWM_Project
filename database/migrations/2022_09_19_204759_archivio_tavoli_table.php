<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArchivioTavoliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('archivio_tavoli', function (Blueprint $table) {
            $table->id();
            $table->string('nome_stagione', 50)->unique();
            $table->string('pdf_tavoli', 100);
            $table->string('pdf_classifica', 100);
            $table->string('csv_tavoli', 100);
            $table->text('dettagli');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('archivio_tavoli');
    }
}
