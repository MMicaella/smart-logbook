<style>

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body{
        width: 100%;
        min-height: 100%;
    }

    body{
        font-family: 'Poppins', sans-serif;

        min-height: 100vh;

        background:
            linear-gradient(rgba(25,0,0,0.82), rgba(0,0,0,0.90)),
            url('{{ asset('images/logo-animation.mp4') }}');

        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;

        overflow-x: hidden;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 18px;
    }

    /* ===============================
       🔥 MAIN GLASS CONTAINER
    =============================== */

    .main-container{

        width: 100%;
        max-width: 1250px;

        display: grid;
        grid-template-columns: 1.1fr 0.9fr;

        overflow: hidden;

        border-radius: 32px;

        background: rgba(255,255,255,0.08);

        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);

        border: 1px solid rgba(255,255,255,0.12);

        box-shadow:
            0 10px 40px rgba(0,0,0,0.45),
            inset 0 1px 0 rgba(255,255,255,0.08);

        min-height: 640px;
    }

    /* ===============================
       🔥 LEFT SECTION
    =============================== */

    .left-section{
        padding: 55px 50px;
        position: relative;
        z-index: 2;

        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .badge{

        display: inline-flex;
        align-items: center;

        width: fit-content;

        padding: 10px 18px;

        border-radius: 999px;

        background: rgba(255,255,255,0.10);

        border: 1px solid rgba(255,255,255,0.12);

        color: rgba(255,255,255,0.80);

        font-size: 0.85rem;
        font-weight: 600;

        margin-bottom: 24px;

        backdrop-filter: blur(10px);
    }

    .title-wrapper{
        display: flex;
        align-items: flex-start;
        gap: 20px;

        margin-bottom: 22px;
    }

    .title-line{

        width: 8px;
        min-height: 145px;

        border-radius: 999px;

        background:
            linear-gradient(
                to bottom,
                #ff4f77,
                #d10039,
                #690014
            );

        box-shadow:
            0 0 25px rgba(255,79,119,0.55);
    }

    .system-title{

        font-size: 3.6rem;
        line-height: 1.03;
        font-weight: 800;

        color: white;

        letter-spacing: -2px;
    }

    .system-title span{
        color: #ff86a0;
    }

    .description{

        margin-top: 12px;

        font-size: 0.98rem;
        line-height: 1.85;

        color: rgba(255,255,255,0.72);

        max-width: 95%;

        text-align: justify;
    }

    /* ===============================
       🔥 BUTTONS
    =============================== */

    .button-group{

        display: flex;
        gap: 18px;

        margin-top: 34px;

        flex-wrap: wrap;
    }

    .btn{

        padding: 15px 28px;

        border-radius: 18px;

        text-decoration: none;

        font-size: 0.95rem;
        font-weight: 700;

        transition: 0.35s ease;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        min-width: 180px;
    }

    .btn-login{

        background:
            linear-gradient(
                135deg,
                rgba(255,255,255,0.18),
                rgba(255,255,255,0.08)
            );

        border: 1px solid rgba(255,255,255,0.18);

        color: white;

        backdrop-filter: blur(12px);

        box-shadow:
            0 10px 25px rgba(0,0,0,0.28);
    }

    .btn-login:hover{

        transform: translateY(-4px) scale(1.02);

        background:
            linear-gradient(
                135deg,
                rgba(255,255,255,0.28),
                rgba(255,255,255,0.12)
            );

        box-shadow:
            0 14px 28px rgba(0,0,0,0.35);
    }

    /* ===============================
       🔥 RIGHT SECTION
    =============================== */

    .right-section{

        position: relative;

        display: flex;
        align-items: center;
        justify-content: center;

        overflow: hidden;

        min-height: 640px;
    }

    /* GLOW EFFECT */

    .glow{

        position: absolute;

        width: 500px;
        height: 500px;

        border-radius: 50%;

        background:
            radial-gradient(
                rgba(255,95,126,0.35),
                transparent 70%
            );

        filter: blur(28px);

        z-index: 1;

        animation: pulseGlow 5s ease-in-out infinite;
    }

    @keyframes pulseGlow{
        0%{
            transform: scale(1);
            opacity: 0.7;
        }
        50%{
            transform: scale(1.08);
            opacity: 1;
        }
        100%{
            transform: scale(1);
            opacity: 0.7;
        }
    }

    /* GLASS CIRCLES */

    .circle{

        position: absolute;

        border-radius: 50%;

        background: rgba(255,255,255,0.08);

        border: 1px solid rgba(255,255,255,0.10);

        backdrop-filter: blur(12px);

        transition: 0.5s ease;
    }

    .circle-one{

        width: 160px;
        height: 160px;

        top: 60px;
        right: 70px;

        animation: floatOne 6s ease-in-out infinite;
    }

    .circle-two{

        width: 110px;
        height: 110px;

        bottom: 80px;
        left: 60px;

        animation: floatTwo 7s ease-in-out infinite;
    }

    .circle-three{

        width: 85px;
        height: 85px;

        top: 160px;
        left: 100px;

        animation: floatThree 8s ease-in-out infinite;
    }

    @keyframes floatOne{
        0%,100%{
            transform: translateY(0);
        }
        50%{
            transform: translateY(-18px);
        }
    }

    @keyframes floatTwo{
        0%,100%{
            transform: translateY(0);
        }
        50%{
            transform: translateY(15px);
        }
    }

    @keyframes floatThree{
        0%,100%{
            transform: translateY(0);
        }
        50%{
            transform: translateY(-12px);
        }
    }

    /* GLASS SQUARES */

    .glass-square{

        position: absolute;

        background: rgba(255,255,255,0.08);

        border: 1px solid rgba(255,255,255,0.12);

        backdrop-filter: blur(15px);

        border-radius: 28px;

        transition: 0.5s ease;
    }

    .square-one{

        width: 160px;
        height: 160px;

        top: 90px;
        left: 50px;

        transform: rotate(18deg);

        animation: rotateFloat 8s ease-in-out infinite;
    }

    .square-two{

        width: 110px;
        height: 110px;

        bottom: 100px;
        right: 90px;

        transform: rotate(-14deg);

        animation: rotateFloatTwo 9s ease-in-out infinite;
    }

    @keyframes rotateFloat{
        0%,100%{
            transform: rotate(18deg) translateY(0);
        }
        50%{
            transform: rotate(24deg) translateY(-10px);
        }
    }

    @keyframes rotateFloatTwo{
        0%,100%{
            transform: rotate(-14deg) translateY(0);
        }
        50%{
            transform: rotate(-20deg) translateY(10px);
        }
    }

    /* ===============================
       🔥 LOGO CONTAINER
    =============================== */

    .glass-logo{

        width: 360px;
        height: 360px;

        border-radius: 50%;

        background:
            radial-gradient(
                circle at center,
                rgba(255,255,255,0.16),
                rgba(255,255,255,0.04)
            );

        border: 1px solid rgba(255,255,255,0.16);

        backdrop-filter: blur(20px);

        display: flex;
        align-items: center;
        justify-content: center;

        position: relative;
        z-index: 2;

        overflow: hidden;

        cursor: pointer;

        transition: 0.45s ease;

        box-shadow:
            0 10px 50px rgba(0,0,0,0.35),
            inset 0 1px 0 rgba(255,255,255,0.08);

        animation: logoFloat 5s ease-in-out infinite;
    }

    @keyframes logoFloat{
        0%,100%{
            transform: translateY(0);
        }
        50%{
            transform: translateY(-10px);
        }
    }

    /* 🔥 HOVER EFFECT */

    .glass-logo:hover{

        transform:
            scale(1.06)
            rotate(2deg);

        box-shadow:
            0 0 40px rgba(255,90,120,0.45),
            0 20px 60px rgba(0,0,0,0.45);

        border: 1px solid rgba(255,255,255,0.30);
    }

    .glass-logo:hover::before{

        content: '';

        position: absolute;

        width: 160%;
        height: 160%;

        background:
            conic-gradient(
                from 0deg,
                transparent,
                rgba(255,255,255,0.22),
                transparent
            );

        animation: spin 3s linear infinite;
    }

    @keyframes spin{
        from{
            transform: rotate(0deg);
        }
        to{
            transform: rotate(360deg);
        }
    }

    /* 🔥 FIXED LOGO IMAGE */

    .glass-logo img{

        width: 70%;
        height: 70%;

        object-fit: contain;

        border-radius: 50%;

        mix-blend-mode: multiply;

        position: relative;
        z-index: 2;

        transition: 0.4s ease;

        filter:
            drop-shadow(0 10px 25px rgba(0,0,0,0.25))
            contrast(1.08)
            brightness(1.05);
    }

    .glass-logo:hover img{
        transform: scale(1.08) rotate(-2deg);
    }

    /* ===============================
       🔥 RESPONSIVE
    =============================== */

    @media (max-width: 1200px){

        .main-container{
            grid-template-columns: 1fr;
        }

        .right-section{
            min-height: 480px;
        }

        .system-title{
            font-size: 3rem;
        }

        .left-section{
            padding: 45px 38px;
        }
    }

    @media (max-width: 768px){

        body{
            padding: 14px;
        }

        .main-container{
            border-radius: 24px;
            min-height: auto;
        }

        .left-section{
            padding: 36px 24px;
        }

        .system-title{
            font-size: 2.2rem;
            line-height: 1.15;
        }

        .title-line{
            min-height: 105px;
        }

        .description{
            font-size: 0.93rem;
        }

        .button-group{
            flex-direction: column;
        }

        .btn{
            width: 100%;
        }

        .glass-logo{
            width: 260px;
            height: 260px;
        }

        .right-section{
            min-height: 360px;
        }

        .square-one,
        .square-two,
        .circle-three{
            display: none;
        }
    }

</style>

<div class="main-container">

    <!-- LEFT SECTION -->
    <div class="left-section">

        <div class="badge">
            Smart Campus Resource Management
        </div>

        <div class="title-wrapper">

            <div class="title-line"></div>

            <h1 class="system-title">
                Smart Borrow <br>
                <span>Management</span> <br>
                System
            </h1>

        </div>

        <p class="description">
            The SmartBorrow Management System is a modern digital platform designed to simplify item requisitions, transportation scheduling, and campus asset monitoring. It replaces manual logging with a secure, centralized, and real-time management experience — improving accountability, efficiency, and accessibility for both users and administrators.
        </p>

        <div class="button-group">

            <a href="{{ route('login') }}"
               class="btn btn-login">

                Login to System

            </a>

        </div>

    </div>

    <!-- RIGHT SECTION -->
    <div class="right-section">

        <div class="glow"></div>

        <div class="circle circle-one"></div>
        <div class="circle circle-two"></div>
        <div class="circle circle-three"></div>

        <div class="glass-square square-one"></div>
        <div class="glass-square square-two"></div>

        <!-- LOGO -->
        <div class="glass-logo">

            <img src="{{ asset('images/osmena-logo.png') }}"
                 alt="Osmena Colleges Logo">

        </div>

    </div>

</div>