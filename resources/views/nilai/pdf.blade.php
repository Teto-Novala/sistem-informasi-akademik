<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mata Kuliah</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Data Nilai</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mahasiswa</th>
                <th>Dosen</th>
                <th>Mata Kuliah</th>
                <th>Mata Huruf</th>
                <th>Mata Angka</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilai as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->mahasiswa->nama ??'-' }}</td>
                <td>{{ $item->dosen->nama??'-' }}</td>
                <td>{{ $item->matakuliah->nama??'-' }}</td>
                <td>{{ $item->nilai_huruf}}</td>
                <td>{{ $item->nilai_angka}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>