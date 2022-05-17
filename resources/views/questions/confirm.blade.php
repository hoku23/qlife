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
                        <li><a href="{{route('posts.create')}}">新規投稿作成</a></li>
                        <li><a href="{{route('follow.index')}}">フォロー/フォロワー一覧</a></li>
                        <li><a href="{{route('posts.index')}}">投稿一覧</a></li>
                        <li><a href="{{route('question.index')}}">質問ホーム</a></li>
                        <li><a href="{{route('settingUser.index')}}">設定</a></li>
                        <li><a href="{{route('shops.index')}}">商品検索</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1>新規質問作成</h1>
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="other-step"><a href="{{route('question.create')}}">本文作成<br>タイトル作成</a></li>
                                <li class="other-step"><a href="{{route('question.create_tags')}}">タグ選択<br>ユーザー指定</a></li>
                                <li class="show-step"><a href="{{route('question.confirm')}}">内容確認</a></li>
                                <li class="other-step">質問投函完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div id="createQuestion-box-left" class="create-box">
                                <div class="createQuestion-box-left">
                                    <div class="createQuestionBox-header">
                                        <div class="textQuestion-heading">
                                            <div class="store-btn">
                                                <a href="{{route('question.release')}}"><button id="release-btn">公開する</button></a>
                                                <a href="{{route('question.draft')}}"><button id="draft-btn">下書き保存</button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="createQuestionForm-box">
                                        <div class="questionCreateCheck-sample">
                                            <div class="questionSample question">
                                                <div class="icon-userName">
                                                    <div class="icon">
                                                        <img src="{{$user->user_icon}}" alt="">
                                                    </div>
                                                    <p class="user-name">{{$user->user_name}}</p>
                                                </div>
                                                <div class="question-title">
                                                    <p>@if(isset($title)){{$title}}@endif</p>
                                                    @if ($errors->has('question_title'))
                                                        <p class="error">{{ $errors->first('question_title') }}</p>
                                                    @endif
                                                </div>
                                                <p class="question-label">困っていること</p>
                                                <div class="questionSample-content">
                                                    @if (isset($content))
                                                        <div>
                                                            <?php
                                                            echo $content;
                                                            ?>
                                                        </div>
                                                    @endif
                                                    @if ($errors->has('question_content'))
                                                        <p class="error">{{ $errors->first('question_content') }}</p>
                                                    @endif
                                                </div>
                                                <p class="question-label">試したことや解決策の候補</p>
                                                <div class="questionSample-content">
                                                    @if (isset($try))
                                                        <div>
                                                            <?php
                                                            echo $try;
                                                            ?>
                                                        </div>
                                                    @endif
                                                    @if ($errors->has('question_try'))
                                                        <p class="error">{{ $errors->first('question_try') }}</p>
                                                    @endif
                                                </div>
                                                <div class="question-tags">
                                                    @if (isset($tags))
                                                        @foreach ($tags as $tag)
                                                            <div class="tag">{{$tag}}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="create-box-right" class="create-box">
                                <div class="questionCreate-right">
                                    <div class="createBox-header">
                                        <div class="text-heading">
                                            <p class="phone_question_confirm">指定されたユーザー</p>
                                        </div>
                                    </div>
                                    <div class="questionSample-tags-users">
                                        <div class="questionSample-users-box">
                                            <p class="pc_question_confirm">指定されたユーザー</p>
                                            <div class="questionSample-users">
                                                @if (isset($selected_users))
                                                @foreach ($selected_users as $selected_user)
                                                <div class="icon-userName">
                                                    <div class="icon">
                                                        <img src="{{$selected_user->user_icon}}" alt="">
                                                    </div>
                                                    <p class="user-name">{{$selected_user->user_name}}</p>
                                                </div>
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