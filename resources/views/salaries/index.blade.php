@php
    $format = fn (float $value) => 'Rp ' . number_format($value, 0, ',', '.');
@endphp

@extends('master')
@section('title', 'Daftar Gaji')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <hgroup style="padding-top: 2rem">
            <h1>Daftar Gaji</h1>
        </hgroup>

        <a href="{{ route('salaries.create') }}" role="button">Tambah</a>
    </div>
    
    <table style="margin-top: 2rem" class="striped">
        <thead>
            <tr>
                <th scope="col">Nama Karyawan</th>
                <th scope="col">Bulan</th>
                <th scope="col">Pokok</th>
                <th scope="col">Tunjangan</th>
                <th scope="col">Potongan</th>
                <th scope="col">Total</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($salaries as $salary)
                <tr>
                    <th scope="row">{{ $salary->employee->nama_lengkap }}</th>
                    <td>{{ $salary->bulan }}</td>
                    <td>{{ $format($salary->gaji_pokok) }}</td>
                    <td>{{ $format($salary->gaji_tunjangan) }}</td>
                    <td>{{ $format($salary->potongan) }}</td>
                    <td>{{ $format($salary->total_gaji) }}</td>

                    <x-action route-name="salaries" :id="$salary->id">
                        <x-action.update />
                        <x-action.delete />
                    </x-action>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
