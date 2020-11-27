<!-- Complete season and start playoffs modal -->
<div class="modal fade" id="start_playoffs" tabindex="-1" role="dialog" aria-labelledby="startPlayoffs" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="">Start Playoffs</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="red-text">**Starting the playoffs will complete your season for you and generate a playoff schedule based on the current standings. This cannot be reversed once accepted**</p>

                <h2 class="h2-responsive my-5">Are you sure you want to start this seasons playoffs?</h2>

                <div class="d-flex align-items-center justify-content-between">
                    <button class="btn btn-lg green white-text" type="button" onclick="event.preventDefault(); document.getElementById('create_playoff_form').submit();">Yes</button>
                        {!! Form::open(['action' => ['LeagueSeasonController@create_playoffs', 'season' => $showSeason->id], 'id' => 'create_playoff_form', 'method' => 'POST']) !!}
                        {!! Form::close() !!}
                    <button class="btn btn-lg btn-warning" type="button" data-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>