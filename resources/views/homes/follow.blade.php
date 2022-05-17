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
                        <li><a href="{{route('shops.index')}}">商品検索</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div id="follow-header" class="main-header">
                    <div class="follow">
                        <h1>フォロー<span>{{$follow_num}}人</span></h1>
                    </div>
                    <div class="follower">
                        <h1>フォロワー<span>{{$follower_num}}人</span></h1>
                    </div>
                    <div class="user_search_header">
                        <form class="search" method="POST" action="{{route('follow.user_search')}}">
                            {{csrf_field()}}
                            <input class="userSearch_form" type="text" placeholder="ユーザーネームを入力" name="user_word">
                            <input class="userSearch-btn" type="submit" value="検索">
                        </form>
                    </div>
                </div>
                <div id="followList">
                    <div id="follow-list" class="follow-follower-list">
                        @if (isset($followUsers))
                            @foreach ($followUsers as $followUser)
                                <div class="follow-user">
                                    <a class="to_user_page_from_follow">
                                        <div class="icon-userName">
                                            <div class="icon">
                                                <img src="{{$followUser->user_icon}}" alt="">
                                            </div>
                                            <p class="user-name">{{$followUser->user_name}}</p>
                                            <form method="POST" action="/follow_remove" style="display:none">
                                                {{csrf_field()}}
                                                <input class="follow_user_id" type="hidden" name="follow_user_id" value="{{$followUser->user_id}}">
                                                <input class="follow_user" type="submit" name="page" value="follow_page" style="display:none"> 
                                            </form>
                                        </div>
                                    </a>
                                    <a class="follow-cancel">フォロー解除</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div id="follower-list" class="follow-follower-list">
                        @if (isset($newFollowers))
                            @foreach ($newFollowers as $follower)
                                <div class="follow-user">
                                    <a class="to_user_page">
                                        <div class="icon-userName">
                                            <div class="icon">
                                                <img src="{{$follower->user_icon}}" alt="">
                                            </div>
                                            <p class="user-name">{{$follower->user_name}}</p>
                                            <form method="POST" action="{{route('follow.user_follow')}}" style="display:none">
                                                {{csrf_field()}}
                                                <input class="follow_user_id" type="hidden" name="follow_user_id" value="{{$follower->user_id}}">
                                                <input class="follow_user" type="submit" name="page" value="follow_page" style="display:none"> 
                                            </form>
                                        </div>
                                    </a>
                                    @if ($follower->follow_count == 1)
                                        <a class="follow-btn">フォロー中</a>
                                    @elseif ($follower->follow_count == 0)
                                        <a class="follow-btn">フォローする</a>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="user_search">
                        @if (session('users'))
                            @foreach (session('users') as $users)
                                <a class="user_page_link">
                                    <div class="icon-userName">
                                        <div class="icon">
                                            <img src="{{$users->user_icon}}" alt="">
                                        </div>
                                        <p class="user-name">{{$users->user_name}}</p>
                                        <p class="user-id" style="display:none">{{$users->user_id}}</p>
                                    </div>
                                </a>
                            @endforeach    
                        @endif
                    </div>
                    <form method="POST" action="/user_page">
                        {{csrf_field()}}
                        <input id="otherUser" type="hidden" name="otherUser">
                        <input id="otherUser_btn" type="submit" style="display:none;">
                    </form>
                </div>
                <div id="phone_followList">
                    <div id="follow-list" class="follow-follower-list">
                        <div class="follow">
                            <h1>フォロー<span>{{$follow_num}}人</span></h1>
                        </div>
                        @if (isset($followUsers))
                            @foreach ($followUsers as $followUser)
                                <div class="follow-user">
                                    <a class="to_user_page_from_follow">
                                        <div class="icon-userName">
                                            <div class="icon">
                                                <img src="{{$followUser->user_icon}}" alt="">
                                            </div>
                                            <p class="user-name">{{$followUser->user_name}}</p>
                                            <form method="POST" action="/follow_remove" style="display:none">
                                                {{csrf_field()}}
                                                <input class="follow_user_id" type="hidden" name="follow_user_id" value="{{$followUser->user_id}}">
                                                <input class="follow_user" type="submit" name="page" value="follow_page" style="display:none"> 
                                            </form>
                                        </div>
                                    </a>
                                    <a class="follow-cancel">フォロー解除</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div id="follower-list" class="follow-follower-list">
                        <div class="follower">
                            <h1>フォロワー<span>{{$follower_num}}人</span></h1>
                        </div>
                        @if (isset($newFollowers))
                            @foreach ($newFollowers as $follower)
                                <div class="follow-user">
                                    <a class="to_user_page">
                                        <div class="icon-userName">
                                            <div class="icon">
                                                <img src="{{$follower->user_icon}}" alt="">
                                            </div>
                                            <p class="user-name">{{$follower->user_name}}</p>
                                            <form method="POST" action="/user_follow" style="display:none">
                                                {{csrf_field()}}
                                                <input class="follow_user_id" type="hidden" name="follow_user_id" value="{{$follower->user_id}}">
                                                <input class="follow_user" type="submit" name="page" value="follow_page" style="display:none"> 
                                            </form>
                                        </div>
                                    </a>
                                    @if ($follower->follow_count == 1)
                                        <a class="follow-btn">フォロー中</a>
                                    @elseif ($follower->follow_count == 0)
                                        <a class="follow-btn">フォローする</a>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="user_search">
                        <div class="user_search_header">
                            <form class="user_search_form" method="POST" action="/user_search">
                                {{csrf_field()}}
                                <input class="userSearch_form" type="text" placeholder="ユーザーネームを入力" name="user_word">
                                <input class="userSearch-btn" type="submit" value="検索">
                            </form>
                        </div>
                        @if (session('users'))
                            @foreach (session('users') as $users)
                                <a class="user_page_link">
                                    <div class="icon-userName">
                                        <div class="icon">
                                            <img src="{{$users->user_icon}}" alt="">
                                        </div>
                                        <p class="user-name">{{$users->user_name}}</p>
                                        <p class="user-id" style="display:none">{{$users->user_id}}</p>
                                    </div>
                                </a>
                            @endforeach    
                        @endif
                    </div>
                    <form method="POST" action="/user_page">
                        {{csrf_field()}}
                        <input id="otherUser" type="hidden" name="otherUser">
                        <input id="otherUser_btn" type="submit" style="display:none;">
                    </form>
                </div>
            </article>
        </main>

        <script src="{{asset('js/index.js')}}"></script>
    </body>
</html>