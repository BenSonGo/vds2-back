<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicators', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
