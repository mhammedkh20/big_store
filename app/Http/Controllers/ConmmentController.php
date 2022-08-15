<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ConmmentController extends Controller
{
    
    use GeneralTrait;

    protected $ruls = [
        'rating_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'comment' => 'required|string',
    ];

    public function index()
    {
        $result = Comment::with(['user', 'rating'])->orderBy('id', 'desc')->simplePaginate();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponse(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->getErrorIfAny($request->all(), $this->ruls)) {
            return $this->getErrorIfAny($request->all(), $this->ruls);
        }

        $comment = new Comment();
        $comment['rating_id'] =  $request['rating_id'];
        $comment['user_id'] =  $request['user_id'];
        $comment['comment'] =  $request['comment'];

        $result = $comment->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $comment), 200);
        } else {
            return response($this->getResponse(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ruls = ['id' => 'required|numeric'];

        if ($this->getErrorIfAny(['id' => $id], $ruls)) {
            return $this->getErrorIfAny(['id' => $id], $ruls);
        }

        $result = Comment::with(['user', 'rating'])->find($id);

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponse(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($this->getErrorIfAny($request->all(), $this->ruls)) {
            return $this->getErrorIfAny($request->all(), $this->ruls);
        }

        $comment = Comment::find($id);

        $result = null;

        if ($comment != null) {
            $result = $comment->update([
                'rating_id' =>  $request['rating_id'],
                'user_id' =>  $request['user_id'],
                'comment' =>  $request['comment'],
            ]);
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruls = ['id' => 'required|numeric'];

        if ($this->getErrorIfAny(['id' => $id], $ruls)) {
            return $this->getErrorIfAny(['id' => $id], $ruls);
        }

        $comment = Comment::find($id);
        $result = null;

        if ($comment) {
            $result = $comment->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
