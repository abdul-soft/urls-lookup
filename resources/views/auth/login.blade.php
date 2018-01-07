@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">

                    <form method="post" id="login_form" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="code" id="code" />
                    </form>

                    <form class="form-horizontal"  onsubmit="event.preventDefault();">

                        <input type="hidden" value="+92" id="country_code" />

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Phone Number</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="number" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="button" onclick="smsLogin();" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    // initialize Account Kit with CSRF protection
    AccountKit_OnInteractive = function(){
        AccountKit.init(
                {
                    appId:"{{ config('fb_account.fb_account_app_id') }}",
                    state:"{{ csrf_token() }}",
                    version:"{{ config('fb_account.fb_account_api_version') }}",
                    fbAppEventsEnabled:true,
                    redirect:"{{ route('login') }}",
                    debug:true
                }
        );
    };

    // login callback
    function loginCallback(response) {
        console.log(response.status);
        if (response.status === "PARTIALLY_AUTHENTICATED") {
            var code = response.code;
            var csrf = response.state;
            // Send code to server to exchange for access token
            document.getElementById('code').value = code;
            document.getElementById('login_form').submit();
        }
        else if (response.status === "NOT_AUTHENTICATED") {
            // handle authentication failure
        }
        else if (response.status === "BAD_PARAMS") {
            // handle bad parameters
        }
    }

    // phone form submission handler
    function smsLogin() {
        var countryCode = document.getElementById("country_code").value;
        var phoneNumber = document.getElementById("phone_number").value;
        AccountKit.login(
                'PHONE',
                {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
                loginCallback
        );
    }

</script>


@endsection
