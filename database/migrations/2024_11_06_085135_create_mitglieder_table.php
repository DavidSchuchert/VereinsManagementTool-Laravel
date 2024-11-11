<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mitglieder', function (Blueprint $table) {
            $table->id();
            $table->string('mitgliedsnummer');
            $table->string('vorname');
            $table->string('nachname');
            $table->date('geburtsdatum');
            $table->integer('plz');
            $table->string('ort');
            $table->string('strasse');
            $table->string('hausnummer');
            $table->string('telefon')->nullable();
            $table->string('email')->nullable();
            $table->date('eintrittsdatum');
            $table->date('austrittsdatum')->nullable();
            $table->unsignedBigInteger('rang_id');
            $table->string('file_path')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rang_id')->references('id')->on('rangarten')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitglieder');
    }
};
