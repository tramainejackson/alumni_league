<!-- Add new game modal -->
<div class="modal fade" id="add_new_game_modal" tabindex="-1" role="dialog" aria-labelledby="addNewGameModal" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="">Add New Game</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Create Form -->
                <form method="POST" action="{{ action('LeagueScheduleController@add_game', ['season' => $showSeason->id]) }}" name="new_game_form">

                    {{ method_field('POST') }}
                    {{ csrf_field() }}

                    <div class="">
                        <select class="mdb-select md-form" name="season_week">
                            <option value="blank" disabled selected>Choose a week</option>
                            @foreach($seasonScheduleWeeks->get() as $week)
                                <option value="{{ $week->season_week }}">Week {{ $week->season_week }}</option>
                            @endforeach
                        </select>
                        <label for="" class="mdb-main-label">Select A Week</label>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg">
                            <div class="">
                                <select class="mdb-select md-form" name="away_team">
                                    <option value="blank" disabled selected>Choose your option</option>
                                    @foreach($showSeason->league_teams as $away_team)
                                        <option value="{{ $away_team->id }}">{{ $away_team->team_name }}</option>
                                    @endforeach
                                </select>
                                <label for="away_team" class="mdb-main-label">Away Team</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg">
                            <div class="">
                                <select class="mdb-select md-form" name="home_team">
                                    <option value="blank" disabled selected>Choose your option</option>
                                    @foreach($showSeason->league_teams as $home_team)
                                        <option value="{{ $home_team->id }}">{{ $home_team->team_name }}</option>
                                    @endforeach
                                </select>
                                <label for="home_team" class="mdb-main-label">Home Team</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg">
                            <div class="md-form">
                                <input type="text" name="date_picker" id="input_gamedate" class="form-control datetimepicker" value="{{ old('game_date') }}" placeholder="Selected Date" />

                                <label for="input_gamedate">Game Date</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg">
                            <div class="md-form">
                                <input type="text" name="game_time" id="input_starttime" class="form-control timepicker" value="{{ old('game_time') }}" placeholder="Selected time" />

                                <label for="input_starttime">Game Time</label>
                            </div>
                        </div>
                    </div>
                    <div class="md-form">
                        <button class="btn blue lighten-1 white-text" type="submit">Add Game</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>