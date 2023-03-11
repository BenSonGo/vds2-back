<?php

namespace App\Http\Controllers\Actions;

use App\Exceptions\RequestForbiddenException;
use App\Exports\ActivityEfficiencyExport;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Services\FormActivityEfficiencyService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ExportActivityEfficiency extends Controller
{
    public function __invoke(
        Activity $activity,
        FormActivityEfficiencyService $formActivityEfficiencyService,
    ): BinaryFileResponse {
        /** @var User $user */
        $user = Auth::user();

        if ($user->companyActivities->doesntContain($activity->id)) {
            throw new RequestForbiddenException('Activity isn\'t assigned to user');
        }

        return Excel::download(
            new ActivityEfficiencyExport(
                $formActivityEfficiencyService($user->companyResources, $activity),
            ),
            sprintf('%s_efficiency.xlsx', $activity->name),
        );
    }
}
