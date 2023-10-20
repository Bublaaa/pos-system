<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=14cm,">
    <title>Kwitansi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row mx-auto text-center">
            <div class="col-12">
                <h5>Kwitansi</h5>
                <p>No. {{$salary->created_at->format('d/m/y')}}/{{$salary->id}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <p>Diterima dari : </p>
                <p>Uang sebesar :</p>
                <p>Untuk pembayaran :</p>
            </div>
            <div class="col-9">
                <p>{{ $user->name }}</p>
                <p id="salary"></p>
                <p>Gaji</p>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h6>Rp. {{ number_format($salary->salary, 2, ',', '.') }}</h6>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4">
                <p>Tanggal: {{ $salary->created_at->format('d M Y') }}</p>
                <br><br><br>
                <p>{{ ($salary->name) }}</p>
            </div>
        </div>
    </div>

</body>
<script>
function capitalizeWords(str) {
    return str.replace(/\b\w/g, function(match) {
        return match.toUpperCase();
    });
}

function convert(number) {
    number = number.toString().replace('.', '');

    if (!/^\d+$/.test(number)) {
        throw new Error('Not a valid number');
    }

    const base = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
    const numeric = [1000000000000000, 1000000000000, 1000000000000, 1000000000, 1000000, 1000, 100, 10, 1];
    const unit = ['kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', ''];
    let result = '';

    if (number == 0) {
        result = 'nol';
    } else {
        for (let i = 0; i < numeric.length; i++) {
            const count = Math.floor(number / numeric[i]);

            if (count >= 10) {
                result += this.convert(count) + ' ' + unit[i] + ' ';
            } else if (count > 0 && count < 10) {
                result += base[count] + ' ' + unit[i] + ' ';
            }

            number -= numeric[i] * count;
        }

        result = result.replace(/satu puluh (\w+)/i, '$1 belas');
        result = result.replace(/satu (ribu|ratus|puluh|belas)/, 'se$1');
        result = result.replace(/\s{2,}/, ' ').trim();
    }

    return result;
}
const number = ('{{ $salary->salary }}');
const amountInWords = capitalizeWords(convert(number) + " Rupiah");
salary.textContent = amountInWords;
</script>

</html>