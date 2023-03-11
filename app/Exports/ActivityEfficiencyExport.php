<?php

namespace App\Exports;

use App\DataTransferObjects\ActivityEfficiency;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

final readonly class ActivityEfficiencyExport implements FromView
{
    public function __construct(private ActivityEfficiency $activityEfficiency)
    {
    }

    public function view(): View
    {
        return view('exports.activity_efficiency', [
            'activityEfficiency' => $this->activityEfficiency,
        ]);
    }
}
