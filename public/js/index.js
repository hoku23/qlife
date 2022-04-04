// タブに対してクリックイベントを適用
const tabs = document.getElementsByClassName('tab');
for(let i = 0; i < tabs.length; i++) {
tabs[i].addEventListener('click', tabSwitch, false);
}

// タブをクリックすると実行する関数
    function tabSwitch(){
    // タブのclassの値を変更
        document.getElementsByClassName('active-tab')[0].classList.remove('active-tab');
        this.classList.add('active-tab');

        // コンテンツのclassの値を変更
        document.getElementsByClassName('show-content')[0].classList.remove('show-content');
        const arrayTabs = Array.prototype.slice.call(tabs);
        const index = arrayTabs.indexOf(this);
        document.getElementsByClassName('setting-content')[index].classList.add('show-content');
    };


// 変更入力ボタンに対してクリックイベントを適用
const changeButtons = document.getElementsByClassName('userChange-btn');
for(let i = 0; i < changeButtons.length; i++) {
    changeButtons[i].addEventListener('click', showChangeForm, false);
}

// 変更入力ボタンをクリックすると実行する関数
    function showChangeForm(){

        // コンテンツのclassの値を変更
        document.getElementsByClassName('show-changeForm')[0].classList.remove('show-changeForm');
        const arrayChanges = Array.prototype.slice.call(changeButtons);
        const index = arrayChanges.indexOf(this);
        document.getElementsByClassName('change-form')[index].classList.add('show-changeForm');
    };


// お気に入りタグに対してクリックイベントを適用
const favoriteTags = document.getElementsByClassName('fav-tag');
for(let i = 0; i < favoriteTags.length; i++) {
    favoriteTags[i].addEventListener('click', switchFavoriteTags, false);
}

// お気に入りタグをクリックすると実行する関数
    function switchFavoriteTags(){

    // classの切り替え
    // .fav-onがついていれば外す
    // .fav-onがついていなければつける
    const arrayFavoriteTags = Array.prototype.slice.call(favoriteTags);
    const index = arrayFavoriteTags.indexOf(this);
    const targetTag = document.getElementsByClassName('fav-tag')[index];
    const tagclasses = Array.from(targetTag.classList);
    if (tagclasses.includes('fav-on') == true) {
        targetTag.classList.remove('fav-on');
    } else {
        targetTag.classList.add('fav-on');
    }
};


// 通知設定のタグに対してクリックイベントを適用
const noteChangeTags = document.getElementsByClassName('noteChange-tag');
for(let i = 0; i < noteChangeTags.length; i++) {
    noteChangeTags[i].addEventListener('click', switchNoteTags, false);
}

// 通知設定のタグをクリックすると実行する関数
    function switchNoteTags(){

    // classの切り替え
    // .fav-onがついていれば外す
    // .fav-onがついていなければつける
    const arrayNoteTags = Array.prototype.slice.call(noteChangeTags);
    const index = arrayNoteTags.indexOf(this);
    const targetTag = document.getElementsByClassName('noteChange-tag')[index];
    const tagclasses = Array.from(targetTag.classList);
    if (tagclasses.includes('note-on') == true) {
        targetTag.classList.remove('note-on');
    } else {
        targetTag.classList.add('note-on');
    }
};


// 通知設定の変更入力ボタンに対してクリックイベントを適用
const noteChangeButtons = document.getElementsByClassName('noteChange-btn');
for(let i = 0; i < noteChangeButtons.length; i++) {
    noteChangeButtons[i].addEventListener('click', showChangeNote, false);
}

// 通知設定の変更入力ボタンをクリックすると実行する関数
    function showChangeNote(){

        // コンテンツのclassの値を変更
        document.getElementsByClassName('show-noteChange')[0].classList.remove('show-noteChange');
        const arrayChanges = Array.prototype.slice.call(noteChangeButtons);
        const index = arrayChanges.indexOf(this);
        document.getElementsByClassName('notification-change')[index].classList.add('show-noteChange');
    };


/* 
.menuをクリックしたら、
#nav-maskに.show-navがついていれば外し、ついていなければ追加する
.show-nav {right: 0;}
#hamburgerに.openがついていれば外し、ついていなければ追加する
.open span:nth-child(1) {
    top: 25px;
    transform: rotate(45deg);
}
.open span:nth-child(2) {
    display: none;
}
.open span:nth-child(3) {
    top: 25px;
    transform: rotate(-45deg);
}
*/
const navMask = document.getElementById('nav-mask');
const menu = document.getElementById('menu');
const hamburger = document.getElementById('hamburger');

// menuボタンに対するクリックイベント
menu.addEventListener('click', openMenu, false);

// menuボタンがクリックされた時の処理
function openMenu(){
    if (navMask.classList.contains('show-nav') == true) {
        navMask.classList.remove('show-nav');
    } else {
        navMask.classList.add('show-nav');
    }

    if (hamburger.classList.contains('open') == true) {
        hamburger.classList.remove('open');
    } else {
        hamburger.classList.add('open');
    }
}
