@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm p-4 d-flex flex-column align-items-center">

        {{-- Avatar --}}
        @if(auth()->user()->avatar && file_exists(storage_path('app/public/' . auth()->user()->avatar)))
        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle profile-avatar mb-3">
        @else
        <i class="bi bi-person-circle mb-3" style="font-size:150px; color:#6c757d;"></i>
        @endif

        {{-- Informasi User --}}
        <h4 class="fw-bold text-center">{{ auth()->user()->name }}</h4>
        <p class="mb-1 text-center"><strong>Username:</strong> {{ auth()->user()->username }}</p>
        <p class="mb-1 text-center"><strong>Email:</strong> {{ auth()->user()->email }}</p>

        {{-- Tombol --}}
        <div class="mt-3">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary me-2 btn-profile-edit">
                <i class="bi bi-pencil-square me-1"></i> Edit Profile
            </a>
            <a href="{{ route('profile.password') }}" class="btn btn-warning btn-profile-password">
                <i class="bi bi-key me-1"></i> Ubah Password
            </a>
        </div>

    </div>

</div>

<style>
.profile-avatar {
    width: 150px;
    height: 150px;
    object-fit: cover;
}

@media (max-width: 575px) {
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
}

/* Warna tombol dan hover */
.btn-profile-edit {
    background-color: #0d6efd;
    /* ganti warna primary */
    color: #fff;
    border: none;
    transition: background 0.3s ease;
}

.btn-profile-edit:hover {
    background-color: #0b5ed7;
    /* warna saat hover */
    color: #fff;
}

.btn-profile-password {
    background-color: #ffc107;
    /* ganti warna warning */
    color: #000;
    border: none;
    transition: background 0.3s ease;
}

.btn-profile-password:hover {
    background-color: #e0a800;
    /* warna saat hover */
    color: #000;
}
</style>
@endsection