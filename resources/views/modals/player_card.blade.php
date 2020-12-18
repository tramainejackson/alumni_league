<!-- Player Card -->
<div class="modal fade" id="player_card" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <!--Card-->
            <div class="card testimonial-card">

                <!-- Bacground color -->
                <div class="card-up dark-gradient lighten-1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="far fa-window-close bg-light text-danger"></i></span>
                    </button>
                </div>

                <!--Card image-->
                <div class="avatar mx-auto white">
                    <img src="{{ $defaultImg }}" class="rounded-circle">
                </div>

                <!--Card content-->
                <div class="card-body playerCardStats container-fluid">

                    <div class="card-header-title">
                        <h2 class="playerNamePlayerCard"></h2>
                        <h3 class="font-weight-bold red-text text-hide playerASG"><i class="fas fa-star"></i>All Star<i class="fas fa-star"></i></h3>
                    </div>

                    <hr/>

                    <div class="row">
                        <div class="col-4 playerCardStatsLI">
                            <b>Team Name:</b> <span class="teamNameVal"></span>
                        </div>
                        <div class="col-4 playerCardStatsLI">
                            <b>Points:</b> <span class="perGamePointsVal"></span>
                        </div>
                        <div class="col-4 playerCardStatsLI">
                            <b>Assist:</b> <span class="perGameAssistVal"></span>
                        </div>
                        <div class="col-4 playerCardStatsLI">
                            <b>Rebounds:</b> <span class="perGameReboundsVal"></span>
                        </div>
                        <div class="col-4 playerCardStatsLI">
                            <b>Steals:</b> <span class="perGameStealsVal"></span>
                        </div>
                        <div class="col-4 playerCardStatsLI">
                            <b>Blocks:</b> <span class="perGameBlocksVal"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.Card-->
        </div>
    </div>
</div>