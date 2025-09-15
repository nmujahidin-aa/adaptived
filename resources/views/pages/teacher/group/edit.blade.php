{{-- DO NOT REMOVE COMMENTS --}}

{{-- Extends layout --}}
{{-- You can change the file path to ../layouts/default-extended to extend a different layout --}}
{{-- For more info: https://laravel.com/docs/10.x/blade#extending-a-layout --}}
@extends('layouts.app')

{{-- If you need to make filtering to DataTable, please use Livewire to make things a lot easier --}}
{{-- For more info: https://livewire.laravel.com/docs/quickstart --}}

{{-- Set page title --}}
@section('title')
    {{ isset($data) ? 'Ubah Kelompok Belajar: ' . $data->name : 'Tambah Kelompok Belajar' }}
@endsection

@section('styles')
    {{-- If you need additional CSS, put inside <style></style> here--}}
    <link rel="stylesheet" href="/assets/vendor/flatpickr/dist/flatpickr.min.css">
@endsection


@section('content')
<div class="content container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('teacher.group.index') }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ isset($data) ? 'Ubah' : 'Tambah' }} Kelompok Belajar
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
                <form id="form-group" action="{{ route('teacher.group.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="card-header card-header-content-between">
                        <h3 class="card-header-title">Data Kelompok Belajar</h3>
                        @if (isset($data))
                            <button type="button" class="btn btn-soft-danger default_delete_button" data-endpoint="{{ route('teacher.group.single_destroy', ['id' => $data->id]) }}" data-text="<i class='bi-trash me-2'></i> Hapus" data-text-loading="Menghapus">
                                <i class="bi-trash me-2"></i> Hapus
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @csrf
                        @if (isset($data))
                            <input type="hidden" name="id" value="{{ $data->id }}" autocomplete="off">
                        @endif
                        <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">

                        <div class="row mb-4">
                            <label for="name" class="col-sm-4 col-md-3 col-form-label form-label">Nama Kelompok <span class="text-danger">*</span> </label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Misal: Kelompok 1 Kelas C" aria-label="Misal: Kelompok 1 Kelas C" value="{{ old('name') ? old('name') : (isset($data) ? $data->name : '') }}">
                                <div class="invalid-feedback">
                                    @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="worksheet_id" class="col-sm-4 col-md-3 col-form-label form-label">Kegiatan Belajar <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="tom-select-custom">
                                    <select class="js-select form-select w-100" name="worksheet_id" data-hs-tom-select-options='{
                                            "searchInDropdown": true,
                                            "dropdownWidth": "100%"
                                            }'>
                                        @foreach($worksheets as $index => $row)
                                            <option value="{{ $row->id }}"
                                                @if(old('worksheet_id', $data->worksheet_id ?? '') == $row->id) selected @endif
                                                data-option-template='
                                                    <div class="d-flex align-items-center">
                                                        <div class="">
                                                            <span class="d-block h6 text-bold mb-0">
                                                                {{ $row->title }}
                                                            </span>
                                                        </div>
                                                    </div>'
                                            >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('worksheet_id')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="leader_id" class="col-sm-4 col-md-3 col-form-label form-label">Ketua Kelompok <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="tom-select-custom">
                                    <select class="js-select form-select w-100" name="leader_id" data-hs-tom-select-options='{
                                            "searchInDropdown": true,
                                            "dropdownWidth": "100%"
                                            }'>
                                        @foreach($students as $index => $row)
                                            <option value="{{ $row->id }}"
                                                @if(old('leader_id', $data->leader_id ?? '') == $row->id) selected @endif
                                                data-option-template='
                                                    <div class="d-flex align-items-center">
                                                        <div class="">
                                                            <span class="d-block h6 text-bold mb-0">
                                                                {{ $row->name }}
                                                            </span>
                                                        </div>
                                                    </div>'
                                            >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('leader_id')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="member_id" class="col-sm-4 col-md-3 col-form-label form-label">Anggota Kelompok <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="tom-select-custom">
                                    {{-- Tambahkan id untuk TomSelect --}}
                                    <select id="member_select" class="js-select form-select w-100 @error('member_id') is-invalid @enderror" name="member_id[]" multiple data-hs-tom-select-options='{
                                        "searchInDropdown": true,
                                        "dropdownWidth": "100%"
                                    }'>
                                        {{-- Dapatkan ID anggota yang sudah ada atau dari old() --}}
                                        @php
                                            $selectedMembers = old('member_id', $data?->members->pluck('user_id')->toArray() ?? []);
                                        @endphp
                                        @foreach($students as $index => $row)
                                            <option value="{{ $row->id }}"
                                                @if(in_array($row->id, $selectedMembers)) selected @endif
                                                data-option-template='
                                                    <div class="d-flex align-items-center">
                                                        <div class="">
                                                            <span class="d-block h6 text-bold mb-0">
                                                                {{ $row->name }}
                                                            </span>
                                                        </div>
                                                    </div>'
                                            >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('member_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
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
    @if(session()->has('alert.group.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.group.success') }}');
    @endif

    initInputResetEventHandler();
    addFormEditedEventHandler('#form-group');

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
