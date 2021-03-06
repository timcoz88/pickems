<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Race
 *
 * @property int $id
 * @property int $season_id
 * @property int $circuit_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $weekend_start
 * @property \Illuminate\Support\Carbon $race_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Circuit $circuit
 * @property-read bool $pickable
 * @property-read \App\Collections\PickCollection|\App\Pick[] $picks
 * @property-read int|null $picks_count
 * @property-read \App\Collections\ResultCollection|\App\Result[] $results
 * @property-read int|null $results_count
 * @property-read \App\Season $season
 * @property-read \App\Collections\StandingCollection|\App\Standing[] $standings
 * @property-read int|null $standings_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race nextDeadline()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race nextOrLast()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race previousOrFirst($index = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereCircuitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereRaceDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereWeekendStart($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Race extends Model
{
    /**
     * Date fields.
     *
     * @var array
     */
    protected $dates = [
        'weekend_start',
        'race_day',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['season_id', 'circuit_id', 'name', 'weekend_start', 'race_day'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'sortByRaceDay',
            function (Builder $builder) {
                $builder->orderBy('race_day');
            }
        );
    }

    /**
     * Get the circuit of this race.
     *
     * @return BelongsTo
     */
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }

    /**
     * Get the season of this race.
     *
     * @return BelongsTo
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the results of this race.
     *
     * @return HasMany
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Get the standings of this race.
     *
     * @return HasMany
     */
    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    /**
     * Get the picks of this race.
     *
     * @return HasMany
     */
    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    /**
     * Get next race according to current date.
     *
     * @param $query Builder
     *
     * @return Builder
     */
    public function scopeNextOrLast(Builder $query)
    {
        $newQuery = clone $query;

        $first = $query->where('race_day', '>=', date('Y-m-d'))->first();

        if ($first) {
            return $first;
        }

        return $newQuery->withoutGlobalScope('sortByRaceDay')->orderBy('race_day', 'desc')->first();
    }

    /**
     * Get previous race according to current date.
     *
     * @param $query Builder
     * @param $index integer
     *
     * @return Builder
     */
    public function scopePreviousOrFirst(Builder $query, int $index = 0)
    {
        $newQuery = clone $query;

        $last = $query->withoutGlobalScope('sortByRaceDay')
            ->where('race_day', '<=', date('Y-m-d'))
            ->orderBy('race_day', 'desc')
            ->get()
            ->slice($index, 1)
            ->first();

        if ($last) {
            return $last;
        }

        return $newQuery->first();
    }

    /**
     * Get next race deadline according to current date.
     *
     * @param $query Builder
     *
     * @return Builder
     */
    public function scopeNextDeadline(Builder $query)
    {
        return $query->where('weekend_start', '>', date('Y-m-d H:i:s'));
    }

    /**
     * Can we pick for this race?
     *
     * @return bool
     */
    public function getPickableAttribute()
    {
        return false;
    }
}
