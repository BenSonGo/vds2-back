<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('resource_id');
            $table->string('expected_effect')->nullable();
            $table->unsignedBigInteger('money_spent');
            $table->string('funding_source')->nullable();
            $table->timestamps();

            $table->foreign('resource_id')
                ->references('id')
                ->on('resources');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
