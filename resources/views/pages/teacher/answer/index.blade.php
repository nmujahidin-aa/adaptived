@extends('layouts.app')

@section('title', 'analysis | Adaptived')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('teacher.assesment.index') }}" class="btn btn-white">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="ms-3">
                <h1 class="card-header-title">
                    Analisis Asesmen <span class="badge bg-soft-dark text-dark ms-2"> {{ $assesment_count }}</span>
                </h1>
            </div>
        </div>
        {{-- Start DataTable --}}
        @include('components.datatable', [
            'search_text' => 'Cari analysis...',
            'table' => $dataTable,
            'show_filter' => true
        ])
        {{-- End DataTable --}}
    </div>
@endsection