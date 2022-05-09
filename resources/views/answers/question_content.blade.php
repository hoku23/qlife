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
                                <li class="show-step"><a href="{{route('answer.question_content')}}">質問内容</a></li>
                                <li class="other-step"><a href="{{route('answer.create')}}">本文作成</a></li>
                                <li class="other-step"><a href="{{route('answer.confirm')}}">内容確認</a></li>
                                <li class="other-step">回答送信完了</li>
                            </ul>
                        </div>
                        <div id="createAnswer-container">
                            <div class="createBox-header">
                                <div class="text-heading">
                                    <p>質問内容</p>
                                </div>
                            </div>
                            <div class="question-area">
                            <div class="questionDetails">
                                <div class="icon-userName">
                                    <div class="icon">
                                        <img src="{{$question->user_icon}}" alt="">
                                    </div>
                                    <p class="user-name">{{$question->user_name}}</p>
                                </div>
                                <p>困っていること</p>
                                <div class="questionDetails-content">
                                    @if (isset($question->question_content))
                                        <div>
                                            <?php
                                            echo $question->question_content;
                                            ?>
                                        </div>
                                    @endif
                                </div>
                                <p>試したことや解決策の候補</p>
                                <div class="questionDetails-content">
                                    @if (isset($question->question_try))
                                        <div>
                                            <?php
                                            echo $question->question_try;
                                            ?>
                                        </div>
                                    @endif
                                </div>
                                <div class="questionDetails-content">
                                    <div class="questionDetails-tags">
                                        @if (isset($question->tags))
                                            @foreach ($question->tags as $tag)
                                                <div class="tag">{{$tag}}</div>
                                            @endforeach
                                        @endif
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

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>