@extends('layouts.gallery')

@section('title', 'Профіль')

@section('content')
<div class="profile-page">
    <div class="profile-container">

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- Profile info --}}
        <section class="profile-section">
            <h2 class="profile-section__title">Особисті дані</h2>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Ім'я</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-input @error('name') is-invalid @enderror"
                           required maxlength="255">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-input @error('email') is-invalid @enderror"
                           required maxlength="255">
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Зберегти зміни</button>
            </form>
        </section>

        {{-- Change password --}}
        <section class="profile-section">
            <h2 class="profile-section__title">Змінити пароль</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Поточний пароль</label>
                    <input type="password" id="current_password" name="current_password"
                           class="form-input @error('current_password') is-invalid @enderror"
                           required autocomplete="current-password">
                    @error('current_password')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="new_password">Новий пароль</label>
                    <input type="password" id="new_password" name="new_password"
                           class="form-input @error('new_password') is-invalid @enderror"
                           required autocomplete="new-password" minlength="8">
                    @error('new_password')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">Підтвердити новий пароль</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                           class="form-input"
                           required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">Змінити пароль</button>
            </form>
        </section>

    </div>
</div>
@endsection
