<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ListeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('liste', function (Blueprint $table) {
            $table->id('list_id');
            $table->foreignId('event_id');
            $table->string('name', 50);
            $table->string('surname', 50);
            $table->integer('quantity');
            $table->integer('entered');
            $table->foreignId('fatto_da');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('created_by');
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('fatto_da')->references('id')->on('users')->onUpdate('cascade')->onDelete('no action');
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
        Schema::dropIfExists('liste');
    }
}
