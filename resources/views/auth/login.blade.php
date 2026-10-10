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
                                <h5 class="card-title">Вход</h5>
                                {{--                                <p class="card-text mb-5">See your growth and get consulting support!</p>--}}
                                <form action="{{ auth()->check() ? route('admin.post_auth') : route('login') }}" class="form-body" method="POST">
                                    @csrf

                                    <div class="row g-3">
                                        @auth
                                            <div class="col-12">
                                                <label for="email" class="form-label">Код из почты (временно - <b>{{ $code }}</b>)</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="text" class="form-control radius-30 ps-5" placeholder="Код из почты" name="auth_code" value="{{ old('auth_code') }}" required autofocus>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12">
                                                <label for="email" class="form-label">Емейл</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="email" class="form-control radius-30 ps-5" placeholder="Емейл" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                                                    <label class="form-check-label" for="remember">Запомнить меня</label>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end">
                                                {{--                                            <a href="authentication-forgot-password.html">Forgot Password ?</a>--}}
                                            </div>
                                        @endauth

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary radius-30">Войти</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
