<?php

namespace App\Models;

use App\Events\PollCreating;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\Models\Poll
 *
 * @property string $id
 * @property string $question
 * @property int $openEnded
 * @property int $multipleChoices
 * @property int $totalVotes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Poll newModelQuery()
 * @method static Builder|Poll newQuery()
 * @method static Builder|Poll query()
 * @method static Builder|Poll whereCreatedAt($value)
 * @method static Builder|Poll whereId($value)
 * @method static Builder|Poll whereMultipleChoices($value)
 * @method static Builder|Poll whereOpenEnded($value)
 * @method static Builder|Poll whereQuestion($value)
 * @method static Builder|Poll whereTotalVotes($value)
 * @method static Builder|Poll whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Choice[] $choices
 * @property-read int|null $choices_count
 */
class Poll extends Model
{
    use HasFactory;
    use Notifiable;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question', 'openEnded', 'multipleChoices'];


    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => PollCreating::class
    ];

    /*
     * Get the choices for this poll.
     *
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }
}
