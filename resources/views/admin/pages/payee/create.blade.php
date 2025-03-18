@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.payees.index') }}">Payees</a></li>
        <li><span href="javascript:void(0)">Add New Payee</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'POST',
            'id' => 'create-payee',
            'route' => ['admin.payees.store'],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Add new Payee</strong></h2>
                </div>


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
                    <label class="col-md-3 control-label" for="email">Email</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email" name="email"
                               placeholder="Enter Payee Email.." value="{{ old('email') }}">
                        @if($errors->has('email'))
                            <span class="help-block animation-slideDown">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('other_emails') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="other_emails">
                        <i class="fa fa-info-circle"  data-toggle="tooltip" data-placement="top" title="Hit ENTER after typing it will create a tag on each email entry."></i> Other Emails</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="other_emails" name="other_emails" value="{!! old('other_emails') !!}"
                            placeholder="Enter Other Emails..">
                        @if($errors->has('other_emails'))
                            <span class="help-block animation-slideDown">{{ $errors->first('other_emails') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="phone_number">Phone Number</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                               placeholder="Enter Payee Phone Number.." value="{{ old('phone_number') }}">
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


                {{-- <div class="form-group{{ $errors->has('extra_field1') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field1">Extra Field #1</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="extra_field1" name="extra_field1"
                               placeholder="Enter Extra Field#1.." value="{{ old('extra_field1') }}">
                        @if($errors->has('extra_field1'))
                            <span class="help-block animation-slideDown">{{ $errors->first('extra_field1') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('extra_field2') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="extra_field2">Extra Field #2</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="extra_field2" name="extra_field2"
                               placeholder="Enter Extra Field#2.." value="{{ old('extra_field2') }}">
                        @if($errors->has('extra_field2'))
                            <span class="help-block animation-slideDown">{{ $errors->first('extra_field2') }}</span>
                        @endif
                    </div>
                </div> --}}

                {{-- <div class="form-group{{ $errors->has('banner_image') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="payee_banner_image">Banner Image</label>
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
                    <label class="col-md-3 control-label" for="payee_file">File</label>
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
                        <a href="{{ route('admin.payees.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/payees.js') }}"></script>
    <script>
        
        $('input[name="other_emails"]').amsifySuggestags({
            type :'bootstrap',
            selectOnHover:true
        });

        $('input[name="other_phone_numbers"]').amsifySuggestags({
            type :'bootstrap',
            selectOnHover:true
        });

    </script>
@endpush