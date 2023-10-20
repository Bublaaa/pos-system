<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container pt-5">
        <div class="row mx-auto text-center">
            <div class="col-12">
                <h1>Kwitansi</h1>
                <p>No. {{$salary->created_at->format('d/m/y')}}/{{$salary->id}}</p>
            </div>

        </div>
        <div class="row">
            <div class="col-3">
                <p>Diterima dari : </p>
                <p>Uang sebesar :</p>
                <p>Untuk pembayaran :</p>
                <p>Total Salary: {{ $salary->salary }}</p>
            </div>
            <div class="col-9">
                <p>Name: {{ $salary->name }}</p>
                <p>Basic Salary: {{ $salary->basic_salary }}</p>
                <p>Attendance Percentage: {{ ($salary->attendance_precentage) }}%</p>
                <p>Total Salary: {{ $salary->salary }}</p>
            </div>
        </div>
    </div>

</body>
<script>
function spellNumber(number) {
    const words = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan'];
    const unit = ['', 'Ribu', 'Juta', 'Miliar', 'Triliun']; // Adjust this array based on your needs

    let result = '';

    const numberStr = String(number);
    const length = numberStr.length;
    const chunkCount = Math.ceil(length / 3);

    for (let i = 0; i < chunkCount; i++) {
        const chunk = parseInt(numberStr.slice(-3 * (i + 1), length - 3 * i));

        if (chunk > 0) {
            let chunkResult = '';
            const chunkDigits = Array.from(String(chunk)).reverse();

            chunkDigits.forEach((digit, j) => {
                if (digit > 0) {
                    if (j === 0) {
                        chunkResult = words[digit] + ' Ratus ' + chunkResult;
                    } else {
                        chunkResult = words[digit] + ' ' + (j === 1 ? 'Puluh' : '') + ' ' + chunkResult;
                    }
                }
            });

            result = chunkResult + ' ' + unit[i] + ' ' + result;
        }
    }

    return result.trim();
}

const amount = 260000;
const amountInWords = spellNumber(amount);
console.log(amountInWords); // Outputs: Dua Ratus Enam Puluh Ribu Rupiah
</script>

</html>