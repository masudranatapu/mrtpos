<?php

use App\Models\Admin;
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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class)->nullable();
            $table->string('month')->nullable();
            $table->enum('discount_type', ['Amount', 'Percentage'])->default('Amount');
            $table->double('discount_value', 14, 2)->default(0);
            $table->integer('sorting_number')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
