<?php

namespace App\Models;

use Database\Factories\CompanySubunitFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder as LaravelAdjacencyBuilder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * App\Models\CompanySubunit
 *
 * @property int $id
 * @property int $company_id
 * @property int|null $parent_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CompanySubunit> $children
 * @property-read int|null $children_count
 * @property-read Collection<int, CompanySubunit> $ancestors
 * @property-read int|null $ancestors_count
 * @property-read Collection<int, CompanySubunit> $siblings
 * @property-read int|null $siblings_count
 * @property-read CompanySubunit|null $parent
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static LaravelAdjacencyBuilder|CompanySubunit breadthFirst()
 * @method static LaravelAdjacencyBuilder|CompanySubunit depthFirst()
 * @method static CompanySubunitFactory factory($count = null, $state = [])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static LaravelAdjacencyBuilder|CompanySubunit getExpressionGrammar()
 * @method static LaravelAdjacencyBuilder|CompanySubunit hasChildren()
 * @method static LaravelAdjacencyBuilder|CompanySubunit hasParent()
 * @method static LaravelAdjacencyBuilder|CompanySubunit isLeaf()
 * @method static LaravelAdjacencyBuilder|CompanySubunit isRoot()
 * @method static LaravelAdjacencyBuilder|CompanySubunit newModelQuery()
 * @method static LaravelAdjacencyBuilder|CompanySubunit newQuery()
 * @method static LaravelAdjacencyBuilder|CompanySubunit query()
 * @method static LaravelAdjacencyBuilder|CompanySubunit tree($maxDepth = null)
 * @method static LaravelAdjacencyBuilder|CompanySubunit treeOf(callable $constraint, $maxDepth = null)
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereCompanyId($value)
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereCreatedAt($value)
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereDepth($operator, $value = null)
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereId($value)
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereName($value)
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereParentId($value)
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereUpdatedAt($value)
 * @method static LaravelAdjacencyBuilder|CompanySubunit withGlobalScopes(array $scopes)
 * @method static LaravelAdjacencyBuilder|CompanySubunit withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @property Carbon|null $deleted_at
 * @method static Builder|CompanySubunit onlyTrashed()
 * @method static LaravelAdjacencyBuilder|CompanySubunit whereDeletedAt($value)
 * @method static Builder|CompanySubunit withTrashed()
 * @method static Builder|CompanySubunit withoutTrashed()
 * @property-read Company $company
 * @mixin \Eloquent
 */
class CompanySubunit extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasRecursiveRelationships;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'parent_id',
        'name',
    ];

    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function siblingsIndicatorByMonthValuesSum(int $indicatorId, Carbon $month): int
    {
        return DB::table(IndicatorValueByMonth::getTableName())
            ->where('indicator_id', $indicatorId)
            ->whereDate('month', '=', $month)
            ->whereIn('company_subunit_id', $this->siblings->pluck('id'))
            ->sum('value');
    }

    public function nearestAncestorIndicatorByMonthValue(int $indicatorId, Carbon $month): ?int
    {
        $ancestors = $this->ancestors;

        /** @var IndicatorValueByMonth $valueByMonth */
        $valueByMonth = DB::table(IndicatorValueByMonth::getTableName())
            ->select('company_id', 'company_subunit_id', 'value')
            ->where('indicator_id', $indicatorId)
            ->whereDate('month', '=', $month)
            ->where('company_id', $this->company_id)
            ->where(
                function (\Staudenmeir\LaravelCte\Query\Builder $q) use ($ancestors) {
                    $q->whereIn('company_subunit_id', $ancestors->pluck('id'))
                        ->orWhere(
                            fn(\Staudenmeir\LaravelCte\Query\Builder $q) => $q->whereNull('company_subunit_id')
                                ->where('company_id', $this->company_id)
                        );
                })
            ->orderBy('value')
            ->first();

        return $valueByMonth?->value ?? null;
    }
}
