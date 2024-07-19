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
        Schema::disableForeignKeyConstraints();

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment('particular of transaction');
            $table->unsignedMediumInteger('account_profile_id')->index();
            $table->foreign('account_profile_id')->references('id')->on('account_profiles');
            $table->unsignedMediumInteger('category_id')->index()->nullable()->default(null);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedInteger('budget_id')->index()->nullable()->default(null);
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->double('cash_amount', 10, 2)->default('0');
            $table->enum('cash_trx_type', ["debit","credit"])->nullable()->default(null);
            $table->double('bank_amount', 10, 2)->default('0');
            $table->enum('bank_trx_type', ["debit","credit"])->nullable()->default(null);
            $table->timestamp('created_at')->index();
            $table->timestamp('deleted_at')->nullable()->default(null);
            //$table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
