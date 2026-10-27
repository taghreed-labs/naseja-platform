<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $title }} | NASEJA</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 25px;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(91, 124, 255, .08),
                    transparent 35%
                ),
                #f6f8fc;

            font-family: 'Tajawal', Arial, sans-serif;

            color: #263146;
        }


        .status-card {
            width: 100%;
            max-width: 520px;

            padding: 45px 35px;

            background: #ffffff;

            border: 1px solid #e7ecf4;
            border-radius: 26px;

            text-align: center;

            box-shadow:
                0 22px 60px rgba(31, 44, 72, .08);
        }


        .status-icon {
            width: 78px;
            height: 78px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 22px;

            border-radius: 24px;

            background:
                linear-gradient(
                    135deg,
                    #edf2ff,
                    #f3efff
                );

            color: #5b72d8;
        }


        .status-icon svg {
            width: 32px;
            height: 32px;
        }


        h1 {
            margin: 0 0 12px;

            font-size: 23px;
            font-weight: 900;
        }


        p {
            max-width: 420px;

            margin: 0 auto 28px;

            color: #7e899a;

            font-size: 14px;
            line-height: 2;
        }


        .back-button {
            min-height: 48px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 0 22px;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #587cff,
                    #7c6ae5
                );

            color: #ffffff;

            text-decoration: none;

            font-size: 13px;
            font-weight: 800;

            box-shadow:
                0 10px 25px rgba(91, 124, 255, .20);
        }


        .back-button svg {
            width: 17px;
            height: 17px;
        }

    </style>

</head>


<body>


<div class="status-card">

    <div class="status-icon">

        <i data-lucide="clock-3"></i>

    </div>


    <h1>
        {{ $title }}
    </h1>


    <p>
        {{ $message }}
    </p>


    <a
        href="{{ route('explore') }}"
        class="back-button"
    >

        العودة إلى الاستكشاف

        <i data-lucide="arrow-left"></i>

    </a>

</div>


<script src="https://unpkg.com/lucide@latest"></script>

<script>
    lucide.createIcons();
</script>


</body>

</html>