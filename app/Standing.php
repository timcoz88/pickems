<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Standing extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'race_id', 'league_user_id' ];

	/**
	* The "booting" method of the model.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('sortByRaceRank', function (Builder $builder) {
		    $builder->orderBy('race_id', 'asc')->orderBy('rank', 'asc');
		});
	}

	/**
	 * Get the race of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->belongsTo( Race::class );
	}
	
	/**
	 * Get the user of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function user()
	{
		return $this->belongsTo( User::class, 'league_user_id' );
	}
	
	/**
	 * Get the previous race entry of this standings entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function previous()
	{
		return $this->belongsTo( Standing::class, 'previous_id' );
	}
	
	/**
	 * Get the previous rank.
	 *
	 * @return	integer|null
	 */
	public function getPreviousRankAttribute()
	{
		return $this->previous ? $this->previous->rank : null;
	}
	
	/**
	 * Get the difference between current rank and previous rank
	 *
	 * @return	integer|null
	 */
	public function getRankMovedAttribute()
	{
		if( is_null( $this->previousRank ) )
			return null;
		
		return $this->previousRank - $this->rank;
	}
	
	/**
	 * Get the correct glyphicon class according to rankMoved.
	 *
	 * @return	string
	 */
	public function getRankMovedGlyphiconAttribute()
	{
		if( is_null( $this->rankMoved ) )
			return 'glyphicon-star';

		if( $this->rankMoved < 0 )		
			return 'glyphicon-arrow-down text-danger';

		if( $this->rankMoved > 0 )			
			return 'glyphicon-arrow-up text-success';
		
		return 'glyphicon-pause text-info';
	}
	
	/**
	 * Get the sum of both picked and positions correct attributes.
	 *
	 * @return	integer
	 */
	public function getTotalAttribute()
	{
		return $this->picked + $this->positions_correct;
	}
	
	/**
	 * Get the sum of both total picked and total positions correct attributes.
	 *
	 * @return	integer
	 */
	public function getTotalOverallAttribute()
	{
		return $this->totalPicked + $this->totalPositionsCorrect;
	}
	
	/**
	 * Get the sum of the 'picked' attribute of itself and its previous standings.
	 *
	 * @return	integer
	 */
	public function getTotalPickedAttribute()
	{
		$picked = $this->picked;
		
		if( $this->previous )
			$picked += $this->previous->totalPicked;
		
		return $picked;
	}
	
	/**
	 * Get the sum of the 'picked' attribute of itself and its previous standings.
	 *
	 * @return	integer
	 */
	public function getTotalPositionsCorrectAttribute()
	{
		$positionsCorrect = $this->positions_correct;
		
		if( $this->previous )
			$positionsCorrect += $this->previous->totalPositionsCorrect;
		
		return $positionsCorrect;
	}
}
