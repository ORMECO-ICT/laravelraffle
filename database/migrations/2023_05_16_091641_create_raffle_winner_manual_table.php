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
        Schema::create('raffle_winner_manual', function (Blueprint $table) {
            $table->id();
            $table->string('venue_id', 20)->nullable();
            $table->string('dist_code', 3)->nullable();
            $table->string('town_code', 3)->nullable();
            $table->string('account_no', 20)->nullable();
            $table->string('account_code', 15)->nullable()->unique();
            $table->string('consumer_name', 150)->nullable();
            $table->string('address', 150)->nullable();
            $table->char('is_lifeline', 1)->nullable()->default('N');
            $table->string('regname', 250)->nullable();
            $table->string('regaddress', 150)->nullable();
            $table->string('contact', 150)->nullable();
            $table->char('winner', 1)->nullable()->default('N');
            $table->integer('win_draw', 11)->nullable()->change();
            $table->integer('prize_id', 11)->nullable()->change();
            $table->timestamp('entrydate')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP()'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_winner_manual');
    }
};
