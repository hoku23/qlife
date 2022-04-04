<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/style.css') }}">
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
            </div>
            <div class="link">
                <a href="{{ route('logins.index') }}">ログイン</a>
            </div>
        </header>
        <main>
            <article>
                <div id="registrationConpletion" class="registration">
                    <h1>会員登録が完了しました</h1>
                    <p>
                        {{ $user->user_name }}さん、QLifeへようこそ!!<br>
                        ログインして暮らしに関する情報をシェアしましょう!!                        
                    </p>
                </div>
            </article>
        </main>

        <script src="index.js"></script>
    </body>
</html>