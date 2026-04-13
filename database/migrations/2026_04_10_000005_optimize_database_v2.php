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
            
            $indexes = Schema::getIndexes('protokolle');
            $indexNames = collect($indexes)->pluck('name')->toArray();
            
            if (!in_array('protokolle_created_at_index', $indexNames)) {
                $table->index('created_at');
            }
            
            if (Schema::hasColumn('protokolle', 'user_id') && !in_array('protokolle_user_id_index', $indexNames)) {
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
            $indexes = Schema::getIndexes('mitglieder');
            $indexNames = collect($indexes)->pluck('name')->toArray();

            if (Schema::hasColumn('mitglieder', 'mitgliedsnummer') && !in_array('mitglieder_mitgliedsnummer_index', $indexNames)) $table->index('mitgliedsnummer');
            if (Schema::hasColumn('mitglieder', 'email') && !in_array('mitglieder_email_index', $indexNames)) $table->index('email');
            if (Schema::hasColumn('mitglieder', 'nachname') && !in_array('mitglieder_nachname_index', $indexNames)) $table->index('nachname');
            if (Schema::hasColumn('mitglieder', 'austrittsdatum') && !in_array('mitglieder_austrittsdatum_index', $indexNames)) $table->index('austrittsdatum');
        });

        Schema::table('inventar', function (Blueprint $table) {
            $indexes = Schema::getIndexes('inventar');
            $indexNames = collect($indexes)->pluck('name')->toArray();

            if (Schema::hasColumn('inventar', 'artikel') && !in_array('inventar_artikel_index', $indexNames)) $table->index('artikel');
            if (Schema::hasColumn('inventar', 'ean') && !in_array('inventar_ean_index', $indexNames)) $table->index('ean');
            
            if (!Schema::hasColumn('inventar', 'lagerstandort')) {
                $table->string('lagerstandort')->nullable();
            }
            if (!in_array('inventar_lagerstandort_index', $indexNames)) {
                $table->index('lagerstandort');
            }

            if (!Schema::hasColumn('inventar', 'kategorie_id')) {
                $table->unsignedBigInteger('kategorie_id')->nullable();
            }
            if (!in_array('inventar_kategorie_id_index', $indexNames)) {
                $table->index('kategorie_id');
            }
        });

        Schema::table('zahlungen', function (Blueprint $table) {
            $indexes = Schema::getIndexes('zahlungen');
            $indexNames = collect($indexes)->pluck('name')->toArray();

            if (Schema::hasColumn('zahlungen', 'datum') && !in_array('zahlungen_datum_index', $indexNames)) $table->index('datum');
            if (Schema::hasColumn('zahlungen', 'typ') && !in_array('zahlungen_typ_index', $indexNames)) $table->index('typ');
            if (Schema::hasColumn('zahlungen', 'rechnungsnr') && !in_array('zahlungen_rechnungsnr_index', $indexNames)) $table->index('rechnungsnr');
            if (Schema::hasColumn('zahlungen', 'zahlungsart_id') && !in_array('zahlungen_zahlungsart_id_index', $indexNames)) $table->index('zahlungsart_id');
        });



        Schema::table('document_uploads', function (Blueprint $table) {
            $indexes = Schema::getIndexes('document_uploads');
            $indexNames = collect($indexes)->pluck('name')->toArray();

            if (Schema::hasColumn('document_uploads', 'title') && !in_array('document_uploads_title_index', $indexNames)) $table->index('title');
            if (Schema::hasColumn('document_uploads', 'file_type') && !in_array('document_uploads_file_type_index', $indexNames)) $table->index('file_type');
            if (Schema::hasColumn('document_uploads', 'uploaded_by') && !in_array('document_uploads_uploaded_by_index', $indexNames)) $table->index('uploaded_by');
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
