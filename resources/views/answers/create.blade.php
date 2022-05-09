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
                    <h1>新規回答作成</h1>
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="other-step"><a href="{{route('answer.question_content')}}">質問内容</a></li>
                                <li class="show-step"><a href="{{route('answer.create')}}">本文作成</a></li>
                                <li class="other-step"><a href="{{route('answer.confirm')}}">内容確認</a></li>
                                <li class="other-step">回答送信完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div id="create-box-left" class="create-box">
                                <div>
                                    <div class="createBox-header">
                                        <div class="text-heading">
                                            <p>本文</p>
                                            <div class="store-btn">
                                                <button id="answer-save-btn">保存する</button>
                                            </div>
                                        </div>
                                        <button id="fileSelect" onchange="addText3();" class="img-select">
                                            <div class="imgSelect-icon">
                                                <img src="{{asset('images/picture.png')}}" alt="画像ロゴ">
                                            </div>
                                            <p>画像選択</p>
                                        </button>
                                    </div>
                                    <form class="createPost-form" method="POST" action="{{route('answer.store')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <textarea id="content" name="content" placeholder="本文を入力">{{$content}}</textarea>
                                        <textarea id="content_htmlTag" name="content_htmlTag">{{$content_htmlTag}}</textarea>
                                        <input id="fileName" type="hidden" name="file_name">
                                        <input id="fileElem" onchange="addText6();" type="file" name="content_img">
                                        <input id="postContent_preview" type="submit" name="action" value="preview">
                                        <input id="postContent_save" type="submit" name="action" value="save">
                                    </form>
                                </div>
                            </div>
                            <div id="create-box-right" class="create-box">
                                <div class="createBox-header">
                                    <div class="text-heading-right">
                                        <button id="postContent_preview-btn">
                                            <p>プレビュー</p>
                                        </button>
                                    </div>
                                </div>
                                <div class="createContent-preview">
                                    @if (isset($content_htmlTag))
                                        <div>
                                            <?php
                                            echo $content_htmlTag;
                                            ?>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </main>
        
        <script type="text/javascript">
            var user_name = JSON.parse('<?php echo $param_json; ?>');
        </script>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>