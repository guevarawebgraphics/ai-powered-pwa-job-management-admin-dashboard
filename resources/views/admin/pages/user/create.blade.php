@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li><span href="javascript:void(0)">Add New User</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'POST',
            'id' => 'create-user',
            'route' => ['admin.users.store'],
            'class' => 'form-horizontal '
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Add new User</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="first_name">Firstname</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               value="{{  Request::old('first_name') ?? '' }}"
                               placeholder="Enter firstname..">
                        @if($errors->has('first_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                </div>
                 <div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="middle_name">Midlle name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="middle_name" name="middle_name"
                               value="{{  Request::old('middle_name') ?? '' }}"
                               placeholder="Enter Midlle name..">
                        @if($errors->has('middle_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('middle_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="last_name">Lastname</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               value="{{  Request::old('last_name') ?? '' }}"
                               placeholder="Enter lastname..">
                        @if($errors->has('last_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                </div>

               

                <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="user_name">Username</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="user_name" name="user_name"
                               value="{{  Request::old('user_name') ?? '' }}"
                               placeholder="Enter username..">
                        @if($errors->has('user_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('user_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="mobile_no">Phone Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                               value="{{  Request::old('mobile_no') ?? '' }}"
                               placeholder="Enter Mobile Number..">
                        @if($errors->has('mobile_no'))
                            <span class="help-block animation-slideDown">{{ $errors->first('mobile_no') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('home_no') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="home_no">Home Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="home_no" name="home_no"
                               value="{{  Request::old('home_no') ?? '' }}"
                               placeholder="Enter Home Number..">
                        @if($errors->has('home_no'))
                            <span class="help-block animation-slideDown">{{ $errors->first('home_no') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('professional_title') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="professional_title">Professional Title</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="professional_title" name="professional_title"
                               value="{{  Request::old('professional_title') ?? '' }}"
                               placeholder="Enter Professional Title..">
                        @if($errors->has('professional_title'))
                            <span class="help-block animation-slideDown">{{ $errors->first('professional_title') }}</span>
                        @endif
                    </div>
                </div>
                  <div class="form-group{{ $errors->has('user_rating') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="user_rating">User Rating</label>

                    <div class="col-md-9">
                        <select class="form-control" id="user_rating" name="user_rating">
                            <option value="0" selected>0 Star</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Star</option>
                            <option value="3" >3 Star</option>
                            <option value="4">4 Star</option>
                            <option value="5">5 Star</option>
                        </select>
                        @if($errors->has('user_rating'))
                            <span class="help-block animation-slideDown">{{ $errors->first('user_rating') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('current_address') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="current_address">Current Address</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="current_address" name="current_address"
                               value="{{  Request::old('current_address') ?? '' }}"
                               placeholder="Enter Current Address..">
                        @if($errors->has('current_address'))
                            <span class="help-block animation-slideDown">{{ $errors->first('current_address') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('service_area') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="service_area">Service Area</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="service_area" name="service_area"
                               value="{{  Request::old('service_area') ?? ''}}"
                               placeholder="Enter Current Address..">
                        @if($errors->has('service_area'))
                            <span class="help-block animation-slideDown">{{ $errors->first('service_area') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="email">Email</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email" name="email"
                               value="{{  Request::old('email') ?? '' }}"
                               placeholder="Enter email..">
                        @if($errors->has('email'))
                            <span class="help-block animation-slideDown">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="password">Password</label>

                    <div class="col-md-9">
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Enter password..">
                        @if($errors->has('password'))
                            <span class="help-block animation-slideDown">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="password_confirmation">Password Confirmation</label>

                    <div class="col-md-9">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                               placeholder="Verify Password..">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active" name="is_active"
                                   value="1" checked>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="roles">Assign Roles</label>
                    <div class="col-md-9">
                        @if(!$roles->isEmpty())
                            <h4></h4>
                            @foreach ($roles as $role)
                                {{ Form::radio('roles[]', $role->id) }}
                                {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                            @endforeach
                        @endif
                        @if($errors->has('roles'))
                            <span class="help-block animation-slideDown">{{ $errors->first('roles') }}</span>
                        @endif
                    </div>
                </div>

                 <div class="form-group{{ $errors->has('rank_type') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="rank_type">Technician Rank Type</label>

                    <div class="col-md-9">
                        <select class="form-control" id="rank_type" name="rank_type"
                               value="{{  Request::old('rank_type') ?? '' }}">
                            <option value="0" selected>Apprentice</option>
                            <option value="1">Journey</option>
                            <option value="2">Master</option>
                        </select>
                        @if($errors->has('rank_type'))
                            <span class="help-block animation-slideDown">{{ $errors->first('rank_type') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/libraries/users.js') }}"></script>
@endpush