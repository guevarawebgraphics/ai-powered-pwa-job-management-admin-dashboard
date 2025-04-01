@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.gigs.index') }}">Gigs</a></li>
        <li><span href="javascript:void(0)">Edit Gig</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-gig',
            'route' => ['admin.gigs.update', $gig->gig_id],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit Gig "{{$gig->gig_cryptic}}"</strong></h2>
                </div>
                
                {{-- 
                    <div class="form-group{{ $errors->has('gig_cryptic') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label" for="gig_cryptic">GIG Cryptic</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="gig_cryptic" name="gig_cryptic"
                                placeholder="Enter Gig Cryptic.." value="{{ old('gig_cryptic') ?? $gig->gig_cryptic }}">
                            @if($errors->has('gig_cryptic'))
                                <span class="help-block animation-slideDown">{{ $errors->first('gig_cryptic') }}</span>
                            @endif
                        </div>
                    </div> 
                --}}

                
                <div class="form-group{{ $errors->has('client_id') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="client_id">Client</label>

                    <div class="col-md-6">
                        <select class="form-control" id="client_id" name="client_id">
                            <option value="" selected>Choose your Client</option>
                            @foreach( getClient() ?? [] as $field )
                                <option value="{{$field->client_id}}" {{ $gig->client_id == $field->client_id ? 'selected' : ''}}>{{$field->client_name}} {{$field->client_last_name}} ({{$field->email}})</option>
                            @endforeach
                        </select>
                        @if($errors->has('client_id'))
                            <span class="help-block animation-slideDown">{{ $errors->first('client_id') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3">
                        {{-- <a href="{{url('admin/clients/create')}}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Add New Client
                        </a> --}}
                         <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formClientModal">
                            <i class="fa fa-plus"></i> Add New Client
                        </button>
                    </div>
                </div>

                

                                
                <div class="form-group{{ $errors->has('model_number_main') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="model_number_main">Machine</label>

                    <div class="col-md-6">
                        <select class="form-control" id="model_number_main" name="model_number_main">
                            <option value="" selected>Choose your Machine</option>
                            @foreach( getMachine() ?? [] as $field )
                                <option value="{{$field->model_number}}" {{ $gig->model_number == $field->model_number ? 'selected' : ''}}>{{$field->model_number}} {{$field->brand_name}} {{$field->machine_type}} </option>
                            @endforeach
                        </select>
                        @if($errors->has('model_number_main'))
                            <span class="help-block animation-slideDown">{{ $errors->first('model_number_main') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3">
                        {{-- <a href="{{url('admin/machines/create')}}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Add New Machine
                        </a> --}}
                         <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formModal">
                            <i class="fa fa-plus"></i> Add New Machine
                        </button>
                    </div>
                </div>


                <div class="form-group{{ $errors->has('serial_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="serial_number">Serial Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="serial_number" name="serial_number"
                               placeholder="Enter Serial Number.." value="{{ old('serial_number') ?? $gig->serial_number }}">
                        @if($errors->has('serial_number'))
                            <span class="help-block animation-slideDown">{{ $errors->first('serial_number') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('initial_issue') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="initial_issue">Initial Issue</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="initial_issue" name="initial_issue" placeholder="The machine is overheating after prolonged use.">{{ old('initial_issue') ?? $gig->initial_issue }}</textarea>
                        @if($errors->has('initial_issue'))
                            <span class="help-block animation-slideDown">{{ $errors->first('initial_issue') }}</span>
                        @endif
                    </div>
                </div>


                
                <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="start_date">Start Date</label>

                    <div class="col-md-9">
                        <input type="date" class="form-control" id="start_date" name="start_date"
                               placeholder="Enter Start Date.." value="{{ old('start_date', isset($gig) ? date('Y-m-d', strtotime($gig->start_datetime)) : '') }}">
                        @if($errors->has('start_date'))
                            <span class="help-block animation-slideDown">{{ $errors->first('start_date') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('start_time') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="start_time">Start Time</label>

                    <div class="col-md-9">
                        <input type="time" class="form-control" id="start_time" name="start_time"
                               placeholder="Enter Start Time.." value="{{ old('start_date', isset($gig) ? date('H:i', strtotime($gig->start_datetime)) : '') }}">
                        @if($errors->has('start_time'))
                            <span class="help-block animation-slideDown">{{ $errors->first('start_time') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('assigned_tech_id') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="assigned_tech_id">Technician</label>

                    <div class="col-md-9">
                        <select class="form-control" id="assigned_tech_id" name="assigned_tech_id">
                            <option value="" selected>Choose your Technician</option>
                            @foreach( getCustomers() ?? [] as $field )
                                <option value="{{$field->id}}" {{$gig->assigned_tech_id == $field->id ? 'selected' : '' }}>{{$field->name}} ({{$field->email}})</option>
                            @endforeach
                        </select>
                        @if($errors->has('assigned_tech_id'))
                            <span class="help-block animation-slideDown">{{ $errors->first('assigned_tech_id') }}</span>
                        @endif
                    </div>

                </div>

                

                <div class="form-group{{ $errors->has('trainee_included') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="trainee_included">Trainee Included</label>

                    <div class="col-md-6">
                        <div id="select-container-trainee"></div>

                        <!-- Add New Select Dropdown Button -->
                        <button class="btn btn-primary mt-3" type="button" id="btn--add-more-trainee">
                            <i class="fa fa-plus"></i>
                        </button>

                        @if($errors->has('trainee_included'))
                            <span class="help-block animation-slideDown">{{ $errors->first('trainee_included') }}</span>
                        @endif
                    </div>

                </div>

                <div class="form-group{{ $errors->has('gig_price') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="gig_price">Price</label>

                    <div class="col-md-9">
                        
                        <select class="form-control" id="gig_price" name="gig_price">   
                            @foreach( getPrices() ?? [] as $array )
                                <option value="{{$array['name']}}"
                                    {{ $gig->gig_price_detail == $array['name'] ? 'selected' : '' }}
                                >{{$array['name']}} 
                                    @if($array['name'] != "Other")
                                        (${{$array['amount']}})
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <input type="number" class="form-control mt-2 decimal" id="custom_gig_price" name="custom_gig_price"
                            value="{{$gig->gig_price}}"
                            placeholder="Enter custom price"
                            style="{{ $gig->gig_price_detail && $gig->gig_price_detail == "Other" ? 'display:block;' : 'display:none;' }}">

                        @if($errors->has('gig_price'))
                            <span class="help-block animation-slideDown">{{ $errors->first('gig_price') }}</span>
                        @endif
                    </div>
                </div>

                
                <div class="form-group{{ $errors->has('repair_notes') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="repair_notes">Repair Notes</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="repair_notes" name="repair_notes" placeholder="The machine is overheating after prolonged use.">{{ old('repair_notes') ?? $gig->repair_notes }}</textarea>
                        @if($errors->has('repair_notes'))
                            <span class="help-block animation-slideDown">{{ $errors->first('repair_notes') }}</span>
                        @endif
                    </div>
                </div>

                
                {{-- <div class="form-group{{ $errors->has('customer_input') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="customer_input">Customer Input</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="customer_input" name="customer_input" placeholder=" The dryer is turning on but not drying the clothes. It Tumbles but it does not seem to get hot. ">{{ old('customer_input') ?? $gig->customer_input }}</textarea>
                        @if($errors->has('customer_input'))
                            <span class="help-block animation-slideDown">{{ $errors->first('customer_input') }}</span>
                        @endif
                    </div>
                </div> --}}



                {{-- <div class="form-group{{ $errors->has('gig_price') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="gig_price">Price</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="gig_price" name="gig_price" value="{{ old('gig_price') ?? $gig->gig_price }}" placeholder="0.00">
                        @if($errors->has('gig_price'))
                            <span class="help-block animation-slideDown">{{ $errors->first('gig_price') }}</span>
                        @endif
                    </div>
                </div> --}}


                {{-- <div class="form-group">
                    <label class="col-md-3 control-label">Is Discounted?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_discount" name="is_discount"
                                   value="1" {{ Request::old('is_discount') ? : ($gig->is_discount == 1 ? 'checked' : '') }}>
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="form-group{{ $errors->has('gig_discount') ? ' has-error' : '' }}" id="discountContainer" style="{{ $gig->is_discount == 0 ? 'display:none;' : 'display:block;' }}">
                    <label class="col-md-3 control-label" for="gig_discount">Discount</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control decimal" id="gig_discount" name="gig_discount" value="{{ old('gig_discount') ?? $gig->gig_discount  }}" placeholder="0.00">
                        @if($errors->has('gig_discount'))
                            <span class="help-block animation-slideDown">{{ $errors->first('gig_discount') }}</span>
                        @endif
                    </div>
                </div> --}}


                {{-- <div class="form-group{{ $errors->has('trainee_included') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="trainee_included">Trainee Included</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="trainee_included" name="trainee_included">{{ old('gig_price') ?? $gig->trainee_included }}</textarea>
                        @if($errors->has('trainee_included'))
                            <span class="help-block animation-slideDown">{{ $errors->first('trainee_included') }}</span>
                        @endif
                    </div>
                </div> --}}


                
                {{-- <div class="form-group{{ $errors->has('resolution') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="resolution">Resolution</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="resolution" name="resolution">{{ old('resolution') ?? $gig->resolution }}</textarea>
                        @if($errors->has('resolution'))
                            <span class="help-block animation-slideDown">{{ $errors->first('resolution') }}</span>
                        @endif
                    </div>
                </div> --}}

                {{-- <div class="form-group{{ $errors->has('youtube_link') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="youtube_link">Youtube Link</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="youtube_link" name="youtube_link"
                               placeholder="Enter Youtube Link.." value="{{ old('youtube_link') ?? $gig->youtube_link }}">
                        @if($errors->has('youtube_link'))
                            <span class="help-block animation-slideDown">{{ $errors->first('youtube_link') }}</span>
                        @endif
                    </div>
                </div>
                 --}}
                {{-- <div class="form-group{{ $errors->has('qb_invoice_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="qb_invoice_number">Invoice Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="qb_invoice_number" name="qb_invoice_number"
                               placeholder="Enter Invoice Number.." value="{{ old('qb_invoice_number') ?? $gig->qb_invoice_number }}">
                        @if($errors->has('qb_invoice_number'))
                            <span class="help-block animation-slideDown">{{ $errors->first('qb_invoice_number') }}</span>
                        @endif
                    </div>
                </div> --}}


                {{-- 
                <div class="form-group{{ $errors->has('parts_used') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="parts_used">Parts Used</label>

                    <div class="col-md-9">
                        
                        <div id="textbox-container-parts-used">
                            @php
                                // Decode JSON safely
                                $json = $gig->parts_used ? json_decode($gig->parts_used, true) : [];
                            @endphp

                            @foreach ($json as $key => $field)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="parts_used[{{ $key }}]" value="{{ $field }}">
                                    <button type="button" class="btn btn-danger btn--delete-parts-used">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach

                        </div>

                        <!-- Add New Textbox Button -->
                        <button class="btn btn-primary mt-3" type="button" id="btn--add-more-parts-used">
                            <i class="fa fa-plus"></i>
                        </button>

                        @if($errors->has('parts_used'))
                            <span class="help-block animation-slideDown">{{ $errors->first('parts_used') }}</span>
                        @endif
                    </div>
                </div> 
                --}}



                {{-- <div class="form-group{{ $errors->has('extra_field1') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field1">Extra Field #1</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="extra_field1" name="extra_field1"
                               placeholder="Enter Extra Field #1.." value="{{ old('extra_field1') ?? $gig->extra_field1 }}">
                        @if($errors->has('extra_field1'))
                            <span class="help-block animation-slideDown">{{ $errors->first('extra_field1') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('extra_field2') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field2">Extra Field #2</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="extra_field2" name="extra_field2"
                               placeholder="Enter Extra Field #2.." value="{{ old('extra_field2') ?? $gig->extra_field2 }}">
                        @if($errors->has('extra_field2'))
                            <span class="help-block animation-slideDown">{{ $errors->first('extra_field2') }}</span>
                        @endif
                    </div>
                </div> --}}


                {{-- <div class="form-group{{ $errors->has('top_recommended_repairs') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="top_recommended_repairs">Top Recommended Repairs</label>

                    <div class="col-md-9">
                        
                        <div id="textbox-container">
                            @php
                                // Decode JSON safely
                                $json = $gig->top_recommended_repairs ? json_decode($gig->top_recommended_repairs, true) : [];
                            @endphp

                            @foreach ($json as $key => $field)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="top_recommended_repairs[{{ $key }}]" value="{{ $field }}">
                                    <button type="button" class="btn btn-danger btn--delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach

                        </div>

                        <!-- Add New Textbox Button -->
                        <button class="btn btn-primary mt-3" type="button" id="btn--add-more">
                            <i class="fa fa-plus"></i>
                        </button>

                        @if($errors->has('top_recommended_repairs'))
                            <span class="help-block animation-slideDown">{{ $errors->first('top_recommended_repairs') }}</span>
                        @endif
                    </div>
                </div> --}}

                {{-- <div class="form-group{{ $errors->has('time_started') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="time_started">Time Started</label>

                    <div class="col-md-9">
                        <input type="datetime-local" class="form-control" id="time_started" name="time_started"
                            placeholder="Enter Time Started.." 
                            value="{{ old('time_started') ?? ($gig->time_started ? \Carbon\Carbon::parse($gig->time_started)->format('Y-m-d\TH:i') : '') }}">
                        @if($errors->has('time_started'))
                            <span class="help-block animation-slideDown">{{ $errors->first('time_started') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('time_ended') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="time_ended">Time Ended</label>

                    <div class="col-md-9">
                        <input type="datetime-local" class="form-control" id="time_ended" name="time_ended"
                            placeholder="Enter Time Ended.." 
                            value="{{ old('time_ended') ?? ($gig->time_ended ? \Carbon\Carbon::parse($gig->time_ended)->format('Y-m-d\TH:i') : '') }}">
                        @if($errors->has('time_ended'))
                            <span class="help-block animation-slideDown">{{ $errors->first('time_ended') }}</span>
                        @endif
                    </div>
                </div> --}}


                {{-- <div class="form-group{{ $errors->has('banner_image') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="gig_banner_image">Banner Image</label>
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
                        <a href="{{ asset($gig->banner_image) }}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">
                            <img src="{{ $gig->banner_image != '' ? asset($gig->banner_image) : '' }}"
                                 alt="{{ $gig->banner_image != '' ? asset($gig->banner_image) : '' }}"
                                 class="img-responsive center-block" style="max-width: 100px;">
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-image-btn"
                           style="display: {{ $gig->banner_image != '' ? '' : 'none' }};"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_banner_image" class="remove-image" value="0">
                    </div>
                </div>

                <div class="form-group file-container {{ $errors->has('file') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="gig_file">File</label>
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
                        <a target="_blank" href="{{ asset($gig->file) }}" class="file-anchor">
                            {{ $gig->file }}
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-file-btn"
                           style="display: {{ $gig->file != '' ? '' : 'none' }};"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_file" class="remove-file" value="0">
                    </div>
                </div> --}}
                
                <div class="form-group" style="display:none;">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active" name="is_active"
                                   value="1" checked>

                                   {{-- {{ Request::old('is_active') ? : ($gig->is_active ? 'checked' : '') }} --}}
                            <span></span>
                        </label>
                    </div>
                </div>
                
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.gigs.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
                                {{-- <input type="text" class="form-control" id="brand_name" name="brand_name"
                                    placeholder="Enter Brand Name.." value="{{ old('brand_name') }}"> --}}
                                @php 
                                    $brand_names = json_decode(getSystemSettings('SS0008')->value);
                                    $oldBrand = old('brand_name'); 
                                    $brandSlugs = collect($brand_names)->pluck('slug')->toArray();
                                @endphp

                                <select class="form-control" id="brand_name" name="brand_name" placeholder="Enter Brand Name..">
                                    <option value="">Select Brand</option>
                                    
                                    @foreach($brand_names ?? [] as $value)
                                        <option value="{{ $value->slug }}" {{ $oldBrand == $value->slug ? 'selected' : '' }}>
                                            {{ $value->brand }}
                                        </option>
                                    @endforeach

                                    {{-- Always include "Other" --}}
                                    <option value="other" {{ (!empty($oldBrand) && !in_array($oldBrand, $brandSlugs)) ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>


                                <input type="text" class="form-control mt-2" id="custom_brand_name" name="custom_brand_name"
                                    value=""
                                    placeholder="Enter Brand Name"
                                    style="{{ Request::old('custom_brand_name') && Request::old('custom_brand_name') == "other" ? 'display:block;' : 'display:none;' }}">

                                @if($errors->has('brand_name'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('brand_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('machine_type') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="machine_type">Machine Type</label>

                            <div class="col-md-9">
                                
                                @php 
                                    $machine_types = json_decode(getSystemSettings('SS0009')->value);
                                    $oldMachineType = old('machine_type'); 
                                    $machineTypesSlug = collect($machine_types)->pluck('slug')->toArray();
                                @endphp

                                <select class="form-control" id="machine_type" name="machine_type" placeholder="Enter Machine Type..">
                                    <option value="">Select Machine Type</option>
                                    
                                    @foreach($machine_types ?? [] as $value)
                                        <option value="{{ $value->slug }}" {{ $oldMachineType == $value->slug ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach

                                    {{-- Always include "Other" --}}
                                    <option value="other" {{ (!empty($oldMachineType) && !in_array($oldMachineType, $machineTypesSlug)) ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>

                                <input type="text" class="form-control mt-2" id="custom_machine_type" name="custom_machine_type"
                                    value=""
                                    placeholder="Enter Machine Type"
                                    style="{{ Request::old('custom_machine_type') && Request::old('custom_machine_type') == "other" ? 'display:block;' : 'display:none;' }}">

                                @if($errors->has('machine_type'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('machine_type') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('display_type') ? ' has-error' : '' }}" id="displayTypeContainer">
                            <label class="col-md-3 control-label" for="display_type">Display Type</label>

                            <div class="col-md-9">
                                <input type="text" class="form-control" id="display_type" name="display_type" value="{!! old('display_type') !!}">

                                @if($errors->has('display_type'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('display_type') }}</span>
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
                                    <input type="checkbox" id="is_active" name="is_active"
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

    
    
        <!-- Modal -->
    <div class="modal fade" id="formClientModal" tabindex="-1" role="dialog" aria-labelledby="formClientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formClientModalLabel">Add New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{  Form::open([
                'method' => 'POST',
                'id' => 'create-client',
                'route' => ['admin.clients.store'],
                'class' => 'form-horizontal ',
                'files' => TRUE
                ])
            }}
            
                <div class="modal-body">

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
                        <div id="select-container-appliance_owned"></div>

                        <!-- Add New Select Dropdown Button -->
                        <button class="btn btn-primary mt-3" type="button" id="btn--add-more-appliance_owned">
                            <i class="fa fa-plus"></i>
                        </button>

                        @if($errors->has('appliance_owned'))
                            <span class="help-block animation-slideDown">{{ $errors->first('appliance_owned') }}</span>
                        @endif
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

                <div class="form-group{{ $errors->has('other_emails') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="other_emails">
                        <i class="fa fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Hit ENTER after typing it will create a tag on each email entry."></i>
                        Other Emails
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="other_emails" name="other_emails"
                            placeholder="Enter Other Emails.." value="{!! old('other_emails') !!}" style="display:none !important;">
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
                               placeholder="Enter Other Phone Numbers.." value="{!! old('other_phone_numbers') !!}"  style="display:none !important;">
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

                  <div class="form-group" style="display:none;">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active_client" name="is_active"
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
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/libraries/gigs.js') }}"></script>

 <script>

    $(document).ready(function () {
        @if($errors->has('model_number') || $errors->has('brand_name') || $errors->has('machine_type'))
            $('#formModal').modal('show')
        @endif
        @if($errors->has('client_name') || $errors->has('client_last_name') || $errors->has('appliance_owned')  || $errors->has('email'))
            $('#formClientModal').modal('show')
        @endif
    });

        var json = `{!!  $gig->top_recommended_repairs   !!}`;
        var parts_used_json = `{!!  $gig->parts_used   !!}`;

        let data = {}; // Default empty object
        let parts_used_data = {};

        // Validate and Parse JSON
        try {
            if (json && json.trim() !== "") {  // Ensure json is not null or empty
                data = JSON.parse(json);
            }
        } catch (e) {
            console.error("Invalid JSON. Falling back to empty object.", e);
            data = {}; // Set to empty object if parsing fails
        }

        try {
            if (parts_used_json && json.trim() !== "") {  // Ensure json is not null or empty
                parts_used_data = JSON.parse(parts_used_json);
            }
        } catch (e) {
            console.error("Invalid JSON. Falling back to empty object.", e);
            parts_used_data = {}; // Set to empty object if parsing fails
        }



                // Function to Render Textboxes
        function renderTextboxesPartsUsed() {
            $("#textbox-container-parts-used").empty(); // Clear existing inputs

            $.each(parts_used_data, function(key, value) {
                let textboxHtml = `
                    <div class="input-group mb-2" data-key="${key}" style="display:flex;">
                        <input type="text" name="parts_used[]" class="form-control w-50 p-3 input--textbox-parts-used" value="${value}">
                        <button class="btn btn-danger btn--delete-parts-used">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;
                $("#textbox-container-parts-used").append(textboxHtml);
            });
        }



        // Function to Render Textboxes
        function renderTextboxes() {
            $("#textbox-container").empty(); // Clear existing inputs

            $.each(data, function(key, value) {
                let textboxHtml = `
                    <div class="input-group mb-2" data-key="${key}" style="display:flex;">
                        <input type="text" name="top_recommended_repairs[]" class="form-control w-50 p-3 input--textbox" value="${value}">
                        <button class="btn btn-danger btn--delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;
                $("#textbox-container").append(textboxHtml);
            });
        }

        // Render Initial Textboxes
        renderTextboxes();
        renderTextboxesPartsUsed();

        // Handle Input Change
        $(document).on("input", ".input--textbox", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            data[key] = $(this).val();
        });
        $(document).on("input", ".input--textbox-parts-used", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            parts_used_data[key] = $(this).val();
        });

        // Add New Textbox
        $("#btn--add-more").click(function() {
            let newKey = "task_" + Date.now(); // Unique key
            data[newKey] = ""; // Add to JSON
            renderTextboxes();
        });
        $("#btn--add-more-parts-used").click(function() {
            let newKey = "task_" + Date.now(); // Unique key
            parts_used_data[newKey] = ""; // Add to JSON
            renderTextboxesPartsUsed();
        });

        // Remove Textbox
        $(document).on("click", ".btn--delete", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            delete data[key]; // Remove from JSON
            renderTextboxes();
        });
        $(document).on("click", ".btn--delete-parts-used", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            delete parts_used_data[key]; // Remove from JSON
            renderTextboxesPartsUsed();
        });

        $(document).on('click', '#is_discount', function () {
            $('#discountContainer').toggle();
        });

        
        $(document).on('change keyup', '#gig_price', function () {
            var customPriceInput = document.getElementById('custom_gig_price');
            
            if ($(this).val() == "Other") {
                $(customPriceInput).show().attr('required', 'required');
            } else {
                $(customPriceInput).hide().removeAttr('required');
            }
        });

        // Run on page load to check initial value
        $(document).ready(function () {
            $('#gig_price').trigger('change');
        });



        
        // Trainee Included
        var trainees = @json(getCustomers()); // Convert PHP array to JavaScript array

        let traineeIncluded = @json($gig->trainee_included ?? ''); // Get stored IDs

        
        console.log(traineeIncluded);
        
        let selectedTraineesID = [];
        if (traineeIncluded.trim() !== '') {
            selectedTraineesID = traineeIncluded.split(','); // Convert to array
        }
        // Initialize data object
        let trainee_data = {};


        // Parse traineeIncluded if it's not empty
        if (traineeIncluded.trim() !== '') {
            let selectedTrain = traineeIncluded.split(','); // Convert to array

            selectedTrain.forEach((model, index) => {
                trainee_data["trainee_" + index] = model; // Store in data object with a unique key
            });
        }

        function renderDropdownsTrainee() {
            $("#select-container-trainee").empty(); // Clear existing inputs
            selectedTraineesID.forEach((traineeId, index) => {
                let dropdownHtmlTrainee = `
                    <div class="input-group mb-2" data-key="${index}" style="display:flex;">
                        <select name="trainee_included[]" class="form-control w-50 p-3 input--dropdown-trainee">
                            <option value="">Select Trainee</option>
                            ${trainees.map(trainee_field => `
                                <option value="${trainee_field.id}" ${trainee_field.id == traineeId ? 'selected' : ''}>
                                    ${trainee_field.name} (${trainee_field.email})
                                </option>
                            `).join('')}
                        </select>
                        <button type="button" class="btn btn-danger btn--delete-trainee">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;

                console.log(dropdownHtmlTrainee);
                $("#select-container-trainee").append(dropdownHtmlTrainee);
            });

                    
            $('select[name="trainee_included[]"]').select2({
                placeholder: 'Select Client',
                theme: 'bootstrap-5', // Use 'bootstrap-4' if using Bootstrap 4
                containerCssClass: 'form-control', // Apply Bootstrap styling
                width: '100%', 
            });
        }

        // Render Initial Dropdowns
        renderDropdownsTrainee();

        // Handle Select Change
        $(document).on("change", ".input--dropdown-trainee", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            let selectedValue = $(this).val();
            trainee_data[key] = selectedValue;
            selectedTraineesID[key] = selectedValue; // Update array to keep track
        });

        // Add New Select Dropdown
        $("#btn--add-more-trainee").click(function() {
            selectedTraineesID.push(""); // Add empty slot
            renderDropdownsTrainee();
        });

        // Remove Dropdown
        $(document).on("click", ".btn--delete-trainee", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            selectedTraineesID.splice(key, 1); // Remove from array
            renderDropdownsTrainee();
        });














        


        $(document).ready(function () {
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
        let appliance_data = {};

        console.log(selectedMachineIds);

        // Parse applianceOwned if it's not empty
        if (applianceOwned.trim() !== '') {
            let selectedModels = applianceOwned.split(','); // Convert to array

            selectedModels.forEach((model, index) => {
                appliance_data["machine_" + index] = model; // Store in data object with a unique key
            });
        }

        function renderDropdowns() {
            $("#select-container-appliance_owned").empty(); // Clear existing inputs
            selectedMachineIds.forEach((machineId, index) => {
                let dropdownHtml = `
                    <div class="input-group mb-2" data-key="${index}" style="display:flex;">
                        <select name="appliance_owned[]" class="form-control w-50 p-3 input--dropdown-appliance_owned">
                            <option value="">Select Machine</option>
                            ${machines.map(machine => `
                                <option value="${machine.machine_id}" ${machine.machine_id == machineId ? 'selected' : ''}>
                                    ${machine.model_number} - ${machine.brand_name} - ${machine.machine_type}
                                </option>
                            `).join('')}
                        </select>
                        <button class="btn btn-danger btn--delete-appliance_owned">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                `;

                console.log(dropdownHtml);
                $("#select-container-appliance_owned").append(dropdownHtml);
            });

                        
            $('select[name="appliance_owned[]"]').select2({
                placeholder: 'Select Client',
                theme: 'bootstrap-5', // Use 'bootstrap-4' if using Bootstrap 4
                containerCssClass: 'form-control', // Apply Bootstrap styling
                width: '100%', 
            });

        }

        // Render Initial Dropdowns
        renderDropdowns();

        // Handle Select Change
        $(document).on("change", ".input--dropdown-appliance_owned", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            let selectedValue = $(this).val();
            appliance_data[key] = selectedValue;
            selectedMachineIds[key] = selectedValue; // Update array to keep track
        });

        // Add New Select Dropdown
        $("#btn--add-more-appliance_owned").click(function() {
            selectedMachineIds.push(""); // Add empty slot
            renderDropdowns();
        });

        // Remove Dropdown
        $(document).on("click", ".btn--delete-appliance_owned", function() {
            let key = $(this).closest(".input-group").attr("data-key");
            selectedMachineIds.splice(key, 1); // Remove from array
            renderDropdowns();
        });



$('#formClientModal').on('shown.bs.modal', function () {
    $('input[name="other_emails"]').css('display', 'none'); // Ensure it remains hidden
    $('input[name="other_emails"]').amsifySuggestags({
        type: 'bootstrap',
        selectOnHover: true
    });

    $('input[name="other_phone_numbers"]').css('display', 'none'); // Ensure it remains hidden
    $('input[name="other_phone_numbers"]').amsifySuggestags({
        type: 'bootstrap',
        selectOnHover: true
    });
});



$('select[name="client_id"]').select2({
    placeholder: 'Select Client',
    theme: 'bootstrap-5', // Use 'bootstrap-4' if using Bootstrap 4
    containerCssClass: 'form-control', // Apply Bootstrap styling
    width: '100%', 
});

$('select[name="assigned_tech_id"]').select2({
    placeholder: 'Select Technician',
    theme: 'bootstrap-5', // Use 'bootstrap-4' if using Bootstrap 4
    containerCssClass: 'form-control', // Apply Bootstrap styling
    width: '100%', 
});

$('select[name="model_number_main"]').select2({
    placeholder: 'Select Machine',
    theme: 'bootstrap-5', // Use 'bootstrap-4' if using Bootstrap 4
    containerCssClass: 'form-control', // Apply Bootstrap styling
    width: '100%', 
});


$('select[name="payee_id"]').select2({
    placeholder: 'Select Payee',
    theme: 'bootstrap-5', // Use 'bootstrap-4' if using Bootstrap 4
    containerCssClass: 'form-control', // Apply Bootstrap styling
    width: '100%', 
});

    </script>


<script>
        $(document).on('change keyup', '#brand_name', function () {
            var customPriceInput = document.getElementById('custom_brand_name');
            
            if ($(this).val() == "other") {
                $(customPriceInput).attr('style','display:block !important;').attr('required', 'required');
            } else {
                $(customPriceInput).attr('style','display:none !important;').removeAttr('required');
            }
        });

        // Run on page load to check initial value
        $(document).ready(function () {
            $('#brand_name').trigger('change');
        });



        $(document).on('change keyup', '#machine_type', function () {
            var customPriceInput = document.getElementById('custom_machine_type');
            
            if ($(this).val() == "other") {
                $(customPriceInput).attr('style','display:block !important;').attr('required', 'required');
            } else {
                $(customPriceInput).attr('style','display:none !important;').removeAttr('required');
            }


            var machine_type = $(this).val();
            if (machine_type == "washers" || machine_type == "stoves") {
                $(`#displayTypeContainer`).attr('style','display:block !important;');
            } else {
                $(`#displayTypeContainer`).attr('style','display:none !important;');
            }
        });

        // Run on page load to check initial value
        $(document).ready(function () {
            $('#machine_type').trigger('change');
        });


        $('#start_date, #start_time').trigger('change');
        
    $('#start_date, #start_time').on('change', function () {
    const date = $('#start_date').val();
    const time = $('#start_time').val();

    if (date && time) {
        checkAllTechAvailability(date, time);
    }
});

function checkAllTechAvailability(date, time) {
    $('#assigned_tech_id option').each(function () {
        const techId = $(this).val();
        if (!techId) return; // Skip placeholder
        checkTechAvailability(techId, date, time);
    });
}

function checkTechAvailability(techID, selectedDate, selectedTime) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "GET",
        dataType: 'JSON',
        url: `${sAdminBaseURI}/tech/schedules/${techID}`,
        success: function (response) {
            console.log(response);
            const scheduleData = response.data;
            const blackout = scheduleData.black_out_date;
            const schedules = scheduleData.schedules;

            const option = $(`#assigned_tech_id option[value="${techID}"]`);
            let isAvailable = true;

            // Check blackout range
            const selected = new Date(selectedDate);
            const from = new Date(blackout.from);
            const to = new Date(blackout.to);

            if (selected >= from && selected <= to) {
                isAvailable = false;
            }

            // Custom mapping: JS getDay (0–6) => DB (1=Sunday, ..., 7=Saturday)
            const dbDay = selected.getDay() + 1;

            const todaySchedule = schedules.find(s => parseInt(s.day) === dbDay);

            if (!todaySchedule || todaySchedule.is_close == 1 || !todaySchedule.open || !todaySchedule.close) {
                isAvailable = false;
            } else {
                const selectedTimeMinutes = toMinutes(selectedTime);
                const openMinutes = toMinutes(todaySchedule.open);
                const closeMinutes = toMinutes(todaySchedule.close);

                if (selectedTimeMinutes < openMinutes || selectedTimeMinutes > closeMinutes) {
                    isAvailable = false;
                }
            }

            if (!isAvailable) {
                option.attr('data-unavailable', 'true');
            } else {
                option.removeAttr('data-unavailable');
            }

            refreshSelect2Styling();
        }
    });
}

function toMinutes(timeStr) {
    const [hours, minutes] = timeStr.split(':').map(Number);
    return hours * 60 + minutes;
}

function refreshSelect2Styling() {
    $('select[name="assigned_tech_id"]').select2({
        placeholder: 'Select Technician',
        theme: 'bootstrap-5',
        width: '100%',
        templateResult: function (data) {
            if (!data.id) return data.text;

            const $option = $(`#assigned_tech_id option[value="${data.id}"]`);
            const unavailable = $option.attr('data-unavailable');

            if (unavailable) {
                return $('<span style="background-color: #ccc; color: #333; padding: 5px; border-radius: 4px;">' + data.text + '</span>');
            }

            return data.text;
        },
        templateSelection: function (data) {
            return data.text;
        }
    });
}

// Initial load for select2
$(document).ready(function () {
    refreshSelect2Styling();
});

</script>

@endpush