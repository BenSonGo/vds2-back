<?php

use App\DataTransferObjects\ActivityEfficiency;
use App\DataTransferObjects\ActivityResourceEfficiency;

/**
 * @var ActivityEfficiency $activityEfficiency
 * @var ActivityResourceEfficiency $resourceEfficiency
 */
?>

<table border="1">
    <tr>
        <td rowspan="2">Components of energy savings</td>
        <td colspan="2">Existing situation</td>
        <td colspan="2">After the implementation of the project</td>
        <td colspan="2">Economy</td>
    </tr>
    <tr>
        <td>quantity</td>
        <td>UAH</td>
        <td>quantity</td>
        <td>UAH</td>
        <td>quantity</td>
        <td>UAH</td>
    </tr>

    @foreach($activityEfficiency->resourceEfficiencies as $resourceEfficiency)
        <tr>
            <td>{{ $resourceEfficiency->resourceName }}</td>
            <td>{{ $resourceEfficiency->currentSituation->consumption }}</td>
            <td>{{ $resourceEfficiency->currentSituation->costs }}</td>
            <td>{{ $resourceEfficiency->afterActivityImplementation->consumption }}</td>
            <td>{{ $resourceEfficiency->afterActivityImplementation->costs }}</td>
            <td>{{ $resourceEfficiency->economy->consumption }}</td>
            <td>{{ $resourceEfficiency->economy->costs }}</td>
        </tr>
    @endforeach

    <tr>
        <td colspan="6">Total savings</td>
        <td>{{ $activityEfficiency->totalMoneySavings }}</td>
    </tr>
</table>
