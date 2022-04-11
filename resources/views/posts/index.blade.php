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
                            <img src="" alt="">
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
                        <li><a href="timeLine.html">タイムライン</a></li>
                        <li><a href="{{ route('posts.create')}}">新規投稿作成</a></li>
                        <li><a href="followList.html">フォロー/フォロワー一覧</a></li>
                        <li><a href="home.html">投稿一覧</a></li>
                        <li><a href="question.html">質問ホーム</a></li>
                        <li><a href="setting.html">設定</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1 class="shown-posts">ユーザーネームさんの投稿</h1>
                    <span>/</span>
                    <a href="savePostsList.html" class="hidden-posts"><h1>保存済みの投稿</h1></a>
                </div>
                <section class="wrapper">
                    <div class="posts-list">
                        <div class="post myPost">
                            <p class="title">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</p>
                            <div class="thumnail">
                                <img src="" alt="">
                            </div>
                            <div class="tags">
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ3</div>
                            </div>
                            <div class="reaction">
                                <p>0グッド</p>
                                <p>0コメント</p>
                            </div>
                        </div>
                        <div class="post myPost">
                            <p class="title">タイトル</p>
                            <div class="thumnail">
                                <img src="" alt="">
                            </div>
                            <div class="tags">
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ3</div>
                                <div class="tag">タグ3</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ3</div>
                                <div class="tag">タグ3</div>
                            </div>
                            <div class="reaction">
                                <p>0グッド</p>
                                <p>0コメント</p>
                            </div>
                        </div>
                        <div class="post myPost">
                            <p class="title">タイトル</p>
                            <div class="thumnail">
                                <img src="" alt="">
                            </div>
                            <div class="tags">
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ3</div>
                            </div>
                            <div class="reaction">
                                <p>0グッド</p>
                                <p>0コメント</p>
                            </div>
                        </div>
                        <div class="post myPost">
                            <p class="title">タイトル</p>
                            <div class="thumnail">
                                <img src="" alt="">
                            </div>
                            <div class="tags">
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ3</div>
                            </div>
                            <div class="reaction">
                                <p>0グッド</p>
                                <p>0コメント</p>
                            </div>
                        </div>
                        <div class="post myPost">
                            <p class="title">タイトル</p>
                            <div class="thumnail">
                                <img src="" alt="">
                            </div>
                            <div class="tags">
                                <div class="tag">タグ1</div>
                                <div class="tag">タグ2</div>
                                <div class="tag">タグ3</div>
                            </div>
                            <div class="reaction">
                                <p>0グッド</p>
                                <p>0コメント</p>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </main>

        <script src="{{ asset('js/index.js') }}" charset="utf-8"></script>
    </body>
</html>