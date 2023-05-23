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
        Schema::create('manual_registrations', function (Blueprint $table) {
            $table->string('venue_id', 3);
            $table->string('account_no', 20)->unique();
            $table->string('account_code', 15)->nullable();
            $table->string('consumer_name', 250)->nullable();
            $table->string('regname', 250)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('contact', 11)->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_registrations');
    }
};
