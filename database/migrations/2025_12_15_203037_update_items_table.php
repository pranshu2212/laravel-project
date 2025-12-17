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
        Schema::table('items', function (Blueprint $table) {

            if (Schema::hasColumn('items', 'img')) {
                $table->string('img')->nullable()->change();
            }

            if (!Schema::hasColumn('items', 'price')) {
                $table->decimal('price', 10, 2);
            }

            if (!Schema::hasColumn('items', 'discount')) {
                $table->decimal('discount', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('items', 'category')) {
                $table->string('category')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {

            if (Schema::hasColumn('items', 'img')) {
                $table->string('img')->nullable(false)->change();
            }

            if (Schema::hasColumn('items', 'price')) {
                $table->dropColumn('price');
            }

            if (Schema::hasColumn('items', 'discount')) {
                $table->dropColumn('discount');
            }

            if (Schema::hasColumn('items', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
