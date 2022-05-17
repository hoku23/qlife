<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('css/phone_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mini_pc_style.css') }}">
        <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon" />
    </head>
    <body>
        <header>
            <a href="home.html">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="ロゴ">
                </div>
            </a>
            <div>
                <div class="header-text">
                    <div class="icon-userName">
                        <div class="icon">
                            <img src="{{$user->user_icon}}" alt="">
                        </div>
                            <p id="user_name" class="user-name">{{$user->user_name}}</p>
                    </div>
                    <a href="{{route('logout')}}">ログアウト</a>
                </div>
                <div id="menu">
                    <div id="hamburger" class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div id="nav-mask" class="nav-mask">
                <nav>
                    <ul>
                        <li><a href="{{route('timeline.index')}}">タイムライン</a></li>
                        <li><a href="{{ route('posts.create')}}">新規投稿作成</a></li>
                        <li><a href="{{ route('follow.index') }}">フォロー/フォロワー一覧</a></li>
                        <li><a href="{{ route('posts.index') }}">投稿一覧</a></li>
                        <li><a href="{{ route('question.index') }}">質問ホーム</a></li>
                        <li><a href="{{route('settingUser.index')}}">設定</a></li>
                        <li><a href="{{route('shops.index')}}">商品検索</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1>設定</h1>
                    @if (session('message'))
                    <div style="display:flex; align-items:center; color:red;">
                        <p>{{session('message')}}</p>
                    </div>
                    @endif
                    @if ($errors->has('new_user_name'))
                        <div style="display:flex; align-items:center; color:red;">
                            <p class="error">{{ $errors->first('new_user_name') }}</p>
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div style="display:flex; align-items:center; color:red;">
                            <p class="error">{{ $errors->first('email') }}</p>
                        </div>
                    @endif
                    @if ($errors->has('new_password'))
                        <div style="display:flex; align-items:center; color:red;">
                            <p class="error">{{ $errors->first('new_password') }}</p>
                        </div>
                    @endif
                    @if ($errors->has('new_password') == false && $errors->has('new_password_confirm'))
                        <div style="display:flex; align-items:center; color:red;">
                            <p class="error">{{ $errors->first('new_password_confirm') }}</p>
                        </div>
                    @endif
                </div>
                <section class="wrapper">
                    <div id="setting">
                        <ul class="tabs pc_tabs">
                            <li class="tab active-tab"><a href="{{route('settingUser.index')}}">会員情報設定</a></li>
                            <li class="tab"><a href="{{route('settingFavoriteTag.index')}}">お気に入りタグ設定</a></li>
                            <li class="tab"><a href="{{route('settingQuestionReceive.index')}}">質問受け取り設定</a></li>
                            <li class="tab"><a href="{{route('settingNotice.index')}}">通知設定</a></li>
                        </ul>
                        <ul class="tabs phone_tabs">
                            <li class="tab active-tab"><a href="{{route('settingUser.index')}}">会員情報</a></li>
                            <li class="tab"><a href="{{route('settingFavoriteTag.index')}}">お気に入りタグ</a></li>
                            <li class="tab"><a href="{{route('settingQuestionReceive.index')}}">質問受け取り</a></li>
                            <li class="tab"><a href="{{route('settingNotice.index')}}">通知</a></li>
                        </ul>
                        <div class="setting-contents">
                            <div class="setting-content show-content">
                                <div class="setting-user">
                                    <div class="user-item">
                                        <div class="setting-icon">
                                            <div class="icon">
                                                <img src="{{$user->user_icon}}" alt="">
                                            </div>
                                            <div class="userChange-btn change-btn">変更する</div>
                                        </div>
                                        <div class="user-info">
                                            <div>
                                                <div class="change">
                                                    <h3>パスワード</h3>
                                                    <div class="userChange-btn change-btn">変更する</div>
                                                </div>
                                                <p class="password">・・・・・・・</p>
                                            </div>
                                            <div>
                                                <div class="change">
                                                    <h3>ユーザーネーム</h3>
                                                    <div class="userChange-btn change-btn">変更する</div>
                                                </div>
                                                <p class="user-name">{{$user->user_name}}</p>
                                            </div>
                                            <div>
                                                <div class="change">
                                                    <h3>メールアドレス</h3>
                                                    <div class="userChange-btn change-btn">変更する</div>
                                                </div>
                                                <p class="email">{{$user->email}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="change-forms">
                                        <div class="change-form icon-change-form show-changeForm">
                                            <div id="newIcon-header">
                                                <p>新しいアイコンを選択</p>
                                                <button id="selection-icon">画像を選ぶ</button>
                                            </div>
                                            <div class="new-icon">
                                                <img id="img" src="" style="height:100%">
                                                <form style="display:none" method="POST" action="{{route('settingUser.user_icon_change')}}" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    <input id="iconFile_select" style="display:none" type="file" name="user_icon">
                                                    <input id="fileName" type="hidden" name="file_name">
                                                    <input id="iconPath" style="hidden" name="iconPath">
                                                    <input id="userIcon_change" type="submit" style="display:none">
                                                </form>
                                            </div>
                                            <div class="setting-btn">
                                                <button id="userIcon_change_btn">変更を保存する</button>
                                            </div>
                                        </div>
                                        <div class="change-form password-change-form">
                                             <form method="POST" action="{{route('settingUser.user_password_change')}}">
                                                {{csrf_field()}}
                                                <div>
                                                    <label>現在のパスワード</label>
                                                    <input type="password" name="user_password">
                                                    <label>新しいパスワード</label>
                                                    <input type="password" name="new_password">
                                                    <label>新しいパスワード（確認用）</label>
                                                    <input type="password" name="new_password_confirm">
                                                    <input type="submit" style="display:none">
                                                </div>
                                            </form>
                                            <div class="setting-btn">
                                                <button class="user_info_changes_btn">変更を保存する</button>
                                            </div>
                                        </div>
                                        <div class="change-form userName-change-form">
                                            <form method="POST" action="{{route('settingUser.user_name_change')}}">
                                                {{csrf_field()}}
                                                <div>
                                                    <label>新しいユーザーネーム</label>
                                                    <input type="text" name="new_user_name">
                                                    <input type="submit" style="display:none">
                                                </div>
                                            </form>
                                            <div class="setting-btn">
                                                <button class="user_info_changes_btn">変更を保存する</button>
                                            </div>
                                        </div>
                                        <div class="change-form emial-change-form">
                                            <form method="POST" action="{{route('settingUser.user_email_change')}}">
                                                {{csrf_field()}}
                                                <div>
                                                    <label>新しいメールアドレス</label>
                                                    <input type="text" name="email">
                                                    <input type="submit" style="display:none">
                                                </div>
                                            </form>
                                            <div class="setting-btn">
                                                <button class="user_info_changes_btn">変更を保存する</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </section>
            </article>
        </main>
        <script type="text/javascript">
            let userName = document.getElementById('user_name');
            var user_name = userName.innerHTML;
        </script>

        <script src="{{asset('js/index.js')}}"></script>
    </body>
</html>