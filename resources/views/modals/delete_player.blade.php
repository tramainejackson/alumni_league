<div class="modal fade" id="delete_player" tabindex="-2" role="dialog" aria-labelledby="deletePlayer" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h2-responsive"></h2>
            </div>
            <div class="modal-body">
                <!-- Delete Form -->
                {!! Form::open(['action' => ['LeaguePlayerController@destroy', null], 'method' => 'DELETE']) !!}
                <div class="">
                    <h4 class="h4-responsive">Deleting this player will delete all of his/her stats already entered.<br/><br/>Are you sure you want to delete this player?</h4>

                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>