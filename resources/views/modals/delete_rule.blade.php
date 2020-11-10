<div class="modal fade" id="delete_rule" tabindex="-2" role="dialog" aria-labelledby="deleteRule" aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h2-responsive"></h2>
            </div>
            <div class="modal-body">
                <!-- Delete Form -->
                {!! Form::open(['action' => ['LeagueSeasonController@destroy_rule', null], 'method' => 'DELETE']) !!}
                <div class="">
                    <h4 class="h4-responsive">Are you sure you want to delete this rule?</h4>

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