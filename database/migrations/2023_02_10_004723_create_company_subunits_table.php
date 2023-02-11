<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_subunits', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_subunits');
    }
};
