<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TriggerNewTavolo extends Migration
{
    /**
     * These triggers transform the table name into uppercase
     *
     * @return void
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER tr_Tavolo_Uppercase_Name
            BEFORE INSERT
            ON tavoli_eventi
            FOR EACH ROW
            SET NEW.nome = UPPER(NEW.nome);');
        DB::unprepared('
            CREATE TRIGGER tr_Tavolo_Uppercase_Name_Update
            BEFORE UPDATE
            ON tavoli_eventi
            FOR EACH ROW
            SET NEW.nome = UPPER(NEW.nome);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `tr_Tavolo_Uppercase_Name`');
        DB::unprepared('DROP TRIGGER `tr_Tavolo_Uppercase_Name_Update`');
    }
}
