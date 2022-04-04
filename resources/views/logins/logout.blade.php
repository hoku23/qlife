<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </div>
            <div id="to-registrationInput">
                <a href="{{ route('logins.index') }}"><button class="toRegistration-btn">ログイン</button></a>
            </div>
        </header>
        <main>
            <article>
                <div class="login">
                    <h1>ログアウトしました</h1>
                    
                </div>
            </article>
        </main>

        <script src="index.js"></script>
    </body>
</html>