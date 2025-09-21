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
        @forelse($worksheets as $row)
            @php
                $group = $row->groups
                    ->first(fn($g) => $g->members->contains(auth()->id()));
            @endphp

            <div class="col-md-4 col-sm-12 mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card card-hover-shadow text-center h-100">
                    <!-- Progress -->
                    <div class="card-progress-wrap">
                        <div class="progress card-progress">
                            @php
                                $progress = ($group && $row->instructions_count > 0)
                                    ? ($group->answers->count() / $row->instructions_count) * 100
                                    : 0;
                            @endphp
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $progress }}%"
                                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!-- End Progress -->

                    <!-- Body -->
                    <div class="card-body">
                        <div class="row align-items-center text-start mb-4">
                            <div class="col">
                                @if($group)
                                    <span class="badge {{ $group->status['class'] }} text-primary p-2">
                                        {{ $group->status['label'] }}
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger p-2">
                                        Belum ada kelompok
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mb-2">
                            <!-- Avatar -->
                            <img class="avatar avatar-lg" src="./assets/svg/brands/prosperops-icon.svg" alt="Image Description">
                        </div>

                        <div class="mb-4">
                            <h2 class="mb-1">{{ $row->title }}</h2>
                            <span class="fs-5"></span>
                        </div>

                        <small class="card-subtitle">Anggota</small>

                        @if($group)
                            <div class="d-flex justify-content-center mb-3">
                                <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                    @foreach($group->members->take(5) as $member)
                                        <a class="avatar" href="#"
                                        data-bs-toggle="tooltip"
                                        title="{{ $member->name }}">
                                            <img class="avatar-img" src="{{ $member->getAvatar() }}" alt="{{ $member->name }}">
                                        </a>
                                    @endforeach

                                    @if($group->members->count() > 5)
                                        <a class="avatar avatar-soft-dark" href="#">
                                            <span class="avatar-initials">+{{ $group->members->count() - 5 }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <a class="stretched-link" href="{{route('worksheet.show', ['worksheet_id' => $row->id, 'group_id' => $group->id])}}"></a>
                        @else
                            <div class="text-center text-danger mb-3">
                                <small>Anda belum bergabung dalam kelompok</small>
                            </div>
                        @endif
                    </div>
                    <!-- End Body -->

                    <!-- Footer -->
                    <div class="card-footer">
                        <div class="row col-divider">
                            <div class="col">
                                <span class="h4">{{ $row->instructions_count }}</span>
                                <span class="d-block fs-5">Instruksi</span>
                            </div>
                            <div class="col">
                                <span class="h4">{{ $group?->answers->count() ?? 0 }}</span>
                                <span class="d-block fs-5">Completed</span>
                            </div>
                        </div>
                    </div>
                    <!-- End Footer -->
                </div>
                <!-- End Card -->
            </div>
        @empty
            <div class="col text-center">
                <p class="text-muted">Belum ada LKPD</p>
            </div>
        @endforelse
    </div>


</div>
@endsection
