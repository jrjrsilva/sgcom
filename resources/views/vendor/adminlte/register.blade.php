@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="register-box">
        <!--<div class="register-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>-->

        <div class="register-box-body">
            
            <p class="login-box-msg"><img src="http://sgcom.cprcatlantico.com.br/logo_systemPNG.png"></p>
            <p class="login-box-msg">{{ trans('adminlte::adminlte.register_message') }}</p>
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback {{ $errors->has('matricula') ? 'has-error' : '' }}">
                    <input type="text" id="matricula"  name="matricula" class="form-control" value="{{ old('matricula') }}"
                    placeholder="Informe sua matricula">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('matricula'))
                        <span class="help-block">
                            <strong>{{ $errors->first('matricula') }}</strong>
                           
                        </span>
                    @endif
                </div>
<input type="hidden" id="opm_id" name="opm_id"  value="" >
<input type="hidden" id="efetivo_id" name="efetivo_id" value="">

                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                           placeholder="{{ trans('adminlte::adminlte.full_name') }}" readonly>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    @if ($errors->has('efetivo'))
                    <span class="help-block">
                        <strong>{{ $errors->first('efetivo') }}</strong>
                    </span>
                @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >{{ trans('adminlte::adminlte.register') }}</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    @yield('js')
<script>
     $('#matricula').focus(function () {       
        $('#name').val("");
        $('#efetivo_id').val("");
        $('#opm_id').val("");        
    });
    
    $('#matricula').blur(function () {
        var matr = $(this).val();
     
        $.get('/rh/matricula/'+matr, function (efetivo) {
        $('#name').val("");
           $('#name').val(efetivo[0].nome);
           $('#efetivo_id').val(efetivo[0].id);
            $('#opm_id').val(efetivo[0].opm_id);
            
        }); 
    });    
</script>
@stop
