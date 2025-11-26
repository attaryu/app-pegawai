@extends('layouts.dashboard')
@section('title', 'Tambah Data Gaji')

@section('content')
    <x-card>
        <x-header title="Tambah Data Gaji" />

        <form action="{{ route('dashboard.admin.salaries.store') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <fieldset class="space-y-4">
                <div class="flex gap-4 w-full">
                    <x-select id="karyawan_id" name="karyawan_id" error="{{ $errors->first('karyawan_id') }}"
                        label="Karyawan" class="w-full">
                        <option value="" selected disabled>Pilih Karyawan</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                        @endforeach
                    </x-select>

                    <x-select id="bulan" name="bulan" error="{{ $errors->first('bulan') }}"
                        label="Bulan" :options="[
                            'Januari' => 'Januari', 'Februari' => 'Februari', 'Maret' => 'Maret',
                            'April' => 'April', 'Mei' => 'Mei', 'Juni' => 'Juni',
                            'Juli' => 'Juli', 'Agustus' => 'Agustus', 'September' => 'September',
                            'Oktober' => 'Oktober', 'November' => 'November', 'Desember' => 'Desember'
                        ]" class="w-full" />
                </div>

                <div class="flex gap-4 w-full">
                    <x-input id="gaji_pokok" name="gaji_pokok" error="{{ $errors->first('gaji_pokok') }}"
                        label="Gaji Pokok" placeholder="0" type="number" value="0" class="w-full" />

                    <x-input id="gaji_tunjangan" name="gaji_tunjangan" error="{{ $errors->first('gaji_tunjangan') }}"
                        label="Gaji Tunjangan" placeholder="0" type="number" value="0" class="w-full" />

                    <x-input id="potongan" name="potongan" error="{{ $errors->first('potongan') }}"
                        label="Potongan" placeholder="0" type="number" value="0" class="w-full" />
                </div>
            </fieldset>

            <div class="flex gap-4">
                <x-button type="reset" variant="secondary" class="ml-auto">Reset</x-button>
                <x-button type="submit">Simpan</x-button>
            </div>
        </form>
    </x-card>
@endsection

@push('scripts')
    <script>
        const employees = @json($employees);

        $('#karyawan_id').on('change', () => {
            const selectedId = $('#karyawan_id').val();
            const selectedEmployee = employees.find(emp => emp.id == selectedId);
            // make it number
            $('#gaji_pokok').val(selectedEmployee ? parseInt(selectedEmployee.position.gaji_pokok) : '');
        })
    </script>
@endpush
