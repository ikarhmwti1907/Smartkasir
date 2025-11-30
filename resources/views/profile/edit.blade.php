@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 text-center">
            <img id="preview-avatar"
                src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : '' }}"
                class="rounded-circle img-fluid profile-avatar mb-2"
                style="{{ auth()->user()->avatar ? '' : 'display:none;' }}">
            <i id="default-avatar" class="bi bi-person-circle"
                style="font-size:120px; {{ auth()->user()->avatar ? 'display:none;' : '' }}"></i>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}"
                required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Username</label>
            <input type="text" name="username" class="form-control"
                value="{{ old('username', auth()->user()->username) }}" required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}"
                required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Avatar</label>
            <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> Simpan Perubahan
        </button>
        <a href="{{ route('profile.index') }}" class="btn btn-secondary">Batal</a>
    </form>
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const preview = document.getElementById('preview-avatar');
    const defaultIcon = document.getElementById('default-avatar');

    // Tampilkan avatar saat halaman load jika ada file
    if (preview.src && preview.src !== window.location.href) {
        preview.style.display = 'block';
        defaultIcon.style.display = 'none';
    }

    // Update preview saat user pilih file baru
    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                defaultIcon.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = preview.src ? 'block' : 'none';
            defaultIcon.style.display = preview.src ? 'none' : 'block';
        }
    });
});
</script>
@endsection