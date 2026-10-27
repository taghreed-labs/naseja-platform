<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تسجيل دخول الإدارة | NASEJA</title>

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
            background: #f4f8fd;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 35px;
            border-radius: 22px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .08);
        }

        .logo {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #4b82d6;
            color: white;
            font-size: 25px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            margin: 0 0 8px;
            font-size: 24px;
        }

        .subtitle {
            text-align: center;
            color: #7b8797;
            margin-bottom: 28px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 50px;
            border: 1px solid #dce5ef;
            border-radius: 12px;
            padding: 0 14px;
            margin-bottom: 18px;
            outline: none;
            font-family: inherit;
        }

        input:focus {
            border-color: #4b82d6;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #667386;
        }

        button {
            width: 100%;
            height: 50px;
            border: 0;
            border-radius: 12px;
            background: #4b82d6;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #3e73c5;
        }

        .error {
            background: #fff3f3;
            color: #b93d3d;
            border: 1px solid #f0cccc;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <div class="logo">
        N
    </div>

    <h1>
        إدارة NASEJA
    </h1>

    <div class="subtitle">
        تسجيل الدخول إلى لوحة الإدارة
    </div>


    @if($errors->any())

        <div class="error">
            {{ $errors->first() }}
        </div>

    @endif


    <form
        method="POST"
        action="{{ route('admin.login.store') }}"
        autocomplete="off"
    >

        @csrf


        <label for="admin_email">
            البريد الإلكتروني
        </label>

        <input
            type="email"
            id="admin_email"
            name="email"
            value=""
            placeholder="admin@naseja.com"
            autocomplete="off"
            required
            autofocus
        >


        <label for="admin_password">
            كلمة المرور
        </label>

        <input
            type="password"
            id="admin_password"
            name="password"
            value=""
            placeholder="أدخل كلمة المرور"
            autocomplete="new-password"
            required
        >


        <label class="remember">

            <input
                type="checkbox"
                name="remember"
                value="1"
            >

            تذكر تسجيل الدخول

        </label>


        <button type="submit">
            دخول لوحة الإدارة
        </button>

    </form>

</div>

</body>

</html>