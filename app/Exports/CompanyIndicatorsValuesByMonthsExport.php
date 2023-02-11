<?php

namespace App\Exports;

use App\Models\IndicatorValueByMonth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

final class CompanyIndicatorsValuesByMonthsExport implements FromView
{
    /**
     * @param Collection<IndicatorValueByMonth> $companyIndicatorValuesByMonths
     */
    public function __construct(private readonly Collection $companyIndicatorValuesByMonths)
    {
    }

    public function view(): View
    {
        $groupedByYearsAndIndicators = $this->companyIndicatorValuesByMonths->groupBy([
            fn(IndicatorValueByMonth $valueByMonth) => $valueByMonth->month->format('Y'),
            fn(IndicatorValueByMonth $valueByMonth) => $valueByMonth->indicator->name,
        ]);

        return view('exports.indicators_values_by_months', [
            'indicatorValueByMonthsGroupedByYearAndIndicator' => $groupedByYearsAndIndicators,
        ]);
    }
}
