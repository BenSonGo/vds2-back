<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

/**
 * App\Models\Company
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company onlyTrashed()
 * @method static Builder|Company whereDeletedAt($value)
 * @method static Builder|Company withTrashed()
 * @method static Builder|Company withoutTrashed()
 * @property-read Collection<int, CompanySubunit> $subunits
 * @property-read int|null $subunits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, IndicatorValueByMonth> $indicatorValuesByMonths
 * @property-read int|null $indicator_values_by_months_count
 * @mixin \Eloquent
 */
class Company extends Model
{
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public function subunits(): HasMany
    {
        return $this->hasMany(CompanySubunit::class, 'company_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'company_user',
            'company_id',
            'user_id',
        );
    }

    public function indicatorValuesByMonths(): HasMany
    {
        return $this->hasMany(IndicatorValueByMonth::class, 'company_id', 'id');
    }
}
