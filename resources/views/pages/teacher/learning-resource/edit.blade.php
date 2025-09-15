{{-- DO NOT REMOVE COMMENTS --}}

{{-- Extends layout --}}
{{-- You can change the file path to ../layouts/default-extended to extend a different layout --}}
{{-- For more info: https://laravel.com/docs/10.x/blade#extending-a-layout --}}
@extends('layouts.app')

{{-- If you need to make filtering to DataTable, please use Livewire to make things a lot easier --}}
{{-- For more info: https://livewire.laravel.com/docs/quickstart --}}

{{-- Set page title --}}
@section('title')
    {{ isset($data) ? 'Ubah Sumber Belajar: ' . $data->name : 'Tambah Sumber Belajar' }}
@endsection

@section('styles')
    {{-- If you need additional CSS, put inside <style></style> here--}}
    <link rel="stylesheet" href="/assets/vendor/flatpickr/dist/flatpickr.min.css">
@endsection


@section('content')
<div class="content container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('teacher.learning-resource.index') }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ isset($data) ? 'Ubah' : 'Tambah' }} Sumber Belajar
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
                <form id="form-learning_resource" action="{{ route('teacher.learning-resource.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="card-header card-header-content-between">
                        <h3 class="card-header-title">Data Sumber Belajar</h3>
                        @if (isset($data))
                            <button type="button" class="btn btn-soft-danger default_delete_button" data-endpoint="{{ route('teacher.learning-resource.single_destroy', ['id' => $data->id]) }}" data-text="<i class='bi-trash me-2'></i> Hapus" data-text-loading="Menghapus">
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
                            <label for="cover" class="col-sm-4 col-md-3 col-form-label form-label">Cover <span class="text-secondary">(opsioanal)</span></label>
                            <div class="col-sm-9">
                                <div class="d-flex align-items-center">
                                    <!-- Avatar -->
                                    <label class="avatar avatar-xl avatar-uploader me-5" for="avatarUploader">
                                    <img id="avatarImg" class="avatar-img" src="{{ isset($data) ? asset('storage/public/'.$data->cover) : '' }}" alt="Image Description">

                                    <input type="file" name="cover" class="js-file-attach avatar-uploader-input" id="avatarUploader" data-hs-file-attach-options='{
                                                "textTarget": "#avatarImg",
                                                "mode": "image",
                                                "targetAttr": "src",
                                                "resetTarget": ".js-file-attach-reset-img",
                                                "resetImg": "./assets/img/160x160/img1.jpg",
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
                                    @error('cover')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="title" class="col-sm-4 col-md-3 col-form-label form-label">Judul Sumber Belajar <span class="text-danger">*</span> </label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Misal: Perkembangan dan Pertumbuhan" aria-label="Misal: Perkembangan dan Pertumbuhan" value="{{ old('title') ? old('title') : (isset($data) ? $data->title : '') }}">
                                <div class="invalid-feedback">
                                    @error('title')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <label for="short_description" class="col-sm-4 col-md-3 col-form-label form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('short_description') is-invalid @enderror" name="short_description" id="short_description" placeholder="tuliskan deskripsi singkat (max 255 karakter)" aria-label="tuliskan deskripsi singkat (max 255 karakter)" value="{{ old('short_description') ? old('short_description') : (isset($data) ? $data->short_description : '') }}">
                                <div class="invalid-feedback">
                                    @error('short_description')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="content" class="col-sm-4 col-md-3 col-form-label form-label">Konten/Materi <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                @trix($data, 'content', ['class' => $errors->has('content') ? 'is-invalid' : ''])
                                <div class="invalid-feedback">
                                    @error('content')
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
    @if(session()->has('alert.learning_resource.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.learning_resource.success') }}');
    @endif

    initInputResetEventHandler();
    addFormEditedEventHandler('#form-learning_resource');

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
