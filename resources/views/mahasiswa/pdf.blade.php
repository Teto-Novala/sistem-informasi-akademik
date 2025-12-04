<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Data Mahasiswa</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Jurusan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->jurusan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>