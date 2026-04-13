<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add location_id column
        Schema::table('inventar', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable()->after('kategorie_id');
        });

        // 2. Migrate existing data
        $items = DB::table('inventar')->select('id', 'lagerstandort')->get();
        foreach ($items as $item) {
            if ($item->lagerstandort) {
                // Find or create a category of type 'location'
                $location = Category::firstOrCreate(
                    ['name' => $item->lagerstandort, 'type' => 'location']
                );

                DB::table('inventar')
                    ->where('id', $item->id)
                    ->update(['location_id' => $location->id]);
            }
        }

        // 3. Foreign key (optional, depends if we want strictness)
        Schema::table('inventar', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventar', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });
    }
};
