@extends('layouts.auth')

@section('title')
    Bergabung ke Adaptived
@endsection

@section('content')
<form id="formRegister" action="{{ route('auth.register.store') }}" method="POST" novalidate>
    @csrf
    <div class="text-center">
        <div class="mb-5">
            <h1 class="display-5 mt-5">Bergabung ke Adaptived</h1>
            <p>Sudah punya akun adaptived? <a class="link" href="{{ route('auth.login.index') }}">
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
        <label class="form-label" for="email">Email</label>
        <input type="email" class="form-control form-control-lg" name="email" id="email" tabindex="1" placeholder="Email Anda" aria-label="Email Anda" required>
        <span class="invalid-feedback"></span>
    </div>
    <div class="mb-4">

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
