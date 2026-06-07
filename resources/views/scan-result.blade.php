<!-- resources/views/scan-result.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>QR Scan Result</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            background:#f4f6f9;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            padding:20px;
        }

        .result-box{
            width:420px;
            background:#fff;
            border-radius:20px;
            padding:30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
            text-align:center;
        }

        .success-icon,
        .invalid-icon{
            width:90px;
            height:90px;
            border-radius:50%;
            margin:auto;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
            font-size:45px;
            margin-bottom:20px;
        }

        .success-icon{
            background:#28c76f;
        }

        .invalid-icon{
            background:#ea5455;
        }

        h1{
            margin-bottom:10px;
            color:#333;
        }

        .status{
            display:inline-block;
            padding:8px 18px;
            border-radius:30px;
            color:white;
            font-size:14px;
            margin-bottom:20px;
            text-transform:uppercase;
            letter-spacing:1px;
        }

        .released{
            background:#28c76f;
        }

        .invalid{
            background:#ea5455;
        }

        .pending{
            background:#ff9f43;
        }

        .info{
            text-align:left;
            margin-top:20px;
        }

        .info p{
            margin-bottom:12px;
            color:#555;
            font-size:15px;
        }

        .info strong{
            color:#222;
        }

        .time{
            margin-top:20px;
            color:#999;
            font-size:13px;
        }

        .btn{
            margin-top:25px;
            display:inline-block;
            padding:12px 25px;
            background:#7367f0;
            color:white;
            text-decoration:none;
            border-radius:10px;
            transition:0.3s;
        }

        .btn:hover{
            background:#5e50ee;
        }

        @media(max-width:500px){
            .result-box{
                width:100%;
            }
        }
    </style>
</head>
<body>

<div class="result-box">

    @if($valid)

        <!-- VALID QR -->

        <div class="success-icon">
            ✔
        </div>

        <h1>QR Verified</h1>

        <div class="status released">
            {{ strtoupper($borrow->status) }}
        </div>

        <div class="info">
            <p>
                <strong>Reference:</strong>
                {{ $borrow->reference }}
            </p>

            <p>
                <strong>Borrower:</strong>
                {{ $borrow->user->name }}
            </p>

            <p>
                <strong>Department:</strong>
                {{ $borrow->department }}
            </p>

            <p>
                <strong>Item:</strong>
                {{ $borrow->item->name }}
            </p>

            <p>
                <strong>Quantity:</strong>
                {{ $borrow->quantity }}
            </p>

            <p>
                <strong>Approved By:</strong>
                {{ $borrow->approved_by ?? 'Admin' }}
            </p>
        </div>

        <div class="time">
            Scanned on {{ now()->format('F d, Y • h:i A') }}
        </div>

    @else

        <!-- INVALID QR -->

        <div class="invalid-icon">
            ✖
        </div>

        <h1>Invalid QR Code</h1>

        <div class="status invalid">
            ACCESS DENIED
        </div>

        <div class="info">
            <p>
                This QR code is invalid, expired,
                or already scanned.
            </p>
        </div>

    @endif

    <a href="/dashboard" class="btn">
        Done
    </a>

</div>

</body>
</html>