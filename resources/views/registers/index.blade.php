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
                <img src="images/logo.png" alt="ロゴ">
            </div>
            <div id="to-registrationInput">
                <a href="{{ route('logins.index') }}"><button class="toRegistration-btn">ログイン</button></a>
            </div>
        </header>
        <main>
            <article>
                <div class="registration">
                    <h1>会員登録</h1>
                    <form id="registrationInput-form" method="POST" action="{{route('registers.confirm')}}">
                        {{ csrf_field() }}
                        <div>
                            <label>ユーザーID</label>
                            <input class="registrationInput" type="text" name="user_id" value="{{ old('user_id') }}">
                            @if ($errors->has('user_id'))
                                <p class="error">{{ $errors->first('user_id') }}</p>
                            @endif
                        </div>
                        <div>
                            <label>パスワード</label>
                            <input class="registrationInput" type="password" name="password" value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <p class="error">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        <div>
                            <label>パスワード（確認用）</label>
                            <input class="registrationInput" type="password" name="confirm_password" value="{{ old('confirm_password') }}">
                            @if ($errors->has('confirm_password'))
                                <p class="error">{{ $errors->first('confirm_password') }}</p>
                            @endif
                        </div>
                        <div>
                            <label>ユーザーネーム</label>
                            <input class="registrationInput" type="text" name="user_name" value="{{ old('user_name') }}">
                            @if ($errors->has('user_name'))
                                <p class="error">{{ $errors->first('user_name') }}</p>
                            @endif
                        </div>
                        <div>
                            <label>メールアドレス</label>
                            <input class="registrationInput" type="text" name="email" value="{{ old('email') }}"> 
                            @if ($errors->has('email'))
                                <p class="error">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div id="to-registrationCheck">
                            <input class="registration-btn" type="submit" value="確認">
                        </div>
                    </form>
                </div>
            </article>
        </main>

        <script src="index.js"></script>
    </body>
</html>