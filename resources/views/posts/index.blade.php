<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                            <p class="user-name">{{ $user->user_name }}</p>
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
                <div class="main-header post-main-header">
                    <div>
                        <h1 class="shown-posts">{{$user->user_name}}さんの投稿</h1>
                        <p>/</p>
                        <a href="{{route('posts.save_post_show')}}" class="hidden-posts"><h1>保存済みの投稿</h1></a>
                    </div>
                    <div>
                        <a href="{{route('posts.draft_post')}}">
                            <button class="draft-btn">下書き保存された投稿を表示</button>
                        </a>
                    </div>
                </div>
                <section class="wrapper">
                    <div class="posts-list">
                        @if (isset($newPosts))
                            @foreach ($newPosts as $post)
                            <div class="post myPost">
                                <p class="title myPost_title">{{$post->post_title}}</p>
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
                                <div class="reaction-to-myPost">
                                    <p>{{$post->good}}グッド</p>
                                    <p>0コメント</p>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </section>
            </article>
        </main>
        
        <script text/javascript>
            let myPost_titles = document.getElementsByClassName('myPost_title');
            for (let i = 0; i < myPost_titles.length; i++) {
                if (myPost_titles[i]) {
                    myPost_titles[i].addEventListener('click', function(e) {
                        console.log(e.target.nextElementSibling.lastElementChild);
                        let submit = e.target.nextElementSibling.lastElementChild;
                        submit.click();
                    })       
                }
            }
        
        </script>

        <script src="{{ asset('js/index.js') }}" charset="utf-8"></script>
    </body>
</html>