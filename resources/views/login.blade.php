@extends('layouts.guest', ['title' => 'Login'])

@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100 position-relative">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    @if ($errors->has('username'))
                        <div class="position-absolute alert-login">
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('username') }}
                            </div>
                        </div>
                    @endif

                    <div class="card bg-blue-light text-dark" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="mb-md-5 mt-md-4 pb-1">
                                    <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                    <p class="text-dark mb-5">Please enter your login and password!</p>

                                    <div class="mb-4 mx-4">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" id="username" name="username"
                                            class="form-control form-control-lg" />
                                    </div>

                                    <button class="btn btn-primary btn-lg px-5" type="submit">Login</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
