<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Series
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Season $latest_season
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\League[] $leagues
 * @property-read int|null $leagues_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Season[] $seasons
 * @property-read int|null $seasons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Series whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Series extends Model
{
    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'orderByName',
            function (Builder $builder) {
                $builder->orderBy('name', 'asc');
            }
        );
    }

    /**
     * Get seasons of this series
     *
     * @return HasMany
     */
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    /**
     * Get leagues of this series.
     *
     * @return HasMany
     */
    public function leagues()
    {
        return $this->hasMany(League::class);
    }

    /**
     * Get latest (most recent by year) season.
     *
     * @return Season
     */
    public function getLatestSeasonAttribute()
    {
        if ($this->seasons->isEmpty()) {
            return new Season();
        }

        return $this->seasons->sortByDesc('name')->first();
    }
}
