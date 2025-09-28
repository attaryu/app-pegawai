<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.amber.min.css">
    <title>Daftar Pegawai</title>
</head>

<body>
    <main class="container">
        <hgroup style="padding-top: 2rem">
            <h1>Pegawai</h1>
            <p>TEKIK INFORMATIKA - PENS 28</p>
        </hgroup>

        <table style="margin-top: 2rem" class="striped overflow-auto">
            <tbody>
                <tr>
                    <th scope="row">Nama Lengkap</th>
                    <td>{{ $employee->nama_lengkap }}</td>
                </tr>

                <tr>
                    <th scope="row">Email</th>
                    <td>{{ $employee->email }}</td>
                </tr>

                <tr>
                    <th scope="row">Nomor Telepon</th>
                    <td>{{ $employee->nomor_telepon }}</td>
                </tr>

                <tr>
                    <th scope="row">Tanggal Lahir</th>
                    <td>{{ $employee->tanggal_lahir }}</td>
                </tr>

                <tr>
                    <th scope="row">Alamat</th>
                    <td>{{ $employee->alamat }}</td>
                </tr>

                <tr>
                    <th scope="row">Tanggal Masuk</th>
                    <td>{{ $employee->tanggal_masuk }}</td>
                </tr>

                <tr>
                    <th scope="row">Status</th>
                    <td>{{ $employee->status }}</td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
