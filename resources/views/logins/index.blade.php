<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/phone_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mini_pc_style.css') }}">
        <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon" />
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </div>
            <div id="to-registrationInput">
                <a href="{{ route('registers.index') }}"><button class="toRegistration-btn">新規会員登録</button></a>
            </div>
        </header>
        <main>
            <article>
                <div class="login">
                    <h1>ログイン</h1>
                    <form method="POST" action="logins/auth">
                        {{ csrf_field() }}
                        <div id="login-forms">
                            @if (session('message'))
                                <p class="error">{{ session('message') }}</p>
                            @endif
                            <div class="login-form">
                                <label>ユーザーID</label>
                                <input type="text" name="user_id">
                                @if ($errors->has('user_id'))
                                    <p class="error">{{ $errors->first('user_id') }}</p>
                                @endif
                            </div>
                            <div class="login-form">
                                <label>パスワード</label>
                                <input type="password" name="password">
                                @if ($errors->has('password'))
                                    <p class="error">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="login-btn-place">
                            <input class="login-btn" type="submit" value="ログイン">
                        </div>
                    </form>
                </div>
            </article>
        </main>

        <script src="index.js"></script>
    </body>
</html>