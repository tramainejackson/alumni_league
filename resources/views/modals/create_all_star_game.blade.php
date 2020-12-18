<div class="modal fade" id="create_all_star_team" tabindex="-1" role="dialog" aria-labelledby="createAllStarTeam" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h2-responsive">Create All Star Game</h2>
            </div>
            <div class="modal-body">
                <!-- Delete Form -->
                <form method="POST" action="{{ action('LeagueSeasonController@create_all_star_team', ['season' => $showSeason->id]) }}" name="">

                    {{ method_field('POST') }}
                    {{ csrf_field() }}

                    <div class="">
                        <h4 class="h4-responsive">Creating an All Star Game will take the <span class="green-text">{{ $showSeason->league_players()->allStars()->count() }}</span> selected players and split them into 2 teams evenly and create a game with those players.<br/><br/>Are you sure you want to create this game?</h4>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-success">Confirm</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>