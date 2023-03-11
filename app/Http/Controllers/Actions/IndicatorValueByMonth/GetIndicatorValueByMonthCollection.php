<?php

namespace App\Http\Controllers\Actions\IndicatorValueByMonth;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndicatorValueByMonth\GetIndicatorValueByMonthCollectionRequest;
use App\Http\Resources\IndicatorValueByMonth\IndicatorValueByMonthResource;
use App\Models\IndicatorValueByMonth;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

final class GetIndicatorValueByMonthCollection extends Controller
{
    public function __invoke(GetIndicatorValueByMonthCollectionRequest $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();
        $query = IndicatorValueByMonth::query()
            ->whereIn('company_id', $user->companies->pluck('id'));

        $companyId = (int)$request->get('company_id');
        if ($companyId) {
            $query->where('indicator_value_by_months.company_id', $companyId);
        }

        $companySubunitId = $request->get('company_subunit_id');
        if ($companySubunitId) {
            $query->where('company_subunit_id', $companySubunitId);
        }

        $indicatorId = $request->get('indicator_id');
        if ($indicatorId) {
            $query->where('indicator_id', $indicatorId);
        }

        $dateFrom = $request->get('date_from');
        if ($dateFrom) {
            $query->whereDate('month', '>=', $dateFrom);
        }

        $dateTo = $request->get('date_to');
        if ($dateTo) {
            $query->whereDate('month', '<=', $dateTo);
        }

        return IndicatorValueByMonthResource::collection($query->get());
    }
}
