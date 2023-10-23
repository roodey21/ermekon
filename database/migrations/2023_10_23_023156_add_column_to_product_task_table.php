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
        Schema::table('product_task', function (Blueprint $table) {
            $table->string('transaction_type')->nullable();
            $table->string('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_task', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
            $table->dropColumn('price');
        });
    }
};
