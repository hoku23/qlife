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
                <div class="main-header timeline-main-header">
                    <h1>質問一覧</h1>
                    @if (session('message'))
                    <div id="pc_error_message" style="align-items:center; color:red;">
                        <p>{{session('message')}}</p>
                    </div>
                    @endif
                    <div id="search_btn">
                        <p>投稿を探す</p>
                    </div>
                </div>
                <section>
                    <div id="questionList-container">
                        <div class="questionList-box">
                            @if (session('message'))
                            <div id="phone_error_message" style="display:flex; align-items:center; color:red;">
                                <p>{{session('message')}}</p>
                            </div>
                            @endif
                            <div class="otherQuestion-lists">
                                @if (isset($newQuestions))
                                @foreach ($newQuestions as $question)
                                <div class="otherQuestion question">
                                    <div class="icon-userName question_userName">
                                        <input type="hidden" value="{{$question->user_id}}">
                                        <div class="icon">
                                            <img src="{{$question->user_icon}}" alt="">
                                        </div>
                                        <p class="user-name">{{$question->user_name}}</p>
                                    </div>
                                        <p class="question-title">{{$question->question_title}}</p>
                                        <form style="display:none" method="POST" action="{{route('question_detail')}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="question_id" value="{{$question->question_id}}">
                                            <input type="submit" style="display:none">
                                        </form>
                                    <p class="question-label">困っていること</p>
                                    <div class="question-content">
                                        @if (isset($question->question_content))
                                            <div>
                                                <?php
                                                echo $question->question_content;
                                                ?>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="question-tags">
                                         @if (isset($question->tags))
                                            @foreach ($question->tags as $tag)
                                                <div class="tag">{{$tag}}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="question-answerNum">
                                        <p>回答<span>{{$question->answers}}件</span></p>
                                        <div class="question-date">
                                            <p>{{$question->question_date}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <form style="display:none" method="POST" action="{{route('follow.user_page')}}">
                                    {{csrf_field()}}
                                    <input id="otherUser" type="hidden" name="otherUser">
                                    <input id="otherUser_btn" type="submit" style="display:none;">
                                </form>
                            </div>
                        </div>
                        <div class="search-area">
                            <div class="keyword-search">
                                <form class="search" method="POST" action="{{route('search.question_search')}}">
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
                                    <div class="search timelineSearch-btn">
                                       <input id="submit" class="tagSearch-btn" type="button" value="検索する">
                                       <form method="POST" action="{{route('search.question_search')}}" style="display:none">
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
                    const url = '/search_tag_store';
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
            
            let question_titles = document.getElementsByClassName('question-title');
            for (let i = 0; i < question_titles.length; i++) {
                if (question_titles[i]) {
                    question_titles[i].addEventListener('click', function(e) {
                        console.log(e.target.nextElementSibling.lastElementChild);
                        let submit = e.target.nextElementSibling.lastElementChild;
                        submit.click();
                    })       
                }
            }
            
            let question_userName = document.getElementsByClassName('question_userName');
            for (let i = 0; i < question_userName.length; i++) {
                if (question_userName[i]) {
                    question_userName[i].addEventListener('click', function(e){
                        console.log(question_userName[i].firstElementChild);
                        let otherUser_name = question_userName[i].firstElementChild.value;
                        console.log(otherUser_name);
                        let otherUser = document.getElementById('otherUser');
                        otherUser.value = otherUser_name;
                        console.log(otherUser.value);
                        let otherUser_btn = document.getElementById('otherUser_btn');
                        otherUser_btn.click();
                    })    
                }
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