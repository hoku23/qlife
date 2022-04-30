<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body>
        <header>
            <div class="logo">
                <a href="home.html"><img src="{{ asset('images/logo.png') }}" alt="ロゴ"></a>
            </div>
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
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1 class="shown-posts">{{$otherUser->user_name}}さんの投稿</h1>
                    <div class="follow-btn-container">
                        @if (isset($follow))
                        <a id="follow-btn">フォロー中</a>
                        @else
                        <a id="follow-btn">フォローする</a>
                        @endif
                        <form method="POST" action="/user_follow">
                            {{csrf_field()}}
                            <input id="follow_user_id" type="hidden" name="follow_user_id" value="{{$otherUser->user_id}}">
                            <input id="follow_user" type="submit" name="page" value="otherUser_page" style="display:none"> 
                        </form>
                    </div>
                </div>
                <section class="wrapper">
                    <div class="posts-list">
                        @if (isset($newPosts))
                            @foreach ($newPosts as $post)
                            <div class="post myPost">
                                <p class="title">{{$post->post_title}}</p>
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
                                        <p>0グッド</p>
                                        <p>0コメント</p>
                                    </div>
                                    <div class="save-img">
                                        <img src="images/save_w.png" alt="">
                                        <div class="post_id" style="display:none">{{$post->post_id}}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </section>
            </article>
        </main>

        <script src="{{ asset('js/index.js') }}" charset="utf-8"></script>
    </body>
</html>