<link rel="stylesheet" href="{{asset('css/style.css')}}">

<p>{{$post_user_name}}さんが新しい投稿をしました。</p>

<div class="post_mail_content">
    <p class="label">タイトル<br>{{$post_title}}</p>    
</div>

@if (isset($post_tags))
<div class="post_mail_content">
    <p class="label">タグ<br>{{$post_tags}}</p>    
</div>
@endif

<div>
    <p>ログインして確認してみましょう！</p>    
</div>

<a href="{{route('logins.index')}}"><button>ログイン</button></a>