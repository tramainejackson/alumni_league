@if($activeSeasons->isNotEmpty())
	@foreach($activeSeasons as $activeSeason)
		<a href="{{ route('league_seasons.index', ['season' => $activeSeason->id]) }}" class="btn btn-lg btn-rounded deep-orange white-text d-block{{ $activeSeason->id == $showSeason->id ? ' lighten-2' : '' }}" type="button">{{ $activeSeason->name }}</a>
	@endforeach
@else
@endif