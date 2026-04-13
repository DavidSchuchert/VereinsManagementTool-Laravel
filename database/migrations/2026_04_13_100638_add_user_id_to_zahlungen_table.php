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
        Schema::table('zahlungen', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('zahlungsart_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Setze Standard-User (Admin ID 1) für bestehende Einträge
        \DB::table('zahlungen')->whereNull('user_id')->update(['user_id' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zahlungen', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
