<!DOCTYPE html>
<html lang="en">
    <head>
        
        <title>NoteSpace</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
        
        <style>
            body {
                background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            }
            .login-card {
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.08);
                padding: 2rem;
            }
            .form-control {
                border-radius: 10px !important;
                height: 48px;
            }
            .btn-primary {
                border-radius: 10px;
                font-size: 1rem;
                padding: 0.75rem;
            }
            .welcome-text {
                font-size: 2rem;
                font-weight: 700;
                color: #1e3a8a;
            }
            .subtitle-text {
                color: #6b7280;
            }
        </style>
    </head>
    
    <body id="kt_body" class="app-blank">
        <script>
            var defaultThemeMode = "light"; 
            var themeMode; 
            if ( document.documentElement ) { 
                if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { 
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
                } else { 
                    if ( localStorage.getItem("data-bs-theme") !== null ) { 
                        themeMode = localStorage.getItem("data-bs-theme"); 
                    } else { 
                        themeMode = defaultThemeMode; 
                    } 
                } 
                if (themeMode === "system") { 
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
                } 
                document.documentElement.setAttribute("data-bs-theme", themeMode); 
            }
        </script>

        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <div class="d-flex flex-column flex-lg-row flex-column-fluid align-items-center justify-content-center min-vh-100">
                <div class="login-card mw-450px w-100">
                    
                    <!-- <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="index.html" action="#"> -->
                    <form method="POST" novalidate="novalidate" action="{{ route('login.post') }}" class="form w-100">
                        @csrf

                        <div class="text-start mb-10 text-center">
                            <h1 class="welcome-text mb-3">Welcome to NoteSpace</h1>
                            <div class="subtitle-text fw-semibold fs-6">Organize your ideas, anytime, anywhere.</div>
                        </div>

                        <!-- Pesan Error -->
                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="fv-row mb-8">
                            <input type="text" placeholder="Username" name="username" autocomplete="off" class="form-control form-control-solid" value="{{ old('username') }}" />
                        </div>

                        <div class="fv-row mb-7">
                            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control form-control-solid" />
                        </div>

                        <div class="d-flex justify-content-end mb-10">
                            <a href="#" class="link-primary fw-semibold">Forgot Password?</a>
                        </div>

                        <div class="d-grid">
                            <button id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">Login</span>
                                <span class="indicator-progress">
                                    Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>var hostUrl = "{{ asset('assets/') }}";</script>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
        <script src="{{ asset('assets/js/custom/authentication/sign-in/i18n.js') }}"></script>
    
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 800,
                    showConfirmButton: false
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: '{{ session('error') }}',
                    timer: 800,
                    showConfirmButton: false
                });
            </script>
        @endif

    </body>
</html>
