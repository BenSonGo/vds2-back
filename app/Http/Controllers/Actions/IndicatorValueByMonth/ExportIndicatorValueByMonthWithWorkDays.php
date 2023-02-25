<?php

namespace App\Http\Controllers\Actions\IndicatorValueByMonth;

use App\Exports\CompanyIndicatorValuesWithWorkDaysByMonthsExport;
use App\Http\Requests\IndicatorValueByMonth\ExportIndicatorValueWithWorkDaysByMonthRequest;
use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\IndicatorValueByMonth;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ExportIndicatorValueByMonthWithWorkDays
{
    public function __invoke(ExportIndicatorValueWithWorkDaysByMonthRequest $request): BinaryFileResponse
    {
        $companyId = $request->get('company_id');
        $subunitId = $request->get('company_subunit_id');
        $indicatorId = $request->get('indicator_id');

        $query = IndicatorValueByMonth::query()
            ->selectRaw(
                'indicator_value_by_months.*, company_subunit_work_days_by_months.work_days as work_days, indicator_value_by_months.value / work_days as value_by_day',
            )
            ->where([
                ['indicator_value_by_months.company_id', '=', $companyId],
                ['indicator_value_by_months.indicator_id', '=', $indicatorId],
            ])
            ->leftJoin('company_subunit_work_days_by_months', function (JoinClause $join) {
                $join->on(
                    'company_subunit_work_days_by_months.company_id',
                    '=',
                    'indicator_value_by_months.company_id',
                );
                $join->on(
                    'company_subunit_work_days_by_months.company_subunit_id',
                    '<=>',
                    'indicator_value_by_months.company_subunit_id',
                );
                $join->on(
                    'company_subunit_work_days_by_months.month',
                    '=',
                    'indicator_value_by_months.month',
                );
            });

        $query = $subunitId
            ? $query->where('indicator_value_by_months.company_subunit_id', $subunitId)
            : $query->whereNull('indicator_value_by_months.company_subunit_id');

        return Excel::download(
            new CompanyIndicatorValuesWithWorkDaysByMonthsExport($query->get()),
            $this->formExportFilename($companyId, $subunitId),
        );
    }

    private function formExportFilename(int $companyId, ?int $subunitId): string
    {
        /**
         * @var Company $company
         * @var CompanySubunit $subunit
         */
        $company = Company::find($companyId);

        $filename = $company->name;

        if ($subunitId) {
            $subunit = CompanySubunit::find($subunitId);
            $filename .= '_'.$subunit->name;
        }

        return $filename.'_with_work_days_'.Carbon::now()->toDateTimeString().'.xlsx';
    }
}
