@extends('layouts.app')
@section('title', $assesment->title . ' | Adaptived')
@section('styles')
<style>
    .rich-text-content img {
        max-width: 100%;
        border-radius: .5rem;
        margin: 1rem 0;
    }
    .rich-text-content iframe {
        width: 100%;
        min-height: 400px;
        border-radius: .5rem;
    }
</style>
@endsection

@section('content')
<div class="content container-fluid">
    <div class="d-flex align-items-center mb-3">
        <a href="{{ route('teacher.answer.index', ['assesment_id' => $assesment->id]) }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ $assesment->title }}
            </h3>
        </div>
    </div>

    {{-- Konten --}}
    <div class="row">
        <div class="mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="alert alert-primary" role="alert">
                        <div class="flex-shrink-0">
                            <i class="bi-patch-question-fill"></i> <span class="fw-semibold">Pertanyaan</span>
                        </div>
                    </div>
                    <div class="rich-text-content pb-3 px-3">  
                        {!! $data->question->question !!}
                    </div>

                    <div class="alert alert-soft-success" role="alert">
                        <div class="flex-shrink-0">
                            <i class="bi-patch-question-fill"></i> <span class="fw-semibold">Jawaban {{ $data->user->name }}</span>
                        </div>
                    </div>
                    <div class="rich-text-content pb-3 px-3">
                        {!! $data->trixRender('answer') !!}
                    </div>

                    <div class="alert alert-dark" role="alert">
                        <div class="flex-shrink-0">
                            <i class="bi-patch-question-fill"></i> <span class="fw-semibold">Analisis AI</span>
                        </div>
                    </div>
                    <div class="rich-text-content pb-3 px-3">
                        <form action="{{ route('teacher.answer.analyze', ['assesment_id' => $assesment->id, 'id' => $data->id]) }}" method="POST">
                            @csrf
                            <div class="text-center">
                                <button type="submit" id="btnAnalyze" class="btn btn-primary">
                                    Analisis Jawaban
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    @if(session()->has('alert.assesment.success'))
        SweetAlert.success('Berhasil', @json(session('alert.assesment.success')));
    @endif

    @if(session()->has('error'))
        SweetAlert.error('Gagal', @json(session('error')));
    @endif
</script>
<script>
    document.getElementById('btnAnalyze')?.addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML = "<span class='spinner-border spinner-border-sm me-2'></span> Memproses...";
    });
</script>
@endsection