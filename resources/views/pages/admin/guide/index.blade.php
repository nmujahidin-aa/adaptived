@extends('layouts.app')

@section('title', 'Petunjuk Penggunaan | Bioadaptiveclass')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-header-title">Petunjuk Penggunaan</h1>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <form action="{{ route('admin.guide.store') }}" method="POST" autocomplete="off" class="w-100" enctype="multipart/form-data"> 
                @csrf
                @if (isset($data))
                    <input type="hidden" name="id" value="{{ $data->id }}" autocomplete="off">
                @endif
                <div class="col-lg-12">
                    @trix($data, 'content', ['class' => $errors->has('content') ? 'is-invalid' : ''])
                    <div class="invalid-feedback">
                        @error('content')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="card-footer mt-3">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi-save me-2"></i> <b>Simpan</b>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    @if(session()->has('alert.guide.success'))
    SweetAlert.success('Berhasil', '{{ session()->get('alert.guide.success') }}');
    @endif
</script>
@endsection