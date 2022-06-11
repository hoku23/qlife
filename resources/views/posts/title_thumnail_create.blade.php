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
            <a href="{{ route('posts.index') }}">
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
                    <a href="{{ route('logout') }}">ログアウト</a>
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
                        <li><a href="{{route('privacy.index')}}">プライバシーポリシー</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1>新規投稿作成</h1>
                    @if (session('title_message'))
                    <div id="phone_error_message" style="align-items:center; color:red;">
                        <p>{{session('title_message')}}</p>
                    </div>
                    <div id="pc_error_message" style="align-items:center; color:red;">
                        <p>{{session('title_message')}}</p>
                    </div>
                    @endif
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="other-step"><a href="{{ route('posts.create')}}">本文作成</a></li>
                                <li class="show-step"><a href="{{ route('posts.create_title')}}">タイトル作成<br>サムネイル指定</a></li>
                                <li class="other-step"><a href="{{ route('posts.create_tags')}}">タグ選択</a></li>
                                <li class="other-step"><a href="{{ route('posts.confirm')}}">内容確認</a></li>
                                <li class="other-step">投稿完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div id="create-box-left" class="create-box">
                                <div>
                                    <div class="createBox-header">
                                        <div class="text-heading">
                                            <p>タイトル</p>
                                            <div class="store-btn">
                                                <button id="postTitle-store-btn">保存する</button>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="createPost-form" method="POST" action="{{route('posts.store_title')}}">
                                        {{csrf_field()}}
                                        <textarea id="postTitle" name="postTitle" placeholder="タイトルを入力">@if(isset($title)){{$title}}@endif</textarea>
                                        <input id="postTitle-store" type="submit" name="action" value="save" style="display:none">
                                    </form>
                                </div>
                            </div>
                            <div id="create-box-right" class="create-box">
                                <div class="createBox-header">
                                    <div class="text-heading">
                                        <div class="thumnail-select">
                                            <p>サムネイル</p>
                                            <button id="thumnailFileSelect-btn" class="thumnailImg-select">
                                                <div class="imgSelect-icon">
                                                    <img src="{{asset('images/picture.png')}}" alt="画像ロゴ">
                                                </div>
                                                <p>画像選択</p>
                                            </button>
                                        </div>
                                        <div class="store-btn">
                                            <button id="postThumnail-store-btn">保存する</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-content">
                                    <div id="selectedThumnail" class="thumnail-up">
                                        <img id="img" src="@if(isset($thumnail)){{$thumnail}}@endif" style="width:100%">
                                    </div>
                                </div>
                                <form method="POST" action="{{route('posts.store_thumnail')}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input id="thumnailFileSelect" type="file" name="thumnail" style="display:none">
                                    <input id="thumnailPath" type="hidden" name="thumnailPath" style="display:none">
                                    <input id="fileName" type="hidden" name="file_name">
                                    <input id="postTitle_textarea" type="hidden" name="postTitle_textarea">
                                    <input id="postThumnail-store" type="submit" name="action" value="save" style="display:none">
                                </form>
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

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>