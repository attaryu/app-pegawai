@extends('master')
@section('title', 'Tambah Data Gaji')

@section('content')
    <hgroup style="padding-top: 2rem">
        <h1>Tambah Data Gaji</h1>
    </hgroup>

    <form action="{{ route('salaries.store') }}" method="POST" style="margin-top: 2rem">
        @csrf

        <fieldset>
            <div class="grid">
                <label for="karyawan_id">
                    Karyawan
                    <select name="karyawan_id" id="karyawan_id">
                        <option value="" selected disabled>Pilih Karyawan</option>

                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </label>


                <label for="gaji_pokok">
                    Bulan
                    <select id="bulan" name="bulan">
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                    </select>
                </label>
            </div>

            <div class="grid">
                <label for="gaji_pokok">
                    Gaji Pokok
                    <input type="number" id="gaji_pokok" name="gaji_pokok" value="0" min="0">
                </label>

                <label for="gaji_tunjangan">
                    Gaji Tunjangan
                    <input type="number" id="gaji_tunjangan" name="gaji_tunjangan" value="0" min="0">
                </label>

                <label for="potongan">
                    Potongan
                    <input type="number" id="potongan" name="potongan" value="0" min="0">
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
