<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>{{ config('app.name') }} - Login</title>
</head>
<body>


<div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('{{ asset('images/login-background.jpg') }}');" >
        <span class="login-image-copy">
            Image by
            <a href="https://pixabay.com/photos/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1246836">Free-Photos</a>
            from
            <a href="https://pixabay.com/?utm_source=link-attribution&amp;utm_medium=referral&amp;utm_campaign=image&amp;utm_content=1246836">Pixabay</a>
        </span>
    </div>
    <div class="contents order-2 order-md-1">

        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <h3>Login to <strong>{{ config('app.name') }}</strong></h3>
                    <p class="mb-4">
                        We won't save your password in our database. We will just perform a remote auth check and then forget it.
                        Sometimes you will need to refresh your login to keep you synced with the app.
                    </p>
                    <p class="mb-4">
                        If you don't know how to login, just ask the sites owner for more details.
                    </p>
                    <form method="post">
                        @csrf
                        <div class="form-group first">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Your Username" name="username" id="username">
                        </div>
                        <div class="form-group last mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Your Password" name="password" id="password">
                        </div>

                        {{--
                        <div class="d-flex mb-5 align-items-center">
                            <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                <input type="checkbox" checked="checked"/>
                                <div class="control__indicator"></div>
                            </label>
                            <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>
                        </div>
                        --}}

                        @if($errors->all())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $message)
                                    - {{ $message }} <br>
                                @endforeach
                            </div>
                        @endif

                        <input type="submit" value="Log In" class="btn btn-block btn-primary">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
