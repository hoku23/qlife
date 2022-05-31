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
                        <li><a href="{{route('privacy.index')}}">プライバシーポリシー</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header shop_main_header">
                    <div id="shop_head">
                        <h1>商品検索</h1>
                    </div>
                    <div id="shop_search">
                        <form class="search" method="POST" action="{{route('shops.search')}}">
                            {{csrf_field()}}
                            <input class="keyword" type="text" placeholder="キーワードを入力" name="keyword">
                            <input id="genre_input" type="hidden" name="genre" value="0">
                            <input id="items_search_btn" class="keywordSearch-btn" type="submit" value="検索">
                        </form>
                        <button id="genre_search">ジャンル検索</button>
                    </div>
                </div>
                <section>
                    <div class="items_list">
                        @if (isset($items))
                        @foreach ($items as $item)
                        <div class="item">
                            <div class="item_img">
                                <img src='{{$item['img']}}'>
                            </div>
                            <div class="item_title">
                                <a href="{{$item['url']}}">{{$item['title']}}</a>
                            </div>
                            <p class="item_price">￥{{$item['price']}}</p>    
                        </div>
                        
                        @endforeach
                        @endif    
                    </div>
                    <div id="genre_list" class="genre_list">
                        <div class="genres">
                            <div id="genre_header" class="genre_header">
                                <p>ジャンルを１つ指定して<br>検索ボタンを押してください</p>
                            </div>
                            <div class="genre" title="100371">レディースファッション</div>
                            <div class="genre" title="551177">メンズファッション</div>
                            <div class="genre" title="100433">インナー・下着・ナイトウェア</div>
                            <div class="genre" title="216131">バッグ・小物・ブランド雑貨</div>
                            <div class="genre" title="558885">靴</div>
                            <div class="genre" title="558929">腕時計</div>
                            <div class="genre" title="216129">ジュエリー・アクセサリー</div>
                            <div class="genre" title="100533">キッズ・ベビー・マタニティ</div>
                            <div class="genre" title="566382">おもちゃ</div>
                            <div class="genre" title="101070">スポーツ・アウトドア</div>
                            <div class="genre" title="562637">家電</div>
                            <div class="genre" title="211742">TV・オーディオ・カメラ</div>
                            <div class="genre" title="100026">パソコン・周辺機器</div>
                            <div class="genre" title="564500">スマホ・タブレット</div>
                            <div class="genre" title="565004">光回線・モバイル通信</div>
                            <div class="genre" title="100227">食品</div>
                            <div class="genre" title="551167">スイーツ・お菓子</div>
                            <div class="genre" title="100316">水・ソフトドリンク</div>
                            <div class="genre" title="510915">ビール・洋酒</div>
                            <div class="genre" title="510901">日本酒・焼酎</div>
                            <div class="genre" title="100804">インテリア・寝具・収納</div>
                            <div class="genre" title="215783">日用品雑貨・文房具・手芸</div>
                            <div class="genre" title="558944">キッチン・食器・調理器具</div>
                            <div class="genre" title="200162">本・雑誌・コミック</div>
                            <div class="genre" title="101240">CD・DVD</div>
                            <div class="genre" title="101205">TVゲーム</div>
                            <div class="genre" title="101164">ホビー</div>
                            <div class="genre" title="112493">楽器・音響機器</div>
                            <div class="genre" title="101114">車・バイク</div>
                            <div class="genre" title="503190">車用品・バイク用品</div>
                            <div class="genre" title="100939">美容・コスメ・香水</div>
                            <div class="genre" title="100938">ダイエット・健康</div>
                            <div class="genre" title="551169">医薬品・コンタクト・介護</div>
                            <div class="genre" title="101213">ペット・ペットグッズ</div>
                            <div class="genre" title="100005">ガーデニング・DIY</div>
                            <div class="genre" title="101438">サービス・リフォーム</div>
                            <div class="genre" title="111427">住宅・不動産</div>
                            <div class="genre" title="101381">カタログギフト・チケット</div>
                            <div class="genre" title="100000">百貨店・総合通販・ギフト</div>
                        </div>
                    </div>
                </section>
            </article>
        </main>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>