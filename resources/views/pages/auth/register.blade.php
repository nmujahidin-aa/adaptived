@extends('layouts.auth')

@section('title')
    Bergabung ke Adaptived
@endsection

@section('content')
@include('sweetalert::alert')
<form id="#" action="{{ route('auth.register.store') }}" method="POST">
    @csrf
    <div class="text-center">
        <div class="mb-5">
            <h1 class="display-5 mt-5">Bergabung ke Bioadaptiveclass</h1>
            <p>Sudah punya akun Bioadaptiveclass? <a class="link" href="{{ route('auth.login.index') }}">
                    Masuk ke akun Anda
                </a></p>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-soft-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="mb-4">
        <label class="form-label" for="role">Bergabung sebagai ?</label>
        <div class="col">
            <div class="input-group input-group-sm-vertical">
            <!-- Radio Check -->
            <label class="form-control" for="Teacher">
                <span class="form-check">
                <input type="radio" class="form-check-input" name="role" value="TEACHER" id="Teacher">
                <span class="form-check-label">Guru</span>
                </span>
            </label>
            <!-- End Radio Check -->

            <!-- Radio Check -->
            <label class="form-control" for="Student">
                <span class="form-check">
                <input type="radio" class="form-check-input" name="role" value="STUDENT" id="Student" checked>
                <span class="form-check-label">Siswa</span>
                </span>
            </label>
            <!-- End Radio Check -->
            </div>
        </div>
        <span class="invalid-feedback"></span>
    </div>

    <span class="divider-center text-muted mb-4">Data Diri</span>

    <div class="mb-4">
        <label class="form-label" for="name">Nama</label>
        <input type="text" class="form-control form-control-lg" name="name" id="name" tabindex="1" placeholder="Nama Anda" aria-label="Nama Anda" required>
        <span class="invalid-feedback"></span>
    </div>
    <div class="mb-4">
        <label class="form-label" for="email">Email</label>
        <input type="email" class="form-control form-control-lg" name="email" id="email" tabindex="1" placeholder="Email Anda" aria-label="Email Anda" required>
        <span class="invalid-feedback"></span>
    </div>
    <div class="mb-4">
        <label class="form-label" for="gender">Jenis Kelamin</label>
        <div class="col">
            <div class="input-group input-group-sm-vertical">
            <!-- Radio Check -->
            <label class="form-control" for="L">
                <span class="form-check">
                <input type="radio" class="form-check-input" name="gender" value="L" id="L" checked>
                <span class="form-check-label">Laki-laki</span>
                </span>
            </label>
            <!-- End Radio Check -->

            <!-- Radio Check -->
            <label class="form-control" for="P">
                <span class="form-check">
                <input type="radio" class="form-check-input" name="gender" value="P" id="P">
                <span class="form-check-label">Perempuan</span>
                </span>
            </label>
            <!-- End Radio Check -->
            </div>
        </div>
        <span class="invalid-feedback"></span>
    </div>
    <div class="mb-4">
        <label class="form-label" for="email">Asal Sekolah</label>
        <div class="tom-select-custom">
            <select class="js-select form-select w-100" name="school_id" data-hs-tom-select-options='{
                    "searchInDropdown": true,
                    "dropdownWidth": "100%"
                    }'>
            @foreach($school as $index => $row)
                <option value="{{$row->id}}" data-option-template='
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                          <img class="avatar-img" src="{{$row->getLogo()}}" alt="Logo">
                        </div>
                        <div class="ms-3">
                          <span class="d-block h6 text-bold mb-0">
                            {{$row->short_name}}
                          </span>
                            <span class="d-block fs-7 text-body text-dark" style="text-transform: uppercase;">{{$row->name}}</span>
                        </div>
                    </div>'>{{$row->name}}</option>
            @endforeach
            </select>
        </div>
        <span class="invalid-feedback"></span>
    </div>


    <div class="mb-4">
        <label class="form-label" for="email">Password</label>
        <div class="input-group input-group-merge">
            <input tabindex="2" type="password" class="js-toggle-password form-control form-control-lg" name="password" id="password" placeholder="Kata sandi Anda" aria-label="Kata sandi Anda" required data-hs-toggle-password-options='{
                    "target": "#changePassTarget",
                    "defaultClass": "bi-eye-slash",
                    "showClass": "bi-eye",
                    "classChangeTarget": "#changePassIcon"
                    }'>
            <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                <i id="changePassIcon" class="bi-eye"></i>
            </a>
        </div>
        <span class="invalid-feedback"></span>
    </div>

    <div class="d-grid">
        <button tabindex="3" type="submit" class="btn btn-primary btn-lg btn-loading" data-text="<b>Bergabung <i class='me-2 bi-arrow-right'></i></b>" data-text-loading="<b>Data sedang diproses</b>">
            <b>Bergabung <i class='me-2 bi-arrow-right'></i></b>
        </button>
    </div>
</form>
@endsection

@section('scripts')
    <script>
        addSubmitFormHandler('#formRegister', function(response) {
            if (response.status === 200) {
                window.location.href = response.data.data.redirect;
            } else {
                alert(response.data.message);
            }
        });
    </script>
@endsection
