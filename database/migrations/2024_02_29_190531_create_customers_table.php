<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Business;
use App\Models\CustomerGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->text('uid')->nullable();
            $table->text('member_ship_id')->nullable();
            $table->foreignIdFor(Business::class)->nullable();
            $table->foreignIdFor(CustomerGroup::class)->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('note')->nullable();
            $table->double('balance', 12, 4)->default(0);
            $table->double('paid_amount', 12, 4)->default(0);
            $table->string('designation')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Blocked', 'Pending'])->default('Active');
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
