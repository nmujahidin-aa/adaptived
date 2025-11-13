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

<div class="offcanvas offcanvas-end" tabindex="-1" id="dataTableFilter" aria-labelledby="dataTableFilterLabel">
    <div class="offcanvas-header">
        <h4 id="dataTableFilterLabel" class="mb-0">Filter</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <span class="text-cap small">Sifat</span>
        <div class="d-grid gap-2 mb-2" id="traits_container">
        </div>
        <hr>
        <span class="text-cap small">Status</span>

        <div class="d-grid gap-2 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="filter_status" value="success" id="filter_status_success" checked>
                <label class="form-check-label" for="filter_status_success">Selesai</label>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <div class="row gx-2">
            <div class="col">
                <div class="d-grid">
                    <button type="button" class="btn btn-white" id="btn_reset_filter">Reset Filter</button>
                </div>
            </div>
            <div class="col">
                <div class="d-grid">
                    <button type="button" class="btn btn-primary" id="btn_filter">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection