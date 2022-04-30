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
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1>設定</h1>
                    @if (session('message'))
                    <div style="display:flex; align-items:center; color:red;">
                        <p>{{session('message')}}</p>
                    </div>
                    @endif
                </div>
                <section class="wrapper">
                    <div id="setting">
                        <ul class="tabs">
                            <li class="tab"><a href="{{route('settingUser.index')}}">会員情報設定</a></li>
                            <li class="tab active-tab"><a href="{{route('settingFavoriteTag.index')}}">お気に入りタグ設定</a></li>
                            <li class="tab"><a href="{{route('settingQuestionReceive.index')}}">質問受け取り設定</a></li>
                            <li class="tab"><a href="{{route('settingNotice.index')}}">通知設定</a></li>
                        </ul>
                        <div class="setting-contents">
                            <div class="setting-content show-content">
                                <div class="setting-favoriteTags">
                                    <p>タグを選択してください</p>
                                    <div class="favorite-tags">
                                        <div class="fav-tag">掃除</div>
                                        <div class="fav-tag">洗濯</div>
                                        <div class="fav-tag">料理</div>
                                        <div class="fav-tag">収納</div>
                                        <div class="fav-tag">育児</div>
                                        <div class="fav-tag">インテリア</div>
                                        <div class="fav-tag">エクステリア</div>
                                        <div class="fav-tag">家電</div>
                                        <div class="fav-tag">家事</div>
                                        <div class="fav-tag">一人暮らし</div>
                                        <div class="fav-tag">初心者</div>
                                        <div class="fav-tag">引っ越し</div>
                                        <div class="fav-tag">簡単</div>
                                        <div class="fav-tag">時短</div>
                                        <div class="fav-tag">趣味</div>
                                        <div class="fav-tag">便利グッズ</div>
                                        <div class="fav-tag">オシャレ</div>
                                        <div class="fav-tag">男性</div>
                                        <div class="fav-tag">女性</div>
                                        <div class="fav-tag">男の子</div>
                                        <div class="fav-tag">女の子</div>
                                        <div class="fav-tag">乳幼児</div>
                                        <div class="fav-tag">小学生</div>
                                        <div class="fav-tag">中学生</div>
                                        <div class="fav-tag">高校生</div>
                                        <div class="fav-tag">大学生</div>
                                        <div class="fav-tag">社会人</div>
                                        <div class="fav-tag">シェアハウス</div>
                                        <div class="fav-tag">カップル</div>
                                        <div class="fav-tag">お母さん</div>
                                        <div class="fav-tag">お父さん</div>
                                        <div class="fav-tag">子供</div>
                                        <div class="fav-tag">結婚</div>
                                        <div class="fav-tag">同棲</div>
                                    </div>
                                    <div class="setting-btn">
                                        <button id="submit">変更を保存する</button>
                                        <form method="POST" action="/settingFavoriteTag/redirect" style="display:none">
                                            {{csrf_field()}}
                                            <input id="next" type="submit" style="display:none">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </section>
            </article>
        </main>
        
        <script text/javascript>
            var param = JSON.parse('<?php echo $param_json; ?>');
            console.log(param);
            
            let elements = document.getElementsByClassName('fav-tag');
            
            for (let i = 0; i < param.length; i++) {
                let target = param[i];
                for (let k = 0; k < elements.length; k++) {
                    if (elements[k].innerHTML === target) {
                        console.log('match');
                        console.log(elements[k]);
                        elements[k].classList.add('tag-on');
                    }
                }
            }
  
        
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
                    const url = '/settingFavoriteTag/store_tags';
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

        <script src="{{asset('js/index.js')}}"></script>
    </body>
</html>