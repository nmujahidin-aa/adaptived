@extends('layouts.app')

@section('title', 'Dashboard | Adaptived')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold">Hay, {{Auth::user()->name}} Selamat Datang di Adaptived 👋</h2>
            <p class="text-muted">Platform pembelajaran cerdas dan adaptif untuk masa depan lebih baik.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($learning_resources as $index => $row)
        <div class="col-md-6 col-lg-3 mb-4">
            <!-- Card -->
            <a class="card card-sm card-transition h-100" href="{{ route('learning-resource.show', $row->id) }}" data-aos="fade-up">
                <img class="card-img p-2" src="{{ $row->getCover() }}" alt="Image Description">
                <div class="card-body">
                <h4 class="card-title text-inherit">{{ $row->title }}</h4>
                <p class="card-text small text-body">{{ $row->short_description_limit() }}</p>
                </div>
            </a>
            <!-- End Card -->
        </div>
        @empty
        <div class="col text-center">
            <p class="text-muted">Belum ada Sumber Belajar</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
