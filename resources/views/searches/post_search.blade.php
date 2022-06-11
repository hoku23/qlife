<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <div class="main-header timeline-main-header">
                    <h1 id="pc_search_result">”{{$keyword}}”の検索結果 {{$posts_num}}件</h1>
                    <h1 id="phone_search_result">検索結果 {{$posts_num}}件</h1>
                    <div id="search_btn">
                        <p>投稿を探す</p>
                    </div>
                </div>
                <section>
                   <div id="timeline-container">
                        <div class="posts-area">
                            @if ($posts_num == 0 ) 
                            <div style="text-align:center">
                                <h2>お探しの投稿は見つかりません</h2>
                            </div>
                            @endif
                            <div class="timelinePosts-list">
                                @if (isset($posts))
                                @foreach ($posts as $post)
                                <div class="post othersPost">
                                    <div class="post_date">
                                        <p>{{$post->post_date}}</p>
                                    </div>
                                    <div class="icon-userName">
                                        <div class="icon">
                                            <img src="{{$post->user_icon}}" alt="">
                                        </div>
                                        <p class="user-name">{{$post->user_name}}</p>
                                    </div>
                                    <p class="title timeline_post_title">{{$post->post_title}}</p>
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
                                            <p>{{$post->comment}}コメント</p>
                                        </div>
                                        <div class="save-img">
                                            @if ($post->save == 1)
                                            <img class="save_img" src="images/save_y.png" alt="">
                                            @elseif ($post->save == 0)
                                            <img class="save_img" src="images/save_w.png" alt="">
                                            @endif
                                            <form style="display:none" method="POST" action="{{route('save_store')}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                            <input type="hidden" name="keyword" value="{{$keyword}}">
                                            <input type="hidden" name="tag_flag" value="@if(isset($tag_flag)){{$tag_flag}}@endif">
                                            <input style="display:none" id="save_submit" type="submit" name="page" value="search_page">
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                       <div class="search-area">
                            <div class="keyword-search">
                                <form class="search" method="POST" action="{{route('search.post_search')}}">
                                    {{csrf_field()}}
                                    <input class="keyword" type="text" name="keyword" placeholder="キーワードを入力">
                                    <input class="keywordSearch-btn" type="submit" value="検索">
                                </form>
                            </div>
                            <div class="tags-search">
                                <div class="searchTags-box">
                                    <p>タグを選択してください</p>
                                    <div class="search-tags">
                                        <div class="search-tag">掃除</div>
                                        <div class="search-tag">洗濯</div>
                                        <div class="search-tag">料理</div>
                                        <div class="search-tag">収納</div>
                                        <div class="search-tag">育児</div>
                                        <div class="search-tag">インテリア</div>
                                        <div class="search-tag">エクステリア</div>
                                        <div class="search-tag">家電</div>
                                        <div class="search-tag">家具</div>
                                        <div class="search-tag">一人暮らし</div>
                                        <div class="search-tag">初心者</div>
                                        <div class="search-tag">引っ越し</div>
                                        <div class="search-tag">簡単</div>
                                        <div class="search-tag">時短</div>
                                        <div class="search-tag">趣味</div>
                                        <div class="search-tag">便利グッズ</div>
                                        <div class="search-tag">オシャレ</div>
                                        <div class="search-tag">男性</div>
                                        <div class="search-tag">女性</div>
                                        <div class="search-tag">男の子</div>
                                        <div class="search-tag">女の子</div>
                                        <div class="search-tag">乳幼児</div>
                                        <div class="search-tag">小学生</div>
                                        <div class="search-tag">中学生</div>
                                        <div class="search-tag">高校生</div>
                                        <div class="search-tag">大学生</div>
                                        <div class="search-tag">社会人</div>
                                        <div class="search-tag">シェアハウス</div>
                                        <div class="search-tag">カップル</div>
                                        <div class="search-tag">お母さん</div>
                                        <div class="search-tag">お父さん</div>
                                        <div class="search-tag">子供</div>
                                        <div class="search-tag">結婚</div>
                                        <div class="search-tag">同棲</div>
                                    </div>
                                    <form class="search timelineSearch-btn">
                                        <input id="submit" class="tagSearch-btn" type="button" value="検索する">
                                        <form method="POST" action="{{route('search.post_search')}}" style="display:none">
                                            {{csrf_field()}}
                                            <input id="next" type="submit" style="display:none">
                                        </form>
                                    </form>
                                </div>
                            </div>
                       </div>
                   </div>
                </section>
            </article>
        </main>
        
        <script text/javascript>
        
            let submit = document.getElementById('submit');
            submit.addEventListener('click', submitData, false);
            
            function submitData() {
                let selectedTags = document.getElementsByClassName('search-on');
                let selectedTagsArray = [];
                for (let i = 0; i < selectedTags.length; i++) {
                    console.log(selectedTags[i].innerHTML);
                    selectedTagsArray.push(selectedTags[i].innerHTML);
                }
                console.log(selectedTagsArray);
                
                
                const asynchronousFunc = (value) => {
                    const url = '{{route('search.search_tag_store')}}';
               　return　fetch(url, {
                    method: 'POST',
                     headers: {
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                       'Content-Type': 'application/json'
                     },
                     body: JSON.stringify(selectedTagsArray)
                   })
                     .then(response => response.json()) 
                     .then(res => {
                         return res;
                     })
                     .catch(error => {
                         console.log(error); 
                     });
                }
                
                const waitAsynchronousFunc = (async() => {
                    const result = await asynchronousFunc()
                    console.log(result)
                    let next = document.getElementById('next');
                    next.click();
                })();
            };
            
            let timeline_post_titles = document.getElementsByClassName('timeline_post_title');
            for (let i = 0; i < timeline_post_titles.length; i++) {
                if (timeline_post_titles[i]) {
                    timeline_post_titles[i].addEventListener('click', function(e) {
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
            
            let search_btn = document.getElementById('search_btn');
            search_btn.addEventListener('click', function(){
                let search_area = document.getElementsByClassName('search-area');
                if (search_area[0].classList.contains('search-area-show')) {
                    search_area[0].classList.remove('search-area-show');
                    search_btn.lastElementChild.textContent = '投稿を探す';
                } else {
                    search_area[0].classList.add('search-area-show');
                    search_btn.lastElementChild.textContent = '一覧に戻る';
                }
            })

        </script>


        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>