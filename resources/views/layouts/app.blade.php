<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script>
        var startTime = (new Date()).getTime();
    </script>
    <title>@yield('title') | Fakultas Vokasi</title>
    <meta name="author" content="Nur Mujahidin Achmad Akbar">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
    <link rel="preload" href="{{URL::to('/')}}/assets/css/theme.vokasi.css" data-hs-appearance="default" as="style">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/vendor/sweetalert/sweetalert2.css">
    <style data-hs-appearance-onload-styles>
        *
        {
            transition: unset !important;
        }
    body {
      opacity: 1;
    }
  </style>
  @yield('styles')
    <script>
        window.hs_config = {"autopath":"@@autopath","deleteLine":"hs-builder:delete","deleteLine:build":"hs-builder:build-delete","deleteLine:dist":"hs-builder:dist-delete","previewMode":false,"startPath":"/index.html","vars":{"themeFont":"https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap","version":"?v=1.0"},"layoutBuilder":{"extend":{"switcherSupport":true},"header":{"layoutMode":"default","containerMode":"container-fluid"},"sidebarLayout":"default"},"themeAppearance":{"layoutSkin":"default","sidebarSkin":"default","styles":{"colors":{"primary":"#377dff","transparent":"transparent","white":"#fff","dark":"132144","gray":{"100":"#f9fafc","900":"#1e2022"}},"font":"Inter"}},"languageDirection":{"lang":"en"},"skipFilesFromBundle":{"dist":["assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","assets/js/demo.js"],"build":["assets/css/theme.css","assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js","assets/js/demo.js","assets/css/theme-dark.css","assets/css/docs.css","assets/vendor/icon-set/style.css","assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js","assets/js/demo.js"]},"minifyCSSFiles":["assets/css/theme.css","assets/css/theme-dark.css"],"copyDependencies":{"dist":{"*assets/js/theme-custom.js":""},"build":{"*assets/js/theme-custom.js":"","node_modules/bootstrap-icons/font/*fonts/**":"assets/css"}},"buildFolder":"","replacePathsToCDN":{},"directoryNames":{"src":"./src","dist":"./dist","build":"./build"},"fileNames":{"dist":{"js":"theme.min.js","css":"theme.min.css"},"build":{"css":"theme.min.css","js":"theme.min.js","vendorCSS":"vendor.min.css","vendorJS":"vendor.min.js"}},"fileTypes":"jpg|png|svg|mp4|webm|ogv|json"}
        window.hs_config.gulpRGBA = (p1) => {
            const options = p1.split(',')
            const hex = options[0].toString()
            const transparent = options[1].toString()

            var c;
            if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
                c= hex.substring(1).split('');
                if(c.length== 3){
                    c= [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c= '0x'+c.join('');
                return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',' + transparent + ')';
            }
            throw new Error('Bad Hex');
        }
        window.hs_config.gulpDarken = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = -parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
        window.hs_config.gulpLighten = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
    </script>
</head>

<body>
<script src="/assets/js/hs.theme-appearance.js"></script>
<div class="overlay-loading-wrapper">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<header id="header" class="navbar navbar-expand-lg navbar-bordered bg-white navbar-sticky-top ">
    <div class="container">
      <nav class="js-mega-menu navbar-nav-wrap">
        <a class="navbar-brand me-sm-5" href="/" aria-label="Fakultas Vokasi">
          <img class="shimmer d-block d-sm-none" src="{{ URL::to('/') }}/assets/img/logos/akun-vokasi.svg" alt="FV"
            data-hs-theme-appearance="default" loading="lazy" width="100px">
          <img class="shimmer d-none d-sm-block" src="{{ URL::to('/') }}/assets/img/logos/akun-vokasi.svg"
            alt="Fakultas Vokasi" data-hs-theme-appearance="default" loading="lazy" width="120px">
        </a>
        <div class="navbar-nav-wrap-secondary-content">
          <ul class="navbar-nav">
            <li class="nav-item">
              @if (\App\Helpers\UserHelper::hasAdminRole())
                <div class="tom-select-custom tom-select-custom-end d-none d-sm-block">
                  <select id="roleSwitcher" class="js-select form-select"
                    data-hs-tom-select-options='{
                                  "hideSearch": true,
                                  "dropdownWidth": "20rem",
                                  "disableSearch": true
                                }'>
                    <option {{ !\App\Helpers\UserHelper::isAdmin() ? 'selected' : '' }} value="user"
                      data-option-template='<div class="d-flex align-items-start"><div class="flex-shrink-0"><i class="bi-person"></i></div><div class="flex-grow-1 ms-2"><span class="d-block fw-semibold">Dosen/Tendik</span><span class="tom-select-custom-hide small">Bertindak sebagai dosen/tendik personal.</span></div></div>'>
                      Dosen/Tendik</option>
                    <option {{ \App\Helpers\UserHelper::isAdmin() ? 'selected' : '' }} value="admin"
                      data-option-template='<div class="d-flex align-items-start"><div class="flex-shrink-0"><i class="bi-lock"></i></div><div class="flex-grow-1 ms-2"><span class="d-block fw-semibold">Admin</span><span class="tom-select-custom-hide small">Bertindak sebagai admin, dapat menambahkan data dosen, mahasiswa, prodi dan lain-lain.</span></div></div>'>
                      Admin</option>
                  </select>
                </div>
              @endif
            </li>
            <li class="nav-item">
              <div class="dropdown">
                <button type="button" class="btn btn-icon btn-ghost-secondary rounded-circle" id="navbarAppsDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                  <i class="bi-grid-3x3-gap-fill"></i>
                </button>

                <div
                  class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless"
                  aria-labelledby="navbarAppsDropdown" style="width: 22em;">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title">Aplikasi lainnya</h4>
                    </div>
                    <div class="card-body card-body-height">
                        <a class="dropdown-item" href="https://siakad.um.ac.id" target="_blank">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img class="avatar avatar-xs avatar-4x3"
                                         src="/assets/img/logos/logo-um.png" alt="Logo">
                                </div>
                                <div class="flex-grow-1 text-truncate ms-3">
                                    <h5 class="mb-0">SIAKAD</h5>
                                    <p class="card-text text-body">Sistem Informasi Akademik</p>
                                </div>
                            </div>
                        </a>
                        @foreach(\App\Models\AuthApplication::where('show', true)->get() as $app)
                            <a class="dropdown-item" href="{{ $app->url }}" target="_blank">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img class="avatar avatar-xs avatar-4x3"
                                             src="{{ $app->iconURL() }}" alt="Logo">
                                    </div>
                                    <div class="flex-grow-1 text-truncate ms-3">
                                        <h5 class="mb-0">{{ $app->name }}</h5>
                                        <p class="card-text text-body">{{ $app->description }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </li>
              @if(\App\Helpers\UserHelper::getAuthUser() != null)
                  <li class="nav-item">
                      <!-- Account -->
                      <div class="dropdown">
                          <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                              <div class="avatar avatar-sm avatar-circle">
                                  <img class="avatar-img" src="{{ \App\Helpers\UserHelper::getAuthUser()->getPhoto() }}" alt="Photo">
                                  <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                              </div>
                          </a>

                          <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 23rem; max-width: 90vw;">
                              <div class="dropdown-item-text">
                                  <div class="d-flex align-items-center">
                                      <div class="avatar avatar-sm avatar-circle">
                                          <img class="avatar-img" src="{{ \App\Helpers\UserHelper::getAuthUser()->getPhoto() }}" alt="Photo">
                                      </div>
                                      <div class="flex-grow-1 ms-3">
                                          <h5 class="mb-0">{{ \App\Helpers\UserHelper::getAuthUser()->name }}</h5>
                                          <p class="card-text text-body">{{ \App\Helpers\UserHelper::getAuthUser()->getIDString() }}</p>
                                      </div>
                                  </div>
                              </div>
                              <div class="dropdown-divider"></div>
                              @if(\App\Helpers\UserHelper::hasAdminRole())
                                  <a class="dropdown-item" href="{{ route('auth.login.switch', ['role' => \App\Helpers\UserHelper::isAdmin() ? 'lecturer' : 'admin']) }}">
                                      <i class="bi-lock me-2"></i>
                                      {{ !\App\Helpers\UserHelper::isAdmin() ? 'Masuk ke mode ADMIN' : 'Keluar dari mode ADMIN' }}
                                  </a>
                              @endif
                              <a class="dropdown-item" href="{{ route('reset-password.index') }}">
                                  <i class="bi-key me-2"></i>
                                  Ubah Kata Sandi
                              </a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                  <i class="bi-door-open me-2"></i>
                                  Keluar
                              </a>
                          </div>
                      </div>
                      <!-- End Account -->
                  </li>
              @endif
          </ul>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarContainerNavDropdown" aria-controls="navbarContainerNavDropdown"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-default">
            <i class="bi-list"></i>
          </span>
          <span class="navbar-toggler-toggled">
            <i class="bi-x"></i>
          </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContainerNavDropdown">
          <ul class="navbar-nav">
            @if (\App\Helpers\UserHelper::isAdmin())
              @include('menu.admin')
            @else
              @include('menu.profile')
            @endif
          </ul>
        </div>
      </nav>
    </div>
  </header>
  <main id="content" role="main" class="main pt-5 mt-5 bg-light pb-10">
    @yield('content')

      <div class="footer border-top bg-light">
          <div class="container pt-3">
              <div class="row justify-content-between align-items-center">
                  <div class="col">
                      <p class="fs-6 mb-0">&copy; 2023 - {{ date('Y') }} <span class="d-inline-block d-sm-none">FV UM</span> <span
                              class="d-none d-sm-inline-block">Fakultas Vokasi Universitas Negeri Malang</span></p>
                  </div>
                  <div class="col-auto">
                      <div id="page_load_time" class="fs-6 mb-0 text-muted">
                          <div class="spinner-border spinner-border-sm" role="status">
                              <span class="visually-hidden">Loading...</span>
                          </div>
                          <span class="ms-2">Memuat...</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </main>

<div id="modalDelete" class="modal fade" data-url="@yield('destroy_endpoint')" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteTitle">Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-delete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<div id="modalSingleDelete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalDeleteSingleTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalDeleteSingleTitle">Hapus Data</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan. Apakah Anda tetap ingin melanjutkan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-delete-single" data-endpoint="@yield('single_delete_endpoint')">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Import Error Modal -->
<div id="importErrorModal" class="modal modal-xl fade" tabindex="-1" role="dialog" aria-labelledby="importErrorModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h4 class="modal-title" id="importErrorModalTitle">Impor Gagal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ps-5 pe-5">
                    <p>Gagal mengimpor data karena ada beberapa data yang tidak sesuai dengan format. Seluruh proses impor telah dibatalkan dan database telah di-rollback seperti semula. Tidak ada perubahan apapun yang terjadi pada sistem.</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-align-middle table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col" style="width: 30px; padding-left: 32px;">Row</th>
                            <th scope="col">Isi Row</th>
                            <th scope="col">ATRIBUT</th>
                            <th scope="col">PESAN KESALAHAN</th>
                        </tr>
                        </thead>
                        <tbody id="tableError">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Import Error Modal -->

<script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
<script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
<script src="/assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
<script src="/assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script src="/assets/vendor/hs-scrollspy/dist/hs-scrollspy.min.js"></script>
<script src="/assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/assets/vendor/datatables.net.extensions/select/select.min.js"></script>
<script src="/assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script src="/assets/vendor/sweetalert/sweetalert2.min.js"></script>
<script src="/assets/vendor/sweetalert/custom.js"></script>
<script src="/assets/js/theme.min.js"></script>
<script src="/assets/js/axios.min.js"></script>
<script src="/assets/js/form-handler.js"></script>
<script src="/assets/js/vokasi.js"></script>
<script async>
    function addImgTimeout(img) {
        var timer;
        function clearTimer() {
            if (timer) {
                clearTimeout(timer);
                timer = null;
            }
        }
        function handleFail() {
            this.onload = this.onabort = this.onerror = function() {};
            clearTimer();
            const altSrc = this.getAttribute('data-alt-src');
            if (altSrc) {
                this.src = altSrc;
            } else {
                if (this.classList.contains('avatar-img')) {
                    this.src = "/assets/img/160x160/img1.jpg";
                } else {
                    if (this.width > 600 && this.height <= 200) {
                        this.src = "/assets/img/600x200/img1.jpg";
                    }else {
                        this.src = "/assets/img/400x400/img2.jpg";
                    }

                }
            }
        }
        img.onerror = img.onabort = handleFail;
        img.onload = function() {
            clearTimer();
        };
        timer = setTimeout(function(theImg) {
            return function() {
                handleFail.call(theImg);
            };
        }(img), 4000);
        return(img);
    }
    $('img').each(function() {
        if (!this.complete) {
            addImgTimeout(this);
        }
    });
</script>
<script>
    (function() {
        $.fn.dataTable.ext.errMode = 'none';

      HSBsDropdown.init();
      HSCore.components.HSTomSelect.init('.js-select');
      new HSMegaMenu('.js-mega-menu', {
        desktop: {
          position: 'left'
        }
      });
      @if (\App\Helpers\UserHelper::hasAdminRole())
        $('#roleSwitcher').change(function() {
          @if (\App\Helpers\UserHelper::isAdmin())
            window.location.href = '{{ route('auth.login.switch', ['role' => 'lecturer']) }}';
          @else
            window.location.href = '{{ route('auth.login.switch', ['role' => 'admin']) }}';
          @endif
        });
      @endif
    })()
  </script>

@yield('scripts')
@stack('scripts')
  <script>
    $(window).on('load', function() {
      function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      }
      var endTime = (new Date()).getTime();
      var millisecondsLoading = endTime - startTime;
      $("#page_load_time").html('Load time ' + numberWithCommas(millisecondsLoading) + " ms");
    });
  </script>
</body>
</html>
