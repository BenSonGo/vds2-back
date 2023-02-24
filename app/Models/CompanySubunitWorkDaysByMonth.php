<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * \App\Models\CompanySubunitWorkDaysByMonth
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $company_subunit_id
 * @property int $work_days
 * @property Carbon $month
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|CompanySubunitWorkDaysByMonth newModelQuery()
 * @method static Builder|CompanySubunitWorkDaysByMonth newQuery()
 * @method static Builder|CompanySubunitWorkDaysByMonth query()
 * @method static Builder|CompanySubunitWorkDaysByMonth whereCompanyId($value)
 * @method static Builder|CompanySubunitWorkDaysByMonth whereCompanySubunitId($value)
 * @method static Builder|CompanySubunitWorkDaysByMonth whereCreatedAt($value)
 * @method static Builder|CompanySubunitWorkDaysByMonth whereId($value)
 * @method static Builder|CompanySubunitWorkDaysByMonth whereMonth($value)
 * @method static Builder|CompanySubunitWorkDaysByMonth whereUpdatedAt($value)
 * @method static Builder|CompanySubunitWorkDaysByMonth whereWorkDays($value)
 * @mixin \Eloquent
 */
class CompanySubunitWorkDaysByMonth extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'company_subunit_id',
        'work_days',
        'month'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'month' => 'datetime',
    ];
}
