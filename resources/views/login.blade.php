@extends('layout.app')
@section('main')
    <div class="main">
        <section class="content-info">
            <div class="container paddings-mini">

                <div class="row text-center text-lg-left">

                    <div class="col-lg-6">
                        <div class="col-lg-12">
                            <form method="post">
                                @csrf

                                <label>Username</label>
                                <input type="text" class="@error('username') is-invalid @enderror form-control" name="username">

                                <label>Password</label>
                                <input name="password" class="@error('password') is-invalid @enderror form-control" type="password">

                                <label>Confirm Password</label>
                                <input name="password_confirmation" class="@error('password') is-invalid @enderror form-control" type="password">


                                @if($errors->all())
                                    <br>
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $message)
                                            - {{ $message }} <br>
                                        @endforeach
                                    </div>
                                @endif

                                <br>

                                <input type="submit" value="Login">
                            </form>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <br>
                            <span>
                                We won't save your password in our database. We will just perform a remote auth check and then forget it.
                                Sometimes you will need to refresh your login to keep you synced with the app.
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('styles')

@endpush
