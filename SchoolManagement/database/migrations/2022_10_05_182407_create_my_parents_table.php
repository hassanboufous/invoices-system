<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_parents', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');

            // Father information --------
            $table->string('father_name');
            $table->string('father_phone');
            $table->string('father_passport');
            $table->string('father_identity');
            $table->string('father_job');
            $table->foreignId('father_nationality_id')->constrained('nationalities');
            $table->foreignId('father_blood_type_id')->constrained('blood_types');
            $table->foreignId('father_religion_id')->constrained('religions');
            $table->string('father_address');

            // Mother information -------
            $table->string('mother_name');
            $table->string('mother_passport');
            $table->string('mother_phone');
            $table->string('mother_job');
            $table->foreignId('mother_nationality_id')->constrained('nationalities');
            $table->foreignId('mother_blood_type_id')->constrained('blood_types');
            $table->foreignId('mother_religion_id')->constrained('religions');
            $table->string('mother_address');
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
        Schema::dropIfExists('my_parents');
    }
}
