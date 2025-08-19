{{-- DO NOT REMOVE COMMENTS --}}

{{-- Extends layout --}}
{{-- You can change the file path to ../layouts/default-extended to extend a different layout --}}
{{-- For more info: https://laravel.com/docs/10.x/blade#extending-a-layout --}}
@extends('layouts.app')

{{-- If you need to make filtering to DataTable, please use Livewire to make things a lot easier --}}
{{-- For more info: https://livewire.laravel.com/docs/quickstart --}}

{{-- Set page title --}}
@section('title')
    {{ isset($variable) ? 'Ubah Variabel: ' . $variable->name : 'Tambah Variabel' }}
@endsection

@section('styles')
    {{-- If you need additional CSS, put inside <style></style> here--}}
    <link rel="stylesheet" href="/assets/vendor/flatpickr/dist/flatpickr.min.css">
@endsection


@section('content')
<div class="content container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('teacher.assesment.index') }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ isset($variable) ? 'Ubah' : 'Tambah' }} Variabel
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
                <form id="form-assesment" action="{{ route('teacher.assesment.store') }}" method="POST" autocomplete="off">
                    <div class="card-header card-header-content-between">
                        <h3 class="card-header-title">Data Variabel</h3>
                        @if (isset($variable))
                            <button type="button" class="btn btn-soft-danger default_delete_button" data-endpoint="{{ route('teacher.assesment.single_destroy', ['id' => $variable->id]) }}" data-text="<i class='bi-trash me-2'></i> Hapus" data-text-loading="Menghapus">
                                <i class="bi-trash me-2"></i> Hapus
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @csrf
                        @if (isset($variable))
                            <input type="hidden" name="id" value="{{ $variable->id }}" autocomplete="off">
                        @endif

                        <div class="row mb-4">
                            <label for="name" class="col-sm-4 col-md-3 col-form-label form-label">Nama Variabel <span class="text-danger">*</span> <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Contoh: Genap 2024/2025"></i></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Misal: Berpikir Kritis" aria-label="Misal: Berpikir Kritis" value="{{ old('name') ? old('name') : (isset($variable) ? $variable->name : '') }}">
                                <div class="invalid-feedback">
                                    @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="icon" class="col-sm-4 col-md-3 col-form-label form-label">Icon <span class="text-danger">*</span> <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Contoh: bar-chart-line untuk Genap 2024/2025"></i></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" name="icon" id="icon" placeholder="Misal: bar-chart-line" aria-label="Misal: bar-chart-line" value="{{ old('icon') ? old('icon') : (isset($variable) ? $variable->icon : '') }}">
                                <div class="invalid-feedback">
                                    @error('icon')
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
    {{-- If you need additional JS, put inside <script></script> here--}}
    <script src="/assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
    <script src="/assets/vendor/flatpickr/dist/l10n/id.js"></script>
    <script>
        @if(session()->has('alert.assesment.success'))
        SweetAlert.success('Berhasil', '{{ session()->get('alert.assesment.success') }}');
        @endif
        initInputResetEventHandler();
        addFormEditedEventHandler('#form-assesment');

        (function() {
            HSCore.components.HSFlatpickr.init('.js-flatpickr');
            new HSStickyBlock('.js-sticky-block', {
                targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
            })
        })();
    </script>
@endsection
