<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
}
