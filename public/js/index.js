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


// // お気に入りタグに対してクリックイベントを適用
// const favoriteTags = document.getElementsByClassName('fav-tag');
// for(let i = 0; i < favoriteTags.length; i++) {
//     favoriteTags[i].addEventListener('click', switchFavoriteTags, false);
// }

// // お気に入りタグをクリックすると実行する関数
// function switchFavoriteTags(){

//     // classの切り替え
//     // .fav-onがついていれば外す
//     // .fav-onがついていなければつける
//     const arrayFavoriteTags = Array.prototype.slice.call(favoriteTags);
//     const index = arrayFavoriteTags.indexOf(this);
//     const targetTag = document.getElementsByClassName('fav-tag')[index];
//     const tagclasses = Array.from(targetTag.classList);
//     if (tagclasses.includes('fav-on') == true) {
//         targetTag.classList.remove('fav-on');
//     } else {
//         targetTag.classList.add('fav-on');
//     }
// };


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


// tag
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


function newTextCreate() {
    area2.value = area.value;
	if (area2.value) {
	    //入力内容を改行ごとに分けて配列に格納
        let formText = area2.value.split('\n');
        //画像パスを拾う
        let aryCheck = formText.filter(value => value.includes('storage/content_imgs/'));
        
        aryCheck.forEach(function(element) {
            //パス部分とテキスト部分を分ける
            let cutElem = element.substr(0, element.indexOf('.jpg') + 4);
            let cutText = element.substr(element.indexOf('.jpg') + 4);
            //パス部分にimgタグを付与して配列に格納し直す
            // let imgTag = "<img src=\"" + cutElem + "\">"
            // let imgTag = "<div class=\"PostContent-imgs\"><img style=\"max-width: 90%\" src=\"https://b0b0704b8c11464390acf6e91a447ae8.vfs.cloud9.us-west-2.amazonaws.com/" + cutElem + "\"></div>"
            console.log(cutElem);
            // cutElem = '../storage/content_imgs/Hokuto.1649828956409.jpg'; // 
            let imgTag = "<div class=\"PostContent-imgs\"><img style=\"max-width: 90%\" src=\"../" + cutElem + "\"></div>"
            formText[formText.indexOf(element)] = imgTag;
            //テキスト部分を配列に格納
            formText.splice(formText.indexOf(imgTag) + 1, 0, cutText);
        });
        //入力内容の配列の要素を<br>で繋ぐ
        let newFormText = formText.join('<br>');
        
        area2.value = newFormText;
    }    
}

//textarea取得
var area = document.getElementById('content');
var area2 = document.getElementById('content_htmlTag');
//プレビューボタン取得
const check = document.getElementById('postContent_preview-btn');
//プレビューボタンのクリックイベント
if (check) {
    check.addEventListener('click', function() {
    //textareaの入力内容にimgタグ付与
    newTextCreate();
    //phpにpost
	let preview = document.getElementById('postContent_preview');
	preview.click();
})    
}


//保存ボタン取得
const save_btn = document.getElementById('save-btn');
//保存ボタンのクリックイベント
if (save_btn) {
    save_btn.addEventListener('click', function() {
    //textareaの入力内容にimgタグ付与
    newTextCreate();
    //phpにpost
	let save = document.getElementById('postContent_save');
	save.click();
})
    
}

const fileSelect = document.getElementById("fileSelect"),
      fileElem = document.getElementById("fileElem");
if (fileSelect) {
    fileSelect.addEventListener("click", function () {
      if (fileElem) {
        fileElem.click();
      }
    }, false);
}
    

function addText3()
{

    var datetime = Date.now();
    var file_name =  user_name + "." + datetime + "." + "jpg";

    let fileName = document.getElementById('fileName');
    fileName.value = file_name;

	var text ="\n" + "storage/content_imgs/" + file_name + "\n";
	
	//カーソルの位置を基準に前後を分割して、その間に文字列を挿入
	area.value = area.value.substr(0, area.selectionStart)
			+ text
			+ area.value.substr(area.selectionStart);
			
	newTextCreate();
	
	let preview = document.getElementById('postContent_preview');
	preview.click();
	
}

// 新規投稿作成のタイトル保存
let postTitle_store_btn = document.getElementById('postTitle-store-btn');
let postTitle_store = document.getElementById('postTitle-store');
if (postTitle_store_btn) {
    postTitle_store_btn.addEventListener("click", function(e) {
        postTitle_store.click();
    })    
}
// 新規投稿作成のサムネイルプレビュー
let postThumnail_store_btn = document.getElementById('postThumnail-store-btn');
let postThumnail_store = document.getElementById('postThumnail-store');
if (postThumnail_store_btn) {
    postThumnail_store_btn.addEventListener("click", function(e) {
        var datetime = Date.now();
        var file_name =  user_name + "." + datetime + "." + "jpg";
    
        let fileName = document.getElementById('fileName');
        fileName.value = file_name;
        console.log(fileName.value);
        
        // let imgTag = "https://b0b0704b8c11464390acf6e91a447ae8.vfs.cloud9.us-west-2.amazonaws.com/storage/thumnail_imgs/" + file_name;
        let imgTag = "storage/thumnail_imgs/" + file_name;

        console.log(imgTag);
        let thumnailPath = document.getElementById('thumnailPath');
        thumnailPath.value = imgTag;
        console.log(thumnailPath.value);
        let postTitle_textarea = document.getElementById('postTitle_textarea');
        let postTitle = document.getElementById('postTitle');
        console.log(postTitle.value);
        console.log(postTitle_textarea);
        postTitle_textarea.value = postTitle.value;
        console.log(postTitle_textarea);
        postThumnail_store.click();
    })    
}
// 新規投稿作成のサムネイル保存
let thumnailFileSelect_btn = document.getElementById('thumnailFileSelect-btn');
let thumnailFileSelect = document.getElementById('thumnailFileSelect');
if (thumnailFileSelect_btn) {
    thumnailFileSelect_btn.addEventListener("click", function(e) {
        thumnailFileSelect.click();
    })

    thumnailFileSelect.addEventListener("change", function(e) {
        
        const file = e.target.files;
        const reader = new FileReader();
        reader.readAsDataURL(file[0]);
        reader.onload = () => {
            const image = document.getElementById('img');
            image.src = reader.result;
        };    
    	
    })
}

// お気に入りタグに対してクリックイベントを適用
const postTags = document.getElementsByClassName('post-tag');
for(let i = 0; i < postTags.length; i++) {
    postTags[i].addEventListener('click', switchPostTags, false);
}

// お気に入りタグをクリックすると実行する関数
function switchPostTags(){

    // classの切り替え
    // .tag-onがついていれば外す
    // .tag-onがついていなければつける
    const arrayPostTags = Array.prototype.slice.call(postTags);
    const index = arrayPostTags.indexOf(this);
    const targetTag = document.getElementsByClassName('post-tag')[index];
    const tagclasses = Array.from(targetTag.classList);
    if (tagclasses.includes('tag-on') == true) {
        targetTag.classList.remove('tag-on');
    } else {
        targetTag.classList.add('tag-on');
    }
};

