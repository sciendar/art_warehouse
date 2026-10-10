@extends('admin._layouts._layout')

@section('content')
    <main class="authentication-content">
        <div class="container-fluid">
            <div class="authentication-card">
                <div class="card shadow rounded-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                            <img src="{{ asset('admin/assets/images/error/login-img.jpg') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body p-4 p-sm-5">
                                <h5 class="card-title">Вхід</h5>
                                {{--                                <p class="card-text mb-5">See your growth and get consulting support!</p>--}}
                                @auth
                                    <form action="{{ route('admin.post_auth') }}" class="form-body" method="POST">
                                        @csrf

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="email" class="form-label">Код з пошти (тимчасово - <b>{{ $code }}</b>)</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="text" class="form-control radius-30 ps-5" placeholder="Код з пошти" name="auth_code" value="{{ old('auth_code') }}" required autofocus>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary radius-30">Увійти</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('login') }}" class="form-body" method="POST">
                                        @csrf

                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="email" class="form-label">Електронна пошта</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="email" class="form-control radius-30 ps-5" placeholder="Електронна пошта" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Пароль</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                                                    <input type="password" class="form-control radius-30 ps-5" id="password" placeholder="Пароль" name="password" required autocomplete="current-password">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">Запам'ятай мене</label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                {{--                                            <a href="authentication-forgot-password.html">Forgot Password ?</a>--}}
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary radius-30">Увійти</button>
                                                </div>
                                            </div>
                                            {{--                                        <div class="col-12">--}}
                                            {{--                                            <p class="mb-0">Don't have an account yet? <a href="authentication-signup.html">Sign up here</a></p>--}}
                                            {{--                                        </div>--}}
                                        </div>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
