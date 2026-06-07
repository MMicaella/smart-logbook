<!DOCTYPE html>
<html>
<head>
    <title>Send OTP</title>

    <style>
        body{
            margin:0;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#f4f6f9;
            font-family:Arial;
        }

        .card{
            background:white;
            width:360px;
            padding:30px;
            border-radius:15px;
            box-shadow:0 10px 25px rgba(0,0,0,0.1);
            text-align:center;
        }

        input{
            width:100%;
            padding:12px;
            margin-top:15px;
            border:1px solid #ddd;
            border-radius:10px;
        }

        button{
            width:100%;
            margin-top:15px;
            padding:12px;
            border:none;
            border-radius:10px;
            background:#2563eb;
            color:white;
            cursor:pointer;
        }

        button:hover{
            background:#1d4ed8;
        }
    </style>
</head>
<body>

<div class="card">

    <h2>Verify Your Email</h2>
    <p>Enter your email to receive OTP</p>

    <form method="POST" action="/otp/send">
        @csrf

        <input type="email"
               name="email"
               placeholder="Enter your email"
               required>

        <button type="submit">
            Send OTP
        </button>
    </form>

</div>

</body>
</html>