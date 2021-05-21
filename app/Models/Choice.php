<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Choice
 *
 * @property int $id
 * @property string $poll_id
 * @property string $text
 * @property int $votes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Choice newModelQuery()
 * @method static Builder|Choice newQuery()
 * @method static Builder|Choice query()
 * @method static Builder|Choice whereCreatedAt($value)
 * @method static Builder|Choice whereId($value)
 * @method static Builder|Choice wherePollId($value)
 * @method static Builder|Choice whereText($value)
 * @method static Builder|Choice whereUpdatedAt($value)
 * @method static Builder|Choice whereVotes($value)
 * @mixin Eloquent
 */
class Choice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text', 'votes'];
}
