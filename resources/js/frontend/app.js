import '../bootstrap';
import '../plugins';

import './common';

jQuery('document').ready(function ($) {
    //Global
    siyApp.ajaxSwalError = function (error) {
        if (error.status == 401) {
            location.reload();
        }
        if ($.isEmptyObject(error)) {
            Swal.fire({
                title: 'Oops!!',
                text: 'Something went wrong. Please try again.',
                type: 'error',
                customClass: 'sweat-alert-confirm'
            });
        } else {
            var error_text = '';
            if (!$.isEmptyObject(error.responseText)) {
                var responseText = JSON.parse(error.responseText);
                if ($.isArray(responseText.errors)) {
                    $.each(responseText.errors, function (i, v) {
                        error_text = error_text + '<br>' + v;
                    });
                } else {
                    error_text = responseText.message;
                }
            } else {
                error_text = 'Something went wrong. Please try again.';
            }
            Swal.fire({
                title: 'Oops!!',
                text: error_text,
                type: 'error',
                customClass: 'sweat-alert-confirm'
            });
        }
    };
    siyApp.ajaxInputError = function (error, formSel) {
        if (error.status == 401) {
            location.reload();
        }
        //removing all error classes
        formSel.find('.is-invalid').removeClass('is-invalid');
        formSel.find('.invalid-feedback').remove();
        if ($.isEmptyObject(error)) {
            Swal.fire({
                title: 'Oops!!',
                text: 'Something went wrong. Please try again.',
                type: 'error',
                customClass: 'sweat-alert-confirm'
            });
        } else {
            if (!$.isEmptyObject(error.responseText)) {
                var responseText = JSON.parse(error.responseText);
                $.each(responseText.errors, function (i, v) {
                    if ($.isArray(v)) {
                        var textValue = '';
                        $.each(v, function (i, value) {
                            textValue = textValue + ' ' + value;
                        });
                    } else {
                        var textValue = v;
                    }
                    var elementSel = formSel.find('[name="' + i + '"]');
                    if (elementSel.attr('type') == "radio") {
                        elementSel.addClass('is-invalid').parents('.radio-ul').append('<div class="invalid-feedback">' + textValue + '</div>');
                    } else if (i == 'interest') {
                        formSel.find('[name="' + i + '[]"]').parents('.interest-parent').append('<div class="invalid-feedback">' + textValue + '</div>');
                    } else {
                        formSel.find('.alert').addClass('alert-danger').append('<div class="invalid-feedback">' + textValue + '</div>');
                    }
                });
            }
        }
    };
    
    siyApp.ajaxInputErrorAmadeus = function (error, formSel) {
        if (error.status == 401) {
            location.reload();
        }
       
        //removing all error classes
        formSel.find('.alert-danger').text('');
        formSel.find('.alert-danger').removeClass('alert-danger');
        formSel.find('.is-invalid').removeClass('is-invalid');
        formSel.find('.invalid-feedback').remove();
        if ($.isEmptyObject(error)) {
            Swal.fire({
                title: 'Oops!!',
                text: 'Something went wrong. Please try again.',
                type: 'error',
                customClass: 'sweat-alert-confirm'
            });
        } else {

            if (!$.isEmptyObject(error)) {
                var responseText = error;
                $.each(responseText.errors, function (i, v) {
                    if ($.isArray(v)) {
                        var textValue = '';
                        $.each(v, function (i, value) {
                            textValue = textValue + ' ' + value;
                        });
                    } else {
                        var textValue = v.detail;
                    }
                    var elementSel = formSel.find('[name="' + i + '"]');
                    if (elementSel.attr('type') == "radio") {
                        elementSel.addClass('is-invalid').parents('.radio-ul').append('<div class="invalid-feedback">' + textValue + '</div>');
                    } else if (i == 'interest') {
                        formSel.find('[name="' + i + '[]"]').parents('.interest-parent').append('<div class="invalid-feedback">' + textValue + '</div>');
                    } else {
                        formSel.find('.alert').addClass('alert-danger').text(textValue);
                    }
                });
            }
        }
    };
    
}); 
    