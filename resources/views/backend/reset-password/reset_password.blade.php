<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Kopilibrasi || Reset Password</title>
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon"
          href="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('vendor/crudbooster/assets/logo_crudbooster.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{asset('vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('vendor/crudbooster/assets/adminlte/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/main.css")}}'/>
    
    {{-- <style type="text/css">
        .login-page, .register-page {
            background: {{ CRUDBooster::getSetting("login_background_color")?:'#dddddd'}} url('{{ CRUDBooster::getSetting("login_background_image")?asset(CRUDBooster::getSetting("login_background_image")):asset('vendor/crudbooster/assets/bg_blur3.jpg') }}');
            color: {{ CRUDBooster::getSetting("login_font_color")?:'#ffffff' }}  !important;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .login-box-body {
            box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.8);
            background: rgba(255, 255, 255, 0.9);
            color: {{ CRUDBooster::getSetting("login_font_color")?:'#666666' }}  !important;
        }
    </style> --}}
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{url('/')}}">
            <img title='{!!($appname == 'CRUDBooster')?"<b>CRUD</b>Booster":$appname!!}'
                 src='{{ CRUDBooster::getSetting("logo")?asset(CRUDBooster::getSetting('logo')):asset('vendor/crudbooster/assets/logo_crudbooster.png') }}'
                 style='max-width: 100%;max-height:170px'/>
        </a>
    </div>
    <div class="login-box-body">

        @if (isset($error))
            <div class='alert alert-warning'>
                {{ $error }}
            </div>
            <div class="col-xs-8">
                {{cbLang("forgot_text_try_again")}} <a href='{{route("getLogin")}}'>{{cbLang("click_here")}}</a>
            </div>
        @elseif(session()->has('successreset'))
            <div class='alert alert-success'>
                {{ session()->get('successreset') }}
            </div>
            <div class="col-xs-8">
                {{cbLang("forgot_text_try_again")}} <a href='{{route("getLogin")}}'>{{cbLang("click_here")}}</a>
            </div>
        @else
            @if(session()->has('errorreset'))
            <div class='alert alert-warning'>
                {{ session()->get('errorreset') }}
            </div>
            @endif
            <p class="login-box-msg">Masukkan password baru anda</p>
            <form action="{{ route('resetpass.submit') }}" method="post">
                @csrf
                <input type="hidden" name="resettoken" value="{{$token}}">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <div class="form-group has-feedback">
                    <input autocomplete='off' type="password" class="form-control" name='new_password' id="new_password" required placeholder="Masukan Password Baru"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <span id="messagePassword"></span>
                </div>
                <div class="form-group has-feedback">
                    <input autocomplete='off' type="password" class="form-control" name='conf_password' id="conf_password" required placeholder="Konfirmasi Password Baru"/>
                    <span  class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <span id="messageConfPassword"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        {{cbLang("forgot_text_try_again")}} <a href='{{route("getLogin")}}'>{{cbLang("click_here")}}</a>
                    </div>
                    <div class="col-xs-4">
                        <button id="savebtn" type="submit" class="btn btn-primary btn-block btn-flat">{{cbLang("button_submit")}}</button>
                    </div>
                </div>
            </form>
        @endif
        <br/>
        <!--a href="#">I forgot my password</a-->

    </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="{{asset('vendor/crudbooster/assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.4.1 JS -->
<script src="{{asset('vendor/crudbooster/assets/adminlte/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        var btnSave = $('#savebtn');
        btnSave.attr('disabled', 'disabled');
        $('#new_password, #conf_password').on('keyup', function () {
        if ($('#new_password').val().length < 6) {
            $('#messageConfPassword').html('');
            $('#messagePassword').html('Minimal panjang password 6 karakter').css('color', 'red');
            btnSave.attr('disabled', true);
        } else{
            $('#messagePassword').html('');
            if ($('#new_password').val() == $('#conf_password').val()) {
                $('#messageConfPassword').html('Konfirmasi Password sesuai').css('color', 'green');
                btnSave.removeAttr("disabled");
            } else {
                $('#messageConfPassword').html('Konfirmasi Password tidak sama').css('color', 'red');
                btnSave.attr('disabled', true);
            }
        }
        
        });
    });
    
</script>
</body>
</html>
