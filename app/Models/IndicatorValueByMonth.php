<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \App\Models\IndicatorValueByMonth
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $company_subunit_id
 * @property int $indicator_id
 * @property int $value
 * @property Carbon $month
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|IndicatorValueByMonth newModelQuery()
 * @method static Builder|IndicatorValueByMonth newQuery()
 * @method static Builder|IndicatorValueByMonth query()
 * @method static Builder|IndicatorValueByMonth whereCompanyId($value)
 * @method static Builder|IndicatorValueByMonth whereCompanySubunitId($value)
 * @method static Builder|IndicatorValueByMonth whereCreatedAt($value)
 * @method static Builder|IndicatorValueByMonth whereId($value)
 * @method static Builder|IndicatorValueByMonth whereIndicatorId($value)
 * @method static Builder|IndicatorValueByMonth whereMonth($value)
 * @method static Builder|IndicatorValueByMonth whereUpdatedAt($value)
 * @method static Builder|IndicatorValueByMonth whereValue($value)
 * @property-read CompanySubunit|null $companySubunit
 * @property-read Company $company
 * @property-read Indicator $indicator
 * @mixin \Eloquent
 */
class IndicatorValueByMonth extends Model
{
    use SoftDeletes;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'month' => 'datetime',
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'company_subunit_id',
        'indicator_id',
        'value',
        'month'
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public function companySubunit(): BelongsTo
    {
        return $this->belongsTo(CompanySubunit::class, 'company_subunit_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(Indicator::class, 'indicator_id', 'id');
    }
}
