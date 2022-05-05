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
                <div class="main-header postDetail-header">
                    <h2 id="question_title">
                        {{$question->question_title}}
                    </h2>
                    <form style="display:none" method="POST" action="/question_detail">
                        {{csrf_field()}}
                        <input type="hidden" name="question_id" value="{{$question->question_id}}">
                        <input type="submit" style="display:none">
                    </form>
                    @if (session('message'))
                    <div style="display:flex; align-items:center; color:red;">
                        <p>{{session('message')}}</p>
                    </div>
                    @endif
                </div>
                <section>
                   <div id="answerDetail-container">
                       <div class="answer-area">
                            <div class="answerDetails">
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
                                <div class="answerDetail-content">
                                    @if (isset($answer->answer_content))
                                        <div class="answer_content">
                                            <?php
                                            echo $answer->answer_content;
                                            ?>
                                        </div>
                                    @endif
                                </div>
                                @if ($question->user_id == $user->user_id)
                                <form method="POST" action="/bestAnswer_select">
                                    {{csrf_field()}}
                                    <input type="hidden" name="answer_id" value="{{$answer->answer_id}}">
                                    @if ($question->best_answer_id == $answer->answer_id)
                                    <input class="bestAnswer_btn" type="submit" value="ベストアンサーとして登録中">
                                    @else
                                    <input class="bestAnswer_btn" type="submit" value="ベストアンサーとして登録">
                                    @endif
                                </form>
                                @endif
                                <div class="answer-date">
                                    <p>{{$answer->answer_date}}</p>
                                </div>
                                @if ($answer->user_id == $user->user_id)
                                <form method="POST" action="/answer_delete" onsubmit="if(confirm('本当に削除してよろしいですか？')) { return true } else {return false };">
                                    {{csrf_field()}}
                                    <input type="hidden" name="answer_id" value="{{$answer->answer_id}}">
                                    <button class="delete_btn" type="submit">回答を削除する</button>
                                </form>
                                @endif
                            </div>
                       </div>
                        <div class="reaction-area">
                            <div class="comment-form-box">
                                <div class="commentForm-title">
                                    <div class="comment-img">
                                        <img src="images/comment.png" alt="">
                                    </div>
                                    <p>コメント</p>
                                </div>
                                <form method="POST" action="/answer_comment_store">
                                    {{csrf_field()}}
                                    <textarea class="comment-form" name="comment" id="" placeholder="コメントを入力"></textarea>
                                    <input type="hidden" name="answer_id" value="{{$answer->answer_id}}">
                                    <input class="comment-btn" type="submit" value="送信">
                                </form>
                            </div>
                            <div class="comment-lists">
                                <div class="answer-comment-num">
                                    <p>コメント<span>{{$comment_count}}件</span></p>
                                </div>
                                <div class="comment-list">
                                    <div class="comment-contents">
                                        @if (isset($new_parent_comments))
                                        @foreach ($new_parent_comments as $parent_comment)
                                        <div class="comment">
                                            <div class="comment-icon-userName">
                                                <div class="icon">
                                                    <img src="{{$parent_comment->user_icon}}" alt="">
                                                </div>
                                                <p class="user-name">{{$parent_comment->user_name}}</p>
                                            </div>
                                            <div class="comment-text">
                                                <p>{{$parent_comment->content}}</p>
                                            </div>
                                            <div class="reply">
                                                <p>返信する</p>
                                            </div>
                                            <form class="reply_form hidden_form" method="POST" action="/answer_reply_store">
                                                {{csrf_field()}}
                                                <textarea class="comment-form" name="comment" id="" placeholder="コメントを入力"></textarea>
                                                <input type="hidden" name="comment_path" value="{{$parent_comment->path}}">
                                                <input type="hidden" name="answer_id" value="{{$answer->answer_id}}">
                                                <input class="comment-btn" type="submit" value="送信">
                                            </form>
                                            <div class="show-reply-btn">
                                                <div class="line-img">
                                                    <img src="images/line.png" alt="">
                                                </div>
                                                <p class="show_reply_btn">返信を表示</p>
                                            </div>
                                            <div class="reply-comment-contents hidden-reply-comment">
                                                @if (isset($parent_comment->reply))
                                                @foreach ($parent_comment->reply as $reply)
                                                <div class="comment">
                                                    <div class="comment-icon-userName">
                                                        <div class="icon">
                                                            <img src="{{$reply->user_icon}}" alt="">
                                                        </div>
                                                        <p class="user-name">{{$reply->user_name}}</p>
                                                    </div>
                                                    <div class="comment-text">
                                                        <p>>>{{$reply->reply_user_name}}</p>
                                                        <p>{{$reply->content}}</p>
                                                    </div>
                                                    <div class="reply">
                                                        <p>返信する</p>
                                                    </div>
                                                    <form class="reply_form hidden_form" method="POST" action="/answer_reply_store">
                                                        {{csrf_field()}}
                                                        <textarea class="comment-form" name="comment" id="" placeholder="コメントを入力"></textarea>
                                                        <input type="hidden" name="comment_path" value="{{$reply->path}}">
                                                        <input type="hidden" name="answer_id" value="{{$answer->answer_id}}">
                                                        <input class="comment-btn" type="submit" value="送信">
                                                    </form>
                                                </div>
                                                @endforeach
                                                @endif
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
            
            let question_title = document.getElementById('question_title');
            if (question_title) {
                question_title.addEventListener('click', function(e) {
                    console.log(e.target.nextElementSibling.lastElementChild);
                    let submit = e.target.nextElementSibling.lastElementChild;
                    submit.click();
                })       
            }

        </script>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>