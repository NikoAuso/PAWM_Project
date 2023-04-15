<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TriggerNewUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER tr_User_Default_Username BEFORE INSERT ON users FOR EACH ROW
            BEGIN
                DECLARE NewUsername VARCHAR(100);
                IF NEW.username IS NULL OR NEW.username = \'\' THEN
                    SET NewUsername = CONCAT(NEW.name, NEW.surname);
                    SET NewUsername = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(NewUsername,\'á\',\'a\'),\'à\',\'a\'),\'â\',\'a\'),\'ã\',\'a\'),\'ä\',\'a\');
                    SET NewUsername = REPLACE(REPLACE(REPLACE(REPLACE(NewUsername,\'é\',\'e\'),\'è\',\'e\'),\'ê\',\'e\'),\'ë\',\'e\');
                    SET NewUsername = REPLACE(REPLACE(REPLACE(REPLACE(NewUsername,\'í\',\'i\'),\'ì\',\'i\'),\'î\',\'i\'),\'ï\',\'i\');
                    SET NewUsername = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(NewUsername,\'ó\',\'o\'),\'ò\',\'o\'),\'ô\',\'o\'),\'õ\',\'o\'),\'ö\',\'o\');
                    SET NewUsername = REPLACE(REPLACE(REPLACE(REPLACE(NewUsername,\'ú\',\'u\'),\'ù\',\'u\'),\'û\',\'u\'),\'ü\',\'u\');

                    SET NewUsername = REPLACE(NewUsername,\'ý\',\'y\');
                    SET NewUsername = REPLACE(NewUsername,\'ñ\',\'n\');
                    SET NewUsername = REPLACE(NewUsername,\'ç\',\'c\');

                    SET NEW.username = TRIM(NewUsername);
                END IF;
            END;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_User_Default_Username`');
    }
}
