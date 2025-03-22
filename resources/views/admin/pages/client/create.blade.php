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

                <div class="form-group{{ $errors->has('appliance_owned') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="appliance_owned">Appliances Owned</label>

                    <div class="col-md-6">
                        <div id="select-container"></div>

                        <!-- Add New Select Dropdown Button -->
                        <button class="btn btn-primary mt-3" type="button" id="btn--add-more">
                            <i class="fa fa-plus"></i>
                        </button>

                        @if($errors->has('appliance_owned'))
                            <span class="help-block animation-slideDown">{{ $errors->first('appliance_owned') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formModal">
                            <i class="fa fa-plus"></i> Add New Machine
                        </button>
                    </div>
                </div>

                
                <div class="form-group{{ $errors->has('payee_id') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="payee_id">Payee</label>

                    <div class="col-md-6">
                        <select class="form-control" id="payee_id" name="payee_id">
                            <option value="" selected>Choose Payee</option>
                            @foreach(getPayee() ?? [] as $field )
                                <option value="{{$field->payee_id}}">{{$field->payee_name}} {{$field->payee_last_name}} ({{ $field->email }})</option>
                            @endforeach
                        </select>
                        @if($errors->has('payee_id'))
                            <span class="help-block animation-slideDown">{{ $errors->first('payee_id') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formPayeeModal">
                            <i class="fa fa-plus"></i> Add New Payee
                        </button>
                    </div>
                </div>
                


                 {{-- <div class="form-group{{ $errors->has('insurance_plan') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="insurance_plan">Insurance Plan</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="insurance_plan" name="insurance_plan"
                               placeholder="Enter Insurance Plan.." value="{{ old('insurance_plan') }}">
                        @if($errors->has('insurance_plan'))
                            <span class="help-block animation-slideDown">{{ $errors->first('insurance_plan') }}</span>
                        @endif
                    </div>
                </div> --}}

                
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

                <div class="form-group{{ $errors->has('other_emails') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="other_emails">
                        <i class="fa fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Hit ENTER after typing it will create a tag on each email entry."></i>
                        Other Emails
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="other_emails" name="other_emails"
                            placeholder="Enter Other Emails.." value="{!! old('other_emails') !!}">
                        @if($errors->has('other_emails'))
                            <span class="help-block animation-slideDown">{{ $errors->first('other_emails') }}</span>
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
                    <label class="col-md-3 control-label" for="other_phone_numbers">
                         <i class="fa fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Hit ENTER after typing it will create a tag on each Phone Number entry."></i>
                         Other Phone Numbers</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="other_phone_numbers" name="other_phone_numbers"
                               placeholder="Enter Other Phone Numbers.." value="{!! old('other_phone_numbers') !!}">
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
                        <select class="form-control" id="state" name="state">
                            <option class="FL" selected>FL</option>
                        </select>
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

                {{-- <div class="form-group{{ $errors->has('maintenance_plan') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="maintenance_plan">Maintenance Plan</label>

                    <div class="col-md-9">
                          <input type="text" class="form-control" id="maintenance_plan" name="maintenance_plan"
                               placeholder="Enter Maintenance Plan.." value="{{ old('maintenance_plan') }}">
                        @if($errors->has('maintenance_plan'))
                            <span class="help-block animation-slideDown">{{ $errors->first('maintenance_plan') }}</span>
                        @endif
                    </div>
                </div> --}}

                {{-- <div class="form-group{{ $errors->has('extra_field1') ? ' has-error' : '' }}">
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
                </div> --}}

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


               
                {{-- <div class="form-group">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active" name="is_active"
                                   value="1" checked>
                            <span></span>
                        </label>
                    </div>
                </div> --}}

                <div class="form-group" style="display:none;">
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

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Add New Machine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                {{  Form::open([
                    'method' => 'POST',
                    'id' => 'create-machine',
                    'route' => ['admin.machines.store'],
                    'class' => 'form-horizontal ',
                    'files' => TRUE
                    ])
                }}
                    <div class="modal-body">

                        <div class="form-group{{ $errors->has('model_number') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="model_number">Model Number</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="model_number" name="model_number"
                                    placeholder="Enter Model Number.." value="{{ old('model_number') }}">
                                @if($errors->has('model_number'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('model_number') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('brand_name') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="brand_name">Brand Name</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="brand_name" name="brand_name"
                                    placeholder="Enter Brand Name.." value="{{ old('brand_name') }}">
                                @if($errors->has('brand_name'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('brand_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('machine_type') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="machine_type">Machine Type</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="machine_type" name="machine_type"
                                    placeholder="Enter Machine Type.." value="{{ old('machine_type') }}">
                                @if($errors->has('machine_type'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('machine_type') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('banner_image') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="file">Banner Image</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            Choose File <input type="file" class="form-control" name="banner_image" style="display: none !important;">
                                            <input type="hidden" class="fld" name="banner_image" value="">
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                @if($errors->has('banner_image'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('banner_image') }}</span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('extra_field1') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="extra_field1">Extra Field #1</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="extra_field1" name="extra_field1"
                                    placeholder="Enter Extra Field #1.." value="{{ old('extra_field1') }}">
                                @if($errors->has('extra_field1'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('extra_field1') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('extra_field2') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="extra_field2">Extra Field #2</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="extra_field2" name="extra_field2"
                                    placeholder="Enter Extra Field #2.." value="{{ old('extra_field2') }}">
                                @if($errors->has('extra_field2'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('extra_field2') }}</span>
                                @endif
                            </div>
                        </div>

                

                        <div class="form-group" style="display:none;">
                            <label class="col-md-3 control-label">Is Active?</label>

                            <div class="col-md-9">
                                <label class="switch switch-primary">
                                    <input type="checkbox" name="is_active"
                                        value="1" checked>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    <div class="modal fade" id="formPayeeModal" tabindex="-1" role="dialog" aria-labelledby="formPayeeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formPayeeModalLabel">Add New Payee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{  Form::open([
                'method' => 'POST',
                'id' => 'create-payee',
                'route' => ['admin.payees.store'],
                'class' => 'form-horizontal ',
                'files' => TRUE
                ])
            }}
            
                    <div class="modal-body">

                        <div class="form-group{{ $errors->has('payee_name') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="payee_name">First Name</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="payee_name" name="payee_name"
                                    placeholder="Enter Payee First name.." value="{{ old('payee_name') }}">
                                @if($errors->has('payee_name'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('payee_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('payee_last_name') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="payee_last_name">Last Name</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="payee_last_name" name="payee_last_name"
                                    placeholder="Enter Payee Last name.." value="{{ old('payee_last_name') }}">
                                @if($errors->has('payee_last_name'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('payee_last_name') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="email_payee">Email</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="email_payee" name="email"
                                    placeholder="Enter Payee Email.." value="{{ old('email') }}">
                                @if($errors->has('email'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('other_emails') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="other_emails_payee">
                                <i class="fa fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Hit ENTER after typing it will create a tag on each email entry."></i> Other Emails</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="other_emails_payee" name="other_emails" value="{!! old('other_emails') !!}"
                                    placeholder="Enter Other Emails..">
                                @if($errors->has('other_emails'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('other_emails') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="phone_number_payee">Phone Number</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="phone_number_payee" name="phone_number"
                                    placeholder="Enter Payee Phone Number.." value="{{ old('phone_number') }}">
                                @if($errors->has('phone_number'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('other_phone_numbers') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="other_phone_numbers_payee">
                                <i class="fa fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Hit ENTER after typing it will create a tag on each Phone Number entry."></i>
                                Other Phone Numbers</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="other_phone_numbers_payee" name="other_phone_numbers"
                                    placeholder="Enter Other Phone Numbers.." value="{!! old('other_phone_numbers') !!}">
                                @if($errors->has('other_phone_numbers'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('other_phone_numbers') }}</span>
                                @endif

                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('payee_notes') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="payee_notes">Payee Notes</label>

                            <div class="col-md-9">
                                <textarea class="form-control" id="payee_notes" name="payee_notes">{{ old('payee_notes') }}</textarea>
                                @if($errors->has('payee_notes'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('payee_notes') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('payee_relation') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="payee_relation">Relation</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="payee_relation" name="payee_relation"
                                    placeholder="Enter Payee Relation.." value="{{ old('payee_relation') }}">
                                @if($errors->has('payee_relation'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('payee_relation') }}</span>
                                @endif
                            </div>
                        </div>

                                

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    
                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    

    <script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/libraries/clients.js') }}"></script>



        <script>

        $(document).ready(function () {
            @if($errors->has('model_number') || $errors->has('brand_name') || $errors->has('machine_type'))
                $('#formModal').modal('show')
            @endif

            @if($errors->has('payee_name') || $errors->has('payee_last_name') || $errors->has('email') )
                $('#formPayeeModal').modal('show')
            @endif

        });
        
        var machines = @json(getMachine()); // Convert PHP array to JavaScript array

        let applianceOwned = @json(''); // Get stored IDs

        let selectedMachineIds = [];
        if (applianceOwned.trim() !== '') {
            selectedMachineIds = applianceOwned.split(','); // Convert to array
        }
        // Initialize data object
        let data = {};

        console.log(selectedMachineIds);

        // Parse applianceOwned if it's not empty
        if (applianceOwned.trim() !== '') {
            let selectedModels = applianceOwned.split(','); // Convert to array

            selectedModels.forEach((model, index) => {
                data["machine_" + index] = model; // Store in data object with a unique key
            });
        }

        function renderDropdowns() {
            $("#select-container").empty(); // Clear existing inputs
            selectedMachineIds.forEach((machineId, index) => {
                let dropdownHtml = `
                    <div class="input-group mb-2" data-key="${index}" style="display:flex;">
                        <select name="appliance_owned[]" class="form-control w-50 p-3 input--dropdown">
                            <option value="">Select Machine</option>
                            ${machines.map(machine => `
                                <option value="${machine.machine_id}" ${machine.machine_id == machineId ? 'selected' : ''}>
                                    ${machine.model_number} - ${machine.brand_name} - ${machine.machine_type}
                                </option>
                            `).join('')}
                        </select>
                        <button class="btn btn-danger btn--delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;

                console.log(dropdownHtml);
                $("#select-container").append(dropdownHtml);
            });
        }

        // Render Initial Dropdowns
        renderDropdowns();

        // Handle Select Change
        $(document).on("change", ".input--dropdown", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            let selectedValue = $(this).val();
            data[key] = selectedValue;
            selectedMachineIds[key] = selectedValue; // Update array to keep track
        });

        // Add New Select Dropdown
        $("#btn--add-more").click(function() {
            selectedMachineIds.push(""); // Add empty slot
            renderDropdowns();
        });

        // Remove Dropdown
        $(document).on("click", ".btn--delete", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            selectedMachineIds.splice(key, 1); // Remove from array
            renderDropdowns();
        });


        $('input[name="other_emails"]').amsifySuggestags({
            type :'bootstrap',
            selectOnHover:true
        });

        $('input[name="other_phone_numbers"]').amsifySuggestags({
            type :'bootstrap',
            selectOnHover:true
        });



        $('input[name="other_emails_payee"]').amsifySuggestags({
            type :'bootstrap',
            selectOnHover:true
        });

        $('input[name="other_phone_numbers_payee"]').amsifySuggestags({
            type :'bootstrap',
            selectOnHover:true
        });
    </script>
@endpush