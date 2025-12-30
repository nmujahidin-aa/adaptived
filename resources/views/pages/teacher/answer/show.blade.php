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

    .typing-cursor::after {
        content: "▋";
        animation: blink 1s infinite;
        margin-left: 2px;
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0; }
    }
</style>
@endsection

@section('content')
<div class="content container-fluid">

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                {{-- Left --}}
                <div class="d-flex align-items-center">
                    <a href="{{ route('teacher.answer.index', ['assesment_id' => $assesment->id]) }}"
                    class="btn btn-sm btn-white me-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>

                    <div>
                        <h4 class="mb-0 fw-semibold">
                            <i class="bi-people me-2 text-primary"></i>
                            {{ $assesment->title }}
                        </h4>
                        <small class="text-muted">
                            Detail jawaban & analisis siswa
                        </small>
                    </div>
                </div>

                {{-- Right --}}
                <div class="d-flex align-items-center gap-3">

                    {{-- Progress --}}
                    @php
                        $total = $answers->count();
                        $done  = $answers->whereNotNull('analysis')->count();
                        $percent = $total ? round(($done / $total) * 100) : 0;
                    @endphp

                    <div class="text-end" style="min-width:180px;">
                        <small class="text-muted">
                            Progress Analisis
                        </small>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height: 6px;">
                                <div class="progress-bar bg-success"
                                    role="progressbar"
                                    style="width: {{ $percent }}%">
                                </div>
                            </div>
                            <span class="badge bg-soft-dark text-dark">
                                {{ $done }}/{{ $total }}
                            </span>
                        </div>
                    </div>

                    {{-- Analyze All --}}
                    @if($done < $total)
                    <form id="analyzeAllForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $answers->first()->user_id }}">
                        <button class="btn btn-sm btn-danger">
                            <i class="bi-lightning-charge me-1"></i>
                            Analyze All
                        </button>
                    </form>
                    @else
                        <span class="badge bg-success">
                            <i class="bi-check-circle me-1"></i>
                            Selesai
                        </span>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="mx-auto">

            @foreach($answers as $data)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">

                    {{-- Pertanyaan --}}
                    <div class="alert alert-primary">
                        <strong>Pertanyaan</strong>
                        <div class="rich-text-content pt-3">
                            {!! $data->question->question !!}
                        </div>
                    </div>

                    {{-- Jawaban --}}
                    <div class="alert alert-soft-success">
                        <strong>Jawaban {{ $data->user->name }}</strong>
                        <div class="rich-text-content pt-3 text-dark">
                            {!! $data->trixRender('answer') !!}
                        </div>
                    </div>

                    {{-- Analisis --}}
                    <div class="alert alert-dark">
                        <strong>Analisis AI</strong>

                        <div class="mt-3">
                            @if ($data->analysis)
                                <div class="py-3">
                                    {!! nl2br(e($data->analysis)) !!}
                                </div>
                            @else
                                <div id="aiResult-{{ $data->id }}" class="mb-3"></div>

                                <form
                                    class="analyze-form"
                                    data-answer-id="{{ $data->id }}"
                                    action="{{ route('teacher.answer.analyze', [
                                        'assesment_id' => $assesment->id,
                                        'id' => $data->id
                                    ]) }}"
                                    method="POST"
                                >
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Analisis Jawaban
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function typeText(el, text, speed = 18) {
    el.innerHTML = '';
    el.classList.add('typing-cursor');

    let i = 0;
    const interval = setInterval(() => {
        el.innerHTML += text.charAt(i).replace(/\n/g, '<br>');
        i++;
        if (i >= text.length) {
            clearInterval(interval);
            el.classList.remove('typing-cursor');
        }
    }, speed);
}

document.querySelectorAll('.analyze-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const btn = form.querySelector('button');
        const answerId = form.dataset.answerId;
        const resultBox = document.getElementById(`aiResult-${answerId}`);

        btn.disabled = true;
        btn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Menganalisis...
        `;

        resultBox.innerHTML = `
            <div class="">
                <em>AI sedang menulis analisis...</em>
            </div>
        `;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                resultBox.innerHTML = `
                    <div class="">
                        <div id="typing-${answerId}"></div>
                    </div>
                `;
                typeText(
                    document.getElementById(`typing-${answerId}`),
                    res.data
                );
                btn.remove();
            } else {
                resultBox.innerHTML = `<div class="alert alert-danger">Gagal</div>`;
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = 'Analisis Jawaban';
            resultBox.innerHTML = `<div class="alert alert-danger">Error jaringan</div>`;
        });
    });
});

const analyzeAllForm = document.getElementById('analyzeAllForm');
if (analyzeAllForm) {
    analyzeAllForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const btn = this.querySelector('button');
        btn.disabled = true;
        btn.innerHTML = 'Menganalisis semua...';

        fetch("{{ route('teacher.answer.analyze_all', ['assesment_id' => $assesment->id]) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_id: this.querySelector('input[name=user_id]').value
            })
        })
        .then(() => location.reload());
    });
}
</script>
@endsection
