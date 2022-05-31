<!DOCTYPE html>
<html>
    <head>
        <title>QLife</title>
        <meta name="description" content="暮らしに関する情報をシェアするアプリケーションです">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/phone_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mini_pc_style.css') }}">
        <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon" />
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="images/logo.png" alt="ロゴ">
            </div>
            <div id="to-registrationInput">
                <a href="{{ route('logins.index') }}"><button class="toRegistration-btn">ログイン</button></a>
            </div>
        </header>
        <main>
            <article>
                <div class="registration">
                    <h1>会員登録</h1>
                    <form id="registrationInput-form" method="POST" action="{{route('registers.confirm')}}">
                        {{ csrf_field() }}
                        <div class="registerInputBox">
                            <label>ユーザーID</label>
                            <input class="registrationInput" type="text" name="user_id" value="{{ old('user_id') }}">
                            @if ($errors->has('user_id'))
                                <p class="error">{{ $errors->first('user_id') }}</p>
                            @endif
                        </div>
                        <div class="registerInputBox">
                            <label>パスワード</label>
                            <input class="registrationInput" type="password" name="password" value="{{ old('password') }}">
                            @if ($errors->has('password'))
                                <p class="error">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        <div class="registerInputBox">
                            <label>パスワード（確認用）</label>
                            <input class="registrationInput" type="password" name="confirm_password" value="{{ old('confirm_password') }}">
                            @if ($errors->has('confirm_password'))
                                <p class="error">{{ $errors->first('confirm_password') }}</p>
                            @endif
                        </div>
                        <div class="registerInputBox">
                            <label>ユーザーネーム</label>
                            <input class="registrationInput" type="text" name="user_name" value="{{ old('user_name') }}">
                            @if ($errors->has('user_name'))
                                <p class="error">{{ $errors->first('user_name') }}</p>
                            @endif
                        </div>
                        <div class="registerInputBox">
                            <label>メールアドレス</label>
                            <input class="registrationInput" type="text" name="email" value="{{ old('email') }}"> 
                            @if ($errors->has('email'))
                                <p class="error">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div id="privacyPolicy-check">
                            <input type="checkbox" name="privacy-policy" >
                            <label class="privacyPolicy">プライバシーポリシーに同意</label>
                            <div class="arrow">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        @if ($errors->has('privacy-policy'))
                                <p class="error">{{ $errors->first('privacy-policy') }}</p>
                            @endif
                        <div class="privacy-policy">
                            <p>
                                Qlife（以下、「当サービス」という。）は，ユーザーの個人情報について以下のとおりプライバシーポリシー（以下、「本ポリシー」という。）を定めます。
                                本ポリシーは、当サービスがどのような個人情報を取得し、どのように利用・共有するか、ユーザーがどのようにご自身の個人情報を管理できるかをご説明するものです。
                            </p>
                            <div class="privacy-container">
                                <p class="privacy-title">1. 個人情報の取得方法</p>
                                <p>
                                    当サービスは、ユーザーが利用登録をするとき、メールアドレスを取得させていただきます。
                                </p>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">2. 個人情報の利用目的</p>
                                <ul>
                                    <li>
                                        取得した閲覧・購買履歴等の情報を分析し、ユーザーに適した新サービスをお知らせするために利用します。
                                    </li>
                                    <li>
                                        ユーザーが利用しているサービスの新機能や更新情報、キャンペーン情報などをメール送付によりご案内するために利用します。
                                    </li>
                                    <li>
                                        ユーザーが利用しているサービスのメンテナンスなど、必要に応じたご連絡をするために利用します。
                                    </li>
                                    <li>
                                        ユーザーからのコメントやお問い合わせに回答するために利用します。
                                    </li>
                                </ul>
                                <p>
                                    個人情報の利用目的は、変更前後の関連性について合理性が認められる場合に限って変更するものとします。
                                    個人情報の利用目的について変更を行った際は、変更後の目的について当サービス所定の方法によってユーザーに通知します。
                                </p>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">3. 個人データを安全に管理するための措置</p>
                                <p>
                                    当サービスは、個人情報を正確かつ最新の内容に保つよう努め、不正なアクセス・改ざん・漏えい・滅失及び毀損から保護するため管理を徹底しています。
                                </p>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">4. 個人データの第三者提供について</p>
                                <p>
                                    当社は以下の場合を除き、同意を得ないで第三者に個人情報を提供することは致しません。
                                </p>
                                <ul>
                                    <li>
                                        法令に基づく場合
                                    </li>
                                    <li>
                                        人の生命、身体又は財産の保護のために必要がある場合であって、本人の同意を得ることが困難であるとき
                                    </li>
                                    <li>
                                        公衆衛生の向上又は児童の健全な育成の推進のために特に必要がある場合であって、本人の同意を得ることが困難であるとき
                                    </li>
                                    <li>
                                        国の機関若しくは地方公共団体又はその委託を受けた者が法令の定める事務を遂行することに対して協力する必要がある場合であって、本人の同意を得ることにより当該事務の遂行に支障を及ぼすおそれがあるとき
                                    </li>
                                    <li>
                                        次に掲げる事項をあらかじめ本人に通知または公表し、かつ当社が個人情報保護委員会に届出をしたとき
                                    </li>
                                    <p>
                                        1. 第三者への提供を利用目的とすること<br>
                                        2. 第三者に提供される個人データの項目<br>
                                        3. 第三者への提供の方法<br>
                                        4. 本人の求めに応じて当該個人情報の第三者への提供を停止すること<br>
                                        5. 本人の求めを受け付ける方法
                                    </p>
                                </ul>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">5. 匿名加工情報に関する取扱い</p>
                                <p>
                                    当サービスは、匿名加工情報（特定の個人を識別できないよう加工した個人情報であって、復元ができないようにしたもの）を作成する場合、以下の対応を行います。
                                </p>
                                <ul>
                                    <li>
                                        法令で定める基準に従い適正な加工を施す
                                    </li>
                                    <li>
                                        法令で定める基準に従い安全管理措置を講じる
                                    </li>
                                    <li>
                                        匿名加工情報に含まれる個人に関する情報の項目を公表する
                                    </li>
                                    <li>
                                        作成元となった個人情報の本人を識別するため、他の情報と照合すること
                                    </li>
                                </ul>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">6. プライバシーポリシーの制定日及び改定日</p>
                                <p>
                                    制定：2022年05月29日
                                </p>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">7. 免責事項</p>
                                <ul>
                                    <li>
                                        当サービスに掲載されている情報の正確さには万全を期していますが、利用者が当サービスの情報を用いて行う一切の行為に関して、当サービスは一切の責任を負わないものとします。
                                    </li>
                                    <li>
                                        当サービスは、利用者が当サービスを利用したことにより生じた利用者の損害及び利用者が第三者に与えた損害に関して、一切の責任を負わないものとします。
                                    </li>
                                </ul>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">8. 著作権・肖像権</p>
                                <p>
                                    当サービス内の文章や画像、すべてのコンテンツは著作権・肖像権等により保護されており、無断での使用や転用は禁止されています。
                                </p>
                            </div>
                            <div class="privacy-container">
                                <p class="privacy-title">9. リンク</p>
                                <p>
                                    当サービスへのリンクは、自由に設置していただいて構いません。ただし、Webサイトの内容等によってはリンク設置をお断りすることがあります。
                                </p>
                            </div>
                        </div>
                        <div id="to-registrationCheck" class="registerInputBox">
                            <input class="registration-btn" type="submit" value="確認">
                        </div>
                    </form>
                </div>
            </article>
        </main>
        
        <script text/javascript>
            let privacyPolicy = document.getElementsByClassName('privacyPolicy');
            privacyPolicy[0].addEventListener('click', function(e) {
                let arrow = document.getElementsByClassName('arrow');
                let privacy_policy = document.getElementsByClassName('privacy-policy');
                if (arrow[0].classList.contains('privacyPolicy-on')) {
                    arrow[0].classList.remove('privacyPolicy-on');
                    privacy_policy[0].classList.remove('privacy-policy-on');
                } else {
                    arrow[0].classList.add('privacyPolicy-on');
                    privacy_policy[0].classList.add('privacy-policy-on');
                }
            })
        
        </script>

        <script src="{{asset('js/index.js')}}"></script>
    </body>
</html>