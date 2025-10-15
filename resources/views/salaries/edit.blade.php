@extends('master')
@section('title', 'Edit Data Gaji')

@section('content')
    <x-header title="Edit Data Gaji" />

    <form action="{{ route('salaries.update', $salary->id) }}" method="POST" style="margin-top: 2rem">
        @csrf
        @method('PUT')

        <fieldset>
            <div class="grid">
                <label for="karyawan_id">
                    Karyawan
                    <select name="karyawan_id" id="karyawan_id">
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(old('karyawan_id', $employee->id) === $salary->karyawan_id)>
                                {{ $employee->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                </label>


                <label for="gaji_pokok">
                    Bulan
                    <select id="bulan" name="bulan">
                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                            <option value="{{ $month }}" @selected(old('bulan', $salary->bulan) === $month)>{{ $month }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="grid">
                <label for="gaji_pokok">
                    Gaji Pokok
                    <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $salary->gaji_pokok) }}" min="0">
                </label>

                <label for="gaji_tunjangan">
                    Gaji Tunjangan
                    <input type="number" id="gaji_tunjangan" name="gaji_tunjangan" value="{{ old('gaji_tunjangan', $salary->gaji_tunjangan) }}" min="0">
                </label>

                <label for="potongan">
                    Potongan
                    <input type="number" id="potongan" name="potongan" value="{{ old('potongan', $salary->potongan) }}" min="0">
                </label>
            </div>
        </fieldset>

        <button type="submit">Simpan</button>
    </form>
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