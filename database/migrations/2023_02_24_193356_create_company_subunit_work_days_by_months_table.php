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
    public function up(): void
    {
        Schema::create('company_subunit_work_days_by_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('company_subunit_id')->nullable();
            $table->tinyInteger('work_days')->default(0);
            $table->date('month');
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table->foreign('company_subunit_id')
                ->references('id')
                ->on('company_subunits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_subunit_work_days_by_months');
    }
};
