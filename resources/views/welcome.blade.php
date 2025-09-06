<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MediTrack SUSL</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .hero-section {
                background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
                color: white;
                min-height: 60vh;
            }
            .feature-icon {
                width: 64px;
                height: 64px;
                background: #007bff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        @if (Route::has('login'))
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="#">MediTrack SUSL</a>
                    <div class="navbar-nav ms-auto">
                        @auth
                            <a href="{{ url('/home') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </nav>
        @endif

        <!-- Hero Section -->
        <section class="hero-section d-flex align-items-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-4">
                            Welcome to <br>
                            <span class="text-warning">MediTrack SUSL</span>
                        </h1>
                        <p class="lead mb-4">
                            A comprehensive medical tracking system built with Laravel. 
                            Manage patient records, appointments, and medical data efficiently 
                            with our modern web application.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="#features" class="btn btn-light btn-lg">Get Started</a>
                            <a href="#about" class="btn btn-outline-light btn-lg">Learn More</a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="p-5">
                            <i class="bi bi-hospital display-1 mb-3"></i>
                            <h3>Medical Dashboard</h3>
                            <p class="text-light">Manage healthcare data efficiently</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="text-primary fw-bold text-uppercase">Features</h2>
                    <h3 class="display-5 fw-bold">Everything you need for medical management</h3>
                    <p class="lead text-muted">
                        Built with modern web technologies and best practices to ensure reliability and security.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="feature-icon">
                                <i class="bi bi-file-medical text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold">Patient Records</h5>
                            <p class="text-muted">
                                Comprehensive patient record management with secure data storage and easy access to medical history.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold">Secure & Compliant</h5>
                            <p class="text-muted">
                                Built with security best practices and healthcare compliance standards in mind.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold">Analytics Dashboard</h5>
                            <p class="text-muted">
                                Real-time analytics and reporting tools to track medical trends and patient outcomes.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="feature-icon">
                                <i class="bi bi-phone text-white fs-2"></i>
                            </div>
                            <h5 class="fw-bold">Mobile Responsive</h5>
                            <p class="text-muted">
                                Fully responsive design that works seamlessly across all devices and screen sizes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="display-5 fw-bold mb-4">Built with Laravel</h2>
                        <p class="lead mb-4">
                            MediTrack SUSL is powered by Laravel {{ Illuminate\Foundation\Application::VERSION }}, 
                            one of the most popular and robust PHP frameworks. This ensures reliability, 
                            security, and scalability for your medical data management needs.
                        </p>
                        <div class="d-flex gap-3">
                            <a href="https://laravel.com/docs" class="btn btn-primary">View Documentation</a>
                            <a href="https://github.com" class="btn btn-outline-primary">GitHub Repository</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4">Technical Stack</h5>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Laravel</span>
                                            <span class="fw-bold text-primary">v{{ Illuminate\Foundation\Application::VERSION }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">PHP</span>
                                            <span class="fw-bold text-primary">v{{ PHP_VERSION }}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Bootstrap</span>
                                            <span class="fw-bold text-primary">v5.3.2</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Database</span>
                                            <span class="fw-bold text-primary">MySQL</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Laravel Resources Section -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-book text-primary fs-3 me-3"></i>
                                    <h5 class="card-title mb-0">
                                        <a href="https://laravel.com/docs" class="text-decoration-none">Documentation</a>
                                    </h5>
                                </div>
                                <p class="card-text text-muted">
                                    Laravel has wonderful, thorough documentation covering every aspect of the framework. 
                                    Whether you are new to the framework or have previous experience with Laravel, 
                                    we recommend reading all of the documentation from beginning to end.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-camera-video text-primary fs-3 me-3"></i>
                                    <h5 class="card-title mb-0">
                                        <a href="https://laracasts.com" class="text-decoration-none">Laracasts</a>
                                    </h5>
                                </div>
                                <p class="card-text text-muted">
                                    Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. 
                                    Check them out, see for yourself, and massively level up your development skills in the process.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white py-5">
            <div class="container">
                <div class="text-center">
                    <h5 class="mb-3">MediTrack SUSL</h5>
                    <p class="text-muted mb-4">
                        A comprehensive medical tracking system for modern healthcare management.
                    </p>
                    <div class="d-flex justify-content-center gap-4 mb-4">
                        <a href="https://laravel.com" class="text-muted text-decoration-none">Laravel Framework</a>
                        <a href="https://getbootstrap.com" class="text-muted text-decoration-none">Bootstrap</a>
                    </div>
                    <hr class="my-4">
                    <p class="text-muted mb-0">
                        &copy; {{ date('Y') }} MediTrack SUSL. All rights reserved. 
                        <small class="d-block mt-2">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small>
                    </p>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
