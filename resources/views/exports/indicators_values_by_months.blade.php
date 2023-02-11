<?php

use App\Models\IndicatorValueByMonth;
use Illuminate\Support\Collection;

/**
 * @var Collection<string, Collection> $indicatorValueByMonthsGroupedByYearAndIndicator
 * @var Collection<string, Collection> $indicatorValuesByMonthsGroupedByIndicators
 * @var Collection<string, IndicatorValueByMonth> $indicatorValuesByMonths
 * @var IndicatorValueByMonth $indicatorValueByMonth
 */

$months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
];

?>


<table border="1">
    <tr>
        <td>Year</td>
        <td>Indicator</td>
        @foreach($months as $month)
            <td>{{ $month }}</td>
        @endforeach
        <td>Total for year</td>
    </tr>

    @foreach($indicatorValueByMonthsGroupedByYearAndIndicator as $year => $indicatorValuesByMonthsGroupedByIndicators)
        @php
            $maxRows = $indicatorValuesByMonthsGroupedByIndicators->count();
        @endphp

        @foreach($indicatorValuesByMonthsGroupedByIndicators as $indicatorName => $indicatorValuesByMonths)
            <tr>
                <td>{{ $year }}</td>
                <td>{{ $indicatorName }}</td>

                @foreach($months as $month)
                    @php
                        $value = $indicatorValuesByMonths->first(function(IndicatorValueByMonth $indicatorValueByMonth) use ($month) {
                            return $indicatorValueByMonth->month->format('F') === $month;
                        })?->value ?? 0;
                    @endphp

                    <td>{{ $value }}</td>
                @endforeach

                @php
                    $sumByIndicator = $indicatorValuesByMonthsGroupedByIndicators->sum(
                        fn (Collection $indicatorValuesByMonths) => $indicatorValuesByMonths->sum('value')
                    );
                @endphp

                <td>{{ $sumByIndicator }}</td>

            </tr>
        @endforeach
    @endforeach
</table>
