@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 580px;
        margin: 40px auto;
        padding: 40px 36px;
        background: linear-gradient(135deg, rgba(30, 41, 59, 0.85) 0%, rgba(15, 23, 42, 0.90) 100%);
        border: 1px solid rgba(34, 197, 94, 0.25);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', system-ui, -apple-system, sans-serif;
    }

    .form-container::before {
        content: "";
        position: absolute;
        top: -40px;
        right: -40px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle at center, rgba(34, 197, 94, 0.15), transparent 60%);
        pointer-events: none;
        border-radius: 50%;
    }

    .form-container::after {
        content: "";
        position: absolute;
        bottom: -60px;
        left: -40px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle at center, rgba(59, 130, 246, 0.12), transparent 60%);
        pointer-events: none;
        border-radius: 50%;
    }

    .form-container h2 {
        color: #e2e8f0;
        margin-bottom: 28px;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.01em;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-container h2 i {
        color: #22c55e;
        font-size: 28px;
    }

    .form-container h2::after {
        content: "";
        display: block;
        width: 60px;
        height: 3px;
        border-radius: 999px;
        background: linear-gradient(90deg, #22c55e 0%, #06b6d4 100%);
        margin-top: 12px;
        margin-left: auto;
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        color: #cbd5e1;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid rgba(100, 116, 139, 0.4);
        border-radius: 12px;
        background: rgba(30, 41, 59, 0.6);
        color: #e2e8f0;
        font-size: 15px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: rgba(203, 213, 225, 0.5);
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #22c55e;
        background: rgba(30, 41, 59, 0.8);
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15), inset 0 1px 3px rgba(0, 0, 0, 0.2);
        transform: translateY(-1px);
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .image-preview {
        width: 100%;
        height: 160px;
        border-radius: 12px;
        background: rgba(15, 23, 42, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 2px dashed rgba(34, 197, 94, 0.3);
        margin-top: 10px;
        transition: all 0.3s ease;
    }

    .image-preview:hover {
        border-color: rgba(34, 197, 94, 0.5);
        background: rgba(15, 23, 42, 0.8);
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .image-preview i {
        color: rgba(203, 213, 225, 0.4);
        font-size: 48px;
    }

    .error-message {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.15) 0%, rgba(190, 24, 93, 0.1) 100%);
        border: 1.5px solid rgba(239, 68, 68, 0.3);
        color: #fca5a5;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
    }

    .error-message ul {
        margin: 0;
        padding-left: 20px;
    }

    .error-message li {
        margin: 6px 0;
        font-size: 14px;
        line-height: 1.5;
    }

    .error-feedback {
        color: #fca5a5;
        font-size: 13px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .error-feedback::before {
        content: "!";
        display: inline-flex;
        width: 18px;
        height: 18px;
        background: rgba(239, 68, 68, 0.2);
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
    }

    .form-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 32px;
        position: relative;
        z-index: 1;
    }

    .btn-submit,
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
        gap: 8px;
        text-decoration: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, #22c55e 0%, #06b6d4 100%);
        color: #ffffff;
        box-shadow: 0 8px 16px rgba(34, 197, 94, 0.25);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(34, 197, 94, 0.35);
        background: linear-gradient(135deg, #16a34a 0%, #0891b2 100%);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-cancel {
        background: rgba(100, 116, 139, 0.2);
        color: #cbd5e1;
        border: 1.5px solid rgba(100, 116, 139, 0.4);
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        background: rgba(100, 116, 139, 0.3);
        border-color: rgba(100, 116, 139, 0.6);
        color: #e2e8f0;
    }

    .btn-cancel:active {
        transform: translateY(0);
    }

    @media (max-width: 320px) {
        .form-container {
            margin: 24px 16px;
            padding: 28px 20px;
        }

        .form-container h2 {
            font-size: 24px;
        }

        .form-actions {
            grid-template-columns: 1fr;
        }

        .form-container h2::after {
            width: 50px;
        }
    }
</style>

<div class="form-container">
    <h2><i class="fas fa-plus-circle"></i>Tambah Alat Baru</h2>

    @if ($errors->any())
        <div class="error-message">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('alats.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="nama_alat">Nama Alat *</label>
            <input type="text" name="nama_alat" id="nama_alat" value="{{ old('nama_alat') }}" required>
            @error('nama_alat')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="kode_alat_text">Kode Alat *</label>
            <input type="text" name="kode_alat_text" id="kode_alat_text" value="{{ old('kode_alat_text') }}" required>
            @error('kode_alat_text')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="form-group">
            <label for="gambar">Pilih Gambar (opsional)</label>
            <input type="file" name="gambar" id="gambar" accept="image/*">
            <div class="image-preview" id="gambarPreview">
                <div class="text-slate-400"><i class="fas fa-image text-3xl"></i></div>
            </div>
            @error('gambar')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="kondisi">Kondisi *</label>
            <select name="kondisi" id="kondisi">
                <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="buruk" {{ old('kondisi') == 'buruk' ? 'selected' : '' }}>Buruk</option>
            </select>
            @error('kondisi')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="stok_baik">Stok Baik *</label>
            <input type="number" name="stok_baik" id="stok_baik" value="{{ old('stok_baik', 1) }}" min="0" required>
            @error('stok_baik')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="stok_rusak">Stok Rusak (opsional)</label>
            <input type="number" name="stok_rusak" id="stok_rusak" value="{{ old('stok_rusak', 0) }}" min="0">
            @error('stok_rusak')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Simpan Alat</button>
            <x-back-link fallback="{{ route('alats.index') }}" class="btn-cancel">Batal</x-back-link>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('gambar');
        const preview = document.getElementById('gambarPreview');

        if (!input) return;

        input.addEventListener('change', function (e) {
            const file = e.target.files && e.target.files[0];
            if (!file) {
                preview.innerHTML = '<div class="text-slate-400"><i class="fas fa-image text-3xl"></i></div>';
                return;
            }

            if (!file.type.startsWith('image/')) {
                preview.innerHTML = '<div class="text-red-600">File bukan gambar</div>';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                preview.innerHTML = '';
                const img = document.createElement('img');
                img.src = event.target.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

@endsection
