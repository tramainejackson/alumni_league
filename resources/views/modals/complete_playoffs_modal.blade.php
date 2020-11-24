<!-- Complete season -->
<div class="modal fade coolText4" id="complete_season" tabindex="-1" role="dialog" aria-labelledby="completeSeason" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="">Complete Season</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="red-text"><i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i>&nbsp;Completing your season will add this season to the archives and remove it as an active season&nbsp;<i class="fa fa-exclamation deep-orange-text" aria-hidden="true"></i></p>

                <h2 class="h2-responsive my-5">Are you sure you want to complete this seasons?</h2>

                <div class="d-flex align-items-center justify-content-between">
                    <button class="btn btn-lg green" type="button" onclick="event.preventDefault(); document.getElementById('complete_season_form').submit();">Yes</button>
                    {!! Form::open(['action' => ['LeagueSeasonController@complete_season', 'season' => $showSeason->id, 'year' => $showSeason->year], 'id' => 'complete_season_form', 'method' => 'POST']) !!}
                    {!! Form::close() !!}
                    <button class="btn btn-lg btn-warning" type="button" data-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>