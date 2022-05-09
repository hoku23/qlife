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
                    </ul>
                </nav>
            </div>
        </header>
        <main>
            <article>
                <div class="main-header">
                    <h1>新規質問作成</h1>
                    @if (session('message'))
                    <div id="pc_error_message" style="align-items:center; color:red;">
                        <p>{{session('message')}}</p>
                    </div>
                    <div id="phone_error_message" style="align-items:center; color:red;">
                        <p>{{session('message')}}</p>
                    </div>
                    @endif
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="other-step"><a href="{{route('question.create')}}">本文作成<br>タイトル作成</a></li>
                                <li class="show-step"><a href="{{route('question.create_tags')}}">タグ選択<br>ユーザー指定</a></li>
                                <li class="other-step"><a href="{{route('question.confirm')}}">内容確認</a></li>
                                <li class="other-step">質問投函完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div id="createQuestionTags-box-left" class="create-box">
                                <div>
                                    <div class="createBox-header">
                                        <div class="text-heading">
                                            <p>タグ選択</p>
                                        </div>
                                    </div>
                                    <div class="questionCreate-tags-box">
                                        <div class="setting-favoriteTags">
                                            <p>タグを選択してください</p>
                                            <div class="questionCreate-tags">
                                                <div class="question-tag">掃除</div>
                                                <div class="question-tag">洗濯</div>
                                                <div class="question-tag">料理</div>
                                                <div class="question-tag">収納</div>
                                                <div class="question-tag">育児</div>
                                                <div class="question-tag">インテリア</div>
                                                <div class="question-tag">エクステリア</div>
                                                <div class="question-tag">家電</div>
                                                <div class="question-tag">家具</div>
                                                <div class="question-tag">一人暮らし</div>
                                                <div class="question-tag">初心者</div>
                                                <div class="question-tag">引っ越し</div>
                                                <div class="question-tag">簡単</div>
                                                <div class="question-tag">時短</div>
                                                <div class="question-tag">趣味</div>
                                                <div class="question-tag">便利グッズ</div>
                                                <div class="question-tag">オシャレ</div>
                                                <div class="question-tag">男性</div>
                                                <div class="question-tag">女性</div>
                                                <div class="question-tag">男の子</div>
                                                <div class="question-tag">女の子</div>
                                                <div class="question-tag">乳幼児</div>
                                                <div class="question-tag">小学生</div>
                                                <div class="question-tag">中学生</div>
                                                <div class="question-tag">高校生</div>
                                                <div class="question-tag">大学生</div>
                                                <div class="question-tag">社会人</div>
                                                <div class="question-tag">シェアハウス</div>
                                                <div class="question-tag">カップル</div>
                                                <div class="question-tag">お母さん</div>
                                                <div class="question-tag">お父さん</div>
                                                <div class="question-tag">子供</div>
                                                <div class="question-tag">結婚</div>
                                                <div class="question-tag">同棲</div>
                                                <div class="question-tag">玄関</div>
                                                <div class="question-tag">リビング</div>
                                                <div class="question-tag">キッチン</div>
                                                <div class="question-tag">ダイニング</div>
                                                <div class="question-tag">寝室</div>
                                                <div class="question-tag">ベランダ</div>
                                                <div class="question-tag">トイレ</div>
                                                <div class="question-tag">バスルーム</div>
                                                <div class="question-tag">子供部屋</div>
                                                <div class="question-tag">マンション</div>
                                                <div class="question-tag">一軒家</div>
                                                <div class="question-tag">アパート</div>
                                                <div class="question-tag">リフォーム</div>
                                                <div class="question-tag">DIY</div>
                                                <div class="question-tag">冷蔵庫</div>
                                                <div class="question-tag">洗濯機</div>
                                                <div class="question-tag">テレビ</div>
                                                <div class="question-tag">ベッド</div>
                                                <div class="question-tag">安価</div>
                                                <div class="question-tag">高価</div>
                                            </div>
                                            <div class="question-store">
                                                <input id="tags_submit" class="questionStore-btn" type="submit" value="保存する">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="create-box-right" class="create-box">
                                <div class="createBox-header">
                                    <div class="text-heading">
                                        <p>ユーザー指定</p>
                                    </div>
                                </div>
                                <div class="questionCreate-users-container">
                                    <div class="questionCreate-users-box">
                                        <p>質問を届けたいユーザーを指定してください</p>
                                        <div class="questionCreateUsers-list">
                                            <div class="questionCreateUsers">
                                                <div class="questionCreateUser">
                                                    <div class="icon-userName">
                                                        <p class="user-name">ユーザーを指定しない</p>
                                                    </div>
                                                    <div class="questionCreateUsers-select">
                                                        <p style="display:none">NoBody</p>
                                                        <p class="users_selected_btn">選択する</p>
                                                    </div>
                                                </div>
                                                @if (isset($follow_users))
                                                @foreach ($follow_users as $follow_user)
                                                <div class="questionCreateUser">
                                                    <div class="icon-userName">
                                                        <div class="icon">
                                                            <img src="{{$follow_user->user_icon}}" alt="">
                                                        </div>
                                                        <p class="user-name">{{$follow_user->user_name}}</p>
                                                    </div>
                                                    <div class="questionCreateUsers-select">
                                                        <p style="display:none">{{$follow_user->user_id}}</p>
                                                        <p class="users_selected_btn">選択する</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                            <div class="question-store">
                                                <input id="users_submit" class="questionStore-btn" type="submit" value="保存する">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{route('question.redirect')}}" style="display:none">
                                {{csrf_field()}}
                                <input id="redirect" type="submit" style="display:none">
                            </form>
                        </div>
                    </div>
                </section>
            </article>
        </main>
        
        <script text/javascript>
            var param = JSON.parse('<?php echo $param_json; ?>');
            console.log(param);
        
            let elements = document.getElementsByClassName('question-tag');
            
            if (param) {
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
            }
            
        
        
            let submit = document.getElementById('tags_submit');
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
                    const url = '{{route('question.store_tags')}}';
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
                    let next = document.getElementById('redirect');
                    next.click();
                })();
            };
            
            let user_submit = document.getElementById('users_submit');
            user_submit.addEventListener('click', submitData2, false);
            
            function submitData2() {
                let selectedTags = document.getElementsByClassName('user_selected');
                let selectedTagsArray = [];
                for (let i = 0; i < selectedTags.length; i++) {
                    console.log(selectedTags[i].previousElementSibling.innerHTML);
                    selectedTagsArray.push(selectedTags[i].previousElementSibling.innerHTML);
                }
                console.log(selectedTagsArray);
                
                
                const asynchronousFunc = (value) => {
                    // const url = '/question/store_users';
                    const url = '{{route('question.store_users')}}';
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
                    let next = document.getElementById('redirect');
                    next.click();
                })();
            };
            
            var users_param = JSON.parse('<?php echo $users_param_json; ?>');
            console.log(users_param);
        
            let users_elements = document.getElementsByClassName('users_selected_btn');
            
            if (users_param) {
                for (let i = 0; i < users_param.length; i++) {
                    let target = users_param[i];
                    for (let k = 0; k < users_elements.length; k++) {
                        if (users_elements[k].previousElementSibling.innerHTML === target) {
                            console.log('match');
                            console.log(users_elements[k]);
                            users_elements[k].classList.add('user_selected');
                            users_elements[k].textContent = '選択中';
                        }
                    }
                }    
            }
            

        </script>
        
        <script src="{{asset('js/index.js')}}" charset="utf-8"></script>
    </body>
</html>