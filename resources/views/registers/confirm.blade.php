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
        </header>
        <main>
            <article>
                <div class="registration">
                    <h1>会員情報確認</h1>
                    <form method="POST" action="{{route('registers.store')}}">
                        {{ csrf_field()}}
                        <input type="hidden" name="user_id" value="{{ $input['user_id'] }}">
                        <input type="hidden" name="password" value="{{ $input['password'] }}">
                        <input type="hidden" name="user_name" value="{{ $input['user_name'] }}">
                        <input type="hidden" name="email" value="{{ $input['email'] }}">
                        <div class="check-info">
                            <div>
                                <label>ユーザーID</label>
                                <p>{{ $input['user_id']}}</p>
                            </div>
                            <div>
                                <label>ユーザーネーム</label>
                                <p>{{ $input['user_name']}}</p>
                            </div>
                            <div>
                                <label>メールアドレス</label>
                                <p>{{ $input['email']}}</p>    
                            </div>
                        </div>
                        <div id="registrationCheck-btn">
                            <div id="back-registrationInput">
                                <input class="registration-btn" type="submit" name="action" value="戻る">
                            </div>
                            <div id="to-registrationConpletion">
                                <input class="registration-btn" type="submit" name="action" value="登録">
                            </div>
                        </div>
                    </form>
                </div>
            </article>
        </main>

        <script src="index.js"></script>
    </body>
</html>