<link rel="stylesheet" href="{{asset('css/style.css')}}">

<p>{{$question_user_name}}さんから質問が届いています。</p>

<div class="question_mail_content">
    <p class="label">タイトル<br>{{$question_title}}</p>    
</div>

@if (isset($question_tags))
<div class="question_mail_content">
    <p class="label">タグ<br>{{$question_tags}}</p>    
</div>
@endif

<div>
    <p>ログインして確認してみましょう！</p>    
</div>

<a href="{{route('logins.index')}}"><button>ログイン</button></a>