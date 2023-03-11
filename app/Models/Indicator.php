<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Indicator
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|Indicator newModelQuery()
 * @method static Builder|Indicator newQuery()
 * @method static Builder|Indicator query()
 * @method static Builder|Indicator whereCreatedAt($value)
 * @method static Builder|Indicator whereId($value)
 * @method static Builder|Indicator whereName($value)
 * @method static Builder|Indicator whereUpdatedAt($value)
 * @method static Builder|Indicator whereDeletedAt($value)
 * @method static Builder|Indicator onlyTrashed()
 * @method static Builder|Indicator withTrashed()
 * @method static Builder|Indicator withoutTrashed()
 * @property int $user_id
 * @method static Builder|Indicator whereUserId($value)
 * @property int|null $resource_id
 * @method static Builder|Indicator whereResourceId($value)
 * @property int|null $type
 * @method static Builder|Indicator whereType($value)
 * @property-read Collection<int, IndicatorValueByMonth> $valueByMonths
 * @property-read int|null $value_by_months_count
 * @mixin \Eloquent
 */
class Indicator extends Model
{
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'resource_id',
        'user_id',
        'name',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public function valueByMonths(): HasMany
    {
        return $this->hasMany(IndicatorValueByMonth::class, 'indicator_id', 'id');
    }
}
