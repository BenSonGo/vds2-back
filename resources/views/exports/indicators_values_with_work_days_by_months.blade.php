<?php

use App\Models\IndicatorValueByMonth;
use Illuminate\Support\Collection;

/**
 * @var Collection<string, Collection> $indicatorValueByMonthsGroupedByYear
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
        @foreach($months as $month)
            <td>{{ $month }}</td>
            <td>Work days</td>
            <td>Average by day</td>
        @endforeach
        <td>Average by year</td>
        <td>Min value by year</td>
        <td>Min month</td>
        <td>Max value by year</td>
        <td>Max month</td>
        <td>Unevenness coefficient</td>
    </tr>

    @foreach($indicatorValueByMonthsGroupedByYear as $year => $indicatorValuesByMonthsWithData)

        @php
//        dd($indicatorValuesByMonthsWithData);
            $indicatorValuesByMonths = $indicatorValuesByMonthsWithData->where(
                fn ($item) => is_object($item) && get_class($item) === IndicatorValueByMonth::class
            );
        @endphp

        <tr>
            <td>{{ $year }}</td>

            @foreach($months as $month)
                @php
                    $indicatorValueByMonth = $indicatorValuesByMonths->first(function(IndicatorValueByMonth $indicatorValueByMonth) use ($month) {
                        return $indicatorValueByMonth->month->format('F') === $month;
                    });
                @endphp

                <td>{{ $indicatorValueByMonth?->value ?? 0 }}</td>
                <td>{{ $indicatorValueByMonth?->work_days ?? 0 }}</td>
                <td>{{ $indicatorValueByMonth?->value_by_day ?? 0 }}</td>
            @endforeach

            <td>{{ $indicatorValuesByMonthsWithData['average_value_by_year'] }}</td>
            <td>{{ $indicatorValuesByMonthsWithData['min_value_by_month'] }}</td>
            <td>{{ $indicatorValuesByMonthsWithData['min_month'] }}</td>
            <td>{{ $indicatorValuesByMonthsWithData['max_value_by_month'] }}</td>
            <td>{{ $indicatorValuesByMonthsWithData['max_month'] }}</td>
            <td>{{ $indicatorValuesByMonthsWithData['unevenness_coefficient'] }}</td>
        </tr>
    @endforeach
</table>
