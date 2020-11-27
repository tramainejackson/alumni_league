<div class="modal fade" id="delete_team" tabindex="-1" role="dialog" aria-labelledby="deleteTeam" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h2-responsive">Delete Team</h2>
            </div>
            <div class="modal-body">
                <!-- Delete Form -->
                <form method="POST" action="{{ action('LeagueTeamController@destroy', ['season' => $showSeason->id]) }}" name="">

                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}

                    <div class="">
                        <h4 class="h4-responsive">Deleting this team will delete all of it's games on the schedule and remove all the stats already entered.<br/><br/>Are you sure you want to delete this team?</h4>

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