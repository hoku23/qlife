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
                        <a href="{{route('posts.index')}}" class="hidden-posts"><h1>{{$user->user_name}}さんの投稿</h1></a>
                        <p>/</p>
                        <h1 class="shown-posts">保存済みの投稿</h1>
                    </div>
                    <div>
                        <a href="{{route('posts.draft_post')}}">
                            <button class="draft-btn">下書き保存された投稿を表示</button>
                        </a>
                    </div>
                </div>
                <section class="wrapper">
                    <div class="othersPosts-list">
                        @if (isset($posts))
                        @foreach ($posts as $post)
                        <div class="post othersPost">
                            <div class="post_date">
                                <p>{{$post->post_date}}</p>
                            </div>
                            <div class="icon-userName save_post_userName">
                                <input type="hidden" value="{{$post->user_id}}">
                                <div class="icon">
                                    <img src="{{$post->user_icon}}" alt="">
                                </div>
                                <p class="user-name">{{$post->user_name}}</p>
                            </div>
                            <p class="title save_post_title">{{$post->post_title}}</p>
                            <form style="display:none" method="POST" action="{{route('timeline.post_detail')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                <input type="submit" style="display:none">
                            </form>
                            <div class="thumnail">
                                <img src="{{$post->thumnail}}" alt="" style="width:100%">
                            </div>
                            <div class="tags">
                                @if (isset($post->tags))
                                    @foreach ($post->tags as $tag)
                                        <div class="tag">{{$tag}}</div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="reaction-img">
                                <div class="reaction">
                                    <p>{{$post->good}}グッド</p>
                                    <p>0コメント</p>
                                </div>
                                <div class="save-img">
                                    <img class="save_img" src="images/save_y.png" alt="">
                                    <form style="display:none" method="POST" action="{{route('save_store')}}">
                                        {{csrf_field()}}
                                        <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                        <input style="display:none" id="save_submit" type="submit" name="page" value="save_posts_page">
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <form style="display:none" method="POST" action="{{route('follow.user_page')}}">
                            {{csrf_field()}}
                            <input id="otherUser" type="hidden" name="otherUser">
                            <input id="otherUser_btn" type="submit" style="display:none;">
                        </form>
                    </div>
                </section>
            </article>
        </main>
        
        <script text/javascript>
            let save_post_titles = document.getElementsByClassName('save_post_title');
            for (let i = 0; i < save_post_titles.length; i++) {
                if (save_post_titles[i]) {
                    save_post_titles[i].addEventListener('click', function(e) {
                        console.log(e.target.nextElementSibling.lastElementChild);
                        let submit = e.target.nextElementSibling.lastElementChild;
                        submit.click();
                    })       
                }
            }
        
            let save_imgs = document.getElementsByClassName('save_img');
            for (let i = 0; i < save_imgs.length; i++) {
                save_imgs[i].addEventListener('click', function(e){
                    console.log(e.target.nextElementSibling.lastElementChild);
                    let submit = e.target.nextElementSibling.lastElementChild;
                    submit.click();
                })    
            }
            
            let save_post_userName = document.getElementsByClassName('save_post_userName');
            for (let i = 0; i < save_post_userName.length; i++) {
                if (save_post_userName[i]) {
                    save_post_userName[i].addEventListener('click', function(e){
                        console.log(save_post_userName[i].firstElementChild);
                        let otherUser_name = save_post_userName[i].firstElementChild.value;
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


        <script src="{{asset('js/index.js')}}"></script>
    </body>
</html>