@extends('layouts.app')

@section('title', 'Login - Admin')

@section('content')
    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <img src="{{ asset('img/logoloja.jpeg') }}" alt="Logo" class="login-logo">
                <h1 class="login-title">Login Administrador Ws</h1>
                <p class="login-subtitle">Acesse para gerenciar os veículos do catálogo.</p>
            </div>

            @if($errors->any())
                <div class="login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="login-form">
                @csrf

                <div class="login-field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="login-field">
                    <label>Senha</label>
                    <input type="password" name="password" required>
                </div>

                <label class="login-remember">
                    <input type="checkbox" name="remember">
                    <span>Lembrar</span>
                </label>

                <button type="submit" class="btn-login">
                    Entrar
                </button>
            </form>

        </div>
    </div>
@endsection
