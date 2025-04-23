@extends('admin.layouts.base')

@section('content')
    @if (auth()->user()->can('Create Machine'))
        <div class="row text-center">
            <div class="col-sm-12 col-lg-12">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#uploadFileModal" class="widget widget-hover-effect2">
                    <div class="widget-extra themed-background">
                        <h4 class="widget-content-light">
                            Add New Files
                        </h4>
                    </div>
                    <div class="widget-extra-full">
                        <span class="h2 text-primary animation-expandOpen">
                            <i class="fa fa-plus"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    @endif
    
    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-newspaper-o sidebar-nav-icon"></i>
                <strong>Machine Files</strong>
            </h2>
        </div>
        <div class="alert alert-info alert-dismissable gig-empty {{getOpenAIFiles()->count() == 0 ? '' : 'johnCena' }}">
            <i class="fa fa-info-circle"></i> No Gigs found.
        </div>
        <div class="table-responsive {{ count(getOpenAIFiles()) == 0 ? 'johnCena' : '' }}">
            <table  id="machines-table" class="table table-bordered table-striped table-vcenter">
                <thead>
                <tr role="row">
                    <th class="text-center">
                        ID
                    </th>
                    <th class="text-center">
                        Model Number
                    </th>
                    <th class="text-center">
                        OpenAI File ID
                    </th>
                    <th class="text-center">
                        Image URL
                    </th>
                    <th class="text-center">
                        Date Created
                    </th>
                    <th class="text-center">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach(getOpenAIFiles() ?? [] as $field)
                    <tr data-id="{{$field->id}}">
                        <td class="text-center">
                            {{ $field->id }}
                        </td>
                        <td class="text-center">
                            {{ $field->model_number }}
                        </td>
                        <td class="text-center">
                            {{ $field->file_id }}
                        </td>
                        <td class="text-center">
                              <a href="{{ url('public' . $field->image) }}">
                                   {{ $field->image }}
                                </a>
                           
                        </td>
                        <td class="text-center">
                            {{ date('F d, Y', strtotime($field->created_at)) }}
                        </td>
                        <td class="text-center">
                                @if (auth()->user()->can('Delete Machine'))
                                    <a href="javascript:void(0)" data-toggle="tooltip"
                                       title=""
                                       class="btn btn-xs btn-danger delete-machine-btn"
                                       data-original-title="Delete"
                                       data-machine-id="{{ $field->id }}"
                                       data-machine-route="#">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal for file upload -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">Add New Files</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <!-- Standard form (without the Dropzone class on the form) -->
                    <form action="#" method="POST" enctype="multipart/form-data" class="form-horizontal" id="my-form">
                        @csrf
                        <!-- Machine Select Field -->
                        <div class="form-group{{ $errors->has('model_number') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="model_number">Machine</label>
                            <div class="col-md-9">
                                <select class="form-control" id="model_number" name="model_number">
                                    <option value="" selected>Select Machine</option>
                                    @foreach(getMachine() ?? [] as $field)
                                        <option value="{{ $field->model_number }}">
                                            {{ $field->model_number }}: {{ strtoupper($field->machine_type) }}, {{ strtoupper($field->brand_name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('model_number'))
                                    <span class="help-block animation-slideDown">{{ $errors->first('model_number') }}</span>
                                @endif
                            </div>
                        </div>
    
                        <!-- Dropzone Container -->
                        <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label" for="files">

                            </label>
                            <div class="col-md-9">
                                <div id="my-dropzone" class="dropzone">
                                    <div class="dz-message" style="font-size: 20px !important;">
                                        Drag and drop files here or click to select files. <br><em style="font-size: 14px;"><small>(Note: Maximum 10 files, concurrent uploads.)</small></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Dropzone Container -->
                    </form>
                </div>
    
                <div class="modal-footer">
                    <!-- Save changes triggers the Dropzone queue processing -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="my-form" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extrascripts')
    <!-- Include Dropzone CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css"
          integrity="sha512-JaTRPZ3itcFB9sFPOxiFOwk8ABaBkM9RHE6IYvU/aiWLSF1A0rjuYlJcVEeBjkHwW+eEiB8qsLSdVh1kJ+n1BQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Include Dropzone JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"
            integrity="sha512-Qio3K+P9OmRhxiIfbmHzdh4uysbsSs1ZKL//JK3kDptlzFofLMx+3rLom1zIpyp2vKxRjMUztBxyR+v+BpwwDA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
    <script>
        // Disable autoDiscover so that Dropzone doesn't attach automatically
        Dropzone.autoDiscover = false;

        // We'll keep track of whether any file had an error
        let uploadErrors = false;

        // Initialize Dropzone
        var myDropzone = new Dropzone("#my-dropzone", {
            url: "{{ route('admin.openai') }}", // Ensure this route is defined and accepts POST
            paramName: "file",
            maxFilesize: 100, // MB
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.doc,.docx",
            dictDefaultMessage: "Drag files here to upload, or click to select files",
            addRemoveLinks: true,
            autoProcessQueue: false, // Wait for manual trigger (Save changes button)
            parallelUploads: 10, // Increase this value to allow more concurrent uploads
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            sending: function(file, xhr, formData) {
                // Add the model_number value for each file request
                formData.append("model_number", document.getElementById("model_number").value);
            },
            init: function() {
                let dzInstance = this;

                this.on("success", function(file, response) {
                    // Remove any default tooltip on success
                    if (file.previewElement) {
                        file.previewElement.removeAttribute("title");
                    }
                });

                this.on("error", function(file, response) {
                    console.error("Error uploading file:", response);
                    uploadErrors = true; // Mark that at least one file has errored

                    let errorMessage = "An error occurred while uploading.";

                    // Parse Laravel validation errors if present
                    if (typeof response === "object" && response.errors) {
                        if (response.errors.model_number) {
                            errorMessage = response.errors.model_number[0];
                        } else if (response.errors.file) {
                            errorMessage = response.errors.file[0];
                        } else if (response.message) {
                            errorMessage = response.message;
                        }
                    } else if (typeof response === "string") {
                        errorMessage = response;
                    } else if (response && response.message) {
                        errorMessage = response.message;
                    }

                    // Show SweetAlert error
                    swal({
                        title: "Upload Error",
                        text: errorMessage,
                        type: "error",
                        html: true,
                        allowEscapeKey: true,
                        allowOutsideClick: true,
                    });

                    // Optionally, update the inline error message in Dropzone preview
                    // if (file.previewElement) {
                    //     file.previewElement.querySelector("[data-dz-errormessage]").textContent = errorMessage;
                    // }
                });

                this.on("removedfile", function(file) {
                    console.log("File removed:", file);
                });

                // When all files in the queue finish uploading (regardless of success or failure)
                this.on("queuecomplete", function() {
                    // Only show success swal if there were no errors
                    if (!uploadErrors) {
                        swal({
                            title: "Success!",
                            text: "All files uploaded successfully.",
                            type: "success",
                            html: true,
                            allowEscapeKey: true,
                            allowOutsideClick: true,
                        }, function () {
                            // Clear Dropzone and close modal on success
                            dzInstance.removeAllFiles(true);
                            $('#uploadFileModal').modal('hide');
                        });
                    }
                    // Reset the error flag for the next upload session
                    uploadErrors = false;
                });
            }
        });

        // Bind the form's submit event to process the Dropzone queue
        $("#my-form").on("submit", function(e) {
            e.preventDefault();

            // Validate that a machine is selected
            if (!document.getElementById("model_number").value) {
                swal({
                    title: "Validation Error",
                    text: "Please select a machine before saving changes.",
                    type: "warning",
                    html: true,
                    allowEscapeKey: true,
                    allowOutsideClick: true,
                });
                return false;
            }

            // Check if there are any accepted files in Dropzone
            if (myDropzone.getAcceptedFiles().length === 0) {
                swal({
                    title: "No Files",
                    text: "Please add at least one file before saving changes.",
                    type: "warning",
                    html: true,
                    allowEscapeKey: true,
                    allowOutsideClick: true
                });
            } else {
                myDropzone.processQueue();
            }
        });

        // Initialize Select2 for the machine dropdown and disable its search box
        $('select[name="model_number"]').select2({
            placeholder: 'Select Machine..',
            theme: 'bootstrap-5', // Use 'bootstrap-4' if needed
            containerCssClass: 'form-control',
            width: '100%'
        });
    </script>

    <script type="text/javascript" src="{{ asset('public/js/libraries/machines.js') }}"></script>
@endpush