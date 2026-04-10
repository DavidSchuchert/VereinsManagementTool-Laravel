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
            $table->index('user_id');
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
            $table->index('mitgliedsnummer');
            $table->index('email');
            $table->index('nachname');
            $table->index('austrittsdatum');
        });

        Schema::table('inventar', function (Blueprint $table) {
            $table->index('artikel');
            $table->index('ean');
            $table->index('lagerstandort');
            $table->index('kategorie_id');
        });

        Schema::table('zahlungen', function (Blueprint $table) {
            $table->index('datum');
            $table->index('typ');
            $table->index('rechnungsnr');
            $table->index('zahlungsart_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('event_date');
        });

        Schema::table('document_uploads', function (Blueprint $table) {
            $table->index('title');
            $table->index('file_type');
            $table->index('uploaded_by');
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
