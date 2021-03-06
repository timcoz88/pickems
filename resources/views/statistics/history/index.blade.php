@extends('layouts.app')

@section('title', __('Historical records') . ' - ' . __('Statistics') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12">
        	@include('statistics.history.dropdown')

		<h3>@lang('Best pickems')</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-4">@lang('Name')</th>
				<th class="col-xs-3 col-sm-2">@lang('Points')</th>
				<th class="col-xs-3 col-sm-2">@lang('Season')</th>
				<th class="col-xs-2 col-sm-4">@lang('Race')</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $bestPickems as $pickems )
				<tr>
					<td>{{ $pickems->user->name }}</td>
					<td>{{ $pickems->total }} ({{ $pickems->picked }}&nbsp;+&nbsp;{{ $pickems->positions_correct }})</td>
					<td>{{ $pickems->race->season->name }}</td>
					<td>
						<span class="{{ $pickems->race->circuit->country->flagClass }}" title="{{ $pickems->race->circuit->country->localName }}"></span>
						<span class="hidden-xs">{{ $pickems->race->circuit->city }}</span>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">@lang('Standings probably have not been built yet.')</td>
				</tr>
			@endforelse
		</tbody>
		</table>

		<h3>@lang('Best carry-over pickems')</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-4">@lang('Name')</th>
				<th class="col-xs-3 col-sm-2">@lang('Points')</th>
				<th class="col-xs-3 col-sm-2">@lang('Season')</th>
				<th class="col-xs-2 col-sm-4">@lang('Race')</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $bestCarryover as $pickems )
				<tr>
					<td>{{ $pickems->user->name }}</td>
					<td>{{ $pickems->total }} ({{ $pickems->picked }}&nbsp;+&nbsp;{{ $pickems->positions_correct }})</td>
					<td>{{ $pickems->race->season->name }}</td>
					<td>
						<span class="{{ $pickems->race->circuit->country->flagClass }}" title="{{ $pickems->race->circuit->country->localName }}"></span>
						<span class="hidden-xs">{{ $pickems->race->circuit->city }}</span>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">@lang('Standings probably have not been built yet.')</td>
				</tr>
			@endforelse
		</tbody>
		</table>

		<h3>@lang('Highest points total in a season')</h3>
		<table class="table table-striped">
		<thead>
			<tr>
				<th class="col-xs-4">@lang('Name')</th>
				<th class="col-xs-3 col-sm-2">@lang('Points')</th>
				<th class="col-xs-3 col-sm-2">@lang('Season')</th>
				<th class="col-xs-2 col-sm-4">@lang('Race')</th>
			</tr>
		</thead>
		<tbody>
			@forelse( $highestPoints as $pickems )
				<tr>
					<td>{{ $pickems->user->name }}</td>
					<td>{{ $pickems->total_overall }} ({{ $pickems->total_picked }}&nbsp;+&nbsp;{{ $pickems->total_positions_correct }})</td>
					<td>{{ $pickems->race->season->name }}</td>
					<td>
						<span class="{{ $pickems->race->circuit->country->flagClass }}" title="{{ $pickems->race->circuit->country->localName }}"></span>
						<span class="hidden-xs">{{ $pickems->race->circuit->city }}</span>
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">@lang('Standings probably have not been built yet.')</td>
				</tr>
			@endforelse
		</tbody>
		</table>
        </div>
    </div>
</div>
@endsection
