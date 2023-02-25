<?php

namespace App\Exports;

use App\Models\IndicatorValueByMonth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

final readonly class CompanyIndicatorValuesWithWorkDaysByMonthsExport implements FromView
{
    /**
     * @param Collection<IndicatorValueByMonth> $companyIndicatorValuesByMonths
     */
    public function __construct(private Collection $companyIndicatorValuesByMonths)
    {
    }

    public function view(): View
    {
        $groupedByYears = $this->companyIndicatorValuesByMonths->groupBy([
            fn(IndicatorValueByMonth $valueByMonth) => $valueByMonth->month->format('Y'),
        ])
            ->map(function (Collection $groupedByYear) {
                $valuesSumByYear = $groupedByYear->sum('value');
                $workMonthsCount = $groupedByYear->whereNotNull('work_days')->count();

                $minValue = $groupedByYear->min('value');
                $minMonth = $groupedByYear->first(fn (IndicatorValueByMonth $valueByMonth) => $valueByMonth->value === $minValue)
                    ->month
                    ->month;

                $maxValue = $groupedByYear->max('value');
                $maxMonth = $groupedByYear->first(fn (IndicatorValueByMonth $valueByMonth) => $valueByMonth->value === $maxValue)
                    ->month
                    ->month;

                $unevennessCoefficient = $minValue !== 0 ? $maxValue / $minValue : 0;

                $groupedByYear->put('average_value_by_year', $valuesSumByYear / $workMonthsCount);
                $groupedByYear->put('min_value_by_month', $minValue);
                $groupedByYear->put('min_month', $minMonth);
                $groupedByYear->put('max_value_by_month', $maxValue);
                $groupedByYear->put('max_month', $maxMonth);
                $groupedByYear->put('unevenness_coefficient', $unevennessCoefficient);

                return $groupedByYear;
            });

        return view('exports.indicators_values_with_work_days_by_months', [
            'indicatorValueByMonthsGroupedByYear' => $groupedByYears,
        ]);
    }
}
