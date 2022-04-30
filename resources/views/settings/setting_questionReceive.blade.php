<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
    </head>
    <body>
        <header>
            <div class="logo">
                <a href="home.html"><img src="{{asset('images/logo.png')}}" alt="ロゴ"></a>
            </div>
            <div>
                <div class="header-text">
                    <div class="icon-userName">
                        <div class="icon">
                            <img src="{{$user->user_icon}}" alt="">
                        </div>
                            <p class="user-name">{{$user->user_name}}</p>
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
                </div>
                <section class="wrapper">
                    <div id="setting">
                        <ul class="tabs">
                            <li class="tab"><a href="{{route('settingUser.index')}}">会員情報設定</a></li>
                            <li class="tab"><a href="{{route('settingFavoriteTag.index')}}">お気に入りタグ設定</a></li>
                            <li class="tab active-tab"><a href="{{route('settingQuestionReceive.index')}}">質問受け取り設定</a></li>
                            <li class="tab"><a href="{{route('settingNotice.index')}}">通知設定</a></li>
                        </ul>
                        <div class="setting-contents">
                            <div class="setting-content show-content">
                                <div class="setting-questionReceive">
                                    <div>
                                        <div class="questionReceive-options">
                                            <button id="questionReceive-yes-btn"><div id="yes_check" class="check"></div></button>
                                            <label>質問を受け取る</label>
                                        </div>
                                        <div class="questionReceive-options">
                                            <button id="questionReceive-no-btn"><div id="no_check" class="check"></div></button>
                                            <label>質問を受け取らない</label>
                                        </div>
                                    </div>
                                    <form style="display: none;" method="POST" action="/store_questionReceive">
                                        {{csrf_field()}}
                                        <input id="questionReceive_yes" class="questionReceive" type="radio" name="questionReceive" value="yes" style="display:none">
                                        <input id="questionReceive_no" class="questionReceive" type="radio" name="questionReceive" value="no" style="display:none">
                                        <input id="questionReceive_submit" type="submit" style="display:none">
                                    </form>
                                    <div id="questionReceive-btn" class="setting-btn">
                                        <button id="questionReceive_submit_btn">変更を保存する</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </section>
            </article>
        </main>

        <script src="{{asset('js/index.js')}}"></script>
    </body>
</html>