<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->datetime('date')->nullable();
            $table->string('titolo',50);
            $table->string('extra',150)->nullable();
            $table->enum('discoteca',  ['MAMAMIA', 'MIAMI', 'NOIR', 'DIRETTA INSTAGRAM'])->nullable();
            $table->text('descrizione')->nullable();
            $table->integer('prevendite')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('deleted')->default(false);
            $table->boolean('isJolly')->default(false);
            $table->boolean('pagato')->default(false);
            $table->foreignId('created_by')->default(1);
            $table->foreignId('updated_by')->default(1);
            $table->dateTime('created_at')->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
}
