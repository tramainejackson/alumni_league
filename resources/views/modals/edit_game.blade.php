<!-- Edit game modal -->
<div class="modal fade" id="edit_game_modal" tabindex="-1" role="dialog" aria-labelledby="editGameModal" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h2-responsive">Edit Game</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            {!! Form::open(['action' => ['LeagueScheduleController@update_game', 'season' => $showSeason->id], 'method' => 'PATCH', 'name' => 'edit_game_form',]) !!}
            <!--Card-->
                <div class="card mb-4">
                    <!--Card content-->
                    <div class="card-body">
                        <!--Title-->
                        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
                            <div class="d-flex align-items-center justify-content-center">
                                <h4 class="card-title h4-responsive my-2">Changing this games teams will remove any stats that have been added</h4>
                            </div>

                            <!-- Forfeit Toggle -->
                            <div class="d-flex flex-column align-items-center">
                                <p class="m-0">Forfeit</p>
                                <div class="">
                                    <button class="btn btn-sm stylish-color-dark awayForfeitBtn d-block white-text" type="button"><span class="awayForfeitBtnTeamName"></span>
                                        <input type="checkbox" name="away_forfeit" class="hidden" value="" hidden />
                                    </button>
                                    <button class="btn btn-sm stylish-color-dark homeForfeitBtn d-block white-text" type="button"><span class="homeForfeitBtnTeamName"></span>
                                        <input type="checkbox" name="home_forfeit" class="hidden" value="" hidden />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div class="my-2">
                            <div class="row">
                                <div class="col-12 col-lg">
                                    <div class="">
                                        <select class="mdb-select md-form" name="edit_away_team">
                                            <option value="" disabled>Choose your option</option>
                                            @foreach($showSeason->league_teams as $away_team)
                                                <option value="{{ $away_team->id }}">{{ $away_team->team_name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="edit_away_team" class="mdb-main-label">Away Team</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg">
                                    <div class="">
                                        <select class="mdb-select md-form" name="edit_home_team">
                                            <option value="" disabled>Choose your option</option>
                                            @foreach($showSeason->league_teams as $home_team)
                                                <option value="{{ $home_team->id }}">{{ $home_team->team_name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="edit_home_team" class="mdb-main-label">Home Team</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="md-form input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Away Score</span>
                                        </div>

                                        <input type="number" name="edit_away_score" id="" class="form-control" value="" placeholder="Enter Away Score" min="0" max="200" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="md-form input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Home Score</span>
                                        </div>

                                        <input type="number" name="edit_home_score" id="" class="form-control" value="" placeholder="Enter Home Score" min="0" max="200" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="md-form input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Game Date</span>
                                        </div>

                                        <input type="text" name="edit_date_picker" id="input_gamedate" class="form-control datetimepicker" value="" placeholder="Selected Date" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="md-form input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Game Time</span>
                                        </div>

                                        <input type="text" name="edit_game_time" id="input_starttime" class="form-control timepicker" value="" placeholder="Selected time" />
                                    </div>
                                </div>

                                <input type="number" name="edit_game_id" class="hidden" value="" hidden />
                            </div>
                            <div class="md-form">
                                <button class="btn blue white-text darken-2" type="submit">Update Game</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.Card-->
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>