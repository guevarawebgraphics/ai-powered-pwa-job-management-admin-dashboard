@extends('admin.layouts.auth')

@section('content')

<style>
    .btn--custom-default {
        background: transparent;
        color:#ac1b1e;
        border: 3px solid #ac1b1e;
        border: 0;
        display: block;
        width: 100%;
        padding: 12px;
        font-weight: bold;
        font-size: 1.2em;
        transition: all 0.3s ease;
    }
    .btn--custom-default:hover {
        color:#fff;
        background: #f2623d !important;
    }
</style>
    {{--Login Form--}}
    {{ Form::open([
        'method' => 'POST',
        'id' => 'form-login',
        'route' => ['otp.store'],
        'class' => 'form-horizontal form-bordered form-control-borderless'
        ]) }}
        <div class="form-group{{ $errors->has('otp_code') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                    <input type="text" id="otp_code" name="otp_code" class="form-control input-lg" placeholder="One Time Password" value="{{ old('otp_code') }}" autofocus>
                </div>
                @if ($errors->has('otp_code'))
                    <span id="otp_code-error" class="help-block animation-slideDown">
                    {{ $errors->first('otp_code') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-12">
                
                <button type="submit" class="btn btn-sm btn-primary">Verify
                </button>
                
            </div>
        </div>
    {{ Form::close() }}


    {{ Form::open([
        'method' => 'POST',
        'id' => 'form-login',
        'route' => ['otp.send'],
        'class' => 'form-horizontal form-bordered form-control-borderless'
    ]) }}

        <div class="form-group form-actions">
            <div class="col-xs-12">
                
                <button type="submit" class="btn btn-sm btn--custom-default">Resend OTP
                </button>
                
            </div>
        </div>

         <div class="form-group form-actions">
            <div class="col-xs-12 text-right">
                <a href="{{url('admin/logout')}}" class="text-white" style="    color: #fff;">
                    <i class="fa fa-users"></i> Switch Account</a>
            </div>
        </div>
    {{ Form::close() }}

    {{--END Login Form--}}
@endsection

@push('extrascripts')
{!! NoCaptcha::renderJs() !!}
@endpush
