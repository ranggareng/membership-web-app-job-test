<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_id');
            $table->unsignedBigInteger('membership_plan_id');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'waiting_confirmation', 'paid']);
            $table->timestamps();

            $table->foreign('membership_id')->references('id')->on('memberships');
            $table->foreign('membership_plan_id')->references('id')->on('membership_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
