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
                <div class="main-header postDetail-header">
                    <h2>
                        {{$question->question_title}}
                    </h2>
                </div>
                <section>
                   <div id="questionDetail-container">
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
                       <div class="answers-area">
                            <div class="answer-lists">
                                <div class="answers-list-header">
                                    <p>回答<span>{{$answers_num}}件</span></p>
                                    <div class="createAnswer-btn-box">
                                        <button id="createAnswer_btn" class="createAnswer-btn">回答を作成する</button>
                                        <form style="display:none" method="POST" action="/create_answer">
                                            {{csrf_field()}}
                                            <input type="hidden" name="question_id" value="{{$question->question_id}}">
                                            <input type="submit" style="display:none">
                                        </form>
                                    </div>
                                </div>
                                <div class="answers-list">
                                    <div class="answersList-contents">
                                        @if (isset($answers))
                                        @foreach ($answers as $answer)
                                        <div class="answer">
                                            <div class="icon-userName">
                                                <div class="icon">
                                                    <img src="{{$answer->user_icon}}" alt="">
                                                </div>
                                                <p class="user-name">{{$answer->user_name}}</p>
                                                @if ($question->best_answer_id == $answer->answer_id)
                                                <div class="bestAnswer-flag bestAnswer-on">
                                                    <img src="images/bestAnswer.png" alt="">
                                                </div>
                                                @endif
                                            </div>
                                            <div class="answer-content">
                                                @if (isset($answer->answer_content))
                                                    <div class="answer_content">
                                                        <?php
                                                        echo $answer->answer_content;
                                                        ?>
                                                    </div>
                                                    <form style="display:none" method="POST" action="/answer_detail">
                                                        {{csrf_field()}}
                                                        <input type="hidden" name="answer_id" value="{{$answer->answer_id}}">
                                                        <input type="submit" style="display:none">
                                                    </form>
                                                @endif
                                            </div>
                                            
                                            <div class="answer_date_and_comment">
                                                <p>コメント<span>{{$answer->comment}}件</span></p>
                                                <p class="answer_date">{{$answer->answer_date}}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                       </div>
                   </div>
                </section>
            </article>
        </main>
        
        <script text/javascript>
            
            let answer_contents = document.getElementsByClassName('answer_content');
            for (let i = 0; i < answer_contents.length; i++) {
                if (answer_contents[i]) {
                    answer_contents[i].addEventListener('click', function(e) {
                        console.log(e.target.nextElementSibling.lastElementChild);
                        let submit = e.target.nextElementSibling.lastElementChild;
                        submit.click();
                    })       
                }
            }
            
            

        </script>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>