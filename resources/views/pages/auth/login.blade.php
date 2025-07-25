@extends('layouts.auth')

@section('title')
    Masuk ke Adaptived
@endsection

@section('content')
<form id="formLogin" action="{{ route('auth.login.store') }}" method="POST" novalidate>
    @csrf
    <div class="text-center">
        <div class="mb-5">
            <h1 class="display-5 mt-5">Masuk ke Adaptived</h1>
            <p>Belum punya akun adaptived? <a class="link" href="{{ route('auth.register.index') }}">
                    Buat akun baru
                </a></p>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-soft-success" role="alert">
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="mb-4">
        <label class="form-label" for="email">Email</label>
        <input type="email" class="form-control form-control-lg" name="email" id="email" tabindex="1" placeholder="Email Anda" aria-label="Email Anda" required>
        <span class="invalid-feedback"></span>
    </div>
    <div class="mb-4">
        <label class="form-label w-100" for="password" tabindex="0">
            <span class="d-flex justify-content-between align-items-center">
                <span>Kata sandi</span>
                <a class="form-label-link mb-0" href="#">Lupa kata sandi?</a>
            </span>
        </label>

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
        <button tabindex="3" type="submit" class="btn btn-primary btn-lg btn-loading" data-text="<b>Masuk <i class='me-2 bi-arrow-right'></i></b>" data-text-loading="<b>Sedang masuk</b>">
            <b>Masuk <i class='me-2 bi-arrow-right'></i></b>
        </button>
    </div>
</form>
@endsection

@section('scripts')

    <script>
        addSubmitFormHandler('#formLogin', function(response) {
            if (response.status === 200) {
                window.location.href = response.data.data.redirect;
            }
        });
    </script>

@endsection
