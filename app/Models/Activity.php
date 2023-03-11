<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * \App\Models\Activity
 *
 * @property int $id
 * @property string $name
 * @property int $resource_id
 * @property string|null $expected_effect
 * @property int $money_spent
 * @property string|null $funding_source
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity query()
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereExpectedEffect($value)
 * @method static Builder|Activity whereFundingSource($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereMoneySpent($value)
 * @method static Builder|Activity whereName($value)
 * @method static Builder|Activity whereResourceId($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @property Carbon $implemented_date
 * @method static Builder|Activity whereImplementedDate($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'implemented_date' => 'datetime',
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'resource_id',
        'expected_effect',
        'money_spent',
        'funding_source',
        'implemented_date',
    ];
}
