@extends('master')
@section('title', 'Edit Data Pegawai')

@section('content')
    <x-header title="Edit Data Pegawai" />

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" style="margin-top: 2rem">
        @csrf
        @method('PUT')

        <fieldset>
            <label for="nama_lengkap">
                Nama Lengkap
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $employee->nama_lengkap }}">
            </label>

            <div class="grid">
                <label for="email">
                    Email
                    <input type="email" id="email" name="email" value="{{ $employee->email }}">
                </label>

                <label for="nomor_telepon">
                    Nomor Telepon
                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $employee->nomor_telepon }}">
                </label>

                <label for="tanggal_lahir">
                    Tanggal Lahir
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ $employee->tanggal_lahir }}">
                </label>
            </div>

            <label for="alamat">
                Alamat
                <textarea id="alamat" name="alamat">{{ $employee->alamat }}</textarea>
            </label>

            <div class="grid">
                <label for="tanggal_masuk">
                    Tanggal Masuk
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ $employee->tanggal_masuk }}">
                </label>

                <label for="status">
                    Status
                    <select id="status" name="status">
                        <option value="aktif" {{ old('status', $employee->status) == 'aktif' ? 'selected' : '' }}>
                            Aktif</option>
                        <option value="nonaktif" {{ old('status', $employee->status) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </label>


                <label for="departemen_id">
                    Departemen
                    <select id="departemen_id" name="departemen_id">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('departemen_id', $employee->departemen_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->nama_departemen }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label for="jabatan_id">
                    Jabatan
                    <select id="jabatan_id" name="jabatan_id">
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}" {{ old('jabatan_id', $employee->jabatan_id) == $position->id ? 'selected' : '' }}>
                                {{ $position->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </label>
            </div>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
@endsection