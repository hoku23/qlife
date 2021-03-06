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
                <div class="main-header postDetail-header">
                    <h2>
                        {{$post->post_title}}
                    </h2>
                    @if (session('message'))
                    <div style="display:flex; align-items:center; color:red;">
                        <p>{{session('message')}}</p>
                    </div>
                    @endif
                </div>
                <section>
                   <div id="postDetail-container">
                       <div class="posts-area">
                            <div class="postDetails">
                                <div class="postDetails-icon-userName post_userName">
                                    <input type="hidden" value="{{$post->user_id}}">
                                    <div class="icon">
                                        <img src="{{$post->user_icon}}" alt="">
                                    </div>
                                    <p class="user-name">{{$post->user_name}}</p>
                                </div>
                                <div class="postDetail-textBox">
                                    <p class="post-text">
                                        @if (isset($post->post_content))
                                        <div>
                                            <?php
                                            echo $post->post_content;
                                            ?>
                                        </div>
                                    @endif
                                    </p>
                                </div>
                                <div class="post-detail-tags">
                                    @if (isset($post->tags))
                                        @foreach ($post->tags as $tag)
                                            <div class="tag">{{$tag}}</div>
                                        @endforeach
                                    @endif
                                </div>
                                <div>
                                    <div class="reaction">
                                        <p>{{$good_num}}グッド</p>
                                    </div>
                                </div>
                                @if ($post->user_id == $user->user_id)
                                <form method="POST" action="{{route('posts.post_delete')}}" onsubmit="if(confirm('本当に削除してよろしいですか？')) { return true } else {return false };">
                                    {{csrf_field()}}
                                    <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                    <button class="post_delete_btn" type="submit">投稿を削除する</button>
                                </form>
                                @endif
                            </div>
                       </div>
                       <div class="reaction-area">
                            <div class="good-save">
                                <div class="goodSave-box">
                                    <div class="goodSave-img">
                                        @if ($post->good == 1)
                                        <img id="good_img" src="images/good_y.png" alt="">
                                        @elseif ($post->good == 0)
                                        <img id="good_img" src="images/good_w.png" alt="">
                                        @endif
                                        <form style="display:none" method="POST" action="{{route('good_store')}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                            <input style="display:none" id="good_submit" type="submit" name="page" value="detail_post_page">
                                        </form>
                                    </div>
                                    <div class="goodSave-img">
                                        @if ($post->save == 1)
                                        <img id="save_img" src="images/save_y.png" alt="">
                                        @elseif ($post->save == 0)
                                        <img id="save_img" src="images/save_w.png" alt="">
                                        @endif
                                        <form style="display:none" method="POST" action="{{route('save_store')}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                            <input style="display:none" id="save_submit" type="submit" name="page" value="detail_post_page">
                                        </form>
                                    </div>
                                </div>
                                <a id="timeline_link" href="{{route('timeline.index')}}">
                                    <button class="backTimeline-btn">タイムラインに戻る</button>
                                </a>
                            </div>
                            <div class="comment-form-box">
                                <div class="commentForm-title">
                                    <div class="comment-img">
                                        <img src="images/comment.png" alt="">
                                    </div>
                                    <p>コメント</p>
                                </div>
                                <form method="POST" action="{{route('comment_store')}}">
                                    {{csrf_field()}}
                                    <textarea class="comment-form" name="comment" id="" placeholder="コメントを入力"></textarea>
                                    <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                    <input class="comment-btn" type="submit" value="送信">
                                </form>
                                <form style="display:none" method="POST" action="{{route('follow.user_page')}}">
                                    {{csrf_field()}}
                                    <input id="otherUser" type="hidden" name="otherUser">
                                    <input id="otherUser_btn" type="submit" style="display:none;">
                                </form>
                            </div>
                            <div class="comment-lists">
                                <div class="comment-num">
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
                                            <form class="reply_form hidden_form" method="POST" action="{{route('reply_store')}}">
                                                {{csrf_field()}}
                                                <textarea class="comment-form" name="comment" id="" placeholder="コメントを入力"></textarea>
                                                <input type="hidden" name="comment_path" value="{{$parent_comment->path}}">
                                                <input type="hidden" name="post_id" value="{{$post->post_id}}">
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
                                                    <form class="reply_form hidden_form" method="POST" action="{{route('reply_store')}}">
                                                        {{csrf_field()}}
                                                        <textarea class="comment-form" name="comment" id="" placeholder="コメントを入力"></textarea>
                                                        <input type="hidden" name="comment_path" value="{{$reply->path}}">
                                                        <input type="hidden" name="post_id" value="{{$post->post_id}}">
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
            let good_img = document.getElementById('good_img');
            good_img.addEventListener('click', function(e){
                let good_submit = document.getElementById('good_submit');
                console.log(good_submit);
                good_submit.click();
            })
            
            let save_img = document.getElementById('save_img');
            save_img.addEventListener('click', function(e){
                let save_submit = document.getElementById('save_submit');
                console.log(save_submit);
                save_submit.click();
            })
            
            let post_userName = document.getElementsByClassName('post_userName');
            for (let i = 0; i < post_userName.length; i++) {
                if (post_userName[i]) {
                    post_userName[i].addEventListener('click', function(e){
                        console.log(post_userName[i].firstElementChild);
                        let otherUser_name = post_userName[i].firstElementChild.value;
                        console.log(otherUser_name);
                        let otherUser = document.getElementById('otherUser');
                        otherUser.value = otherUser_name;
                        console.log(otherUser.value);
                        let otherUser_btn = document.getElementById('otherUser_btn');
                        otherUser_btn.click();
                    })    
                }
            }
        </script>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>