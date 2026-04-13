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
            
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('protokolle');
            
            if (!array_key_exists('protokolle_created_at_index', $indexes)) {
                $table->index('created_at');
            }
            
            if (Schema::hasColumn('protokolle', 'user_id') && !array_key_exists('protokolle_user_id_index', $indexes)) {
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
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('mitglieder');

            if (Schema::hasColumn('mitglieder', 'mitgliedsnummer') && !array_key_exists('mitglieder_mitgliedsnummer_index', $indexes)) $table->index('mitgliedsnummer');
            if (Schema::hasColumn('mitglieder', 'email') && !array_key_exists('mitglieder_email_index', $indexes)) $table->index('email');
            if (Schema::hasColumn('mitglieder', 'nachname') && !array_key_exists('mitglieder_nachname_index', $indexes)) $table->index('nachname');
            if (Schema::hasColumn('mitglieder', 'austrittsdatum') && !array_key_exists('mitglieder_austrittsdatum_index', $indexes)) $table->index('austrittsdatum');
        });

        Schema::table('inventar', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('inventar');

            if (Schema::hasColumn('inventar', 'artikel') && !array_key_exists('inventar_artikel_index', $indexes)) $table->index('artikel');
            if (Schema::hasColumn('inventar', 'ean') && !array_key_exists('inventar_ean_index', $indexes)) $table->index('ean');
            
            if (!Schema::hasColumn('inventar', 'lagerstandort')) {
                $table->string('lagerstandort')->nullable();
            }
            if (!array_key_exists('inventar_lagerstandort_index', $indexes)) {
                $table->index('lagerstandort');
            }

            if (!Schema::hasColumn('inventar', 'kategorie_id')) {
                $table->unsignedBigInteger('kategorie_id')->nullable();
            }
            if (!array_key_exists('inventar_kategorie_id_index', $indexes)) {
                $table->index('kategorie_id');
            }
        });

        Schema::table('zahlungen', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('zahlungen');

            if (Schema::hasColumn('zahlungen', 'datum') && !array_key_exists('zahlungen_datum_index', $indexes)) $table->index('datum');
            if (Schema::hasColumn('zahlungen', 'typ') && !array_key_exists('zahlungen_typ_index', $indexes)) $table->index('typ');
            if (Schema::hasColumn('zahlungen', 'rechnungsnr') && !array_key_exists('zahlungen_rechnungsnr_index', $indexes)) $table->index('rechnungsnr');
            if (Schema::hasColumn('zahlungen', 'zahlungsart_id') && !array_key_exists('zahlungen_zahlungsart_id_index', $indexes)) $table->index('zahlungsart_id');
        });



        Schema::table('document_uploads', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('document_uploads');

            if (Schema::hasColumn('document_uploads', 'title') && !array_key_exists('document_uploads_title_index', $indexes)) $table->index('title');
            if (Schema::hasColumn('document_uploads', 'file_type') && !array_key_exists('document_uploads_file_type_index', $indexes)) $table->index('file_type');
            if (Schema::hasColumn('document_uploads', 'uploaded_by') && !array_key_exists('document_uploads_uploaded_by_index', $indexes)) $table->index('uploaded_by');
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
