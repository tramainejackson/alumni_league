<div class="modal fade" id="restore_team" tabindex="-1" role="dialog" aria-labelledby="restoreTeam" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h2-responsive">Restore Team</h2>
            </div>
            <div class="modal-body">
                <!-- Restore Form -->
                <form method="POST" action="{{ action('LeagueTeamController@restore', ['id' => null]) }}" name="restore_team_form">

                    {{ method_field('POST') }}
                    {{ csrf_field() }}

                    <div class="">
                        <h4 class="h4-responsive">Restoring this team will bring back all of it's games on the schedule, players and all the stats already removed.<br/><br/>Are you sure you want to restore this team?</h4>

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