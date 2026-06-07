<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gate Pass QR</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 30px;

            font-family: 'Segoe UI', sans-serif;

            background:
                linear-gradient(rgba(30,0,0,0.88), rgba(0,0,0,0.92)),
                url('/images/osmena-logo.png');

            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
        }

        .glass-card {
            position: relative;

            width: 100%;
            max-width: 700px;

            background: rgba(255,255,255,0.08);

            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border: 1px solid rgba(255,255,255,0.12);

            border-radius: 24px;

            padding: 35px;

            box-shadow: 0 10px 40px rgba(0,0,0,0.35);
        }

        .glass-card:hover {
            transform: translateY(-3px);
            transition: .3s;
        }

        .close-btn {
            position: absolute;

            top: 18px;
            right: 18px;

            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            text-decoration: none;

            border-radius: 50%;

            background: rgba(255,255,255,0.1);

            color: white;
            font-size: 22px;
            font-weight: bold;

            transition: .3s;
        }

        .close-btn:hover {
            background: rgba(255,255,255,0.2);
        }

        .title {
            text-align: center;
            color: white;
            font-size: 32px;
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            margin-top: 8px;

            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }

        .divider {
            margin: 25px 0;
            border-top: 1px solid rgba(255,255,255,0.12);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-box {
            background: rgba(255,255,255,0.05);

            border: 1px solid rgba(255,255,255,0.08);

            border-radius: 15px;

            padding: 15px;
        }

        .label {
            color: rgba(255,255,255,0.6);
            font-size: 12px;
            margin-bottom: 5px;
        }

        .value {
            color: white;
            font-size: 15px;
            font-weight: 600;
        }

        .badge {
            display: inline-block;

            padding: 6px 12px;

            border-radius: 999px;

            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: rgba(250,204,21,.2);
            color: #fde047;
        }

        .approved,
        .released {
            background: rgba(34,197,94,.2);
            color: #4ade80;
        }

        .returned {
            background: rgba(168,85,247,.2);
            color: #c084fc;
        }

        .rejected {
            background: rgba(239,68,68,.2);
            color: #f87171;
        }

        .expired {
            margin-top: 20px;

            text-align: center;

            color: #f87171;

            font-weight: bold;
            font-size: 15px;
        }

        .valid {
            margin-top: 20px;

            text-align: center;

            color: #4ade80;

            font-weight: bold;
            font-size: 15px;
        }

        .qr-section {
            margin-top: 25px;
            text-align: center;
        }

        .qr-box {
            display: inline-block;

            padding: 20px;

            background: white;

            border-radius: 20px;
        }

        .qr-label {
            color: rgba(255,255,255,0.7);

            margin-bottom: 15px;

            font-size: 13px;
        }

        @media(max-width:768px) {

            .info-grid {
                grid-template-columns: 1fr;
            }

            .glass-card {
                padding: 25px;
            }

            .title {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

    <div class="glass-card">

        <a href="{{ url()->previous() }}" class="close-btn">
            ×
        </a>

        <h1 class="title">
            Gate Pass QR
        </h1>

        <p class="subtitle">
            Reference #: {{ $borrow->reference_number }}
        </p>

        <div class="divider"></div>

        <div class="info-grid">

            {{-- <div class="info-box">
                <div class="label">Employee ID</div>
                <div class="value">
                    {{ $borrower->employee_id ?? 'N/A' }}
                </div>
            </div> --}}

            <div class="info-box">
                <div class="label">Borrower</div>
                <div class="value">
                    {{ $borrower->department ?? 'N/A' }}
                </div>
            </div>

            {{-- <div class="info-box">
                <div class="label">Department</div>
                <div class="value">
                    {{ $borrower->department ?? 'N/A' }}
                </div>
            </div> --}}

            <div class="info-box">
                <div class="label">Item</div>
                <div class="value">
                    {{ optional($borrow->item)->item_name }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Quantity</div>
                <div class="value">
                    {{ $borrow->quantity }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Status</div>

                <div class="value">

                    <span class="badge
                        @if($borrow->status == 'pending') pending
                        @elseif($borrow->status == 'approved') approved
                        @elseif($borrow->status == 'released') released
                        @elseif($borrow->status == 'returned') returned
                        @elseif($borrow->status == 'rejected') rejected
                        @endif">

                        {{ strtoupper($borrow->status) }}

                    </span>

                </div>
            </div>

            <div class="info-box">
                <div class="label">Borrowed At</div>

                <div class="value">
                    {{ optional($borrow->created_at)->format('M d, Y h:i A') }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Approved At</div>

                <div class="value">
                    {{ optional($borrow->approved_at)->format('M d, Y h:i A') ?? 'Not Approved' }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Expires At</div>

                <div class="value">
                    {{ optional($borrow->expires_at)->format('M d, Y h:i A') ?? 'Not Set' }}
                </div>
            </div>

        </div>

        @if($borrow->is_expired)

            <div class="expired">
                ⚠ THIS GATE PASS IS EXPIRED
            </div>

        @else

            <div class="valid">
                ✔ VALID GATE PASS
            </div>

        @endif

        <div class="divider"></div>

        @php
            $scanUrl = url('/scan/' . $borrow->reference_number);
        @endphp

        <div class="qr-section">

            <div class="qr-label">
                Scan this QR code at the Gate
            </div>

            <div class="qr-box">
                {!! QrCode::size(280)->generate($scanUrl) !!}
            </div>

        </div>

    </div>

</body>

</html>