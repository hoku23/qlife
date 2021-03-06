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
                <div class="main-header post-main-header">
                    <div>
                        <h1 class="shown-posts">{{$user->user_name}}さんの質問</h1>
                    </div>
                    <div>
                        <a href="{{route('question.draft_question')}}">
                            <button class="draft-btn">下書き保存された質問を表示</button>
                        </a>
                    </div>
                </div>
                <section>
                    <div id="questionHome-container">
                        <div class="myQuestions">
                            <div class="question-lists">
                                @if (isset($newQuestions))
                                @foreach ($newQuestions as $question)
                                <div class="myQuestion question">
                                    <p class="question-title">{{$question->question_title}}</p>
                                    <form style="display:none" method="POST" action="{{route('question_detail')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" name="question_id" value="{{$question->question_id}}">
                                        <input type="submit" style="display:none">
                                    </form>
                                    <p class="question-label">困っていること</p>
                                    <div class="question-content">
                                        @if (isset($question->question_content))
                                            <div>
                                                <?php
                                                echo $question->question_content;
                                                ?>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="question-tags">
                                        @if (isset($question->tags))
                                            @foreach ($question->tags as $tag)
                                                <div class="tag">{{$tag}}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="question-answerNum">
                                        <p>回答<span>{{$question->answers}}件</span></p>
                                        <div class="question-date">
                                            <p>{{$question->question_date}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="question-link">
                            <ul>
                                <li><a href="{{route('question.create')}}">新規質問作成</a></li>
                                <li><a href="{{route('question_list_show')}}">質問一覧</a></li>
                            </ul>
                        </div>
                    </div>
                </section>
            </article>
        </main>
        
        <script text/javascript>
            let question_titles = document.getElementsByClassName('question-title');
            for (let i = 0; i < question_titles.length; i++) {
                if (question_titles[i]) {
                    question_titles[i].addEventListener('click', function(e) {
                        console.log(e.target.nextElementSibling.lastElementChild);
                        let submit = e.target.nextElementSibling.lastElementChild;
                        submit.click();
                        console.log('click');
                    })       
                }
            }
        </script>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>