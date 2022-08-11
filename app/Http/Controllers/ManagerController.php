<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $result = Manager::with(['user'])->orderBy('id', 'desc')->simplePaginate();

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
        $ruls = [
            'store_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'active' => 'required|numeric',
        ];

        if ($this->getErrorIfAny($request->all(), $ruls)) {
            return $this->getErrorIfAny($request->all(), $ruls);
        }

        $manager = new Manager();
        $manager['store_id'] =  $request['store_id'];
        $manager['user_id'] =  $request['user_id'];
        $manager['active'] =  $request['active'];


        $result = $manager->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $manager), 200);
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

        $result = Manager::with(['user'])->find($id);

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
        $ruls = [
            'id' => 'required|numeric',
            'store_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'active' => 'required|numeric',
        ];

        $fialds = [
            'id' => $id,
            'store_id' => $request->store_id,
            'user_id' => $request->user_id,
            'active' => $request->active,
        ];

        if ($this->getErrorIfAny($fialds, $ruls)) {
            return $this->getErrorIfAny($fialds, $ruls);
        }

        $manager = Manager::find($id);

        $result = null;

        if ($manager != null) {
            $result = $manager->update([
                'street' => $request->street,
                'store_id' => $request->store_id,
                'user_id' => $request->user_id,
                'active' => $request->active,
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

        $manager = Manager::find($id);
        $result = null;

        if ($manager) {
            $result = $manager->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
