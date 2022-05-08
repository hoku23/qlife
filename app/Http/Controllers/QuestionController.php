<?php

namespace App\Http\Controllers;

use App\Question;
use App\Question_tag_notice;
use App\Answer;
use App\Answer_comment;
use App\Follow;
use App\User;
use Mail;
use App\Mail\QuestionNotification;
use App\Mail\RequestNotification;
use App\Question_tag;
use App\Question_request;
use Validator;
use Illuminate\Http\Request;
use App\Jobs\SendQuestionedMail;
use App\Jobs\SendRequestMail;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $questions = Question::where('user_id', $user->user_id)->where('release_flag', 1)->orderBy('question_date', 'desc')->orderBy('question_time', 'desc')->get();
            
        $newQuestions =[];
        foreach ($questions as $question) {
            $tagsRecords = Question_tag::where('question_id', $question->question_id)->get();
            $tags =[];
            foreach ($tagsRecords as $tagsRecord) {
                $tag = $tagsRecord->tag_name;
                array_push($tags, $tag);
            }
            $question['tags'] = $tags;
            
            $answers_num = Answer::where('question_id', $question->question_id)->where('release_flag', 1)->get()->count();
            
            $question['answers'] = $answers_num;
            array_push($newQuestions, $question);
        }
        
        return view('questions.index', compact('user', 'newQuestions'));
    }
    
    public function question_list_show()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $questions = Question::where('release_flag', 1)->orderBy('question_date', 'desc')->orderBy('question_time', 'desc')->get();
            
        $newQuestions =[];
        foreach ($questions as $question) {
            $tagsRecords = Question_tag::where('question_id', $question->question_id)->get();
            $tags =[];
            foreach ($tagsRecords as $tagsRecord) {
                $tag = $tagsRecord->tag_name;
                array_push($tags, $tag);
            }
            $question['tags'] = $tags;
            
            $question_user = User::where('user_id', $question->user_id)->first();
            $question['user_icon'] = $question_user->user_icon;
            $question['user_name'] = $question_user->user_name;
            
            $answers_num = Answer::where('question_id', $question->question_id)->where('release_flag', 1)->get()->count();
            
            $question['answers'] = $answers_num;

            array_push($newQuestions, $question);
        }
        
        return view('questions.list', compact('user', 'newQuestions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $user_name = $user->user_name;
        $param_json = json_encode($user_name);
        
        $session_title = session()->get('question_title');
        $session_content = session()->get('question_content');
        $session_input_content = session()->get('question_input_content');
        $session_try = session()->get('question_try');
        $session_input_try = session()->get('question_input_try');
        
        
        if (isset($session_title)) {
            $title = $session_title;
        } else {
            $title = old('title');
        }
        if (isset($session_content)) {
            $content_htmlTag = $session_content;
        } else {
            $content_htmlTag = old('content_htmlTag');
        }
        if (isset($session_try)) {
            $try_htmlTag = $session_try;
        } else {
            $try_htmlTag = old('try_htmlTag');
        }
        if (isset($session_input_content)) {
            $content = $session_input_content;
        } else {
            $content = old('content');
        }
        if (isset($session_input_try)) {
            $try = $session_input_try;
        } else {
            $try = old('try');
        }
        
        $file_name = old('file_name');
        
        
        return view('questions.content_title_create', compact('user', 'param_json', 'file_name', 'content', 'content_htmlTag', 'title', 'try', 'try_htmlTag'));
    }
    
    public function store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $file_name = $request->input('file_name');
        $title = $request->input('title');
        $content = $request->input('content');
        $content_htmlTag = $request->input('content_htmlTag');
        $try = $request->input('try');
        $try_htmlTag = $request->input('try_htmlTag');
        
        $values = [
            'file_name' => $file_name,
            'title' => $title,
            'content' => $content,
            'content_htmlTag' =>$content_htmlTag,
            'try' => $try,
            'try_htmlTag' => $try_htmlTag
        ];
            
        
        if ($request->file('content_img')) {
            $img = $request->file('content_img')->storeAs('question_imgs', $file_name, 'public');
        } 
        
        if ($request->file('try_img')) {
            $img = $request->file('try_img')->storeAs('question_imgs', $file_name, 'public');
        } 
        
        if ($request->input('action') == 'preview') {
            session()->put('question_content', $content_htmlTag);
            session()->put('question_input_content', $content);
            return redirect()->route('question.create')->withInput($values);   
        } else {
            session()->put('question_title', $title);
            session()->put('question_content', $content_htmlTag);
            session()->put('question_input_content', $content);
            session()->put('question_try', $try_htmlTag);
            session()->put('question_input_try', $try);
            if (empty($try)) {
                session()->put('question_try', '特になし');
            }
            return redirect()->route('question.create_tags');
        }
    }
    
    public function create_tags()
    {
        Log::info('question.create_tags通過');
        
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $tags = session()->get('question_tags');
        $param_json = json_encode($tags);
        
        $selected_users = session()->get('question_selected_users');
        $users_param_json = json_encode($selected_users);
        
        $follow_users = [];
        
        $follows = Follow::where('user_id', $user->user_id)->get();
        foreach ($follows as $follow) {
            $follow_user = User::where('user_id', $follow->follow_user_id)->first();
            array_push($follow_users, $follow_user);
        }
        
        return view('questions.create_tags', compact('user', 'param_json', 'users_param_json', 'follow_users'));
    }
    
    public function store_tags(Request $request)
    {
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換
        
        // やりたい処理
        
        $result = $data;
        
        session()->put('question_tags', $result);
        $tags = session()->get('question_tags');
        
        $res = 'Complete';
        echo json_encode($res);
        
        //非同期処理でsessionに保存
        //タグとユーザー両方sessionnがあれば確認画面にredirect
        //もう片方がなければ同じ画面にredirect
        //sessionがあれば値を取り出してload時にjsでclassをつける
    }
    
    public function store_users(Request $request)
    {
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換
        
        // やりたい処理
        
        $result = $data;
        
        session()->put('question_selected_users', $result);
        $selected_users = session()->get('question_selected_users');
        
        // $res = 'Complete';
        $res = $selected_users;
        echo json_encode($res);
        
        //非同期処理でsessionに保存
        //タグとユーザー両方sessionnがあれば確認画面にredirect
        //もう片方がなければ同じ画面にredirect
        //sessionがあれば値を取り出してload時にjsでclassをつける
    }
    
    public function redirect()
    {
        Log::info('question.redirect通過1');
        
        $tags = session()->get('question_tags');
        $selected_users = session()->get('question_selected_users');
        
        Log::info('question.redirect通過5');
        
        if (isset($tags) && isset($selected_users)) {
            Log::info('question.redirect通過2');
            return redirect()->route('question.confirm');
        } elseif (isset($tags)) {
            Log::info('question.redirect通過3');
            return redirect()->route('question.create_tags')->with('message', 'ユーザーを選択してください');
        } elseif (isset($selected_users)) {
            Log::info('question.redirect通過4');
            return redirect()->route('question.create_tags')->with('message', 'タグ選択を保存してください');
        }
        
    }
    
    public function confirm()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $tags = session()->get('question_tags');
        $title = session()->get('question_title');
        $content = session()->get('question_content');
        $try = session()->get('question_try');
        $selected_users_ids = session()->get('question_selected_users');
        $selected_users = [];
        if (isset($selected_users_ids)) {
            foreach ($selected_users_ids as $selected_user_id) {
            if ($selected_user_id !== 'NoBody') {
                $selected_user = User::where('user_id', $selected_user_id)->first();
                array_push($selected_users, $selected_user);    
            }
        }   
        }
        
        return view('questions.confirm', compact('user', 'tags', 'title', 'content', 'try', 'selected_users'));
    }
    
    private $validator = [
            'question_title' =>'required|string',
            'question_content' => 'required|string',
            'question_try' => 'required|string',
        ]; 
        
    public function release_question()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $input = [
            'question_title' => session()->get('question_title'),
            'question_content' => session()->get('question_content'),
            'question_try' => session()->get('question_try'),
            ];
        $validator = Validator::make($input, $this->validator);
        
        if ($validator->fails()) {
            return redirect()->route('question.confirm')
                             ->withErrors($validator);
        } else {
            $question = new Question();
            $question->question_title = session()->get('question_title');
            $question->question_content = session()->get('question_content');
            $question->question_try = session()->get('question_try');
            $question->question_date = date('Y.m.d');
            session()->put('question_date', $question->question_date);
            $question->question_time = date('H:i:s');
            session()->put('question_time', $question->question_time);
            $question->user_id = session()->get('user')->user_id;
            $question->release_flag = 1;
            $question->save();
            
            $target_question = Question::where('question_date', session()->get('question_date'))->where('question_time', session()->get('question_time'))->where('user_id', $user->user_id)->first();
            $question_id = $target_question->question_id;
        
            
            session()->forget('question_title');
            session()->forget('question_content');
            session()->forget('question_input_content');
            session()->forget('question_try');
            session()->forget('question_input_try');
            
            $tags = session()->get('question_tags');
            
            if (isset($tags)) {
                foreach ($tags as $tag) {
                    $question_tag = new Question_tag();
                    $question_tag->question_id = $question_id;
                    $question_tag->tag_name = $tag;
                    $question_tag->save();
                }
            }
            session()->forget('question_tags'); 
            
            $selected_users_ids = session()->get('question_selected_users');
            if (isset($selected_users_ids)) {
                foreach ($selected_users_ids as $selected_users_id) {
                    if ($selected_users_id !== 'NoBody') {
                        $request = new Question_request();
                        $request->question_id = $question_id;
                        $request->selected_user = $selected_users_id;
                        $request->save();
                    }
                }
            }
            
            session()->forget('question_selected_users');
            
            $question_user = User::where('user_id', $question->user_id)->first();
            
            $request_users = [];
    	    $users = [];
    	    $not_user = [];
    	    
    	    $question_tags = implode('/', $tags);
    	    
    	    
    	        foreach ($selected_users_ids as $selected_users_id) {
        	        $request_user = User::where('user_id', $selected_users_id)->first();
        	        if (isset($request_user)) {
            	        array_push($request_users, $request_user);
            	        array_push($not_user, $request_user->user_id);
        	        }
        	    }    
    	    
    	    if (isset($tags)) {
    	        foreach ($tags as $tag) {
        	        $notice_tags = Question_tag_notice::where('tag_name', $tag)->whereNotIn('user_id', $not_user)->get();
        	        foreach ($notice_tags as $notice_tag) {
        	            $notice_tags_user = User::where('user_id', $notice_tag->user_id)->first();
        	            array_push($users, $notice_tags_user);
        	            array_push($not_user, $notice_tags_user->user_id);   
        	        }
        	    }    
    	    }
    	     
    	   
    	    
    	    $question_user_id = $question->user_id;
    	    $question_title = $question->question_title;
    	    
    	    SendRequestMail::dispatch($question_user_id, $question_title, $question_tags, $request_users);
    	    SendQuestionedMail::dispatch($question_user_id, $question_title, $question_tags, $users);
    	    
    	    
            
            
            return view('questions.complete', compact('user'));    
        }
        
        
    }
    
    public function draft_question()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $input = [
            'question_title' => session()->get('question_title'),
            'question_content' => session()->get('question_content'),
            'question_try' => session()->get('question_try'),
            ];
        $validator = Validator::make($input, $this->validator);
        
        if ($validator->fails()) {
            return redirect()->route('question.confirm')
                             ->withErrors($validator);
        } else {
            $question = new Question();
            $question->question_title = session()->get('question_title');
            $question->question_content = session()->get('question_content');
            $question->question_try = session()->get('question_try');
            $question->question_date = date('Y.m.d');
            session()->put('question_date', $question->question_date);
            $question->question_time = date('H:i:s');
            session()->put('question_time', $question->question_time);
            $question->user_id = session()->get('user')->user_id;
            $question->release_flag = 0;
            $question->save();
            
            $target_question = Question::where('question_date', session()->get('question_date'))->where('question_time', session()->get('question_time'))->where('user_id', $user->user_id)->first();
            $question_id = $target_question->question_id;
        
            
            session()->forget('question_title');
            session()->forget('question_content');
            session()->forget('question_input_content');
            session()->forget('question_try');
            session()->forget('question_input_try');
            
            $tags = session()->get('question_tags');
            
            if (isset($tags)) {
                foreach ($tags as $tag) {
                    $question_tag = new Question_tag();
                    $question_tag->question_id = $question_id;
                    $question_tag->tag_name = $tag;
                    $question_tag->save();
                }
            }
            session()->forget('question_tags'); 
            
            $selected_users_ids = session()->get('question_selected_users');
            if (isset($selected_users_ids)) {
                foreach ($selected_users_ids as $selected_users_id) {
                    if ($selected_users_id !== 'NoBody') {
                        $request = new Question_request();
                        $request->question_id = $question_id;
                        $request->selected_user = $selected_users_id;
                        $request->save();
                    }
                }
            }
            
            session()->forget('question_selected_users');
            
            
            return view('questions.draft', compact('user'));    
        }
    }
    
    public function question_detail(Request $request)
    {
        $detail_question_id = $request->input('question_id');
        
        $values = [
            'question_id' => $detail_question_id,
            ];
        
        return redirect()->route('question.users_question')->withInput($values);
    }

    public function users_question(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $question_id = old('question_id');
        if (empty($question_id)) {
            return redirect()->route('question_list_show');
        }
        
        $question = Question::where('question_id', $question_id)->first();
        $question_user = User::where('user_id', $question->user_id)->first();
        $question['user_name'] = $question_user->user_name;
        $question['user_icon'] = $question_user->user_icon;
        
        $tagsRecords = Question_tag::where('question_id', $question->question_id)->get();
        $tags =[];
        foreach ($tagsRecords as $tagsRecord) {
            $tag = $tagsRecord->tag_name;
            array_push($tags, $tag);
        }
        $question['tags'] = $tags;
        
        $answers = [];
        if ($question->best_answer_id !== null) {
            $best_answer = Answer::where('answer_id', $question->best_answer_id)->first();
            $best_answer_id = $best_answer->answer_id;
            $best_answer_user = User::where('user_id', $best_answer->user_id)->first();
            $best_answer['user_icon'] = $best_answer_user->user_icon;
            $best_answer['user_name'] = $best_answer_user->user_name;
            $comment_count = Answer_comment::where('path', 'like', "$best_answer_id/%")->get()->count();
            $best_answer['comment'] = $comment_count;
            
            array_push($answers, $best_answer);
        } else {
            $best_answer_id = 0;
        }
        
        $question_answers = Answer::where('question_id', $question->question_id)->where('release_flag', 1)->whereNotIn('answer_id', [$best_answer_id])->get();
        foreach ($question_answers as $answer) {
            $answer_user = User::where('user_id', $answer->user_id)->first();
            $answer['user_icon'] = $answer_user->user_icon;
            $answer['user_name'] = $answer_user->user_name;
            
            $answer_id = $answer->answer_id;
            $comment_count = Answer_comment::where('path', 'like', "$answer_id/%")->get()->count();
            $answer['comment'] = $comment_count;
            
            array_push($answers, $answer);
        }
        
        $answers_num = count($answers);
        
        
        $draft_question_answers = Answer::where('question_id', $question->question_id)->where('user_id', $user->user_id)->where('release_flag', 0)->whereNotIn('answer_id', [$best_answer_id])->get();
        $draft_answers = [];
        foreach ($draft_question_answers as $draft_answer) {
            $draft_answer_user = User::where('user_id', $draft_answer->user_id)->first();
            $draft_answer['user_icon'] = $draft_answer_user->user_icon;
            $draft_answer['user_name'] = $draft_answer_user->user_name;
            
            $draft_answer_id = $draft_answer->answer_id;

            array_push($draft_answers, $draft_answer);
        }
        
        $draft_answers_num = count($draft_answers);

        return view('questions.users_question', compact('user', 'question', 'answers', 'answers_num', 'draft_answers', 'draft_answers_num'));
    }
    
    public function question_delete(Request $request)
    {
        $question_id = $request->input('question_id');
        Question::where('question_id', $question_id)->delete();
        Question_tag::where('question_id', $question_id)->delete();
        $answers = Answer::where('question_id', $question_id)->get();
        foreach ($answers as $answer) {
            $answer_id = $answer->answer_id;
            Answer_comment::where('path', 'like', "$answer_id/%")->delete();   
        }
        Answer::where('question_id', $question_id)->delete();

        return redirect()->route('question.question_deleted');
    }
    
    public function question_deleted()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        return view('questions.deleted', compact('user'));
    }
    
    public function show_draft_question()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $questions = Question::where('user_id', $user->user_id)->where('release_flag', 0)->orderBy('question_date', 'desc')->orderBy('question_time', 'desc')->get();
            
        $newQuestions =[];
        foreach ($questions as $question) {
            $tagsRecords = Question_tag::where('question_id', $question->question_id)->get();
            $tags =[];
            foreach ($tagsRecords as $tagsRecord) {
                $tag = $tagsRecord->tag_name;
                array_push($tags, $tag);
            }
            $question['tags'] = $tags;
            
            $answers_num = Answer::where('question_id', $question->question_id)->get()->count();
            
            $question['answers'] = $answers_num;
            array_push($newQuestions, $question);
        }
        
        return view('questions.draft_question', compact('user', 'newQuestions'));
    }
    
    public function release_flag_chnge(Request $request)
    {
        $question_id = $request->input('question_id');
        $question = Question::where('question_id', $question_id)->first();
        Question::where('question_id', $question_id)->update(['release_flag' => 1]);
        
        $question_tags = Question_tag::where('question_id', $question_id)->get();
        $tags = [];
        foreach ($question_tags as $question_tag) {
            array_push($tags, $question_tag->tag_name);
        }
        
        $question_requests = Question_request::where('question_id', $question_id)->get();
        $selected_users_ids = [];
        foreach ($question_requests as $question_request) {
            array_push($selected_users_ids, $question_request->selected_user);
        }
        
        $question_user = User::where('user_id', $question->user_id)->first();
            
        $request_users = [];
	    $users = [];
	    $not_user = [];
	    
	    $question_tags = implode('/', $tags);
	    
	    foreach ($selected_users_ids as $selected_users_id) {
	        $request_user = User::where('user_id', $selected_users_id)->first();
	        array_push($request_users, $request_user);
	        array_push($not_user, $request_user->user_id);
	    }
	    
	    foreach ($tags as $tag) {
	        $notice_tags = Question_tag_notice::where('tag_name', $tag)->whereNotIn('user_id', $not_user)->get();
	        foreach ($notice_tags as $notice_tag) {
	            $notice_tags_user = User::where('user_id', $notice_tag->user_id)->first();
	            array_push($users, $notice_tags_user);
	            array_push($not_user, $notice_tags_user->user_id);   
	        }
	    }
	    
	    $question_user_id = $question->user_id;
	    $question_title = $question->question_title;
	    
	    SendRequestMail::dispatch($question_user_id, $question_title, $question_tags, $request_users);
	    SendQuestionedMail::dispatch($question_user_id, $question_title, $question_tags, $users);
        
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        return view('questions.complete', compact('user'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
