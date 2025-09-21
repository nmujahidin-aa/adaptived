{{-- DO NOT REMOVE COMMENTS --}}

{{-- Extends layout --}}
{{-- You can change the file path to ../layouts/default-extended to extend a different layout --}}
{{-- For more info: https://laravel.com/docs/10.x/blade#extending-a-layout --}}
@extends('layouts.app')

{{-- If you need to make filtering to DataTable, please use Livewire to make things a lot easier --}}
{{-- For more info: https://livewire.laravel.com/docs/quickstart --}}

{{-- Set page title --}}
@section('title')
    {{ isset($data) ? 'Ubah Sekolah: ' . $data->name : 'Tambah Sekolah' }}
@endsection

@section('styles')
    {{-- If you need additional CSS, put inside <style></style> here--}}
    <link rel="stylesheet" href="/assets/vendor/flatpickr/dist/flatpickr.min.css">
@endsection


@section('content')
<div class="content container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('admin.school.index') }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ isset($data) ? 'Ubah' : 'Tambah' }} Sekolah
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
                <form id="form-school" action="{{ route('admin.school.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="card-header card-header-content-between">
                        <h3 class="card-header-title">Data Sekolah</h3>
                        @if (isset($data))
                            <button type="button" class="btn btn-soft-danger default_delete_button" data-endpoint="{{ route('admin.school.single_destroy', ['id' => $data->id]) }}" data-text="<i class='bi-trash me-2'></i> Hapus" data-text-loading="Menghapus">
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
                            <label for="logo" class="col-sm-4 col-md-3 col-form-label form-label">Logo Sekolah <span class="text-secondary">(opsioanal)</span></label>
                            <div class="col-sm-9">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                    <label class="avatar avatar-xl avatar-uploader me-5" for="avatarUploader">
                                    <img id="avatarImg" class="avatar-img" src="{{ isset($data) ? asset('storage/public/'.$data->logo) : '' }}" alt="Image Description">

                                    <input type="file" name="logo" class="js-file-attach avatar-uploader-input" id="avatarUploader" data-hs-file-attach-options='{
                                                "textTarget": "#avatarImg",
                                                "mode": "image",
                                                "targetAttr": "src",
                                                "resetTarget": ".js-file-attach-reset-img",
                                                "resetImg": "./assets/img/160x160/img2.jpg",
                                                "allowTypes": [".png", ".jpeg", ".jpg"]
                                            }'>

                                    <span class="avatar-uploader-trigger">
                                        <i class="bi-pencil avatar-uploader-icon shadow-sm"></i>
                                    </span>
                                    </label>
                                    <!-- End Avatar -->

                                    <button type="button" class="js-file-attach-reset-img btn btn-white">Hapus</button>
                                </div>
                                <div class="invalid-feedback">
                                    @error('logo')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        

                        <div class="row mb-4">
                            <label for="name" class="col-sm-4 col-md-3 col-form-label form-label">Nama Sekolah <span class="text-danger">*</span> </label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Misal: SMA Negeri 1 Kepanjen" aria-label="Misal: SMA Negeri 1 Kepanjen" value="{{ old('name') ? old('name') : (isset($data) ? $data->name : '') }}">
                                <div class="invalid-feedback">
                                    @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="short_name" class="col-sm-4 col-md-3 col-form-label form-label">Nama Singkat <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('short_name') is-invalid @enderror" name="short_name" id="short_name" placeholder="Misal: SMANEKA" aria-label="Misal: SMANEKA" value="{{ old('short_name') ? old('short_name') : (isset($data) ? $data->short_name : '') }}">
                                <div class="invalid-feedback">
                                    @error('short_name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="address" class="col-sm-4 col-md-3 col-form-label form-label">Alamat <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="3" placeholder="Misal: Jl. Raya No. 1" aria-label="Misal: Jl. Raya No. 1">{{ old('address') ? old('address') : (isset($data) ? $data->address : '') }}</textarea>
                                <div class="invalid-feedback">
                                    @error('address')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="phone" class="col-sm-4 col-md-3 col-form-label form-label">Telepon Sekolah <span class="text-secondary">(opsional)</span></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="Misal: 021-12345678" aria-label="Misal: 021-12345678" value="{{ old('phone') ? old('phone') : (isset($data) ? $data->phone : '') }}">
                                <div class="invalid-feedback">
                                    @error('phone')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="email" class="col-sm-4 col-md-3 col-form-label form-label">Email Sekolah <span class="text-secondary">(opsional)</span></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Misal: info@smaneka.sch.id" aria-label="Misal: info@smaneka.sch.id" value="{{ old('email') ? old('email') : (isset($data) ? $data->email : '') }}">
                                <div class="invalid-feedback">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="website" class="col-sm-4 col-md-3 col-form-label form-label">Website Sekolah <span class="text-secondary">(opsional)</span></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" id="website" placeholder="Misal: www.smaneka.sch.id" aria-label="Misal: www.smaneka.sch.id" value="{{ old('website') ? old('website') : (isset($data) ? $data->website : '') }}">
                                <div class="invalid-feedback">
                                    @error('website')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="status" class="col-sm-4 col-md-3 col-form-label form-label">Status <span class="text-secondary">(opsional)</span><i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Berlaku hanya untuk webiste ini"></i></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="col">
                                    <div class="input-group input-group-sm-vertical">
                                    <!-- Radio Check -->
                                    <label class="form-control" for="active">
                                        <div class="form-check">
                                            <input 
                                                type="radio"
                                                class="form-check-input"
                                                name="status"
                                                value="active"
                                                id="active"
                                                checked
                                            >
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                    </label>
                                    <!-- End Radio Check -->

                                    <!-- Radio Check -->
                                    <label class="form-control" for="inactive">
                                        <div class="form-check">
                                            <input 
                                                type="radio"
                                                class="form-check-input"
                                                name="status"
                                                value="inactive"
                                                id="inactive"
                                            >
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </label>
                                    <!-- End Radio Check -->
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    @error('status')
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
    @if(session()->has('alert.school.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.school.success') }}');
    @endif

    initInputResetEventHandler();
    addFormEditedEventHandler('#form-school');

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
