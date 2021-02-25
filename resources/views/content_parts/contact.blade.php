<!-- Contact Form -->
<!--  Form login -->
<div class="card">

    <h5 class="card-header info-color white-text text-center py-4">
        <strong>Talk To Me</strong>
    </h5>

    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">

        <!-- Form -->
        <form action="{{ route('messages.store') }}" method="POST" class="text-center" style="color: #757575;">

            {{ csrf_field() }}

            <!-- Name -->
            <div class="md-form">
                <div class="form-row" id="">
                    <div class="col-12 col-md-6" id="">
                        <input type="text" name="first_name" id="" class="form-control" value="{{ old('first_name') }}" {{ $errors->has('first_name') ? 'autofocus' : '' }}>
                        <label for="materialLoginFormPassword">First Name</label>

                        @if ($errors->has('first_name'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-12 col-md-6" id="">
                        <input type="text" name="last_name" id="" class="form-control" value="{{ old('last_name') }}" {{ $errors->has('last_name') ? 'autofocus' : '' }}>
                        <label for="materialLoginFormPassword">Last Name</label>

                        @if ($errors->has('last_name'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="md-form">
                <input type="email" name="email" id="" class="form-control" value="{{ old('email') }}"  {{ $errors->has('email') ? 'autofocus' : '' }}>
                <label for="materialLoginFormEmail">E-mail</label>

                @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Phone -->
            <div class="md-form">
                <input type="number" name="phone" id="" class="form-control" value="{{ old('phone') }}">
                <label for="materialLoginFormEmail">Phone (Optional)</label>

                @if($errors->has('phone'))
                    <span class="text-danger">Phone number has to be exactly 10 numbers</span>
                @endif
            </div>

            <!-- Message -->
            <div class="md-form my-5">
                <textarea name="message" id="" class="md-textarea form-control" rows="4"  {{ $errors->has('message') ? 'autofocus' : '' }}>{{ old('message') }}</textarea>

                <label for="materialLoginFormEmail">How Can We Help</label>

                @if ($errors->has('message'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('message') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Sign in button -->
            <button class="btn btn-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Send <i class="fas fa-paper-plane"></i></button>

        </form>
        <!-- Form -->
    </div>
</div>
<!-- Form login -->