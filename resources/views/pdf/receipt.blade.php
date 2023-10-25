<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kwitansi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .table-no-padding td {
        padding: 0;
    }

    body {
        margin: 0;
        padding: 0;
    }
    </style>
</head>

<body>
    <table class="table-no-padding">
        <tr>
            <td colspan="2" class="text-center">
                <h5>Kwitansi</h5>
                <p>No. {{ $salary->created_at->format('d/m/y') }}/{{ $salary->id }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Diterima dari :</p>
                <p>Uang sebesar :</p>
                <p>Untuk pembayaran :</p>
            </td>
            <td>
                <p>{{ $user->name }}</p>
                <p>{{ $amountInWords }}</p>
                <p>Gaji</p>
            </td>
        </tr>
        <tr>
            <td>
                <h6>Rp. {{ number_format($salary->salary, 2, ',', '.') }}</h6>
            </td>
            <td>
                <p>Tanggal: {{ $salary->created_at->format('d M Y') }}</p>
                <br>
                <p>{{ $salary->name }}</p>
            </td>
        </tr>
    </table>


</body>

</html>