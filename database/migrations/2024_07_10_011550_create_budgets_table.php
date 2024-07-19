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

        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->double('amount');
            $table->unsignedTinyInteger('is_pined');
            $table->enum('frequency', ["monthly","daily","weekly","yearly"])->nullable()->default(null);
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
