<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add SoftDeletes to tables that are missing it
        Schema::table('protokolle', function (Blueprint $table) {
            if (!Schema::hasColumn('protokolle', 'deleted_at')) {
                $table->softDeletes();
            }
            $table->index('created_at');
            if (Schema::hasColumn('protokolle', 'user_id')) {
                $table->index('user_id');
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('rangarten', function (Blueprint $table) {
            if (!Schema::hasColumn('rangarten', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('zahlungsarten', function (Blueprint $table) {
            if (!Schema::hasColumn('zahlungsarten', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Add Performance Indexes
        Schema::table('mitglieder', function (Blueprint $table) {
            if (Schema::hasColumn('mitglieder', 'mitgliedsnummer')) $table->index('mitgliedsnummer');
            if (Schema::hasColumn('mitglieder', 'email')) $table->index('email');
            if (Schema::hasColumn('mitglieder', 'nachname')) $table->index('nachname');
            if (Schema::hasColumn('mitglieder', 'austrittsdatum')) $table->index('austrittsdatum');
        });

        Schema::table('inventar', function (Blueprint $table) {
            if (Schema::hasColumn('inventar', 'artikel')) $table->index('artikel');
            if (Schema::hasColumn('inventar', 'ean')) $table->index('ean');
            
            if (!Schema::hasColumn('inventar', 'lagerstandort')) {
                $table->string('lagerstandort')->nullable();
            }
            $table->index('lagerstandort');

            if (!Schema::hasColumn('inventar', 'kategorie_id')) {
                $table->unsignedBigInteger('kategorie_id')->nullable();
            }
            $table->index('kategorie_id');
        });

        Schema::table('zahlungen', function (Blueprint $table) {
            if (Schema::hasColumn('zahlungen', 'datum')) $table->index('datum');
            if (Schema::hasColumn('zahlungen', 'typ')) $table->index('typ');
            if (Schema::hasColumn('zahlungen', 'rechnungsnr')) $table->index('rechnungsnr');
            if (Schema::hasColumn('zahlungen', 'zahlungsart_id')) $table->index('zahlungsart_id');
        });



        Schema::table('document_uploads', function (Blueprint $table) {
            if (Schema::hasColumn('document_uploads', 'title')) $table->index('title');
            if (Schema::hasColumn('document_uploads', 'file_type')) $table->index('file_type');
            if (Schema::hasColumn('document_uploads', 'uploaded_by')) $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Standard down methods are skipped here for brevity as this is an optimization migration
    }
};
