<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | Adaptived</title>
    <meta name="author" content="Fakultas Vokasi Universitas Negeri Malang">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/img/favicon/site.webmanifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
    <link rel="stylesheet" href="/assets/vendor/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/auth.css">
    <link rel="stylesheet" href="/assets/vendor/sweetalert/sweetalert2.css">
    <link rel="preload" href="/assets/css/theme.vokasi.css" data-hs-appearance="default" as="style">
    <style>
        .overlay-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .overlay-background::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-blend-mode: multiply;
            background-image: linear-gradient(120deg, #377dff 0%, #ff6f00 100%);
            opacity: 0.4;
        }
        .overlay-background img {
            object-fit: cover;
            object-position: center;
            width: 100%;
            height: 100%;
        }

        .reveal {
            position: relative;
            opacity: 0;
            transition: 1s all ease;
        }

        .reveal-scale-up {
            transform: scale(0.1);
        }

        .reveal-scale-down {
            transform: scale(2);
        }

        .reveal-left {
            transform: translateX(-150px);
        }

        .reveal-right {
            transform: translateX(150px);
        }

        .reveal-top {
            transform: translateY(-150px);
        }

        .reveal-bottom {
            transform: translateY(150px);
        }

        .reveal.active {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .input-group-merge.is-invalid{border-color:#ed4c78 !important}

        .shimmer {
            background: #f6f7f8;
            background-image: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
            background-repeat: no-repeat;
            animation : shim infinite 1.2s linear;
            border-radius: 10px;
        }
        @keyframes shim {
            0% { background-position: -468px 0;}
            100% { background-position: 468px 0;}
        }

    </style>
    <style data-hs-appearance-onload-styles>
        *
        {
            transition: unset !important;
        }

        body
        {
            opacity: 1;
        }
    </style>
    <script>
        window.hs_config = {"autopath":"@@autopath","deleteLine":"hs-builder:delete","deleteLine:build":"hs-builder:build-delete","deleteLine:dist":"hs-builder:dist-delete","previewMode":false,"startPath":"/index.html","vars":{"themeFont":"https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap","version":"?v=1.0"},"layoutBuilder":{"extend":{"switcherSupport":true},"header":{"layoutMode":"default","containerMode":"container-fluid"},"sidebarLayout":"default"},"themeAppearance":{"layoutSkin":"default","sidebarSkin":"default","styles":{"colors":{"primary":"#377dff","transparent":"transparent","white":"#fff","dark":"132144","gray":{"100":"#f9fafc","900":"#1e2022"}},"font":"Inter"}},"languageDirection":{"lang":"en"},"skipFilesFromBundle":{"dist":["/assets/js/hs.theme-appearance.js","/assets/js/hs.theme-appearance-charts.js","assets/js/demo.js"],"build":["/assets/css/theme.css","/assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js","/assets/js/demo.js","/assets/css/theme-dark.css","/assets/css/docs.css","/assets/vendor/icon-set/style.css","/assets/js/hs.theme-appearance.js","/assets/js/hs.theme-appearance-charts.js","/node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js","/assets/js/demo.js"]},"minifyCSSFiles":["/assets/css/theme.css","/assets/css/theme-dark.css"],"copyDependencies":{"dist":{"*assets/js/theme-custom.js":""},"build":{"*assets/js/theme-custom.js":"","node_modules/bootstrap-icons/font/*fonts/**":"assets/css"}},"buildFolder":"","replacePathsToCDN":{},"directoryNames":{"src":"./src","dist":"./dist","build":"./build"},"fileNames":{"dist":{"js":"theme.min.js","css":"theme.min.css"},"build":{"css":"theme.min.css","js":"theme.min.js","vendorCSS":"vendor.min.css","vendorJS":"vendor.min.js"}},"fileTypes":"jpg|png|svg|mp4|webm|ogv|json"}
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
    <script>
        function onImageError(img) {
            img.src = "/assets/img/160x160/img1.jpg";
        }
    </script>
</head>

<body class="d-flex align-items-center min-h-100">
<script src="/assets/js/hs.theme-appearance.js"></script>
<main id="content" role="main" class="main pt-0">
    <!-- Content -->
    <div class="container-fluid px-0" style="overflow: hidden;">
        <div class="row">
            <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative px-0" style="background-color: #B4EBE6;">
                <div class="col-8 text-center">
                    <img src="/assets/img/backgrounds/icon.png" alt="Adaptived" loading="lazy" style="width: 300px;">

                    <h2 class="mt-5">
                        Hai, Selamat Datang di Sistem Informasi Terpadu Fakultas Vokasi UM!
                    </h2>
                    <p>
                        Satu akun untuk segala keperluan di Fakultas Vokasi Universitas Negeri Malang.
                    </p>
                </div>

            </div>

            <div class="col-lg-6 d-flex justify-content-center align-items-center min-vh-lg-100">
                <div class="w-100 content-space-t-1 content-space-t-lg-1 content-space-b-1" style="max-width: 25rem;">
                    <div class="reveal reveal-right">
                        <div class="text-center">
                            {{-- <img class="shimmer" src="/assets/img/logos/auth_logo_default.png" alt="Fakultas Vokasi" width="100%" loading="lazy" style="max-width: 80%;"> --}}
                        </div>
                        <div class="auth-content">
                            <div class="container-fluid">
                                @yield('content')
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <div class="d-none d-md-block">
                                <small>&copy; 2023 - {{ date('Y') }} Universitas Negeri Malang</small>
                            </div>
                            <div class="d-block d-md-none">
                                <small>&copy; 2023 - {{ date('Y') }} Adaptived</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
<script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="/assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
<script src="/assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
<script src="/assets/vendor/flatpickr/dist/l10n/id.js"></script>
<script src="/assets/js/theme.min.js"></script>
<script src="/assets/js/axios.min.js"></script>
<script src="/assets/js/form-handler.js"></script>
<script src="/assets/vendor/sweetalert/sweetalert2.min.js"></script>
<script src="/assets/vendor/sweetalert/custom.js"></script>

<script>
    (function() {
        window.onload = function () {
            new HSTogglePassword('.js-toggle-password');
            HSCore.components.HSTomSelect.init('.js-select');
        };
    })()
</script>
<script>
    function reveal() {
        let reveals = document.querySelectorAll(".reveal");

        for (let i = 0; i < reveals.length; i++) {
            reveals[i].classList.add("active");
        }

        document.querySelector(".overlay-background").classList.add("active");
    }

    function loadImage() {
        let img = document.querySelectorAll('.shimmer');
        for (let i = 0; i < img.length; i++) {
            if (img[i].complete) {
                img[i].classList.remove('shimmer');
                continue;
            }
            img[i].addEventListener('load', function() {
                this.classList.remove('shimmer');
            });
        }
    }

    loadImage();

    reveal();
</script>
@yield('scripts')
</body>
</html>
