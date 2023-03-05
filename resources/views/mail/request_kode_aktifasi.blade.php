<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mail Notifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="card">
    <div class="card-header">
        <h3>Halo, {{ $data_email['content']['nama']['nama_depan'] }}</h3>

    </div>
    <div class="card-body">
        <p>Berikut kami kirimkan kode aktifasi akun anda :</p>
        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $data_email['content']['nama']['nama_depan'] }}</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>:</td>
                <td>{{ $data_email['content']['gender'] }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $data_email['content']['nik'] }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $data_email['content']['kontak']['email'] }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>:</td>
                <td>{{ $data_email['content']['kontak']['nomor_telepon'] }}</td>
            </tr>
            <tr>
                <td>Kode Aktifasi</td>
                <td>:</td>
                <td><b>{{ $data_email['content']['aktifasi']['otp'] }}</b></td>
            </tr>
            <tr>
                <td>Kadaluarsa Kode</td>
                <td>:</td>
                <td>
                    {{ date('Y-m-d H:i:s', $data_email['content']['aktifasi']['exp']) }}
                </td>
            </tr>
        </table>

        <p>Salam</p>
        <p>Tele Sehat Indonesia</p>
        <h2 style="padding: 23px;background: #b3deb8a1;border-bottom: 6px green solid;">
        </h2>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
