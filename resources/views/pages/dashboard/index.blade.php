@extends('layouts.app')
@section('title','Dashboard | Adaptived')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">Dashboard</h4>
        <p class="text-muted mb-0">Ringkasan aktivitas Anda</p>
    </div>

    {{-- ================= ADMIN ================= --}}
    @role(\App\Enums\RoleEnum::ADMINISTRATOR)
    <div class="mb-5">

        <h6 class="fw-semibold mb-3">Statistik Sistem</h6>

        {{-- KPI --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Sekolah Terdaftar</small>
                        <h3 class="fw-bold">{{ $data['schools'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Siswa</small>
                        <h3 class="fw-bold">{{ $data['students'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Guru</small>
                        <h3 class="fw-bold">{{ $data['teachers'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHART --}}
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-semibold">Distribusi Siswa per Sekolah</h6>
                        <canvas id="adminStudentChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-semibold">Distribusi Guru per Sekolah</h6>
                        <canvas id="adminTeacherChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endrole

    {{-- ================= TEACHER ================= --}}
    @role(\App\Enums\RoleEnum::TEACHER)
        <div class="row g-4 mb-5">

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Siswa</small>
                        <h3 class="fw-bold">{{ $data['students'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total LKPD</small>
                        <h3 class="fw-bold">{{ $data['lkpd'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Asesmen</small>
                        <h3 class="fw-bold">{{ $data['assesments'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Total Kelompok</small>
                        <h3 class="fw-bold">{{ $data['groups'] }}</h3>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= DONUT + PROGRESS ================= --}}
        <div class="row g-4 mb-5">

            {{-- Donut Gender --}}
            <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-3">Komposisi Gender Siswa</h6>
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Tujaun Pembelajaran --}}
            <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-4">Tujuan Pembelajaran</h6>

                        @forelse ($data['learning_objectives'] as $objective)
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="fw-semibold text-primary pt-1" style="min-width: 24px">
                                    {{ $loop->iteration }}.
                                </span>

                                <div class="flex-grow-3">
                                    {!! is_array($objective) ? $objective['content'] : $objective->content !!}
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">
                                Tidak ada tujuan pembelajaran yang tersedia.
                            </p>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>

        {{-- ================= STACKED BAR ================= --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Asesmen Dibuat vs Dianalisis</h6>
                <canvas id="stackedChart"></canvas>
            </div>
        </div>
    @endrole

    {{-- ================= STUDENT ================= --}}
    @role(\App\Enums\RoleEnum::STUDENT)
    <div>

        <h6 class="fw-semibold mb-3">Tugas Anda</h6>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-1">
                    <small>Asesmen Belum Dikerjakan</small>
                    <small>{{ $data['pending_assesments'] }} / {{ $data['total_assesments'] }}</small>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-danger"
                        style="width: {{ $data['assesment_progress'] }}%">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-1">
                    <small>LKPD Belum Dikerjakan</small>
                    <small>{{ $data['pending_lkpd'] }} / {{ $data['total_lkpd'] }}</small>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-warning"
                        style="width: {{ $data['lkpd_progress'] }}%">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-semibold mb-4">Tujuan Pembelajaran</h6>

                    @forelse ($data['learning_objectives'] as $objective)
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="fw-semibold text-primary pt-1" style="min-width: 24px">
                                {{ $loop->iteration }}.
                            </span>

                            <div class="flex-grow-3">
                                {!! is_array($objective) ? $objective['content'] : $objective->content !!}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            Tidak ada tujuan pembelajaran yang tersedia.
                        </p>
                    @endforelse

                </div>
            </div>
        </div>

    </div>
    @endrole

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@role(\App\Enums\RoleEnum::ADMINISTRATOR)
<script>
new Chart(adminStudentChart, {
    type:'doughnut',
    data:{
        labels:@json($data['school_names']),
        datasets:[{ data:@json($data['students_per_school']) }]
    }
});
new Chart(adminTeacherChart, {
    type:'doughnut',
    data:{
        labels:@json($data['school_names']),
        datasets:[{ data:@json($data['teachers_per_school']) }]
    }
});
</script>
@endrole

@role(\App\Enums\RoleEnum::TEACHER)
<script>
new Chart(genderChart,{
    type:'doughnut',
    data:{
        labels:['Laki-laki','Perempuan'],
        datasets:[{
            data:[
                {{ $data['male_students'] }},
                {{ $data['female_students'] }}
            ],
            backgroundColor:['#0d6efd','#e83e8c']
        }]
    }
});

new Chart(stackedChart,{
    type:'bar',
    data:{
        labels:['Asesmen'],
        datasets:[
            {
                label:'Dibuat',
                data:[{{ $data['created_assesments'] }}],
                backgroundColor:'#adb5bd'
            },
            {
                label:'Dianalisis',
                data:[{{ $data['analyzed_assesments'] }}],
                backgroundColor:'#198754'
            }
        ]
    },
    options:{
        scales:{
            x:{ stacked:true },
            y:{ stacked:true, beginAtZero:true }
        }
    }
});
</script>
@endrole
@endsection
