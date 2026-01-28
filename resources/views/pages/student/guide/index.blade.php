@extends('layouts.app')

@section('title', 'Petunjuk Penggunaan | Adaptived')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">Hay, {{Auth::user()->name}} Selamat Datang di Adaptived 👋</h2>
            <p class="text-muted">Petunjuk Penggunaan Media Pembelajaran Bioadaptiveclass</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">                            
                <div class="card-body">
                    <div class="rich-text-content">
                        @if (!empty($data->content))
                            {!! $data->content !!}
                        @else
                            <p class="text-muted fst-italic mb-0">
                                Petunjuk belum diinputkan.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
