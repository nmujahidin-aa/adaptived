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
        <!-- Card 1 -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-lines-fill fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Profil Saya</h5>
                    <p class="text-muted small">Kelola akun dan data pribadi Anda.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-book-half fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Materi Belajar</h5>
                    <p class="text-muted small">Akses semua materi pembelajaran sesuai level Anda.</p>
                    <a href="#" class="btn btn-sm btn-outline-success">Mulai Belajar</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Kemajuan</h5>
                    <p class="text-muted small">Lihat progres dan hasil evaluasi belajar Anda.</p>
                    <a href="#" class="btn btn-sm btn-outline-warning">Lihat Progres</a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event fs-1 text-danger"></i>
                    <h5 class="card-title mt-3">Agenda</h5>
                    <p class="text-muted small">Jadwal kelas, ujian, dan event lainnya.</p>
                    <a href="#" class="btn btn-sm btn-outline-danger">Lihat Agenda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
