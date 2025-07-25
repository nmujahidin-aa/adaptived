let tomSelects = [];
function initSelect() {
    $('.tom-select-js').each(function () {
        let placeholder = $(this).attr('placeholder');
        placeholder = placeholder === undefined ? "Pilih salah satu" : placeholder;

        const id_control = '#' + $(this).attr('id');
        let selectControl = new TomSelect(id_control, {
            create: false,
            plugins: ['remove_button'],
            placeholder: placeholder
        });

        // check if any option default selected
        const defaultOption = $(this).find('option[selected]');
        if (defaultOption.length == 0) {
            selectControl.clear();
        }

        selectControl.on('change', function() {
            $(id_control).next().removeClass('is-invalid');
            $(id_control).parent().parent().find('.error-feedback').text('');
        });
        tomSelects.push({
            id: id_control,
            select: selectControl
        });
    });
}

function addSelectChangeListener(id, callback) {
    const select = tomSelects.find(x => x.id == id);
    if (select) {
        select.select.on('change', function() {
            callback($(this).val());
        });
    }
}

function setSelectValue(id, value) {
    const select = tomSelects.find(x => x.id == id);
    if (select) {
        select.select.setValue(value);
    }
}

function initRadio() {
    $('.radio-box').each(function () {
        $(this).on('change', function () {
            $(this).parent().parent().parent().children().each(function() {
                $(this).removeClass('is-invalid');
            });
            $(this).parent().parent().parent().parent().find('.error-feedback').text('');
        });
    });
}
function initInputResetEventHandler() {
    initSelect();
    initRadio();
    addEventResetFeedback();
}
function addEventResetFeedback() {
    // loop through all input and select in form student
    $("#form-student input").each(function() {
        $(this).on('keyup', function() {
            // remove is invalid
            $(this).removeClass('is-invalid');
            // check if invalid feedback in neighbor
            const invalid_feedback = $(this).next('.invalid-feedback');
            if (invalid_feedback.length > 0) {
                invalid_feedback.text('');
            } else {
                $(this).parent().next('.invalid-feedback').text('');
            }
        });

        $(this).on('change', function() {
            // remove is invalid
            $(this).removeClass('is-invalid');
            // check if invalid feedback in neighbor
            const invalid_feedback = $(this).next('.invalid-feedback');
            if (invalid_feedback.length > 0) {
                invalid_feedback.text('');
            } else {
                $(this).parent().next('.invalid-feedback').text('');
            }
        });
    });
}
function addSubmitFormHandler(form, successFunction, errorFunction = null, clearForm = true, blob = false) {
    $(form).submit(function (e) {
        e.preventDefault();
        const submit_button = $(this).find('button[type="submit"]');
        changeButtonLoading(submit_button, true);
        const form_instance = $(this);
        form_instance.find('input, select, textarea, button').attr('disabled', true);
        const formData = new FormData();
        $.each($(this).find('input, select, textarea'), function (key, value) {
            if ($(this).attr('type') == 'file') {
                const file = $(this)[0].files[0];
                if (file) {
                    formData.append($(this).attr('name'), file);
                }
            } else if ($(this).attr('type') == 'checkbox') {
                if ($(this).is(':checked')) {
                    formData.append($(this).attr('name'), $(this).val());
                }

            } else if ($(this).attr('type') == 'radio') {
                if ($(this).is(':checked')) {
                    formData.append($(this).attr('name'), $(this).val());
                }
            } else {
                formData.append($(this).attr('name'), $(this).val());
            }
        });


        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            responseType: blob ? 'blob' : 'json'
        }).then(function (response) {
            if (clearForm) {
                $(form).trigger('reset');
            }
            if (successFunction) {
                successFunction(response);
            }
        }).catch(function (error) {
            if (errorFunction) {
                errorFunction(error);
            } else {
                if (error.response) {
                    if (error.response.status == 422) {
                        showValidationErrors(error.response.data.errors);
                    } else if (error.response.status == 419) {
                        window.location.reload();
                    }
                } else if (error.request) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Terjadi kesalahan yang tidak diketahui saat mengirim data'
                    });
                }

            }
        }).finally(function () {
            form_instance.find('input, select, textarea, button').attr('disabled', false);
            changeButtonLoading(submit_button, false);

        });
    });
}
function changeButtonLoading(button, loading = true, text = null) {
    if (text == null) {
        text = button.attr('data-text');
    }

    let loading_text = button.attr('data-text-loading')
    loading_text = loading_text === undefined ? text : loading_text;

    if (loading) {
        button.addClass('disabled');
        button.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ' + loading_text);
    } else {
        button.removeClass('disabled');
        button.html(text);
    }
}

function showValidationError(input, message) {
    const parent = input.parent();
    if (parent.hasClass('input-group')) {
        parent.addClass('is-invalid');
        parent.parent().find('.invalid-feedback').html(message);
    } else {
        input.addClass('is-invalid');
        input.parent().find('.invalid-feedback').html(message);
    }
    input.on('keyup', function () {
        const inputParent = input.parent();
        if (inputParent.hasClass('input-group')) {
            parent.removeClass('is-invalid');
            parent.parent().find('.invalid-feedback').html('');
        } else {
            input.removeClass('is-invalid');
            input.parent().find('.invalid-feedback').html('');
        }
    });
}


function showValidationErrors(errors, type = "name") {
    $.each(errors, function (key, value) {
        if (type == "name") {
            showValidationError($('[name="' + key + '"]'), value);
        } else if (type == "class") {
            showValidationError($('.' + key), value);
        }
    });
}

$("#btn_mass_delete").click(function (e) {
    e.preventDefault();

    let names = [];
    $('.mass-delete:checked').each(function () {
        names.push($(this).data('name'));
    });

    // create string of names, separated by enter, maximum 5 names, with ... before the last name
    let text = names.slice(0, 5).join("\n");
    if (names.length > 5) {
        if (names.length > 6) {
            text += "\n...";
        }
        text += "\n" + names[names.length - 1];
    }

    $('#modalDelete .modal-body').html(`
            <p>Anda yakin ingin menghapus ${names.length} &nbsp;data berikut?</p>
            <pre>${text}</pre>
        `);

    $('#modalDelete').modal('show');

});

$("#modalDelete .btn-delete").click(function (e) {
    e.preventDefault();
    let ids = [];
    $('.mass-delete:checked').each(function () {
        ids.push($(this).val());
    });
    const endpoint = $("#modalDelete").data('url');
    $('.overlay-loading-wrapper').css('display', 'flex');
    axios.delete(endpoint, {
        data: {
            ids: ids
        }
    }).then(function (response) {
        SweetAlert.success('Berhasil', 'Data yang dipilih berhasil dihapus');
        window.LaravelDataTables['datatable'].ajax.reload(null, false);
    }).catch(function (error) {
        if (error.response) {
            if (error.response.status == 404) {
                SweetAlert.error('Terjadi Kesalahan', 'Kami tidak dapat menemukan data yang ingin dihapus pada database');
            } else if (error.response.status == 419) {
                SweetAlert.alert('Server Menolak Permintaan', 'Permintaan Anda tidak dapat diproses karena kunci koneksi ke server telah berubah. Mohon muat ulang halaman ini.', 'Muat Ulang', 'Nanti Saja', function() {
                    window.location.reload();
                });
            } else {
                SweetAlert.error('Terjadi Kesalahan', 'Terjadi kesalahan saat menghapus data');
            }
        } else if (error.request) {
            SweetAlert.error('Jaringan Tidak Tersedia', 'Kami tidak dapat terhubung ke server. Mohon periksa koneksi internet Anda.');
        } else {
            SweetAlert.error('Terjadi Kesalahan', 'Mohon maaf, terjadi kesalahan yang tidak diketahui saat menghapus data');
        }
    }).finally(function () {
        $('.overlay-loading-wrapper').css('display', 'none');
        $('#modalDelete').modal('hide');
        $('#checkbox-all').prop('checked', false);
        $('.mass-delete').each(function () {
            $(this).prop('checked', false);
        });
    });
});

function moveDataToForm(oldForm, newForm) {

}

function singleDelete(endpoint, refreshTable = false) {
    SweetAlert.ask('Anda yakin ingin menghapus data ini?', 'Tindakan ini tidak dapat dibatalkan. Apakah Anda tetap ingin melanjutkan?', 'Hapus', 'Batal', function() {
        $('.overlay-loading-wrapper').css('display', 'flex');
        axios.delete(endpoint, {}).then(function (response) {
            // get redirect data
            if (refreshTable) {
                window.LaravelDataTables['datatable'].ajax.reload(null, false);
                SweetAlert.success('Berhasil', 'Data berhasil dihapus');
            } else {
                window.location.href = response.data.data.redirect;
            }
        }).catch(function (error) {
            if (error.response) {
                if (error.response.status == 404) {
                    SweetAlert.error('Terjadi Kesalahan', 'Kami tidak dapat menemukan data yang ingin dihapus pada database');
                } else if (error.response.status == 419) {
                    SweetAlert.alert('Server Menolak Permintaan', 'Permintaan Anda tidak dapat diproses karena kunci koneksi ke server telah berubah. Mohon muat ulang halaman ini.', 'Muat Ulang', 'Nanti Saja', function() {
                        window.location.reload();
                    });
                } else {
                    SweetAlert.error('Terjadi Kesalahan', 'Terjadi kesalahan saat menghapus data');
                }
            } else if (error.request) {
                SweetAlert.error('Jaringan Tidak Tersedia', 'Kami tidak dapat terhubung ke server. Mohon periksa koneksi internet Anda.');
            } else {
                SweetAlert.error('Terjadi Kesalahan', 'Mohon maaf, terjadi kesalahan yang tidak diketahui saat menghapus data');
            }
        }).finally(function () {
            $('.overlay-loading-wrapper').css('display', 'none');
        });
    });
}
$(".default_delete_button").click(function (e) {
    e.preventDefault();
    const endpoint = $(this).data('endpoint');
    singleDelete(endpoint, false);
});
function triggerDeleteFromTable(e) {
    const endpoint = e.getAttribute('data-endpoint');
    singleDelete(endpoint, true);
}

function addFormEditedEventHandler(form) {
    $(form + " :input").change(function() {
        $(form).data("changed", true);

        // bind
        $(window).on('beforeunload', function(e){
            e.preventDefault();
        });
    });

    $(form).submit(function(e) {
        $(form).data("changed", false);
        // unbind
        $(window).off('beforeunload');
    });
}
