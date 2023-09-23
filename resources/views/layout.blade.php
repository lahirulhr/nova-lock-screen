<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full font-sans antialiased">

<head>
    <title>Locked</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="ZJpba94MMK4uNSbaQr8swRC3BkLF3bjbsEL7H6Sn">
    <meta name="viewport" content="width=device-width" />
    <meta name="locale" content="en" />
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <style>
        .lock-form {
            background-color: #4c4c4c33;
        }

        .radius-16 {
            border-radius: 16px;
        }

        .bg-lock {
            background-image: url('{{ $bg }}');
        }

        /* Nova Tool CSS */


        .shake {
            animation: shake 0.5s;
        }

        @keyframes shake {
            0% {
                transform: translate(1px, 1px) rotate(0deg);
            }

            10% {
                transform: translate(-1px, -2px) rotate(-1deg);
            }

            20% {
                transform: translate(-3px, 0px) rotate(1deg);
            }

            30% {
                transform: translate(3px, 2px) rotate(0deg);
            }

            40% {
                transform: translate(1px, -1px) rotate(1deg);
            }

            50% {
                transform: translate(-1px, 2px) rotate(-1deg);
            }

            60% {
                transform: translate(-3px, 1px) rotate(0deg);
            }

            70% {
                transform: translate(3px, 1px) rotate(-1deg);
            }

            80% {
                transform: translate(-1px, -1px) rotate(1deg);
            }

            90% {
                transform: translate(1px, 2px) rotate(0deg);
            }

            100% {
                transform: translate(1px, -2px) rotate(-1deg);
            }
        }

        .lc-parent {
            position: relative;

        }

        .bg-lock::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100vh;
            backdrop-filter: blur(8px);
        }

        div.bg-lock {
            height: 100vh;
            width: 100%;
            background-color: linear-gradient(rgba(0, 0, 0, 0.63), rgba(0, 0, 0, 0.623));
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: -1;

        }
    </style>

</head>

<body>
    <div class="py-6 px-1 md:px-2 lg:px-6 lc-parent">
        <div class="bg-lock"></div>
        <div class="mx-auto py-8 max-w-sm flex justify-center text-black">
            {{-- logo --}}
        </div>
        @yield('content')
    </div>
</body>

</html>
