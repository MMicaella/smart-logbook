<!DOCTYPE html>
<html>
<head>
    <title>QR Scanner</title>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            font-family: Arial;
            background: #0f172a;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: #1e293b;
            padding: 20px;
            border-radius: 12px;
        }

        #reader {
            width: 100%;
        }

        .result {
            margin-top: 20px;
            text-align: left;
        }

        .card {
            background: #334155;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .row {
            margin: 6px 0;
            font-size: 14px;
        }

        .label {
            font-weight: bold;
            color: #93c5fd;
        }

        .valid {
            color: #22c55e;
            font-weight: bold;
        }

        .invalid {
            color: #ef4444;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>📷 QR Scanner</h2>

    <div id="reader"></div>

    <div class="result" id="result">
        Scan a QR code...
    </div>

</div>

<script>
function onScanSuccess(decodedText) {

    try {
        let data = JSON.parse(decodedText);

        document.getElementById('result').innerHTML = `
            <div class="card">

                <p class="valid">✔ QR SCANNED SUCCESSFULLY</p>

                <div class="row"><span class="label">Reference:</span> ${data.reference}</div>
                <div class="row"><span class="label">Borrow ID:</span> ${data.borrow_id}</div>
                <div class="row"><span class="label">Borrower:</span> ${data.borrower}</div>
                <div class="row"><span class="label">Employee ID:</span> ${data.employee_id ?? 'N/A'}</div>
                <div class="row"><span class="label">Department:</span> ${data.department}</div>
                <div class="row"><span class="label">Item:</span> ${data.item}</div>
                <div class="row"><span class="label">Quantity:</span> ${data.qty}</div>
                <div class="row"><span class="label">Status:</span> ${data.status.toUpperCase()}</div>
                <div class="row"><span class="label">Date:</span> ${data.date}</div>

            </div>
        `;

    } catch (e) {
        document.getElementById('result').innerHTML = `
            <p class="invalid">❌ Invalid QR Code</p>
        `;
    }
}

let scanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
});

scanner.render(onScanSuccess);
</script>

</body>
</html>