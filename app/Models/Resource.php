<?php

namespace App\Models;

use App\Enums\IndicatorTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * \App\Models\Resource
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Resource newModelQuery()
 * @method static Builder|Resource newQuery()
 * @method static Builder|Resource query()
 * @method static Builder|Resource whereCreatedAt($value)
 * @method static Builder|Resource whereId($value)
 * @method static Builder|Resource whereName($value)
 * @method static Builder|Resource whereUpdatedAt($value)
 * @property int $user_id
 * @method static Builder|Resource whereUserId($value)
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Indicator> $indicators
 * @property-read int|null $indicators_count
 * @property-read Collection<int, \App\Models\Indicator> $consumptionIndicators
 * @property-read int|null $consumption_indicators_count
 * @property-read Collection<int, \App\Models\Indicator> $moneyIndicators
 * @property-read int|null $money_indicators_count
 * @mixin \Eloquent
 */
final class Resource extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
    ];

    public static function getTableName(): string
    {
        return (new Resource)->getTable();
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'resource_id', 'id');
    }

    public function indicators(): HasMany
    {
        return $this->hasMany(Indicator::class, 'resource_id', 'id');
    }

    public function consumptionIndicators(): HasMany
    {
        return $this->indicators()->where('type', IndicatorTypeEnum::Consumption);
    }

    public function moneyIndicators(): HasMany
    {
        return $this->indicators()->where('type', IndicatorTypeEnum::Money);
    }
}
