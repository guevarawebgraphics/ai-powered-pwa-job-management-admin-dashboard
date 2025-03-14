@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.clients.index') }}">Clients</a></li>
        <li><span href="javascript:void(0)">Add New Client</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'POST',
            'id' => 'create-client',
            'route' => ['admin.clients.store'],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Add new Client</strong></h2>
                </div>

                <div class="form-group{{ $errors->has('client_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="client_name">First Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="client_name" name="client_name"
                               placeholder="Enter Client First Name.." value="{{ old('client_name') }}">
                        @if($errors->has('client_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('client_name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('client_last_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="client_last_name">Last Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="client_last_name" name="client_last_name"
                               placeholder="Enter Client Last Name.." value="{{ old('client_last_name') }}">
                        @if($errors->has('client_last_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('client_last_name') }}</span>
                        @endif
                    </div>
                </div>


                 <div class="form-group{{ $errors->has('insurance_plan') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="insurance_plan">Insurance Plan</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="insurance_plan" name="insurance_plan"
                               placeholder="Enter Insurance Plan.." value="{{ old('insurance_plan') }}">
                        @if($errors->has('insurance_plan'))
                            <span class="help-block animation-slideDown">{{ $errors->first('insurance_plan') }}</span>
                        @endif
                    </div>
                </div>

                
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="email">Email</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email" name="email"
                               placeholder="Enter Email.." value="{{ old('email') }}">
                        @if($errors->has('email'))
                            <span class="help-block animation-slideDown">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="phone_number">Phone Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                               placeholder="Enter Phone Number.." value="{{ old('phone_number') }}">
                        @if($errors->has('phone_number'))
                            <span class="help-block animation-slideDown">{{ $errors->first('phone_number') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('other_phone_numbers') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="other_phone_numbers">Other Phone Numbers</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="other_phone_numbers" name="other_phone_numbers"
                               placeholder="Enter Other Phone Numbers.." value="{{ old('other_phone_numbers') }}">
                        @if($errors->has('other_phone_numbers'))
                            <span class="help-block animation-slideDown">{{ $errors->first('other_phone_numbers') }}</span>
                        @endif
                    </div>
                </div>

                
                <div class="form-group{{ $errors->has('street_address') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="street_address">Street Address</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="street_address" name="street_address"
                               placeholder="Enter Street Address.." value="{{ old('street_address') }}">
                        @if($errors->has('street_address'))
                            <span class="help-block animation-slideDown">{{ $errors->first('street_address') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="city">City</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="city" name="city"
                               placeholder="Enter City.." value="{{ old('city') }}">
                        @if($errors->has('city'))
                            <span class="help-block animation-slideDown">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('zip_code') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="zip_code">ZIP Code</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="zip_code" name="zip_code"
                               placeholder="Enter ZIP Code.." value="{{ old('zip_code') }}">
                        @if($errors->has('zip_code'))
                            <span class="help-block animation-slideDown">{{ $errors->first('zip_code') }}</span>
                        @endif
                    </div>
                </div>


                
                <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="state">State</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="state" name="state"
                               placeholder="Enter State.." value="{{ old('state') }}">
                        @if($errors->has('state'))
                            <span class="help-block animation-slideDown">{{ $errors->first('state') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="country">Country</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="country" name="country"
                               placeholder="Enter Country.." value="{{ old('country') }}">
                        @if($errors->has('country'))
                            <span class="help-block animation-slideDown">{{ $errors->first('country') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('client_notes') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="client_notes">Client Notes</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="client_notes" name="client_notes">{{ old('client_notes') }}</textarea>
                        @if($errors->has('client_notes'))
                            <span class="help-block animation-slideDown">{{ $errors->first('client_notes') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('maintenance_plan') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="maintenance_plan">Maintenance Plan</label>

                    <div class="col-md-9">
                          <input type="text" class="form-control" id="maintenance_plan" name="maintenance_plan"
                               placeholder="Enter Maintenance Plan.." value="{{ old('maintenance_plan') }}">
                        @if($errors->has('maintenance_plan'))
                            <span class="help-block animation-slideDown">{{ $errors->first('maintenance_plan') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('extra_field1') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field1">Extra Field #1</label>

                    <div class="col-md-9">
                         <input type="text" class="form-control" id="extra_field1" name="extra_field1"
                               placeholder="Enter Extra Field #1" value="{{ old('extra_field1') }}">
                        @if($errors->has('extra_field1'))
                            <span class="help-block animation-slideDown">{{ $errors->first('extra_field1') }}</span>
                        @endif
                    </div>
                </div>

                
                <div class="form-group{{ $errors->has('extra_field2') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field2">Extra Field #2</label>

                    <div class="col-md-9">
                         <input type="text" class="form-control" id="extra_field2" name="extra_field2"
                               placeholder="Enter Extra Field #2" value="{{ old('extra_field2') }}">
                        @if($errors->has('extra_field2'))
                            <span class="help-block animation-slideDown">{{ $errors->first('extra_field2') }}</span>
                        @endif
                    </div>
                </div>

                {{-- <div class="form-group{{ $errors->has('banner_image') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="client_banner_image">Banner Image</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <label class="input-group-btn">
                            <span class="btn btn-primary">
                                Choose File <input type="file" name="banner_image" style="display: none;">
                            </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        @if($errors->has('banner_image'))
                            <span class="help-block animation-slideDown">{{ $errors->first('banner_image') }}</span>
                        @endif
                    </div>
                    <div class="col-md-offset-3 col-md-9">
                        <a href="" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">
                            <img src="" alt="" class="img-responsive center-block" style="max-width: 100px;">
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-image-btn" style="display: none;"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_banner_image" class="remove-image" value="0">
                    </div>
                </div>
                <div class="form-group file-container {{ $errors->has('file') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="client_file">File</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <label class="input-group-btn">
                            <span class="btn btn-primary">
                                Choose File <input type="file" name="file" style="display: none;">
                            </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        @if($errors->has('file'))
                            <span class="help-block animation-slideDown">{{ $errors->first('file') }}</span>
                        @endif
                    </div>
                    <div class="col-md-offset-3 col-md-9">
                        <a href="" class="file-anchor"></a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-file-btn" style="display: none;"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_file" class="remove-file" value="0">
                    </div>
                </div> --}}


               
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
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
    <script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/libraries/clients.js') }}"></script>
@endpush