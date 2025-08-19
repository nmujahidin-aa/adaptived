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
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-{{$row->icon}} fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">{{$row->name}}</h5>
                    <p class="text-muted small">Kelola akun dan data pribadi Anda.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col text-center">
            <p class="text-muted">Asesmen belum diatur</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
