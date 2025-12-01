@extends('layouts.dashboard')
@section('title', 'Add Employee')

@section('content')
    <x-card>
        <x-header title="Add Employee" />

        <form action="{{ route('dashboard.admin.employees.store') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <fieldset class="space-y-4">
                <x-input id="nama_lengkap" name="nama_lengkap" error="{{ $errors->first('nama_lengkap') }}" label="Full Name"
                    placeholder="Enter full name" />

                <div class="flex gap-4 w-full">
                    <x-input id="email" name="email" error="{{ $errors->first('email') }}" label="Email"
                        placeholder="Enter email address" class="w-full" />

                    <x-input id="nomor_telepon" name="nomor_telepon" error="{{ $errors->first('nomor_telepon') }}"
                        label="Phone Number" placeholder="Enter phone number" class="w-full" />

                    <x-input id="tanggal_lahir" name="tanggal_lahir" error="{{ $errors->first('tanggal_lahir') }}"
                        label="Born Date" type="date" class="w-full" />
                </div>

                <x-input id="alamat" name="alamat" error="{{ $errors->first('alamat') }}" label="Address"
                    placeholder="Enter address" type="textarea" />

                <div class="flex gap-4 w-full">
                    <x-input id="tanggal_masuk" name="tanggal_masuk" error="{{ $errors->first('tanggal_masuk') }}"
                        label="Join Date" type="date" class="w-full" />

                    <x-select id="status" name="status" label="Status" :options="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']"
                        error="{{ $errors->first('status') }}" class="w-full" />

                    <x-select id="departemen_id" name="departemen_id" error="{{ $errors->first('departemen_id') }}"
                        label="Departemen" class="w-full">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->nama_departemen }}</option>
                        @endforeach
                    </x-select>

                    <x-select id="jabatan_id" name="jabatan_id" error="{{ $errors->first('jabatan_id') }}" label="Jabatan"
                        class="w-full">
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                        @endforeach
                    </x-select>
                </div>

                <x-input id="password" name="password" error="{{ $errors->first('password') }}" label="Account Password"
                    placeholder="Enter password" type="password" class="password-input hidden" />
            </fieldset>

            <div class="flex gap-4">
                <x-button type="reset" variant="secondary" class="ml-auto">Reset</x-button>
                <x-button type="submit">Add</x-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const status = document.getElementById('status');
            const passwordInput = document.querySelector('.password-input');

            status.addEventListener('change', () => {
                if (status.value === 'aktif') {
                    console.log('aktif');
                    passwordInput.classList.remove('hidden');
                } else {
                    console.log('nonaktif');
                    passwordInput.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
