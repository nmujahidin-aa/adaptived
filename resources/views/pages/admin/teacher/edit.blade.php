{{-- DO NOT REMOVE COMMENTS --}}

{{-- Extends layout --}}
{{-- You can change the file path to ../layouts/default-extended to extend a different layout --}}
{{-- For more info: https://laravel.com/docs/10.x/blade#extending-a-layout --}}
@extends('layouts.app')

{{-- If you need to make filtering to DataTable, please use Livewire to make things a lot easier --}}
{{-- For more info: https://livewire.laravel.com/docs/quickstart --}}

{{-- Set page title --}}
@section('title')
    {{ isset($data) ? 'Ubah Guru: ' . $data->name : 'Tambah Guru' }}
@endsection

@section('styles')
    {{-- If you need additional CSS, put inside <style></style> here--}}
    <link rel="stylesheet" href="/assets/vendor/flatpickr/dist/flatpickr.min.css">
@endsection


@section('content')
<div class="content container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.teacher.index') }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ isset($data) ? 'Ubah' : 'Tambah' }} Guru
            </h3>
            <p class="mb-0">Mohon isi data dengan benar dan teliti</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div id="profilePhotoSidebar">

                <div class="js-sticky-block" data-hs-sticky-block-options='{
                     "parentSelector": "#profilePhotoSidebar",
                     "targetSelector": "#header",
                     "breakpoint": "lg",
                     "startPoint": "#profilePhotoSidebar",
                     "endPoint": "#stickyBlockEndPoint",
                     "stickyOffsetTop": 90
                   }'>

                    <div class="card mb-3">
                        <div class="card-header">
                            <p class="form-label mb-0"><b>Petunjuk Pengisian</b></p>
                        </div>
                        <div class="card-body">
                            <p>
                                Isi data dengan benar dan teliti. Mohon pastikan tanggal mulai dan tanggal selesai tahun akademik sesuai, karena sistem akan secara otomatis melakukan assign tahun akademik sesuai dengan rentang tanggal yang diisi.
                            </p>
                            <p>
                                <span class="text-danger">*</span> Wajib diisi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">

            <div class="card mb-3">
                <form id="form-teacher" action="{{ route('admin.teacher.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="card-header card-header-content-between">
                        <h3 class="card-header-title">Data Guru</h3>
                        @if (isset($data))
                            <button type="button" class="btn btn-soft-danger default_delete_button" data-endpoint="{{ route('admin.teacher.single_destroy', ['id' => $data->id]) }}" data-text="<i class='bi-trash me-2'></i> Hapus" data-text-loading="Menghapus">
                                <i class="bi-trash me-2"></i> Hapus
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @csrf
                        @if (isset($data))
                            <input type="hidden" name="id" value="{{ $data->id }}" autocomplete="off">
                        @endif
                        

                        <div class="row mb-4">
                            <label for="name" class="col-sm-4 col-md-3 col-form-label form-label">Nama Guru <span class="text-danger">*</span> </label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Misal: Lionel Messi" aria-label="Misal: Lionel Messi" value="{{ old('name') ? old('name') : (isset($data) ? $data->name : '') }}">
                                <div class="invalid-feedback">
                                    @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="email" class="col-sm-4 col-md-3 col-form-label form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Misal: email@gmail.com" aria-label="Misal: email@gmail.com" value="{{ old('email') ? old('email') : (isset($data) ? $data->email : '') }}">
                                <div class="invalid-feedback">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="phone" class="col-sm-4 col-md-3 col-form-label form-label">Phone <span class="text-secondary">(opsional)</span></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Misal: 0812-3456-7890" aria-label="Misal: 0812-3456-7890" value="{{ old('phone') ? old('phone') : (isset($data) ? $data->phone : '') }}">
                                <div class="invalid-feedback">
                                    @error('phone')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="gender" class="col-sm-4 col-md-3 col-form-label form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="input-group input-group-sm-vertical">
                                <!-- Radio Check -->
                                <label class="form-control" for="L">
                                    <span class="form-check">
                                    <input type="radio" class="form-check-input" name="gender" value="L" id="L" {{ old('gender', isset($data) ? $data->gender : '') == 'L' ? 'checked' : '' }}>
                                    <span class="form-check-label">Laki-laki</span>
                                    </span>
                                </label>
                                <!-- End Radio Check -->

                                <!-- Radio Check -->
                                <label class="form-control" for="P">
                                    <span class="form-check">
                                    <input type="radio" class="form-check-input" name="gender" value="P" id="P" {{ old('gender', isset($data) ? $data->gender : '') == 'P' ? 'checked' : '' }}>
                                    <span class="form-check-label">Perempuan</span>
                                    </span>
                                </label>
                                <!-- End Radio Check -->
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="school_id" class="col-sm-4 col-md-3 col-form-label form-label">Instansi <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="tom-select-custom">
                                    <select class="js-select form-select w-100" name="school_id" data-hs-tom-select-options='{
                                            "searchInDropdown": true,
                                            "dropdownWidth": "100%"
                                            }'>
                                        @foreach($school as $index => $row)
                                            <option value="{{ $row->id }}"
                                                @if(old('school_id', $data->school_id ?? '') == $row->id) selected @endif
                                                data-option-template='
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar">
                                                            <img class="avatar-img" src="{{ $row->getLogo() }}" alt="Logo">
                                                        </div>
                                                        <div class="ms-3">
                                                            <span class="d-block h6 text-bold mb-0">
                                                                {{ $row->short_name }}
                                                            </span>
                                                            <span class="d-block fs-7 text-body text-dark" style="text-transform: uppercase;">
                                                                {{ $row->name }}
                                                            </span>
                                                        </div>
                                                    </div>'
                                            >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('school_id')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi-save me-2"></i> <b>Simpan</b>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="stickyBlockEndPoint"></div>
</div>
@endsection

@section('scripts')
<script src="/assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/vendor/flatpickr/dist/l10n/id.js"></script>
<script src="/assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script>
    @if(session()->has('alert.teacher.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.teacher.success') }}');
    @endif

    initInputResetEventHandler();
    addFormEditedEventHandler('#form-teacher');

    (function () {
        window.onload = function () {
            // INITIALIZATION OF FILE ATTACH
            // =======================================================
            new HSFileAttach('.js-file-attach');

            HSCore.components.HSFlatpickr.init('.js-flatpickr');

            new HSStickyBlock('.js-sticky-block', {
                targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
            });
        };
    })();
</script>
@endsection
