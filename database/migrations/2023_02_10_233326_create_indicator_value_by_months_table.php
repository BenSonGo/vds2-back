<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicator_value_by_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('company_subunit_id')->nullable();
            $table->unsignedBigInteger('indicator_id');
            $table->bigInteger('value');
            $table->date('month');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table->foreign('company_subunit_id')
                ->references('id')
                ->on('company_subunits');

            $table->foreign('indicator_id')
                ->references('id')
                ->on('indicators');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicator_value_by_months');
    }
};
