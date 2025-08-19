{{-- DO NOT REMOVE COMMENTS --}}

{{-- Extends layout --}}
{{-- You can change the file path to ../layouts/default-extended to extend a different layout --}}
{{-- For more info: https://laravel.com/docs/10.x/blade#extending-a-layout --}}
@extends('layouts.app')

{{-- If you need to make filtering to DataTable, please use Livewire to make things a lot easier --}}
{{-- For more info: https://livewire.laravel.com/docs/quickstart --}}

{{-- Set page title --}}
@section('title', 'Data Siswa')

@section('styles')
    <link rel="stylesheet" href="/assets/vendor/dropify/css/dropify.css">
    {{-- If you need additional CSS, put inside <style></style> here--}}
@endsection

@section('destroy_endpoint', route('superadmin.student.destroy'))

@section('content')
    {{-- Header Section --}}
    {{-- You can modify title, add button, etc. Make sure it's responsive :) --}}
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-header-title">Siswa <span id="data_counter" class="badge bg-soft-dark text-dark ms-2">{{ $student_count }}</span></h1>
                    <div class="d-sm-flex mt-2">
                        <a class="d-inline-block text-body mb-2 mb-sm-0 me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#importCustomersModal">
                            <i class="bi-upload me-1"></i> Impor
                        </a>
                        <a class="d-inline-block text-body mb-2 mb-sm-0 me-3" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="bi-download me-1"></i> Ekspor
                        </a>
                    </div>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('admin.students.edit') }}">
                        <i class="bi bi-plus-square-fill me-sm-2"></i>
                        <span class="d-none d-sm-inline">Tambah Mahasiswa</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- Start DataTable --}}
        @include('components.datatable', [
            'search_text' => 'Cari mahasiswa...',
            'table' => $dataTable,
            'show_filter' => true
        ])
        {{-- End DataTable --}}
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formExport" action="{{ route('admin.students.export') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="exportModalLabel">Ekspor Data Mahasiswa</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <!-- Select -->
                            <div class="tom-select-custom tom-select-custom-with-tags mb-3">
                                <select name="export_study_program[]" class="js-select form-select" autocomplete="off" multiple
                                        data-hs-tom-select-options='{
                                        "placeholder": "Pilih program studi (boleh lebih dari satu)"
                                      }'>
                                    @foreach($study_programs as $study_program)
                                        <option value="{{ $study_program->id }}">{{ $study_program->code }} - {{ $study_program->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- End Select -->
                            <!-- Select -->
                            <div class="tom-select-custom tom-select-custom-with-tags">
                                <select name="export_semester[]" class="js-select form-select" autocomplete="off" multiple
                                        data-hs-tom-select-options='{
                                        "placeholder": "Pilih angkatan (boleh lebih dari satu)"
                                      }'>
                                    @foreach($semesters as $semester)
                                        <option value="{{ $semester }}">Angkatan {{ $semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- End Select -->
                        </div>
                        <label class="form-label">Ekspor sebagai</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exportAs" id="exportAs1" value="xlsx" checked>
                            <label class="form-check-label" for="exportAs1">
                                Microsoft Excel (.xlsx)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exportAs" id="exportAs2" value="csv">
                            <label class="form-check-label" for="exportAs2">
                                Plain CSV file
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exportAs" id="exportAs3" value="pdf">
                            <label class="form-check-label" for="exportAs3">
                                PDF
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        <button type="submit" class="btn btn-primary" data-text="Ekspor" data-loading="Mengekspor">Ekspor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Export Modal -->


    <!-- Filter Modal -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="dataTableFilter" aria-labelledby="dataTableFilterLabel">
        <div class="offcanvas-header">
            <h4 id="dataTableFilterLabel" class="mb-0">Filter</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <span class="text-cap small">Program Studi</span>
            <div class="d-grid gap-2 mb-2" id="study_program_container">
                @foreach($study_programs as $study_program)
                    <div class="form-check">
                        <input type="checkbox" name="filter_program_study" id="filter_program_study_{{ $study_program->id }}" value="{{ $study_program->id }}" class="form-check-input">
                        <label class="form-check-label" for="filter_program_study_{{ $study_program->id }}">{{ $study_program->code }} - {{ $study_program->name }}</label>
                    </div>
                @endforeach
            </div>
            <hr>
            <span class="text-cap small">Angkatan</span>
            <div class="d-grid gap-2 mb-2" id="semester_container">
                @foreach($semesters as $semester)
                    <div class="form-check">
                        <input type="checkbox" name="filter_semester" id="filter_semester_{{ $semester }}" value="{{ $semester }}" class="form-check-input">
                        <label class="form-check-label" for="filter_semester_{{ $semester }}">Angkatan {{ $semester }}</label>
                    </div>
                @endforeach
            </div>
            <hr>
            <span class="text-cap small">Jenis Kelamin</span>

            <div class="d-grid gap-2 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter_gender" value="all" id="filter_gender_all" checked>
                    <label class="form-check-label" for="filter_gender_all">Semua</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter_gender" value="male" id="filter_gender_male">
                    <label class="form-check-label" for="filter_gender_male">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter_gender" value="female" id="filter_gender_female">
                    <label class="form-check-label" for="filter_gender_female">Perempuan</label>
                </div>
            </div>
            <hr>
            <span class="text-cap small">Akun</span>

            <div class="d-grid gap-2 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter_account" value="all" id="filter_account_all" checked>
                    <label class="form-check-label" for="filter_account_all">Semua</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter_account" value="account" id="filter_account_has_account">
                    <label class="form-check-label" for="filter_account_has_account">Sudah Membuat Akun</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter_account" value="no_account" id="filter_account_no_account">
                    <label class="form-check-label" for="filter_account_no_account">Belum Membuat Akun</label>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="row gx-2">
                <div class="col">
                    <div class="d-grid">
                        <button type="button" class="btn btn-white" id="btn_reset_filter">Reset Filter</button>
                    </div>
                </div>
                <div class="col">
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" id="btn_filter">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Filter Modal -->

    <!-- Import Modal -->
    <div class="modal fade" id="importCustomersModal" tabindex="-1" aria-labelledby="importCustomersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formImport" action="{{ route('admin.students.import') }}" method="POST">
                    @csrf
                    <!-- Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="importCustomersModalLabel">Impor Mahasiswa dari Excel</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="modal-body">
                        <p><a class="link" href="/samples/Format%20Pengisian%20Data%20Mahasiswa.xlsx">Unduh sampel XLSX </a> untuk melihat contoh format impor yang dapat dibaca oleh sistem.</p>

                        <div class="mb-4">
                            <input type="file" id="import_file" name="file" class="form-control">
                        </div>

                        <!-- Form Check -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="overwrite" id="overwriteCurrentCustomersCheckbox">
                            <label class="form-check-label" for="overwriteCurrentCustomersCheckbox">
                                Timpa data mahasiswa yang sudah ada jika memiliki NIM yang sama
                            </label>
                        </div>
                        <!-- End Form Check -->
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                        <button type="submit" class="btn btn-primary" data-text="Impor" data-loading="Mengimpor">Impor</button>
                    </div>
                    <!-- End Footer -->
                </form>
            </div>
        </div>
    </div>
    <!-- End Import Modal -->
@endsection
@section('scripts')
    <script src="/assets/vendor/dropify/js/dropify.min.js"></script>
    <script>

        addSubmitFormHandler('#formImport', function (response) {
            if (response.status === 200) {
                // close modal import
                const importModal = bootstrap.Modal.getInstance(document.getElementById('importCustomersModal'));
                importModal.hide();

                const counter = response.data.data.count;
                const total = response.data.data.total;
                $('#data_counter').html(total);
                SweetAlert.success('Berhasil', 'Berhasil mengimpor sebanyak ' + counter + ' data mahasiswa.');

                // reload datatable
                const dataTable = window.LaravelDataTables['datatable'];
                dataTable.ajax.reload();
            }
        }, function(error) {
            if (error.response.status === 400) {
                // put error data to table
                let error_data = error.response.data.errors;
                let table_body = '';
                for (const [key, value] of Object.entries(error_data)) {
                    table_body += '<tr>';
                    table_body += '<th scope="row" class="text-center" style="padding-left: 32px;">' + value.row + '</th>';
                    table_body += '<td style="width: 500px;">' + value.values + '</td>';
                    table_body += '<td>';
                    table_body += '<ul class="p-3">';
                    for (const [key2, value2] of Object.entries(value.attributes)) {
                        table_body += '<li>' + value2 + '</li>';
                    }
                    table_body += '</ul>';
                    table_body += '</td>';
                    table_body += '<td>';
                    table_body += '<ul class="p-3">';
                    for (const [key3, value3] of Object.entries(value.errors)) {
                        table_body += '<li>' + value3 + '</li>';
                    }
                    table_body += '</ul>';
                    table_body += '</td>';
                    table_body += '</tr>';
                }

                $('#tableError').html(table_body);

                const errorModal = new bootstrap.Modal('#importErrorModal', {
                    keyboard: false
                });
                errorModal.show();
            }
        }, false, false);

        addSubmitFormHandler('#formExport', function (response) {
            console.log(response.headers['content-type']);
            // check if response is pdf, xlsx or csv
            if (response.type === 'application/pdf') {

            } else {
                var disposition = response.headers['content-disposition'];
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'mahasiswa');

                const url = window.URL.createObjectURL(new Blob([response.data], {
                    type: response.headers['content-type']
                }));

                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', filename);

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }, function(error) {
            SweetAlert.error('Terjadi kesalahan', 'Gagal mengekspor data mahasiswa. Pastikan Anda telah memilih program studi dan angkatan yang ingin diekspor.');
        }, false, true);

        $('.dropify').dropify();

        @if(session()->has('alert.student.success'))
            SweetAlert.success('Berhasil', '{{ session()->get('alert.student.success') }}');
        @endif
        function getQueryStringFilter() {
            let study_programs = [];
            $('input[name="filter_program_study"]:checked').each(function() {
                study_programs.push($(this).val());
            });
            let semesters = [];
            $('input[name="filter_semester"]:checked').each(function() {
                semesters.push($(this).val());
            });
            const gender = $('input[name="filter_gender"]:checked').val();
            const account = $('input[name="filter_account"]:checked').val();

            // build query string
            let query_string = '';
            if(study_programs.length > 0) {
                query_string += 'study_programs=' + study_programs.join(',') + '&';
            }

            if (semesters.length > 0) {
                query_string += 'semesters=' + semesters.join(',') + '&';
            }

            query_string += 'gender=' + gender + '&';
            query_string += 'account=' + account;

            return query_string;
        }

        function resetFilter() {
            // loop checkboxes inside study_program_container
            $('#study_program_container input[type="checkbox"]').each(function() {
                $(this).prop('checked', false);
            });
            // loop checkboxes inside semester_container
            $('#semester_container input[type="checkbox"]').each(function() {
                $(this).prop('checked', false);
            });
            // change radio of filter_gender_all to checked
            $('#filter_gender_all').prop('checked', true);
            // change radio of filter_account_all to checked
            $('#filter_account_all').prop('checked', true);
            // trigger click on btn_filter
            $('#btn_filter').trigger('click');
        }

        $('#btn_filter').on('click', function() {
            const query_string = getQueryStringFilter();
            const dataTable = window.LaravelDataTables['datatable'];
            dataTable.ajax.url(
                '{{ route('admin.students.index') }}?{{ request()->getQueryString() }}&' + query_string
            ).load();
            // close offcanvas
            $('#dataTableFilter').offcanvas('hide');
        });
        $('#btn_reset_filter').on('click', function() {
            resetFilter();
        });
    </script>
    {{-- If you need additional JS, put inside <script></script> here--}}
@endsection
