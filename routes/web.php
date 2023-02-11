<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Exports\CompanyIndicatorsValuesByMonthsExport;
use App\Models\IndicatorValueByMonth;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {

    $indicatorValues = \App\Models\IndicatorValueByMonth::query()
        ->where('company_id', '=', 4)
        ->whereNull('company_subunit_id')
        ->get();

    $groupedByYearsAndIndicators = $indicatorValues->groupBy([
        fn(IndicatorValueByMonth $valueByMonth) => $valueByMonth->month->format('Y'),
        fn(IndicatorValueByMonth $valueByMonth) => $valueByMonth->indicator->name,
    ]);

    return view('exports.indicators_values_by_months', [
        'indicatorValueByMonthsGroupedByYearAndIndicator' => $groupedByYearsAndIndicators,
    ]);


//    Excel::download(
//    new CompanyIndicatorsValuesByMonthsExport(
//    ),
//    'test.xlsx')
});
