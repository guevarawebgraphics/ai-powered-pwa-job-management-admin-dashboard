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


                                
                <div class="form-group{{ $errors->has('model_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="model_number">Machine</label>

                    <div class="col-md-9">
                        <select class="form-control" id="model_number" name="model_number">
                            <option value="" selected>Choose your Machine</option>
                            @foreach( getMachine() ?? [] as $field )
                                <option value="{{$field->model_number}}" {{ $gig->model_number == $field->model_number ? 'selected' : ''}}>{{$field->model_number}} {{$field->brand_name}} {{$field->machine_type}} </option>
                            @endforeach
                        </select>
                        @if($errors->has('model_number'))
                            <span class="help-block animation-slideDown">{{ $errors->first('model_number') }}</span>
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

                
                <div class="form-group{{ $errors->has('customer_input') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="customer_input">Customer Input</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="customer_input" name="customer_input" placeholder=" The dryer is turning on but not drying the clothes. It Tumbles but it does not seem to get hot. ">{{ old('customer_input') ?? $gig->customer_input }}</textarea>
                        @if($errors->has('customer_input'))
                            <span class="help-block animation-slideDown">{{ $errors->first('customer_input') }}</span>
                        @endif
                    </div>
                </div>



                <div class="form-group{{ $errors->has('gig_price') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="gig_price">Price</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="gig_price" name="gig_price" value="{{ old('gig_price') ?? $gig->gig_price }}" placeholder="0.00">
                        @if($errors->has('gig_price'))
                            <span class="help-block animation-slideDown">{{ $errors->first('gig_price') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('gig_discount') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="gig_discount">Discount</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="gig_discount" name="gig_discount" value="{{ old('gig_discount') ?? $gig->gig_discount  }}" placeholder="0.00">
                        @if($errors->has('gig_discount'))
                            <span class="help-block animation-slideDown">{{ $errors->first('gig_discount') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('client_id') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="client_id">Client</label>

                    <div class="col-md-9">
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

                    <div class="col-md-9">
                        <textarea class="form-control" id="trainee_included" name="trainee_included">{{ old('gig_price') ?? $gig->trainee_included }}</textarea>
                        @if($errors->has('trainee_included'))
                            <span class="help-block animation-slideDown">{{ $errors->first('trainee_included') }}</span>
                        @endif
                    </div>
                </div>


                
                <div class="form-group{{ $errors->has('resolution') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="resolution">Resolution</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="resolution" name="resolution">{{ old('resolution') ?? $gig->resolution }}</textarea>
                        @if($errors->has('resolution'))
                            <span class="help-block animation-slideDown">{{ $errors->first('resolution') }}</span>
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
                
                <div class="form-group{{ $errors->has('qb_invoice_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="qb_invoice_number">Invoice Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="qb_invoice_number" name="qb_invoice_number"
                               placeholder="Enter Invoice Number.." value="{{ old('qb_invoice_number') ?? $gig->qb_invoice_number }}">
                        @if($errors->has('qb_invoice_number'))
                            <span class="help-block animation-slideDown">{{ $errors->first('qb_invoice_number') }}</span>
                        @endif
                    </div>
                </div>


                {{-- <div class="form-group{{ $errors->has('parts_used') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="parts_used">Parts Used</label>

                    <div class="col-md-9">
                        <textarea class="form-control" id="parts_used" name="parts_used">{{ old('parts_used') ?? $gig->parts_used }}</textarea>
                        @if($errors->has('parts_used'))
                            <span class="help-block animation-slideDown">{{ $errors->first('parts_used') }}</span>
                        @endif
                    </div>
                </div> --}}

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


                <div class="form-group{{ $errors->has('extra_field1') ? ' has-error' : '' }}">
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
                </div>


                <div class="form-group{{ $errors->has('top_recommended_repairs') ? ' has-error' : '' }}">
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
                </div>

                <div class="form-group{{ $errors->has('time_started') ? ' has-error' : '' }}">
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
                </div>


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
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active" name="is_active"
                                   value="1" {{ Request::old('is_active') ? : ($gig->is_active ? 'checked' : '') }}>
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
@endsection

@push('extrascripts')
    <script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/libraries/gigs.js') }}"></script>

 <script>
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
    </script>
@endpush