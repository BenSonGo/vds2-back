<?php

namespace App\Http\Controllers\Actions\IndicatorValueByMonth;

use App\Exports\CompanyIndicatorsValuesByMonthsExport;
use App\Http\Requests\IndicatorValueByMonth\ExportIndicatorValueByMonthRequest;
use App\Models\Company;
use App\Models\CompanySubunit;
use App\Models\IndicatorValueByMonth;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ExportIndicatorValueByMonthWithWorkDays
{
    public function __invoke(ExportIndicatorValueByMonthRequest $request): BinaryFileResponse
    {
        $companyId = $request->get('company_id');
        $subunitId = $request->get('company_subunit_id');

        $query = IndicatorValueByMonth::query()
            ->where('company_id', '=', $companyId);

        $query = $subunitId
            ? $query->where('company_subunit_id', $subunitId)
            : $query->whereNull('company_subunit_id');

        dd(1);
        //TODO: make normal export
//        return Excel::download(
//            new CompanyIndicatorsValuesByMonthsExport($query->get()),
//            $this->formExportFilename($companyId, $subunitId),
//        );
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
