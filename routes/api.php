<?php

use App\Http\Controllers\Actions\CompanySubunitWorkDaysByMonth\CreateCompanySubunitWorkDaysByMonth;
use App\Http\Controllers\Actions\CompanySubunitWorkDaysByMonth\UpdateCompanySubunitWorkDaysByMonth;
use App\Http\Controllers\Actions\IndicatorValueByMonth\CreateIndicatorValueByMonth;
use App\Http\Controllers\Actions\IndicatorValueByMonth\DeleteIndicatorValueByMonth;
use App\Http\Controllers\Actions\IndicatorValueByMonth\ExportIndicatorValueByMonth;
use App\Http\Controllers\Actions\IndicatorValueByMonth\ExportIndicatorValueByMonthWithWorkDays;
use App\Http\Controllers\Actions\IndicatorValueByMonth\UpdateIndicatorValueByMonth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanySubunitController;
use App\Http\Controllers\Indicator\IndicatorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

require __DIR__ . '/auth.php';

Route::middleware('auth:user')->group(function () {
    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::controller(CompanySubunitController::class)->prefix('subunit')->group(function () {
            Route::prefix('work-days-by-month')
                ->group(function () {
                    Route::post('/', CreateCompanySubunitWorkDaysByMonth::class);
                    Route::patch('/{workDaysByMonth}', UpdateCompanySubunitWorkDaysByMonth::class);
                });

            Route::get('/', 'collection');
            Route::get('/tree', 'collectionTree');
            Route::get('/{subunit}', 'get');
            Route::post('/', 'create');
            Route::patch('/{subunit}', 'update');
            Route::delete('/{subunit}', 'delete');
        });

        Route::get('/', 'collection');
        Route::get('/{company}', 'get');
        Route::post('/', 'create');
        Route::patch('/{company}', 'update');
        Route::delete('/{company}', 'delete');
    });

    Route::controller(IndicatorController::class)->prefix('indicator')->group(function () {
        Route::get('/', 'collection');
        Route::get('/{indicator}', 'get');
        Route::post('/', 'create');
        Route::patch('/{indicator}', 'update');
        Route::delete('/{indicator}', 'delete');
    });

    Route::prefix('indicator-value-by-month')
        ->group(function () {
            Route::post('/', CreateIndicatorValueByMonth::class);
            Route::patch('/{indicatorValueByMonth}', UpdateIndicatorValueByMonth::class);
            Route::delete('/{indicatorValueByMonth}', DeleteIndicatorValueByMonth::class);

            Route::prefix('export')->group(function () {
                Route::get('/', ExportIndicatorValueByMonth::class);
                Route::get('/with-work-days', ExportIndicatorValueByMonthWithWorkDays::class);
            });
        });
});
