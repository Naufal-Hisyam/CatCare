@extends('layouts.app')

@section('title', 'Edit Data Kucing | CatCare')

@section('content')
<div class="page-content">
    <div class="activity-section" style="max-width: 800px; margin: 0 auto;">
        <div class="activity-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2>Edit Data Kucing</h2>
                <p>Perbarui informasi data kucing</p>
            </div>
            <div>
                <a href="{{ route('cats.index') }}" class="btn" style="background-color: #8195a2; width: auto; padding: 8px 16px; margin-top: 0; text-decoration: none;">Kembali</a>
            </div>
        </div>

        <div style="padding: 24px;">
            @if ($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <strong>Terjadi Kesalahan!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cats.update', $cat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="profile-form-group" style="margin-bottom: 15px;">
                    <label for="name">Nama Kucing <span>*</span></label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $cat->name) }}" placeholder="Masukkan nama kucing" required>
                </div>

                <div class="profile-form-group" style="margin-bottom: 15px;">
                    <label for="breed">Ras Kucing</label>
                    <input type="text" id="breed" name="breed" class="form-control" value="{{ old('breed', $cat->breed) }}" placeholder="Contoh: Persia, Anggora, Domestic">
                </div>

                <div class="profile-form-group" style="margin-bottom: 15px;">
                    <label for="age">Umur (Bulan)</label>
                    <input type="number" id="age" name="age" class="form-control" value="{{ old('age', $cat->age) }}" placeholder="Contoh: 12">
                </div>

                <div class="profile-form-group" style="margin-bottom: 15px;">
                    <label for="gender">Gender <span>*</span></label>
                    <select id="gender" name="gender" class="form-control" required style="background: #fbfdff;">
                        <option value="">-- Pilih Gender --</option>
                        <option value="jantan" {{ old('gender', $cat->gender) == 'jantan' ? 'selected' : '' }}>Jantan</option>
                        <option value="betina" {{ old('gender', $cat->gender) == 'betina' ? 'selected' : '' }}>Betina</option>
                    </select>
                </div>

                <div class="profile-form-actions" style="margin-top: 20px;">
                    <button type="submit" class="profile-save-button">Perbarui Data Kucing</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection