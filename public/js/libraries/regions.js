(function () {
    "use strict";
    /* declare global variables within the class */
    var uiRegionTable,
        uiCreateRegionForm,
        uiEditRegionForm,
        uiRegionDatatable,
        uiInputBannerImage,
        uiRemoveImgBtn,
        uiInputFile,
        uiRemoveFileBtn,
        filler;

    /* private ajax function that will send request to backend */
    function _ajax(oParams, fnCallback, uiBtn) {
        if (platform.var_check(oParams)) {
            var oAjaxConfig = {
                "type": oParams.type,
                "data": oParams.data,
                "url": oParams.url,
                "token": platform.config('csrf.token'),
                "beforeSend": function () {
                    /* check if there is a button to add spinner */
                    if (platform.var_check(uiBtn)) {
                        platform.show_spinner(uiBtn, true);
                    }
                },
                "success": function (oData) {
                    console.log(oData);
                    if (typeof(fnCallback) == 'function') {
                        fnCallback(oData);
                    }
                },
                "complete": function () {
                    /* check if there is a button to remove spinner */
                    if (platform.var_check(uiBtn)) {
                        platform.show_spinner(uiBtn, false);
                    }
                }
            };

            return platform.CentralAjax.ajax(oAjaxConfig);
        }
    }

    /* private fileselect function that will check/validate files input */
    function _fileselect(element, numFiles, label, ext, filetype) {
        var input = $(element).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        var uiImgContainer = $(element).parents('.form-group:first').find('.img-responsive');
        var uiFileContainer = $(element).parents('.form-group:first').find('.file-anchor');

        if (element.val() == '') {
            uiImgContainer.attr('src', uiImgContainer.attr('alt'));
            uiImgContainer.parents('.zoom:first').attr('href', uiImgContainer.attr('alt'));
            uiFileContainer.attr('href', '');
            uiFileContainer.text('');
            element.closest('.form-group').find('.remove-image-btn').hide();
            element.closest('.form-group').find('.remove-file-btn').hide();
            _fileselect_error(element, input, 'File is required.');
        } else {
            if (platform.var_check(filetype) && filetype == 'file') {
                if (ext == 'docx' || ext == 'doc' || ext == 'pdf') {
                    element.closest('.form-group').find('.help-block').remove();
                    element.closest('.form-group').removeClass('has-success has-error');
                    element.closest('.form-group').find('.remove-file-btn').show();
                    element.closest('.form-group').find('input.remove-file').val(0);

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log) {
                            console.log(log);
                        }
                    }
                } else {
                    uiFileContainer.attr('href', '');
                    uiFileContainer.text('');
                    element.closest('.form-group').find('.remove-image-btn').hide();
                    element.closest('.form-group').find('.remove-file-btn').hide();
                    _fileselect_error(element, input, 'The upload file must be a file of type: docx, doc, pdf.');
                }
            } else {
                if (ext == 'jpeg' || ext == 'jpg' || ext == 'png') {
                    element.closest('.form-group').find('.help-block').remove();
                    element.closest('.form-group').removeClass('has-success has-error');
                    element.closest('.form-group').find('.remove-image-btn').show();
                    element.closest('.form-group').find('input.remove-image').val(0);

                    if (input.length) {
                        input.val(log);
                        platform.readURL($(element).get(0).files[0], uiImgContainer, []);
                    } else {
                        if (log) {
                            console.log(log);
                        }
                    }
                }
                else {
                    uiImgContainer.attr('src', uiImgContainer.attr('alt'));
                    uiImgContainer.parents('.zoom:first').attr('href', uiImgContainer.attr('alt'));
                    element.closest('.form-group').find('.remove-image-btn').hide();
                    element.closest('.form-group').find('.remove-file-btn').hide();
                    _fileselect_error(element, input, 'The upload file must be a file of type: jpeg, jpg, png.');
                }
            }
        }

        element.closest('.form-group').find('.remove-image-btn').off('click').on('click', function () {
            uiImgContainer.attr('src', '');
            uiImgContainer.attr('alt', '');
            uiImgContainer.parents('.zoom:first').attr('href', uiImgContainer.attr('alt'));
            input.val('');
            element.val('');
            element.closest('.form-group').find('.remove-image-btn').hide();
            element.closest('.form-group').find('input.remove-image').val(1);
        });

        element.closest('.form-group').find('.remove-file-btn').off('click').on('click', function () {
            uiFileContainer.attr('href', '');
            uiFileContainer.text('');
            input.val('');
            element.val('');
            element.closest('.form-group').find('.remove-file-btn').hide();
            element.closest('.form-group').find('input.remove-file').val(1);
        });
    }

    /* private fileselect_error function that will append/display error messages of file input */
    function _fileselect_error(element, input, msg) {
        element.closest('.form-group').find('.help-block').remove();
        element.closest('.form-group').removeClass('has-success has-error').addClass('has-error');
        element.parents('.form-group > div').append('<span id="file-error" class="help-block animation-slideDown">' + msg + '</span>');
        element.val('');
        input.val('');
    }

    /*
     * This js file will only contain press events
     *
     * */
    CPlatform.prototype.region = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiRegionTable = $('#regions-table');
            uiCreateRegionForm = $('#create-region');
            uiEditRegionForm = $('#edit-region');
            uiRegionDatatable = null;
            uiInputBannerImage = $('input[name="banner_image"]');
            uiInputFile = $('input[name="file"]');
            uiRemoveImgBtn = $('.remove-image-btn');
            uiRemoveFileBtn = $('.remove-file-btn');

            uiRegionDatatable = platform.region.initialize_datatable();

            /* create press validation */
            uiCreateRegionForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiCreateRegionForm.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                ignore: [':hidden:not([type="file"])'],
                errorPlacement: function (error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.form-group').find('.help-block').remove();
                },
                success: function (e) {
                    e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').find('.help-block').remove();
                },
                submitHandler: function (form) {
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'FAQQuestion': {
                        required: true
                    },
                    'FAQAnswer': {
                        required: true
                    },
                    'FAQVideoTag': {
                        required: true
                    }
                },
                messages: {
                    'FAQQuestion': {
                        required: 'Question is required.'
                    },
                    'FAQAnswer': {
                        required: 'Answer is required.'
                    },
                    'FAQVideoTag': {
                        required: 'Video tag is required.'
                    }
                }
            });

            /* edit press validation */
            uiEditRegionForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiEditRegionForm.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                ignore: [':hidden:not([type="file"])'],
                errorPlacement: function (error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.form-group').find('.help-block').remove();
                },
                success: function (e) {
                    e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').find('.help-block').remove();
                },
                submitHandler: function (form) {
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'name': {
                        required: true
                    },
                    'video_url': {
                        required: true
                    },
                    'date': {
                        required: true
                    },
                    'content': {
                        required: true
                    }
                },
                messages: {
                    'name': {
                        required: 'Name is required.'
                    },
                    'video_url': {
                        required: 'Video URL is required.'
                    },
                    'date': {
                        required: 'Date is required.'
                    },
                    'content': {
                        required: 'Content is required.'
                    }
                }
            });

            /* delete press button ajax */
            $('body').on('click', '.delete-region-btn', function (e) {
                e.preventDefault();
                var self = $(this);
                /* open confirmation modal */
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete this record?",
                    type: "warning",
                    showCancelButton: true,
                    //confirmButtonColor: "#27ae60",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: true
                }, function (isConfirm) {
                    /* if confirmed, send request ajax */
                    if (isConfirm) {
                        var oParams = {
                            'data': {'id': self.attr('data-region-id')},
                            'url': self.attr('data-region-route')
                        };
                        platform.delete.delete(oParams, function (oData) {
                            /* check return of ajax */
                            if (platform.var_check(oData)) {
                                /* check status if success */
                                if (oData.status > 0) {
                                    /* if status is true, render success messages */
                                    if (platform.var_check(oData.message)) {
                                        for (var x in oData.message) {
                                            var message = oData.message[x];
                                            swal({
                                                'title': "Deleted!",
                                                'text': message,
                                                'type': "success"
                                                //'confirmButtonColor': "#DD6B55",
                                            }, function () {
                                                /* remove press container */
                                                // $('[data-press-id="' + oData.data.id + '"]').remove();
                                                if (platform.var_check(uiRegionDatatable)) {
                                                    uiRegionDatatable.row(self.parents('tr:first')).remove();
                                                }

                                                uiRegionDatatable = platform.region.initialize_datatable();

                                                /* check if there are other presses to hide the table header and show the no presses found */
                                                if ($('tr[data-region-id]').length == 0) {
                                                    $('.region-empty').removeClass('johnCena');
                                                    $('.table-responsive').addClass('johnCena');
                                                }
                                            });
                                        }
                                    }
                                }
                                else {
                                    /* if status is false, render error messages */
                                    if (platform.var_check(oData.message)) {
                                        for (var x in oData.message) {
                                            var message = oData.message[x];
                                            swal({
                                                'title': "Error!",
                                                'text': message,
                                                'type': "error"
                                                //'confirmButtonColor': "#DD6B55",
                                            }, function () {

                                            });
                                        }
                                    }
                                }
                            }
                        }, self);
                    }
                });
            });

            /* input file event */
            uiInputBannerImage.on('change', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
                    sValue = $(this).val(),
                    ext = sValue.substring(sValue.lastIndexOf('.') + 1).toLowerCase();
                _fileselect($(this), numFiles, label, ext, 'image');
            });

            uiInputFile.on('change', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
                    sValue = $(this).val(),
                    ext = sValue.substring(sValue.lastIndexOf('.') + 1).toLowerCase();
                _fileselect($(this), numFiles, label, ext, 'file');
            });

            uiRemoveImgBtn.off('click').on('click', function () {
                var uiImgContainer = $(this).parents('.form-group:first').find('.img-responsive');
                var input = $(this).parents('.form-group:first').find('.input-group').find(':text');
                var element = $(this).parents('.form-group:first').find('input[type="file"]');
                uiImgContainer.attr('src', '');
                uiImgContainer.attr('alt', '');
                uiImgContainer.parents('.zoom:first').attr('href', uiImgContainer.attr('alt'));
                input.val('');
                element.val('');
                element.closest('.form-group').find('.remove-image-btn').hide();
                element.closest('.form-group').find('input.remove-image').val(1);
            });

            uiRemoveFileBtn.off('click').on('click', function () {
                var uiFileContainer = $(this).parents('.form-group:first').find('.file-anchor');
                var input = $(this).parents('.form-group:first').find('.input-group').find(':text');
                var element = $(this).parents('.form-group:first').find('input[type="file"]');
                uiFileContainer.attr('href', '');
                uiFileContainer.text('');
                input.val('');
                element.val('');
                element.closest('.form-group').find('.remove-file-btn').hide();
                element.closest('.form-group').find('input.remove-file').val(1);
            });
        },

        initialize_datatable: function () {
            if (platform.var_check(uiRegionDatatable)) {
                uiRegionDatatable.destroy();
            }

            /* presses table initialize datatable */
            uiRegionDatatable = uiRegionTable.DataTable({
                "order": [],
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'All']],
                "ordering": true,
                "info": true,
                "searching": true,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': []
                }]
            });

            return uiRegionDatatable;
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.region.initialize();
});