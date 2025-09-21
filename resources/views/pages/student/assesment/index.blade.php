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
        @forelse($assesment as $index => $row)
        <div class="col-md-6 col-lg-3 mb-4">
            <!-- Card -->
            <a class="card card-sm card-transition h-100" href="{{ route('assesment.show', $row->id) }}" data-aos="fade-up">
                <img class="card-img p-2" src="#" alt="Image Description">
                <div class="card-body">
                    <div><small><i class="bi bi-{{ $row->variable->icon }}"></i> {{$row->variable->name}}</small></div>
                    <h4 class="card-title text-inherit mt-2">{{ $row->title }}</h4>
                </div>
            </a>
            <!-- End Card -->
        </div>
        @empty
        <div class="col text-center">
            <p class="text-muted">Belum ada Assesment</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
