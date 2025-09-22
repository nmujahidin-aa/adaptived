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
        <a href="{{ route('assesment.index') }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                {{ $assesment->title }}
            </h3>
        </div>
    </div>

    {{-- Group Description --}}

    {{-- Instructions --}}
    <div class="row">
        <div class="mx-auto">
            @foreach($questions as $index => $question)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        
                        <div class="alert alert-soft-primary">
                            <i class="bi bi-patch-question-fill me-1"></i>
                            <strong>Pertanyaan {{ $index + 1 }}</strong>
                        </div>
                        <div class="rich-text-content mb-4">
                            {!! $question->question !!}
                        </div>

                        {{-- Jawaban --}}
                        <div class="alert alert-soft-success">
                            <i class="bi bi-chat-left-text-fill me-1"></i>
                            <strong>Jawaban Anda</strong>
                        </div>

                        <form action="{{ route('assesment.answer.store', $assesment->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="assesment_id" value="{{ $assesment->id }}">
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            
                            @if($question->user_answer)
                                <input type="hidden" name="id" value="{{ $question->user_answer->id }}">
                            @endif

                            @trix(
                                $question->user_answer ?? new \App\Models\Answer,
                                'answer',
                                ['class' => $errors->has('answer') ? 'is-invalid' : '']
                            )

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-send-check me-1"></i>
                                    {{ $question->user_answer ? 'Update Jawaban' : 'Kirim Jawaban' }}
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
