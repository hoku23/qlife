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
                            <img src="" alt="">
                        </div>
                            <p class="user-name">{{$user->user_name}}</p>
                    </div>
                    <a href="login.html">ログアウト</a>
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
                        <li><a href="{{ route('posts.index') }}">投稿一覧</a></li>
                        <li><a href="question.html">質問ホーム</a></li>
                        <li><a href="setting.html">設定</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1>新規投稿作成</h1>
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="other-step"><a href="{{ route('posts.create')}}">本文作成</a></li>
                                <li class="show-step"><a href="{{ route('posts.create_title')}}">タイトル作成<br>サムネイル指定</a></li>
                                <li class="other-step"><a href="createNewPostTags.html">タグ選択</a></li>
                                <li class="other-step"><a href="createNewPostCheck.html">内容確認</a></li>
                                <li class="other-step">投稿完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div id="create-box-left" class="create-box">
                                <div>
                                    <div class="createBox-header">
                                        <div class="text-heading">
                                            <p>タイトル</p>
                                            <div class="store-btn">
                                                <button>保存する</button>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="createPost-form">
                                        <textarea name="" placeholder="タイトルを入力"></textarea>
                                    </form>
                                </div>
                            </div>
                            <div id="create-box-right" class="create-box">
                                <div class="createBox-header">
                                    <div class="text-heading">
                                        <div class="thumnail-select">
                                            <p>サムネイル</p>
                                            <button id="fileSelect" onchange="addText3();" class="thumnailImg-select">
                                                <div class="imgSelect-icon">
                                                    <img src="{{asset('images/picture.png')}}" alt="画像ロゴ">
                                                </div>
                                                <p>画像選択</p>
                                            </button>
                                        </div>
                                        <div class="store-btn">
                                            <button>保存する</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-content">
                                    <div class="thumnail-up"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </main>

        <script src="js/index.js" charset="utf-8"></script>
    </body>
</html>