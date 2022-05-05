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
                    <h1>設定</h1>
                </div>
                <section class="wrapper">
                    <div id="setting">
                        <ul class="tabs pc_tabs">
                            <li class="tab"><a href="{{route('settingUser.index')}}">会員情報設定</a></li>
                            <li class="tab"><a href="{{route('settingFavoriteTag.index')}}">お気に入りタグ設定</a></li>
                            <li class="tab"><a href="{{route('settingQuestionReceive.index')}}">質問受け取り設定</a></li>
                            <li class="tab active-tab"><a href="{{route('settingNotice.index')}}">通知設定</a></li>
                        </ul>
                        <ul class="tabs phone_tabs">
                            <li class="tab"><a href="{{route('settingUser.index')}}">会員情報</a></li>
                            <li class="tab"><a href="{{route('settingFavoriteTag.index')}}">お気に入りタグ</a></li>
                            <li class="tab"><a href="{{route('settingQuestionReceive.index')}}">質問受け取り</a></li>
                            <li class="tab active-tab"><a href="{{route('settingNotice.index')}}">通知</a></li>
                        </ul>
                        <div class="setting-contents">
                            <div class="setting-content show-content">
                                <div class="setting-notification">
                                    <div class="notification-item">
                                        <div class="notification-info">
                                            <div>
                                                <div class="change">
                                                    <h3>ユーザー指定</h3>
                                                    <div class=" change-btn noteChange-btn">変更する</div>
                                                </div>
                                                <div class="selected-user">
                                                    @if (isset($newNotice_users))
                                                            @foreach ($newNotice_users as $notice_user)
                                                    <div class="icon-userName">
                                                        <div class="icon">
                                                            <img src="{{$notice_user->user_icon}}" alt="">
                                                        </div>
                                                        <p class="user-name">{{$notice_user->user_name}}</p>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <div class="change">
                                                    <h3>投稿タグ指定</h3>
                                                    <div class="change-btn noteChange-btn">変更する</div>
                                                </div>
                                                <div class="notificationTags notification-postTags">
                                                    @if (isset($notice_post_tags))
                                                    @foreach ($notice_post_tags as $notice_post_tag)
                                                    <div class="note-postTag note-tag">{{$notice_post_tag->tag_name}}</div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <div class="change">
                                                    <h3>質問タグ指定</h3>
                                                    <div class="change-btn noteChange-btn">変更する</div>
                                                </div>
                                                <div class="notificationTags notification-questionTags">
                                                    @if (isset($notice_question_tags))
                                                    @foreach ($notice_question_tags as $notice_question_tag)
                                                    <div class="note-questionTag note-tag">{{$notice_question_tag->tag_name}}</div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                            <div class="notification-changes">
                                                    <div class="notification-change show-noteChange">
                                                        <div class="noteChange-titleBox">
                                                            <p class="noteChange-title">ユーザー指定</p>
                                                        </div>
                                                        <div class="noteChange-contentBox">
                                                            <div class="followUser-lists">
                                                                @if (isset($newFollows))
                                                            @foreach ($newFollows as $follow)
                                                                <div class="userSelection">
                                                                    <div class="icon-userName">
                                                                        <div class="icon">
                                                                            <img src="{{$follow->user_icon}}" alt="">
                                                                        </div>
                                                                        <p class="user-name">{{$follow->user_name}}</p>
                                                                    </div>
                                                                    <form style="display:none" method="POST" action="/store_notice_users">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="notice_user_id" value="{{$follow->user_id}}">
                                                                        <input type="submit" style="display:none">
                                                                    </form>
                                                                    @if ($follow->notice_user == 0)
                                                                    <div class="userSelection-btn">追加</div>
                                                                    @elseif ($follow->notice_user == 1)
                                                                    <div class="userSelection-btn">解除</div>
                                                                    @endif
                                                                </div>
                                                                @endforeach
                                                            @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="notification-change">
                                                        <div class="noteChange-titleBox">
                                                        <p class="noteChange-title">投稿タグ指定</p>
                                                        </div>
                                                        <div class="noteChange-contentBox">
                                                            <div class="postTag-selection">
                                                                <div class="noteChangeTags noteChange-postTags">
                                                                    <div class="noteChange-postTag noteChange-tag">掃除</div>
                                                                    <div class="noteChange-postTag noteChange-tag">洗濯</div>
                                                                    <div class="noteChange-postTag noteChange-tag">料理</div>
                                                                    <div class="noteChange-postTag noteChange-tag">収納</div>
                                                                    <div class="noteChange-postTag noteChange-tag">育児</div>
                                                                    <div class="noteChange-postTag noteChange-tag">インテリア</div>
                                                                    <div class="noteChange-postTag noteChange-tag">エクステリア</div>
                                                                    <div class="noteChange-postTag noteChange-tag">家電</div>
                                                                    <div class="noteChange-postTag noteChange-tag">家具</div>
                                                                    <div class="noteChange-postTag noteChange-tag">一人暮らし</div>
                                                                    <div class="noteChange-postTag noteChange-tag">初心者</div>
                                                                    <div class="noteChange-postTag noteChange-tag">引っ越し</div>
                                                                    <div class="noteChange-postTag noteChange-tag">簡単</div>
                                                                    <div class="noteChange-postTag noteChange-tag">時短</div>
                                                                    <div class="noteChange-postTag noteChange-tag">趣味</div>
                                                                    <div class="noteChange-postTag noteChange-tag">便利グッズ</div>
                                                                    <div class="noteChange-postTag noteChange-tag">オシャレ</div>
                                                                    <div class="noteChange-postTag noteChange-tag">男性</div>
                                                                    <div class="noteChange-postTag noteChange-tag">女性</div>
                                                                    <div class="noteChange-postTag noteChange-tag">男の子</div>
                                                                    <div class="noteChange-postTag noteChange-tag">女の子</div>
                                                                    <div class="noteChange-postTag noteChange-tag">乳幼児</div>
                                                                    <div class="noteChange-postTag noteChange-tag">小学生</div>
                                                                    <div class="noteChange-postTag noteChange-tag">中学生</div>
                                                                    <div class="noteChange-postTag noteChange-tag">高校生</div>
                                                                    <div class="noteChange-postTag noteChange-tag">大学生</div>
                                                                    <div class="noteChange-postTag noteChange-tag">社会人</div>
                                                                    <div class="noteChange-postTag noteChange-tag">シェアハウス</div>
                                                                    <div class="noteChange-postTag noteChange-tag">カップル</div>
                                                                    <div class="noteChange-postTag noteChange-tag">お母さん</div>
                                                                    <div class="noteChange-postTag noteChange-tag">お父さん</div>
                                                                    <div class="noteChange-postTag noteChange-tag">子供</div>
                                                                    <div class="noteChange-postTag noteChange-tag">結婚</div>
                                                                    <div class="noteChange-postTag noteChange-tag">同棲</div>
                                                                    <div class="noteChange-postTag noteChange-tag">玄関</div>
                                                                    <div class="noteChange-postTag noteChange-tag">リビング</div>
                                                                    <div class="noteChange-postTag noteChange-tag">キッチン</div>
                                                                    <div class="noteChange-postTag noteChange-tag">ダイニング</div>
                                                                    <div class="noteChange-postTag noteChange-tag">寝室</div>
                                                                    <div class="noteChange-postTag noteChange-tag">ベランダ</div>
                                                                    <div class="noteChange-postTag noteChange-tag">トイレ</div>
                                                                    <div class="noteChange-postTag noteChange-tag">バスルーム</div>
                                                                    <div class="noteChange-postTag noteChange-tag">子供部屋</div>
                                                                    <div class="noteChange-postTag noteChange-tag">マンション</div>
                                                                    <div class="noteChange-postTag noteChange-tag">一軒家</div>
                                                                    <div class="noteChange-postTag noteChange-tag">アパート</div>
                                                                    <div class="noteChange-postTag noteChange-tag">リフォーム</div>
                                                                    <div class="noteChange-postTag noteChange-tag">DIY</div>
                                                                    <div class="noteChange-postTag noteChange-tag">冷蔵庫</div>
                                                                    <div class="noteChange-postTag noteChange-tag">洗濯機</div>
                                                                    <div class="noteChange-postTag noteChange-tag">テレビ</div>
                                                                    <div class="noteChange-postTag noteChange-tag">ベッド</div>
                                                                    <div class="noteChange-postTag noteChange-tag">安価</div>
                                                                    <div class="noteChange-postTag noteChange-tag">高価</div>
                                                                </div>
                                                            </div>
                                                            <div class="setting-btn">
                                                                <button id="submitPostTags">変更を保存する</button>
                                                                <form method="POST" action="/settingNoticeTag/redirect" style="display:none">
                                                                    {{csrf_field()}}
                                                                    <input id="postTag_redirect" type="submit" style="display:none">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="notification-change">
                                                        <div class="noteChange-titleBox">
                                                        <p class="noteChange-title">質問タグ指定</p>
                                                        </div>
                                                        <div class="noteChange-contentBox">
                                                            <div class="postTag-selection">
                                                                <div class="noteChangeTags noteChange-postTags">
                                                                    <div class="noteChange-questionTag noteChange-tag">掃除</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">洗濯</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">料理</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">収納</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">育児</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">インテリア</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">エクステリア</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">家電</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">家具</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">一人暮らし</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">初心者</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">引っ越し</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">簡単</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">時短</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">趣味</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">便利グッズ</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">オシャレ</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">男性</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">女性</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">男の子</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">女の子</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">乳幼児</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">小学生</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">中学生</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">高校生</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">大学生</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">社会人</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">シェアハウス</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">カップル</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">お母さん</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">お父さん</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">子供</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">結婚</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">同棲</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">玄関</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">リビング</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">キッチン</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">ダイニング</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">寝室</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">ベランダ</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">トイレ</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">バスルーム</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">子供部屋</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">マンション</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">一軒家</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">アパート</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">リフォーム</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">DIY</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">冷蔵庫</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">洗濯機</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">テレビ</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">ベッド</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">安価</div>
                                                                    <div class="noteChange-questionTag noteChange-tag">高価</div>
                                                                </div>
                                                            </div>
                                                            <div class="setting-btn">
                                                                <button id="submitQuestionTags">変更を保存する</button>
                                                                <form method="POST" action="/settingNoticeTag/redirect" style="display:none">
                                                                    {{csrf_field()}}
                                                                    <input id="questionTag_redirect" type="submit" style="display:none">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
            
            let elements = document.getElementsByClassName('noteChange-postTag');
            
            for (let i = 0; i < param.length; i++) {
                let target = param[i];
                for (let k = 0; k < elements.length; k++) {
                    if (elements[k].innerHTML === target) {
                        console.log('match');
                        console.log(elements[k]);
                        elements[k].classList.add('notePost-on');
                    }
                }
            }
        
            let submit = document.getElementById('submitPostTags');
            submit.addEventListener('click', submitData, false);
            
            console.log(submit);
            
            function submitData() {
                let selectedTags = document.getElementsByClassName('notePost-on');
                let selectedTagsArray = [];
                for (let i = 0; i < selectedTags.length; i++) {
                    console.log(selectedTags[i].innerHTML);
                    selectedTagsArray.push(selectedTags[i].innerHTML);
                }
                console.log(selectedTagsArray);
                
                
                const asynchronousFunc = (value) => {
                    const url = '/settingNoticeTag/store_postTags';
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
                    let next = document.getElementById('postTag_redirect');
                    next.click();
                })();
            };
            
            
            
            var param_question = JSON.parse('<?php echo $param_question_json; ?>');
            console.log(param_question);
            
            let question_elements = document.getElementsByClassName('noteChange-questionTag');
            
            for (let i = 0; i < param_question.length; i++) {
                let target = param_question[i];
                for (let k = 0; k < question_elements.length; k++) {
                    if (question_elements[k].innerHTML === target) {
                        console.log('match');
                        console.log(question_elements[k]);
                        question_elements[k].classList.add('noteQuestion-on');
                    }
                }
            }
            
            let submitQuestionTags = document.getElementById('submitQuestionTags');
            submitQuestionTags.addEventListener('click', submitQuestionTagsData, false);
            
            console.log(submit);
            
            function submitQuestionTagsData() {
                let selectedTags = document.getElementsByClassName('noteQuestion-on');
                let selectedTagsArray = [];
                for (let i = 0; i < selectedTags.length; i++) {
                    console.log(selectedTags[i].innerHTML);
                    selectedTagsArray.push(selectedTags[i].innerHTML);
                }
                console.log(selectedTagsArray);
                
                
                const asynchronousFunc = (value) => {
                    const url = '/settingNoticeTag/store_questionTags';
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
                    let next = document.getElementById('questionTag_redirect');
                    next.click();
                })();
            };


        </script>


        <script src="{{asset('js/index.js')}}"></script>
    </body>
</html>