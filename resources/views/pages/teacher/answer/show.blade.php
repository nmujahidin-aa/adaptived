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
        <a href="{{ route('teacher.answer.index', ['assesment_id' => $assesment->id]) }}" class="btn btn-white">
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
                    <div class="alert alert-primary" role="alert">
                        <div class="flex-shrink-0">
                            <i class="bi-patch-question-fill"></i> <span class="fw-semibold">Pertanyaan</span>
                        </div>
                    </div>
                    <div class="rich-text-content pb-3 px-3">  
                        {!! $data->question->question !!}
                    </div>

                    <div class="alert alert-soft-success" role="alert">
                        <div class="flex-shrink-0">
                            <i class="bi-patch-question-fill"></i> <span class="fw-semibold">Jawaban {{ $data->user->name }}</span>
                        </div>
                    </div>
                    <div class="rich-text-content pb-3 px-3">
                        {!! $data->trixRender('answer') !!}
                    </div>

                    <div class="alert alert-dark" role="alert">
                        <div class="flex-shrink-0">
                            <i class="bi-patch-question-fill"></i> <span class="fw-semibold">Analisis AI</span>
                        </div>
                    </div>
                    <div class="rich-text-content pb-3 px-3">
                        <form action="{{ route('teacher.answer.analyze', ['assesment_id' => $assesment->id, 'id' => $data->id]) }}" method="POST">
                            @csrf
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Analisis Jawaban</button>
                            </div>
                        </form>
                        <!-- <h1>Analisis Jawaban Siswa</h1>
                        <p>Analisis terhadap jawaban siswa menunjukkan pemahaman yang cukup baik mengenai topik yang dibahas. Siswa mampu mengidentifikasi pertanyaan yang relevan berdasarkan teks yang diberikan, khususnya terkait dengan <strong>perubahan komponen ekosistem</strong> akibat pencemaran pestisida.</p>

                        <hr>

                        <h2>Analisis Jawaban Siswa</h2>
                        <p>Siswa membuat tiga pertanyaan, padahal instruksi hanya meminta dua. Meskipun demikian, pertanyaan-pertanyaan yang diajukan memiliki kualitas yang baik dan saling berkaitan. Mari kita bedah satu per satu:</p>

                        <ul>
                            <li>
                                <div class="analysis-point">
                                    <strong>"Apa dampak pencemaran residu pestisida terhadap komponen abiotik dalam ekosistem?"</strong>
                                    <p>Pertanyaan ini sangat relevan. Teks menyebutkan bahwa 80% pestisida masuk ke tanah, yang merupakan <strong>komponen abiotik</strong>. Dampak pencemaran ini, seperti terganggunya kesuburan tanah, adalah inti dari masalah yang dijelaskan dalam teks.</p>
                                </div>
                            </li>
                            <li>
                                <div class="analysis-point">
                                    <strong>"Bagaimana pengaruh pestisida terhadap interaksi antar makhluk hidup dalam ekosistem?"</strong>
                                    <p>Pertanyaan ini juga relevan dan menunjukkan pemikiran yang lebih mendalam. Teks menyebutkan <strong>kerusakan ekosistem mikroba tanah</strong>, yang merupakan bagian dari <strong>komponen biotik</strong>. Mikroba ini memiliki peran penting dalam siklus nutrisi dan interaksi dengan tumbuhan, sehingga kerusakan pada mereka akan mengubah interaksi dalam ekosistem.</p>
                                </div>
                            </li>
                            <li>
                                <div class="analysis-point">
                                    <strong>"Bagaimana pengaruh kandungan pestisida terhadap kesuburan tanah?"</strong>
                                    <p>Pertanyaan ini juga sangat baik dan secara langsung merujuk pada salah satu poin kunci dalam teks: "...mengganggu kesuburan tanah...". Pertanyaan ini bisa dianggap sebagai penguat dari pertanyaan pertama, berfokus secara spesifik pada <strong>kesuburan tanah</strong> yang merupakan aspek vital dari komponen abiotik.</p>
                                </div>
                            </li>
                        </ul>

                        <p>Secara keseluruhan, siswa berhasil menangkap esensi dari bacaan dan menghubungkannya dengan konsep <strong>ekosistem</strong>, yang terdiri dari komponen <strong>biotik</strong> (makhluk hidup) dan <strong>abiotik</strong> (benda tak hidup). Pertanyaan yang diajukan sangat berbobot dan menargetkan poin-poin penting yang disebutkan dalam teks.</p>

                        <hr>

                        <h2>Penilaian</h2>
                        <p>Berdasarkan analisis di atas, jawaban siswa layak mendapatkan nilai:</p>

                        <div class="score-box">
                            <span class="score">90/100</span>
                            <h3>Alasan:</h3>
                            <ul>
                                <li><strong>Kualitas Pertanyaan (40 poin):</strong> Pertanyaan yang diajukan menunjukkan pemahaman yang kuat tentang bacaan dan mampu mengaitkannya dengan konsep ilmiah (ekosistem).</li>
                                <li><strong>Keterkaitan dengan Teks (30 poin):</strong> Semua pertanyaan secara langsung didukung oleh informasi yang ada dalam teks, baik secara eksplisit (pencemaran tanah, kesuburan tanah) maupun implisit (kerusakan ekosistem mikroba, yang memengaruhi interaksi).</li>
                                <li><strong>Kesesuaian dengan Instruksi (20 poin):</strong> Siswa mengajukan tiga pertanyaan, padahal instruksi hanya meminta dua. Ini menunjukkan ketidakakuratan dalam mengikuti perintah, meskipun pertanyaan tambahan tersebut berkualitas.</li>
                                <li><strong>Struktur dan Kejelasan (10 poin):</strong> Pertanyaan dirumuskan dengan jelas dan mudah dipahami.</li>
                            </ul>
                        </div> -->
                    </div>
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
