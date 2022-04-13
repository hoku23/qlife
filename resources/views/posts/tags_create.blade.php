<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <p class="user-name">ユーザーネーム</p>
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
                        <li><a href="createNewPost.html">新規投稿作成</a></li>
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
                    <h1>新規投稿作成</h1>
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="other-step"><a href="{{route('posts.create')}}">本文作成</a></li>
                                <li class="other-step"><a href="{{route('posts.create_title')}}l">タイトル作成<br>サムネイル指定</a></li>
                                <li class="show-step"><a href="{{route('posts.create_tags')}}">タグ選択</a></li>
                                <li class="other-step"><a href="createNewPostCheck.html">内容確認</a></li>
                                <li class="other-step">投稿完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div class="createPostTags-container">
                                <div class="setting-favoriteTags">
                                    <p>タグを選択してください</p>
                                    <div class="post-tags">
                                        <div class="post-tag">掃除</div>
                                        <div class="post-tag">洗濯</div>
                                        <div class="post-tag">料理</div>
                                        <div class="post-tag">収納</div>
                                        <div class="post-tag">育児</div>
                                        <div class="post-tag">インテリア</div>
                                        <div class="post-tag">エクステリア</div>
                                        <div class="post-tag">家電</div>
                                        <div class="post-tag">家具</div>
                                        <div class="post-tag">一人暮らし</div>
                                        <div class="post-tag">初心者</div>
                                        <div class="post-tag">引っ越し</div>
                                        <div class="post-tag">簡単</div>
                                        <div class="post-tag">時短</div>
                                        <div class="post-tag">趣味</div>
                                        <div class="post-tag">便利グッズ</div>
                                        <div class="post-tag">オシャレ</div>
                                        <div class="post-tag">男性</div>
                                        <div class="post-tag">女性</div>
                                        <div class="post-tag">男の子</div>
                                        <div class="post-tag">女の子</div>
                                        <div class="post-tag">乳幼児</div>
                                        <div class="post-tag">小学生</div>
                                        <div class="post-tag">中学生</div>
                                        <div class="post-tag">高校生</div>
                                        <div class="post-tag">大学生</div>
                                        <div class="post-tag">社会人</div>
                                        <div class="post-tag">シェアハウス</div>
                                        <div class="post-tag">カップル</div>
                                        <div class="post-tag">お母さん</div>
                                        <div class="post-tag">お父さん</div>
                                        <div class="post-tag">子供</div>
                                        <div class="post-tag">結婚</div>
                                        <div class="post-tag">同棲</div>
                                    </div>
                                    <div class="store-btn createPostTags-btn">
                                        <button id="submit">保存する</button>
                                        <a id="next" href=" {{route('posts.confirm')}}"></a>
                                    </div>
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
                let selectedTags = document.getElementsByClassName('tag-on');
                let selectedTagsArray = [];
                for (let i = 0; i < selectedTags.length; i++) {
                    console.log(selectedTags[i].innerHTML);
                    selectedTagsArray.push(selectedTags[i].innerHTML);
                }
                console.log(selectedTagsArray);
                
                
                const asynchronousFunc = (value) => {
                    const url = '/posts/store_tags';
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

        </script>

        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>