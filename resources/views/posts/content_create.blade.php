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
                                <li class="show-step"><a href="{{ route('posts.create')}}">本文作成</a></li>
                                <li class="other-step"><a href="{{ route('posts.create_title')}}">タイトル作成<br>サムネイル指定</a></li>
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
                                            <p>本文</p>
                                            <div class="store-btn">
                                                <button id="save-btn">保存する</button>
                                            </div>
                                        </div>
                                        <button id="fileSelect" onchange="addText3();" class="img-select">
                                            <div class="imgSelect-icon">
                                                <img src="{{asset('images/picture.png') }}" alt="画像ロゴ">
                                            </div>
                                            <p>画像選択</p>
                                        </button>
                                    </div>
                                    <form class="createPost-form" method="POST" action="/posts" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <textarea id="content" name="content" placeholder="本文を入力">{{$content}}</textarea>
                                        <textarea id="content_htmlTag" name="content_htmlTag">{{$content_htmlTag}}</textarea>
                                        <input id="fileName" type="hidden" name="file_name">
                                        <input id="fileElem" onchange="addText3();" type="file" name="content_img">
                                        <input id="postContent_preview" type="submit" name="action" value="preview">
                                        <input id="postContent_save" type="submit" name="action" value="save">
                                    </form>
                                </div>
                            </div>
                            <div id="create-box-right" class="create-box">
                                <div class="createBox-header">
                                    <div class="text-heading-right">
                                        <button id="postContent_preview-btn">
                                            <p>プレビュー</p>
                                        </button>
                                    </div>
                                </div>
                                <div class="createContent-preview">
                                    @if (isset($content_htmlTag))
                                    <div>
                                        <?php
                                        echo $content_htmlTag;
                                        ?>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </main>
        
        <script type="text/javascript">
            <!--function newTextCreate() {-->
            <!--    area2.value = area.value;-->
            <!--	if (area2.value) {-->
            <!--	    //入力内容を改行ごとに分けて配列に格納-->
            <!--        let formText = area2.value.split('\n');-->
            <!--        //画像パスを拾う-->
            <!--        let aryCheck = formText.filter(value => value.includes('storage/content_imgs/'));-->
                    
            <!--        aryCheck.forEach(function(element) {-->
            <!--            //パス部分とテキスト部分を分ける-->
            <!--            let cutElem = element.substr(0, element.indexOf('.jpg') + 4);-->
            <!--            let cutText = element.substr(element.indexOf('.jpg') + 4);-->
            <!--            //パス部分にimgタグを付与して配列に格納し直す-->
            <!--            let imgTag = "<img src=" + cutElem + ">"-->
            <!--            formText[formText.indexOf(element)] = imgTag;-->
            <!--            //テキスト部分を配列に格納-->
            <!--            formText.splice(formText.indexOf(imgTag) + 1, 0, cutText);-->
            <!--        });-->
            <!--        //入力内容の配列の要素を<br>で繋ぐ-->
            <!--        let newFormText = formText.join('<br>');-->
                    
            <!--        area2.value = newFormText;-->
            <!--    }    -->
            <!--}-->
            
            <!--//textarea取得-->
            <!--var area = document.getElementById('content');-->
            <!--var area2 = document.getElementById('content_htmlTag');-->
            <!--//プレビューボタン取得-->
            <!--const check = document.getElementById('postContent_preview-btn');-->
            <!--//プレビューボタンのクリックイベント-->
            <!--check.addEventListener('click', function(e) {-->
            <!--    //textareaの入力内容にimgタグ付与-->
            <!--    newTextCreate();-->
            <!--    //phpにpost-->
            <!--	let preview = document.getElementById('postContent_preview');-->
            <!--	preview.click();-->
            <!--})-->
            
            <!--//保存ボタン取得-->
            <!--const save_btn = document.getElementById('save-btn');-->
            <!--//保存ボタンのクリックイベント-->
            <!--save_btn.addEventListener('click', function(e) {-->
            <!--    //textareaの入力内容にimgタグ付与-->
            <!--    newTextCreate();-->
            <!--    //phpにpost-->
            <!--	let save = document.getElementById('save-btn');-->
            <!--	save.click();-->
            <!--})-->
            
            <!--const fileSelect = document.getElementById("fileSelect"),-->
            <!--      fileElem = document.getElementById("fileElem");-->
                
            <!--    fileSelect.addEventListener("click", function (e) {-->
            <!--      if (fileElem) {-->
            <!--        fileElem.click();-->
            <!--      }-->
            <!--    }, false);-->
            
            <!--fileElem.addEventListener("change", addText3());-->
            
            <!--function addText3()-->
            <!--{-->
            <!--    var user_name = JSON.parse('<?php echo $param_json; ?>');-->
            
            <!--    var datetime = Date.now();-->
            <!--    var file_name =  user_name + "." + datetime + "." + "jpg";-->
            
            <!--    let fileName = document.getElementById('fileName');-->
            <!--    fileName.value = file_name;-->
            
            <!--	var text ="\n" + "storage/content_imgs/" + file_name + "\n";-->
            	
            <!--	//カーソルの位置を基準に前後を分割して、その間に文字列を挿入-->
            <!--	area.value = area.value.substr(0, area.selectionStart)-->
            <!--			+ text-->
            <!--			+ area.value.substr(area.selectionStart);-->
            			
            <!--	newTextCreate();-->
            	
            <!--	let preview = document.getElementById('postContent_preview');-->
            <!--	preview.click();-->
            	
            <!--}-->
            
            var hokuto = 'kuramoto';
            var user_name = JSON.parse('<?php echo $param_json; ?>');
        </script>
        
        <script type="text/javascript" src="{{asset('js/index.js')}}"></script>
    </body>
</html>