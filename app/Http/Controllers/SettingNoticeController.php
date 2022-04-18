<?php

namespace App\Http\Controllers;

use App\User;
use App\Follow;
use App\User_notice;
use App\Post_tag_notice;
use App\Question_tag_notice;
use Illuminate\Http\Request;

class SettingNoticeController extends Controller
{
    public function index()
    {
        $user = session()->get('user');
        
        $follows = Follow::where('user_id', $user->user_id)->get();
        $newFollows = [];
        
        foreach ($follows as $follow) {
            $follow_user = User::where('user_id', $follow->follow_user_id)->first();
            $notice_user_check = User_notice::where('user_id', $user->user_id)->where('notice_user_id', $follow->follow_user_id)->first();
            
            $follow_user_question_receive = $follow_user->question_receive;
            if ($follow_user_question_receive == 'yes') {
                $follow['user_name'] = $follow_user->user_name;
                $follow['user_id'] = $follow_user->user_id;
                $follow['user_icon'] = $follow_user->user_icon;
                if (isset($notice_user_check)) {
                    $follow['notice_user'] = 1;
                } else {
                    $follow['notice_user'] = 0;
                }
                array_push($newFollows, $follow);    
            }
        }
        
        $notice_users = User_notice::where('user_id', $user->user_id)->get();
        $newNotice_users = [];
        
        foreach ($notice_users as $notice_user) {
            $user_info = User::where('user_id', $notice_user->notice_user_id)->first();
            array_push($newNotice_users, $user_info);
        }
        
        //投稿タグ指定
        $newNoticePostTags = [];
        $notice_postTags = Post_tag_notice::where('user_id', $user->user_id)->get();
        foreach ($notice_postTags as $notice_postTag) {
            array_push($newNoticePostTags, $notice_postTag->tag_name);
        }
        
        $json_array = json_encode($newNoticePostTags);
        $param_json = json_encode($newNoticePostTags);
        
        $notice_post_tags = Post_tag_notice::where('user_id', $user->user_id)->get();
        
        //質問タグ指定
        $newNoticeQuestionTags = [];
        $notice_questionTags = Question_tag_notice::where('user_id', $user->user_id)->get();
        foreach ($notice_questionTags as $notice_questionTag) {
            array_push($newNoticeQuestionTags, $notice_questionTag->tag_name);
        }
        
        $json_array = json_encode($newNoticeQuestionTags);
        $param_question_json = json_encode($newNoticeQuestionTags);
        
        $notice_question_tags = Question_tag_notice::where('user_id', $user->user_id)->get();

    
        return view('settings.setting_notice', compact('user', 'newFollows', 'newNotice_users', 'param_json', 'param_question_json', 'notice_post_tags', 'notice_question_tags'));
    }
    
    public function store_notice_users(Request $request)
    {
        $user = session()->get('user');
        $notice_user_id = $request->input('notice_user_id');
        
        $notice_user_check = User_notice::where('user_id', $user->user_id)->where('notice_user_id', $notice_user_id)->first();
        
        if (isset($notice_user_check)) {
            User_notice::where('user_id', $user->user_id)->where('notice_user_id', $notice_user_id)->delete();
            return redirect()->route('settingNotice.index');    
        } else {
            $user_notice = new User_notice();
            $user_notice->user_id = $user->user_id;
            $user_notice->notice_user_id = $notice_user_id;
            $user_notice->save();
            return redirect()->route('settingNotice.index');
        }
        
        
    }
    
    public function store_postTags(Request $request)
    {
        
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換
        
        // やりたい処理
        
        $user = session()->get('user');
        $user_id = $user->user_id;
        
        $noticeTags_check = Post_tag_notice::where('user_id', $user_id)->first();
        
        if (isset($noticeTags_check)) {
            Post_tag_notice::where('user_id', $user_id)->delete();
        }
        
        foreach ($data as $tag) {
            $notice_tag = new Post_tag_notice();
            $notice_tag->user_id = $user_id;
            $notice_tag->tag_name = $tag;
            $notice_tag->save();
        }
        

        $res = 'Complete';
        // $res = $data;
        echo json_encode($res);
    }
    
    public function store_questionTags(Request $request)
    {
        
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換
        
        // やりたい処理
        
        $user = session()->get('user');
        $user_id = $user->user_id;
        
        $noticeTags_check = Question_tag_notice::where('user_id', $user_id)->first();
        
        if (isset($noticeTags_check)) {
            Question_tag_notice::where('user_id', $user_id)->delete();
        }
        
        foreach ($data as $tag) {
            $notice_tag = new Question_tag_notice();
            $notice_tag->user_id = $user_id;
            $notice_tag->tag_name = $tag;
            $notice_tag->save();
        }
        

        $res = $data;
        // $res = $data;
        echo json_encode($res);
    }
    
    public function redirect() {
        return redirect()->route('settingNotice.index')->with('message', 'お気に入りタグを保存しました');
    }
}



