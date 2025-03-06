<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis - {{ $medicalRecord->patient->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 10px;
        }
        .info label {
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">Rekam Medis Pasien</div>

    <div class="info">
        <label>Nama Pasien:</label> {{ $medicalRecord->patient->name }} <br>
        <label>Tanggal Periksa:</label> {{ $medicalRecord->tgl_periksa }} <br>
    </div>

    <table class="table">
        <tr>
            <th>Diagnosis</th>
            <td>{{ $medicalRecord->diagnosis }}</td>
        </tr>
        <tr>
            <th>Resep</th>
            <td>{{ $medicalRecord->resep }}</td>
        </tr>
        <tr>
            <th>Catatan Medis</th>
            <td>{{ $medicalRecord->catatan_medis }}</td>
        </tr>
    </table>

    <br><br>
    <p><i>Dokumen ini dihasilkan secara otomatis oleh sistem.</i></p>
</body>
</html>
