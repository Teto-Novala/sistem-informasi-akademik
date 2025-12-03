<!DOCTYPE html>
<html>
<head>
    <title>Daftar Dosen</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Data Dosen</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIDN</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dosen as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nidn }}</td>
                <td>{{ $item->no_hp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>