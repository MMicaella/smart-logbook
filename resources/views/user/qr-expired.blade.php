<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QR Expired</title>

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
            width: 100%;
            max-width: 550px;

            background: rgba(255,255,255,0.08);

            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);

            border: 1px solid rgba(255,255,255,0.12);

            border-radius: 24px;

            padding: 40px;

            text-align: center;

            box-shadow: 0 10px 40px rgba(0,0,0,0.35);

            transition: .3s ease;
        }

        .glass-card:hover {
            transform: translateY(-3px);
        }

        .icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .title {
            color: #f87171;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .subtitle {
            color: rgba(255,255,255,0.75);
            font-size: 15px;
            line-height: 1.7;
        }

        .divider {
            margin: 25px 0;
            border-top: 1px solid rgba(255,255,255,0.12);
        }

        .reference-box {
            background: rgba(255,255,255,0.05);

            border: 1px solid rgba(255,255,255,0.08);

            border-radius: 16px;

            padding: 18px;
        }

        .label {
            color: rgba(255,255,255,0.6);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .reference {
            color: white;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .status-badge {
            display: inline-block;

            margin-top: 25px;

            padding: 10px 18px;

            border-radius: 999px;

            background: rgba(239,68,68,0.15);

            color: #f87171;

            border: 1px solid rgba(239,68,68,0.25);

            font-size: 13px;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;

            color: rgba(255,255,255,0.55);

            font-size: 13px;
        }

        @media (max-width: 640px) {

            .glass-card {
                padding: 28px;
            }

            .title {
                font-size: 26px;
            }

            .icon {
                font-size: 65px;
            }
        }
    </style>
</head>

<body>

    <div class="glass-card">

        <div class="icon">
            ❌
        </div>

        <h1 class="title">
            QR EXPIRED
        </h1>

        <p class="subtitle">
            This Gate Pass has already expired and is no longer valid for campus exit verification.
        </p>

        <div class="status-badge">
            EXPIRED GATE PASS
        </div>

        <div class="divider"></div>

        <div class="reference-box">

            <div class="label">
                REFERENCE NUMBER
            </div>

            <div class="reference">
                {{ $borrow->reference_number }}
            </div>

        </div>

        <div class="footer">
            Please contact the Property Custodian or System Administrator for assistance.
        </div>

    </div>

</body>

</html>