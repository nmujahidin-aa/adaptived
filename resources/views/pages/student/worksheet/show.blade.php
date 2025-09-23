@extends('layouts.app')
@section('Worksheet' | 'Adaptive')
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
        <a href="{{ route('worksheet.index') }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                {{ $worksheet->title }}
            </h3>
        </div>
    </div>

    {{-- Group Description --}}
    <div class="row mb-4">
        <div class="mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body rich-text-content">
                    <h2 class="text-center text-bold pt-3">LEMBAR KERJA PESERTA DIDIK</h2>
                    
                </div>
            </div>
        </div>
    </div>

    {{-- Instructions --}}
    <div class="row">
        <div class="mx-auto">
            @foreach($instructions as $index => $instruction)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="alert alert-soft-primary" role="alert">
                            <i class="bi-patch-question-fill"></i>
                            <span class="fw-semibold">Instruksi {{ $index + 1 }}</span>
                        </div>

                        <div class="rich-text-content mb-4">
                            {!! $instruction->instruction !!}
                        </div>

                        <div class="alert alert-soft-success" role="alert">
                            <i class="bi-patch-question-fill"></i>
                            <span class="fw-semibold">Jawaban Instruksi {{ $index + 1 }}</span>
                        </div>

                        <form action="{{ route('worksheet.answer.store', [$worksheet->id, $group->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="worksheet_id" value="{{ $worksheet->id }}">
                            <input type="hidden" name="worksheet_instruction_id" value="{{ $instruction->id }}">
                            <input type="hidden" name="group_id" value="{{ $group->id }}">

                            @if(isset($instruction->group_answer))
                                <input type="hidden" name="id" value="{{ $instruction->group_answer->id }}">
                            @endif

                            {{-- Trix editor --}}
                            @trix($instruction->group_answer ?? new \App\Models\GroupAnswer, 'groupanswer', [
                                'class' => $errors->has('groupanswer') ? 'is-invalid' : ''
                            ])

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-send-check me-1"></i>
                                    {{ isset($instruction->group_answer) ? 'Update Jawaban' : 'Kirim Jawaban' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    @if(session()->has('alert.answer.success'))
        SweetAlert.success('Berhasil', '{{ session()->get('alert.answer.success') }}');
    @endif
</script>
@endsection
