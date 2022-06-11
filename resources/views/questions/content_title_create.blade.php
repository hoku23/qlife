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
                <div class="main-header">
                    <h1>新規質問作成</h1>
                </div>
                <section>
                    <div id="createNewPost">
                        <div id="create-flow">
                            <ul class="createFlow-list">
                                <li class="show-step"><a href="{{route('question.create')}}">本文作成<br>タイトル作成</a></li>
                                <li class="other-step"><a href="{{route('question.create_tags')}}">タグ選択<br>ユーザー指定</a></li>
                                <li class="other-step"><a href="{{route('question.confirm')}}">内容確認</a></li>
                                <li class="other-step">質問投函完了</li>
                            </ul>
                        </div>
                        <div id="createPost-container">
                            <div id="createQuestion-box-left" class="create-box">
                                <div>
                                    <div class="createBox-header">
                                        <div class="text-heading">
                                            <p>内容</p>
                                            <div class="store-btn">
                                                <button id="save-btn">保存する</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="createQuestionForm-box">
                                        <form class="createQuestionText-form" method="POST" action="{{route('question.store')}}" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <label for="">タイトル</label>
                                            <textarea id="questionCreate-title" name="title" placeholder="タイトルを入力してください">{{$title}}</textarea>
                                            
                                            <label for="">困っていることは何ですか？</label>
                                            <input type="button" id="question_fileSelect" class="question_img_btn" value="画像を選択">
                                            <textarea id="questionCreate-content" name="content" placeholder="質問内容を入力してください">{{$content}}</textarea>
                                            <textarea id="question_content_htmlTag" name="content_htmlTag" style="display:none">{{$content_htmlTag}}</textarea>
                                            
                                            <label for="">試したことや解決策の候補はありますか？</label>
                                            <input type="button" id="try_fileSelect" class="question_img_btn" value="画像を選択">
                                            <input id="try_fileElem" onchange="addText5();" type="file" name="try_img" style="display:none">
                                            <textarea id="questionCreate-try" name="try" placeholder="特になし">{{$try}}</textarea>
                                            <textarea id="try_htmlTag" name="try_htmlTag" style="display:none">{{$try_htmlTag}}</textarea>

                                            <input id="question_fileName" type="hidden" name="file_name">
                                            <input id="question_fileElem" onchange="addText4();" type="file" name="content_img" style="display:none">
                                            <input id="questionContent_preview" type="submit" name="action" value="preview" style="display:none">
                                            <input id="questionContent_save" type="submit" name="action" value="save" style="display:none">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="create-box-right" class="create-box">
                                <div class="createBox-header">
                                    <div class="text-heading-right">
                                        <button id="questionContent_preview-btn">
                                            <p>プレビュー</p>
                                        </button>
                                    </div>
                                </div>
                                <div class="createContent-preview">
                                    <p>タイトル</p>
                                    <div class="preview_box">
                                        @if (isset($title))
                                            <div>
                                                <?php
                                                echo $title;
                                                ?>
                                            </div>
                                        @endif
                                    </div>
                                    <p>困っていること</p>
                                    <div class="preview_box">
                                        @if (isset($content_htmlTag))
                                            <div>
                                                <?php
                                                echo $content_htmlTag;
                                                ?>
                                            </div>
                                        @endif
                                    </div>
                                    <p>試したことや解決策の候補</p>
                                    <div class="preview_box">
                                        @if (isset($try_htmlTag))
                                            <div>
                                                <?php
                                                echo $try_htmlTag;
                                                ?>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </article>
        </main>
        
        <script type="text/javascript">
            var user_name = JSON.parse('<?php echo $param_json; ?>');
        </script>
        
        <script type="text/javascript" src="{{asset('js/index.js')}}"></script>
    </body>
</html>