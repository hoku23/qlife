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
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="other-step"><a href="{{route('posts.create')}}">本文作成</a></li>
                                <li class="other-step"><a href="{{route('posts.create_title')}}">タイトル作成<br>サムネイル指定</a></li>
                                <li class="other-step"><a href="{{route('posts.create_tags')}}">タグ選択</a></li>
                                <li class="show-step"><a href="{{route('posts.confirm')}}">内容確認</a></li>
                                <li class="other-step">投稿完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div id="checkPost-box-left" class="checkPost-box">
                                <div>
                                    <div class="createBox-header">
                                        <div class="text-heading">
                                            <p>タイトル & サムネイル</p>
                                        </div>
                                    </div>
                                    <div class="text-content createPost-check">
                                        <div class="createPost-sample">
                                            <div class="icon-userName">
                                                <div class="icon">
                                                    <img src="{{$user->user_icon}}" alt="">
                                                </div>
                                                <p class="user-name">{{$user->user_name}}</p>
                                            </div>
                                            @if ($errors->has('post_title'))
                                                <p class="error">{{ $errors->first('post_title') }}</p>
                                            @endif
                                            <p class="title">@if(isset($title)){{$title}}@endif</p>
                                            <div class="thumnail">
                                                <img src="@if(isset($thumnail)){{$thumnail}}@endif" alt="" style="width:100%">
                                                @if ($errors->has('thumnail'))
                                                    <p class="error">{{ $errors->first('thumnail') }}</p>
                                                @endif
                                            </div>
                                            <div class="tags">
                                                @if (isset($tags))
                                                    @foreach ($tags as $tag)
                                                        <div class="tag">{{$tag}}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="reaction-img">
                                                <div class="reaction">
                                                    <p>0グッド</p>
                                                    <p>0コメント</p>
                                                </div>
                                                <div class="save-img">
                                                    <img src="images/save_w.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="checkPost-box-right" class="checkPost-box">
                                <div class="createBox-header">
                                    <div class="text-heading-right">
                                        <p id=postContentPreview-head>本文プレビュー</p>
                                        <div class="store-btn">
                                            <a href="{{route('posts.release')}}"><button id="release-btn">公開する</button></a>
                                            <a href="{{route('posts.draft')}}"><button id="draft-btn">下書き保存</button></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="createContent-preview">
                                    @if (isset($content))
                                        <div>
                                            <?php
                                            echo $content;
                                            ?>
                                        </div>
                                    @endif
                                    @if ($errors->has('post_content'))
                                        <p class="error">{{ $errors->first('post_content') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </main>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>