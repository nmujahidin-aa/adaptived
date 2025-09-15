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
        <a href="{{ route('assesment.index') }}" class="btn btn-white">
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
                    <div class="rich-text-content">
                        {!! $assesment->question !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Jawaban --}}
    <div class="row mt-4">
        <div class="mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('assesment.answer.store', $assesment->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="assesment_id" value="{{ $assesment->id }}">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        @if(isset($data))
                            <input type="hidden" name="id" value="{{ $data->id }}">
                        @endif

                        <div class="rich-text-content mb-4">
                            <input id="answer" type="hidden" name="answer" value="{{ $data->answer ?? '' }}">
                            <trix-editor input="answer"></trix-editor>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#submitModal">
                                <i class="bi bi-send-check me-2"></i> Kirim Jawaban
                            </button>
                        </div>

                        {{-- Modal --}}
                        <div class="modal fade" id="submitModal" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="submitModalLabel">
                                            <i class="bi bi-send-check me-2"></i> Konfirmasi Pengiriman
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-3">Apakah kamu yakin ingin mengirim jawaban ini?</p>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i> Pastikan semua jawaban sudah benar sebelum dikirim.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-1"></i> Ya, Kirim Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Modal --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        @if(session()->has('alert.assesment.success'))
        SweetAlert.success('Berhasil', '{{ session()->get('alert.assesment.success') }}');
        @endif
    </script>
@endsection
