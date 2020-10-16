<!--New Season Modal-->
<div class="modal fade" id="newSeasonForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ action('LeagueSeasonController@store') }}" method="POST" name="newSeasonForm" class="" enctype="multipart/form-data">

                {{ csrf_field() }}
                
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">New Season</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body mx-3">
                    <form name="newSeasonForm" class="">
                        <div class="newSeasonInfo animated">
                            <div class="row">
                                <div class="col-12">
                                    <div class="md-form">
                                        <input type="text" class="form-control" id="season_name" value="{{ old('name') }}" placeholder="Add A Name For This Season" name="name" required />

                                        <label data-error="wrong" data-success="right" for="season" class="blue-text">Season</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg">
                                    <select class="mdb-select md-form" name="season" required>
                                        <option value="" disabled selected>Choose A Season</option>
                                        <option value="winter">Winter</option>
                                        <option value="spring">Spring</option>
                                        <option value="summer">Summer</option>
                                        <option value="fall">Fall</option>
                                    </select>

                                    <label data-error="wrong" data-success="right" for="season" class="blue-text mdb-main-label">Season</label>
                                </div>
                                <div class="col-12 col-lg">
                                    <select class="mdb-select md-form" name="year" required>
                                        <option value="" disabled selected>Choose A Year</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                    </select>

                                    <label data-error="wrong" data-success="right" for="season" class="blue-text mdb-main-label">Year</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg">
                                    <div class="md-form input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text md-addon"><i class="fas fa-dollar-sign" aria-hidden="true"></i></span>
                                        </div>

                                        <input type="number" name="league_fee" class="form-control" id="league_fee" value="{{ $showSeason->league_profile ? $showSeason->league_profile->leagues_fee == null ? '0.00' : $showSeason->leagues_fee == null ? '0.00' : $showSeason->leagues_fee : '0.00' }}" step="0.01" placeholder="League Entry Fee" required />

                                        <input type="number" name="league_id" class="hidden" value="{{ $showSeason->league_profile ? $showSeason->league_profile->id : $showSeason->id }}" hidden />

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Per Team</span>
                                        </div>

                                        <label for="leagues_fee">Entry Fee</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg">
                                    <div class="md-form input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text md-addon"><i class="fas fa-dollar-sign" aria-hidden="true"></i></span>
                                        </div>

                                        <input type="number" class="form-control" class="form-control" name="ref_fee" id="ref_fee" value="{{ $showSeason->league_profile ? $showSeason->league_profile->ref_fee == null ? '0.00' : $showSeason->ref_fee == null ? '0.00' : $showSeason->ref_fee : '0.00' }}" step="0.01" placeholder="League Referee Fee" required />

                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Per Game</span>
                                        </div>

                                        <label for="ref_fee">Ref Fee</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="">

                                <div class="col-12">
                                    <select class="mdb-select md-form" name="age_group">
                                        @if(head($ageGroups) == '' || head($ageGroups) == null)
                                        <option value="blank" selected disabled>You do not have any age groups selected to choose from</option>
                                        @else
                                        @foreach($ageGroups as $ageGroup)
                                        <option value="{{ $ageGroup }}">{{ ucwords(str_ireplace('_', ' ', $ageGroup)) }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                    <label data-error="wrong" data-success="right" for="age_group" class="blue-text mdb-main-label">Age Group</label>
                                </div>

                                <div class="col-12">
                                    <select class="mdb-select md-form" name="comp_group">
                                        @if(head($ageGroups) == '' || head($ageGroups) == null)
                                        <option value="blank" selected disabled>You do not have any competition groups selected to choose from</option>
                                        @else
                                        @foreach($compGroups as $compGroup)
                                        <option value="{{ $compGroup }}">{{ ucwords(str_ireplace('_', ' ', $compGroup)) }}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                    <label data-error="wrong" data-success="right" for="comp_group" class="blue-text mdb-main-label">Competition Group</label>
                                </div>

                                <div class="col-12" id="">
                                    <div class="md-form">
                                        <input type="text" name="location" class="form-control" value="{{ old('location') ? old('location') : $showSeason->league_profile ? $showSeason->league_profile->address : $showSeason->address }}" />

                                        <label data-error="wrong" data-success="right" for="age_group">Games Location</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-row text-center">
                                        <div class="form-group col-12 col-lg-6">
                                            <label for="standings_type" class="d-block form-control-label">Standings Type</label>

                                            <div class="d-block d-sm-inline">
                                                <button type="button" class="btn w-auto automatic active btn-success">
                                                    <input type="checkbox" name="standings_type" value="automatic" checked hidden /> Automatic
                                                </button>
                                            </div>
                                            <div class="d-block d-sm-inline">
                                                <button type="button" class="btn w-auto manual btn-blue-grey">
                                                    <input type="checkbox" name="standings_type" value="manual" hidden /> Manual
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group col-12 col-lg-6">
                                            <label for="schedule_type" class="d-block form-control-label">Scheduling Type</label>

                                            <div class="d-block d-sm-inline">
                                                <button type="button" class="btn w-auto automatic active btn-success">
                                                    <input type="checkbox" name="schedule_type" value="automatic" checked hidden /> Automatic
                                                </button>
                                            </div>
                                            <div class="d-block d-sm-inline">
                                                <button type="button" class="btn w-auto manual btn-blue-grey">
                                                    <input type="checkbox" name="schedule_type" value="manual" hidden /> Manual
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="">
                                    <div class="form-row justify-content-between align-items-center">
                                        <div class="form-group text-center">
                                            <label for="conferences" class="d-block form-control-label">Conferences</label>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success active activeYes" style="line-height:1.5">
                                                    <input type="checkbox" name="conferences" value="Y" checked hidden />Yes
                                                </button>
                                                <button type="button" class="btn btn-blue-grey activeNo" style="line-height:1.5">
                                                    <input type="checkbox" name="conferences" value="N" hidden />No
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group text-center">
                                            <label for="divisions" class="d-block form-control-label">Divisions</label>

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success active activeYes" style="line-height:1.5">
                                                    <input type="checkbox" name="divisions" value="Y" checked hidden />Yes
                                                </button>
                                                <button type="button" class="btn btn-blue-grey activeNo" style="line-height:1.5">
                                                    <input type="checkbox" name="divisions" value="N" hidden />No
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="payPalCheckout coolText4 animated hidden">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h3 class="h3-responsive">To continue, select the PayPal checkout button. Each season is $100 and includes all features throughout the whole season. Your will be redirected to your new season once payment is accepted.</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h4 class="h4-responsive">New Season For
                                        <span class="payPalCheckoutSeason"></span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <p class="text-underline mb-0">Season Name</p>
                                    <p class="payPalCheckoutSeasonName"></p>
                                </div>
                                <div class="col-6">
                                    <p class="text-underline mb-0">Season Location</p>
                                    <p class="payPalCheckoutSeasonLocation"></p>
                                </div>
                                <div class="col-6">
                                    <p class="text-underline mb-0">Season Levels</p>
                                    <p class="payPalCheckoutSeasonLevel"></p>
                                </div>
                                <div class="col-6">
                                    <p class="text-underline mb-0">Season Cost</p>
                                    <p class="payPalCheckoutSeasonCost"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-deep-orange addSeasonBtn animated">Add Season</button>

                    <div class="payPalCheckoutBtn animated hidden">
                        <script src="https://www.paypalobjects.com/api/checkout.js"></script>

                        <div id="paypal-button"></div>

                        <script>
                            paypal.Button.render({

                                env: 'sandbox', // sandbox | production

                                style: {
                                    size: 'medium',
                                    color: 'blue',
                                    shape: 'pill',
                                    label: 'checkout',
                                    tagline: 'true'
                                },

                                client: {
                                    sandbox:    'AZri7zmZvEDIt-EyO1A1kfvDzygfGcuOjVdowBT1pqqmuZFDhkKq9HG2HSMlkzo5ibNUBFf3-3GsuiGu',
                                    production: 'AS7p39CJ_I30Af236rVzKtkoq2LzJw5ZMJnFwcuPOXUVWwehJ7OJscCl43jknJB_sdjBqNVbTUYexfIN'
                                },

                                payment: function(data, actions) {
                                    return actions.payment.create({
                                        payment: {
                                            transactions: [{
                                                amount: {
                                                    total: '100.00',
                                                    currency: 'USD'
                                                }
                                            }]
                                        }
                                    });
                                },

                                // Wait for the payment to be authorized by the customer

                                onAuthorize: function(data, actions) {
                                    return actions.payment.execute()
                                        .then(function () {
                                            $.ajax({
                                                method: "POST",
                                                url: "league_season",
                                                data: $('form[name="newSeasonForm"]').serialize()
                                            })

                                                .fail(function() {
                                                    alert("Fail");
                                                })

                                                .done(function(data) {
                                                    var returnData = data;

                                                    toastr.success(returnData[1], 'Successful');

                                                    setTimeout(function() {
                                                        window.open('/home?season=' + returnData[0] + '&year=' + $('.newSeasonInfo select[name="year"]').val(), '_self');
                                                    }, 2000);
                                                });
                                        });
                                },

                                onCancel: function (data, actions) {
                                    // Show a cancel page or return to cart
                                    alert("Cancel");
                                },

                                onError: function (err) {
                                    // Show an error page here, when an error occurs
                                    alert("Error");
                                }

                            }, '#paypal-button');

                        </script>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>