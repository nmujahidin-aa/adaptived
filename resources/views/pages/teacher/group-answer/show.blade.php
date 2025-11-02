@extends('layouts.app')
@section('title | Adaptived')
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
        <a href="{{ route('teacher.worksheet-group-answer.index', ['worksheet_id' => $worksheet_id]) }}" class="btn btn-white">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="ms-3">
            <h3 class="card-header-title">
                <i class="bi-people me-2"></i>
                {{ $worksheet->title }}
            </h3>
        </div>
    </div>

    {{-- Konten --}}
    <div class="row">
        @forelse ($answers as $index => $item)
            <div class="mx-auto mt-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- Instruksi --}}
                        <div class="alert alert-primary" role="alert">
                            <i class="bi-patch-question-fill"></i>
                            <span class="fw-semibold">Instruksi</span>
                        </div>
                        <div class="rich-text-content pb-3 px-3">
                            {!! $item->instruction->instruction ?? 'Instruksi tidak tersedia' !!}
                        </div>

                        {{-- Jawaban --}}
                        <div class="alert alert-soft-success" role="alert">
                            <i class="bi-chat-left-dots-fill"></i>
                            <span class="fw-semibold">Jawaban {{ $group->name }}</span>
                        </div>
                        <div class="rich-text-content pb-3 px-3">
                            {!! $item->trixRender('groupanswer') ?? '<em class="text-muted">Belum ada jawaban</em>' !!}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-secondary text-center">
                Belum ada jawaban untuk kelompok ini.
            </div>
        @endforelse
    </div>

    {{-- Form Penilaian LKPD --}}
    @if($answers->isNotEmpty())
        <form action="{{ route('teacher.worksheet-group-answer.grade', ['worksheet_id' => $worksheet_id, 'group_id' => $group->id]) }}" method="POST" class="mt-4">
            @csrf
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">
                        <i class="bi-clipboard-check me-2"></i> Penilaian LKPD
                    </h5>
                    <div class="d-flex align-items-center gap-3">
                        <input type="number" name="grade" class="form-control w-auto" placeholder="0-100" min="0" max="100" value="{{ old('grade', $groupWorksheet->grade ?? '') }}" required>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan Nilai
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif

</div>

@endsection

@section('scripts')
    <script>
        @if(session()->has('alert.grade.success'))
        SweetAlert.success('Berhasil', '{{ session()->get('alert.grade.success') }}');
        @endif
    </script>
@endsection
