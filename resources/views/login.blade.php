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

        <!-- Custom common CSS -->
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    </head>
    <body>
        <!-- make login page here -->
         <div class="container p-0 w-50 d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="d-flex w-100 rounded shadow-lg" style="height: 65vh;">
                
                <div class="w-50 d-flex justify-content-center align-items-center rounded-start"
                    style="background: linear-gradient(to right, var(--primary), var(--card-cyan));">
                <img src="{{ asset('images/MediTrack-Logo_white.png') }}" alt="Logo" class="img-fluid" style="max-height: 250px;">
                </div>
                
                <form class="w-50 px-5 d-flex flex-column justify-content-center gap-3 bg-white rounded-end">
                <div>
                    <h2 class="text-center fw-bold">Login</h2>
                    <p class="text-center fw-semibold text-dark">Access to our dashboard</p>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn mb-3" style="background-color: var(--card-cyan); color: var(--light);">Submit</button>
                <p class="text-center"><a href="#" class="text-decoration-none text-secondary">Forgot password?</a></p>
                </form>
                
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
