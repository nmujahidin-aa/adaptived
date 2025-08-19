{{-- DO NOT REMOVE COMMENTS --}}

{{-- Extends layout --}}
{{-- You can change the file path to ../layouts/default-extended to extend a different layout --}}
{{-- For more info: https://laravel.com/docs/10.x/blade#extending-a-layout --}}
@extends('layouts.app')

{{-- If you need to make filtering to DataTable, please use Livewire to make things a lot easier --}}
{{-- For more info: https://livewire.laravel.com/docs/quickstart --}}

{{-- Set page title --}}
@section('title')
    {{ isset($question) ? 'Ubah Pertanyaan: ' . $question->question : 'Tambah Pertanyaan' }}
@endsection

@section('styles')
    {{-- If you need additional CSS, put inside <style></style> here--}}
    <link rel="stylesheet" href="/assets/vendor/flatpickr/dist/flatpickr.min.css">
@endsection


@section('content')
<div class="content container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('teacher.assesment.question.index', ['variable_id' => $variable->id]) }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ isset($question) ? 'Ubah' : 'Tambah' }} Pertanyaan
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
                <form id="form-assesment" action="{{ route('teacher.assesment.question.store', ['variable_id' => $variable->id]) }}" method="POST" autocomplete="off">
                    <div class="card-header card-header-content-between">
                        <h3 class="card-header-title">Data Pertanyaan</h3>
                        @if (isset($question))
                            <button type="button" class="btn btn-soft-danger default_delete_button" data-endpoint="{{ route('teacher.assesment.single_destroy', ['variable_id' => $variable->id, 'id' => $question->id]) }}" data-text="<i class='bi-trash me-2'></i> Hapus" data-text-loading="Menghapus">
                                <i class="bi-trash me-2"></i> Hapus
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        @csrf
                        @if (isset($question))
                            <input type="hidden" name="id" value="{{ $question->id }}" autocomplete="off">
                        @endif

                        <input type="hidden" name="assesment_variable_id" value="{{ $variable->id }}">
                        <div id="accountType" class="row mb-4">
                            <label class="col-sm-4 col-md-3 col-form-label form-label">Type Soal <span class="text-danger">*</span></label>
                            <div class="col-sm-8 col-md-9">
                                <div class="input-group input-group-sm-vertical" id="label_type">
                                    <label class="form-control @error('type') is-invalid @enderror" for="type-essay">
                                      <span class="form-check">
                                        <input type="radio" class="radio-box form-check-input" name="type" id="type-essay" value="essay" {{ old('type') ? (old('type') == 'essay' ? 'checked' : '') : (isset($question) ? ($question->type == 'essay' ? 'checked' : '') : '') }} autocomplete="off">
                                        <span class="form-check-label">Essay</span>
                                      </span>
                                    </label>
                                    <label class="form-control @error('type') is-invalid @enderror" for="type-short_answer">
                                      <span class="form-check">
                                        <input type="radio" class="radio-box form-check-input" name="type" id="type-short_answer" value="short_answer" {{ old('type') ? (old('type') == 'short_answer' ? 'checked' : '') : (isset($question) ? ($question->type == 'short_answer' ? 'checked' : '') : '') }} autocomplete="off">
                                        <span class="form-check-label">Jawaban Singkat</span>
                                      </span>
                                    </label>
                                </div>
                                <div class="error-feedback text-danger mt-1" id="error_gender">
                                    @error('gender')
                                    <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="question" class="col-sm-4 col-md-3 col-form-label form-label">Pertanyaan <span class="text-danger">*</span> <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Contoh: Genap 2024/2025"></i></label>
                            <div class="col-sm-8 col-md-9">
                                <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" id="question" placeholder="Misal: Analisis masalah berikut" aria-label="Misal: Analisis masalah berikut" value="{{ old('question') ? old('question') : (isset($question) ? $question->question : '') }}">
                                <div class="invalid-feedback">
                                    @error('question')
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
        @if(session()->has('alert.assesment.question.success'))
        SweetAlert.success('Berhasil', '{{ session()->get('alert.assesment.question.success') }}');
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
