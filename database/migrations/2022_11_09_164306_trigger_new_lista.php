<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TriggerNewLista extends Migration
{
    /**
     * These triggers transform the "lista" details into uppercase
     *
     * @return void
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER tr_Lista_Uppercase_Nome
            BEFORE INSERT
            ON liste
            FOR EACH ROW
            SET NEW.name = UPPER(NEW.name);');
        DB::unprepared('
            CREATE TRIGGER tr_Lista_Uppercase_Cognome
            BEFORE INSERT
            ON liste
            FOR EACH ROW
            SET NEW.surname = UPPER(NEW.surname);');
        DB::unprepared('
            CREATE TRIGGER tr_Lista_Uppercase_Nome_Update
            BEFORE UPDATE
            ON liste
            FOR EACH ROW
            SET NEW.name = UPPER(NEW.name);');
        DB::unprepared('
            CREATE TRIGGER tr_Lista_Uppercase_Cognome_Update
            BEFORE UPDATE
            ON liste
            FOR EACH ROW
            SET NEW.surname = UPPER(NEW.surname);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER `tr_Lista_Uppercase_Nome`');
        DB::unprepared('DROP TRIGGER `tr_Lista_Uppercase_Cognome`');
        DB::unprepared('DROP TRIGGER `tr_Lista_Uppercase_Nome_Update`');
        DB::unprepared('DROP TRIGGER `tr_Lista_Uppercase_Cognome_Update`');
    }
}
