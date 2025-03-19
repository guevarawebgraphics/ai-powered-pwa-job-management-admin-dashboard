@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.machines.index') }}">Machines</a></li>
        <li><span href="javascript:void(0)">Edit Machine</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-machine',
            'route' => ['admin.machines.update', $machine->machine_id],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit Machine "{{$machine->model_number}}"</strong></h2>
                </div>
               
                <div class="form-group{{ $errors->has('model_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="model_number">Model Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="model_number" name="model_number"
                               placeholder="Enter Model Number.." value="{{ old('model_number') ?? $machine->model_number }}">
                        @if($errors->has('model_number'))
                            <span class="help-block animation-slideDown">{{ $errors->first('model_number') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('brand_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="brand_name">Brand Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="brand_name" name="brand_name"
                               placeholder="Enter Brand Name.." value="{{ old('brand_name') ?? $machine->brand_name }}">
                        @if($errors->has('brand_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('brand_name') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('machine_type') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="machine_type">Machine Type</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="machine_type" name="machine_type"
                               placeholder="Enter Machine Type.." value="{{ old('machine_type') ?? $machine->machine_type }}">
                        @if($errors->has('machine_type'))
                            <span class="help-block animation-slideDown">{{ $errors->first('machine_type') }}</span>
                        @endif
                    </div>
                </div>


                {{-- <div class="form-group{{ $errors->has('service_manual') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="service_manual">Service Manual</label>

                    <div class="col-md-9">
                        <textarea class="form-control ckeditor" id="service_manual" name="service_manual">{!! old('service_manual') ?? $machine->service_manual !!}</textarea>
                        @if($errors->has('service_manual'))
                            <span class="help-block animation-slideDown">{{ $errors->first('service_manual') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('parts_diagram') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="parts_diagram">Parts Diagram</label>

                    <div class="col-md-9">

                        <textarea class="form-control ckeditor" id="parts_diagram" name="parts_diagram">{!! old('parts_diagram') ?? $machine->parts_diagram !!}</textarea>

                        @if($errors->has('parts_diagram'))
                            <span class="help-block animation-slideDown">{{ $errors->first('parts_diagram') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('service_pointers') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="service_pointers">Service Pointers</label>

                    <div class="col-md-9">
                        <textarea class="form-control ckeditor" id="service_pointers" name="service_pointers">{!! old('service_pointers') ?? $machine->service_pointers !!}</textarea>

                        @if($errors->has('service_pointers'))
                            <span class="help-block animation-slideDown">{{ $errors->first('service_pointers') }}</span>
                        @endif
                    </div>
                </div> --}}

                <div class="form-group{{ $errors->has('banner_image') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="machine_banner_image">Banner Image</label>
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
                        <a href="{{ $machine->machine_photo }}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">
                            <img src="{{ $machine->machine_photo != '' ? $machine->machine_photo : '' }}"
                                 alt="{{ $machine->machine_photo != '' ? $machine->machine_photo : '' }}"
                                 class="img-responsive center-block" style="max-width: 100px;">
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-image-btn"
                           style="display: {{ $machine->machine_photo != '' ? '' : 'none' }};"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_banner_image" class="remove-image" value="0">
                    </div>
                </div>

                {{-- <div class="form-group file-container {{ $errors->has('file') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="machine_file">File</label>
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
                        <a target="_blank" href="{{ asset($machine->file) }}" class="file-anchor">
                            {{ $machine->file }}
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-file-btn"
                           style="display: {{ $machine->file != '' ? '' : 'none' }};"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_file" class="remove-file" value="0">
                    </div>
                </div> --}}

    
                <div class="form-group{{ $errors->has('extra_field1') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field1">Extra Field #1</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="extra_field1" name="extra_field1"
                               placeholder="Enter Extra Field #1.." value="{{ old('extra_field1') ?? $machine->extra_field1 }}">
                        @if($errors->has('extra_field1'))
                            <span class="help-block animation-slideDown">{{ $errors->first('extra_field1') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('extra_field2') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field2">Extra Field #2</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="extra_field2" name="extra_field2"
                               placeholder="Enter Extra Field #2.." value="{{ old('extra_field2') ?? $machine->extra_field2 }}">
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
                                   value="1" {{ Request::old('is_active') ? : ($machine->is_active ? 'checked' : '') }}>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.machines.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/machines.js') }}"></script>
@endpush