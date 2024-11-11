<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZahlungenTable extends Migration
{
    public function up()
    {
        Schema::create('zahlungen', function (Blueprint $table) {
            $table->id();
            $table->decimal('betrag', 10, 2);
            $table->date('datum');
            $table->unsignedBigInteger('zahlungsart_id');
            $table->enum('typ', ['Einnahme', 'Ausgabe']);
            $table->text('beschreibung')->nullable();
            $table->string('rechnungsnr', 50)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        
            // Fremdschlüssel setzen
            $table->foreign('zahlungsart_id')->references('id')->on('zahlungsarten')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('zahlungen');
    }
}

