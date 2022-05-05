<?php

namespace App\Http\Controllers;

use App\User;
use App\Answer;
use App\Answer_comment;
use App\Question;
use App\Question_tag;
use Validator;
use Illuminate\Http\Request;
use Mail;
use App\Mail\AnswerNotification;
use App\Jobs\SendAnswerMail;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_answer(Request $request)
    {
        $question_id = $request->input('question_id');
        
        session()->put('answer_question_id', $question_id);    
        
        return redirect()->route('answer.create');
     }
     
    public function question_content()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $question_id = session()->get('answer_question_id');
        
        if (isset($question_id)) {
            $question = Question::where('question_id', $question_id)->first();
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
            
            return view('answers.question_content', compact('user', 'question'));    
        } else {
            return redirect()->route('question_list_show');
        }
        
        
    }
     
    public function create()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $question_id = session()->get('answer_question_id');
        if (isset($question_id)) {
            $user_name = $user->user_name;
            $param_json = json_encode($user_name);
            
            $session_content = session()->get('answer_input_content');
            $session_content_htmlTag = session()->get('answer_content');
            
            if (isset($session_content)) {
                $content = $session_content;
            } else {
                $content = old('content');    
            }
            
            if (isset($session_content_htmlTag)) {
                $content_htmlTag = $session_content_htmlTag;
            } else {
                $content_htmlTag = old('content_htmlTag');    
            }
            
            $file_name = old('file_name');
            
            return view('answers.create', compact('user', 'question_id', 'content', 'content_htmlTag', 'param_json'));
        } else {
            return redirect()->route('question_list_show');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $file_name = $request->input('file_name');
        $content = $request->input('content');
        $content_htmlTag = $request->input('content_htmlTag');
        
        $values = [
            'file_name' => $file_name,
            'content' => $content,
            'content_htmlTag' =>$content_htmlTag,
        ];
            
        
        if ($request->file('content_img')) {
            $img = $request->file('content_img')->storeAs('answer_imgs', $file_name, 'public');
        } 
        
        if ($request->input('action') == 'preview') {
            return redirect()->route('answer.create')->withInput($values);   
        } else {
            session()->put('answer_content', $content_htmlTag);
            session()->put('answer_input_content', $content);
            return redirect()->route('answer.confirm');
        }
    }

    public function confirm()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $content = session()->get('answer_content');
        
        return view('answers.confirm', compact('user', 'content'));
    }
    
    private $validator = [
            'answer_content' => 'required|string',
        ]; 
    
    public function release_answer()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $input = [
            'answer_content' => session()->get('answer_content'),
            ];
        $validator = Validator::make($input, $this->validator);
        
        if ($validator->fails()) {
            return redirect()->route('answer.confirm')
                             ->withErrors($validator);
        } else {
            $answer = new Answer();
            $answer->answer_content = session()->get('answer_content');
            $answer->answer_date = date('Y.m.d');
            session()->put('answer_date', $answer->answer_date);
            $answer->answer_time = date('H:i:s');
            session()->put('answer_time', $answer->answer_time);
            $answer->user_id = session()->get('user')->user_id;
            $answer->release_flag = 1;
            $answer->question_id = session()->get('answer_question_id');
            $answer->save();
            
            $target_answer = Answer::where('answer_date', session()->get('answer_date'))->where('answer_time', session()->get('answer_time'))->where('user_id', $user->user_id)->first();
            $answer_id = $target_answer->answer_id;
        
            session()->forget('answer_content');
            session()->forget('answer_input_content');
            session()->forget('answer_question_id');
            
            
            $question = Question::where('question_id', $answer->question_id)->first();
            $question_user = User::where('user_id', $question->user_id)->first();
            
            $emails = [$question_user->email];
            $answer_user_name = $user->user_name;
            $question_title = $question->question_title;
            
            SendAnswerMail::dispatch($answer_user_name, $question_title, $emails);
            
            return view('answers.complete', compact('user'));    
        }
        
        
    }
    
    public function draft_answer()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $input = [
            'answer_content' => session()->get('answer_content'),
            ];
        $validator = Validator::make($input, $this->validator);
        
        if ($validator->fails()) {
            return redirect()->route('answer.confirm')
                             ->withErrors($validator);
        } else {
            $answer = new Answer();
            $answer->answer_content = session()->get('answer_content');
            $answer->answer_date = date('Y.m.d');
            session()->put('answer_date', $answer->answer_date);
            $answer->answer_time = date('H:i:s');
            session()->put('answer_time', $answer->answer_time);
            $answer->user_id = session()->get('user')->user_id;
            $answer->release_flag = 0;
            $answer->question_id = session()->get('answer_question_id');
            $answer->save();
            
            $target_answer = Answer::where('answer_date', session()->get('answer_date'))->where('answer_time', session()->get('answer_time'))->where('user_id', $user->user_id)->first();
            $answer_id = $target_answer->answer_id;
        
            session()->forget('answer_content');
            session()->forget('answer_input_content');
            session()->forget('answer_question_id');


            return view('answers.draft', compact('user'));    
        }
    }
    
    public function answer_detail(Request $request)
    {
        $detail_answer_id = $request->input('answer_id');
        
        $values = [
            'answer_id' => $detail_answer_id,
            ];
        
        return redirect()->route('answer.users_answer')->withInput($values);
    }

    public function users_answer(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $answer_id = old('answer_id');
        
        if (empty($answer_id)) {
            return redirect()->route('question_list_show');
        }
        
        $answer = Answer::where('answer_id', $answer_id)->first();
        $answer_user = User::where('user_id', $answer->user_id)->first();
        $answer['user_name'] = $answer_user->user_name;
        $answer['user_icon'] = $answer_user->user_icon;
        
        $question = Question::where('question_id', $answer->question_id)->first();
        
        
        $question_answers = Answer::where('question_id', $question->question_id)->whereNotIn('answer_id', [$answer_id])->orderBy('answer_date', 'desc')->orderBy('answer_time', 'desc')->get();
        $answers = [];
        foreach ($question_answers as $question_answer) {
            $answer_user = User::where('user_id', $question_answer->user_id)->first();
            $question_answer['user_icon'] = $answer_user->user_icon;
            $question_answer['user_name'] = $answer_user->user_name;
            array_push($answers, $question_answer);
        }
        
        $answers_num = count($answers);
        
        $parent_comments = Answer_comment::where('path', 'like', "$answer_id%")->where('parent_comment_id', 0)->get();
        $new_parent_comments = [];
        foreach ($parent_comments as $parent_comment) {
            
            $parent_comment_user = User::where('user_id', $parent_comment->user_id)->first();
            $user_name = $parent_comment_user->user_name;
            $user_icon = $parent_comment_user->user_icon;
            $parent_comment['user_name'] = $user_name;
            $parent_comment['user_icon'] = $user_icon;
            
            $child_comments = Answer_comment::where('root_comment_id', $parent_comment->root_comment_id)->whereNotIn('comment_id', [$parent_comment->comment_id])->orderBy('order')->get();
            $new_child_comments = [];
            foreach ($child_comments as $child_comment) {
                $child_comment_user = User::where('user_id', $child_comment->user_id)->first();
                $user_name = $child_comment_user->user_name;
                $user_icon = $child_comment_user->user_icon;
                $child_comment['user_name'] = $user_name;
                $child_comment['user_icon'] = $user_icon;
                
                $p_comment = Answer_comment::where('comment_id', $child_comment->parent_comment_id)->first();
                $p_comment_user = User::where('user_id', $p_comment->user_id)->first();
                $p_comment_user_name = $p_comment_user->user_name;
                
                $child_comment['reply_user_name'] = $p_comment_user_name;
                
                array_push($new_child_comments, $child_comment);
            }
            $parent_comment['reply'] = $new_child_comments;
            array_push($new_parent_comments, $parent_comment);
        }
        
        $comment_count = Answer_comment::where('path', 'like', "$answer_id%")->get()->count();

        return view('answers.answer_detail', compact('user', 'question', 'answers', 'answers_num', 'answer', 'new_parent_comments', 'comment_count'));
    }
    
    public function bestAnswer_select(Request $request)
    {
        $answer_id = $request->input('answer_id');
        
        $values = [
            'answer_id' => $answer_id,
            ];
            
        
        $answer = Answer::where('answer_id', $answer_id)->first();
        
        $question = Question::where('question_id', $answer->question_id)->first();
        if ($question->best_answer_id == $answer_id) {
            Question::where('question_id', $answer->question_id)->update(['best_answer_id' => null]);
        } else {
            Question::where('question_id', $answer->question_id)->update(['best_answer_id' => $answer_id]);    
        }

        return redirect()->route('answer.users_answer')->withInput($values);
    }
    
    
    public function answer_delete(Request $request)
    {
        $answer_id = $request->input('answer_id');
        Answer::where('answer_id', $answer_id)->delete();
        Answer_comment::where('path', 'like', "$answer_id/%");
        
        return redirect()->route('answer.answer_deleted');
    }
    
    public function answer_deleted()
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        return view('answers.deleted', compact('user'));
    }
    
    public function release_flag_chnge(Request $request)
    {
        if (session()->has('user')) {
            $user = session()->get('user');
        } else {
            return redirect()->route('logins.index')->with('message', 'ログインしてください');
        }
        
        $answer_id = $request->input('answer_id');
        $answer = Answer::where('answer_id', $answer_id)->first();
        Answer::where('answer_id', $answer_id)->update(['release_flag' => 1]);
        
        $question = Question::where('question_id', $answer->question_id)->first();
        $question_user = User::where('user_id', $question->user_id)->first();
        
        $emails = [$question_user->email];
        $answer_user_name = $user->user_name;
        $question_title = $question->question_title;
        
        SendAnswerMail::dispatch($answer_user_name, $question_title, $emails);
        
        return view('answers.complete', compact('user'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
