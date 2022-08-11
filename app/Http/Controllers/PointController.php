<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class PointController extends Controller
{

    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Point::/*with(['orders','user','city'])->*/orderBy('id', 'desc')->simplePaginate();

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
            'user_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'street' => 'required|string',
            'place_detail' => 'required|string',
            'location_latitude' => 'required|numeric',
            'location_longitude' => 'required|numeric',
            'name' => 'required|string',
            'phone' => 'required|string|min:10|max:10',
        ];

        if ($this->getErrorIfAny($request->all(), $ruls)) {
            return $this->getErrorIfAny($request->all(), $ruls);
        }

        $point = new Point();
        $point['user_id'] =  $request['user_id'];
        $point['city_id'] =  $request['city_id'];
        $point['street'] =  $request['street'];
        $point['place_detail'] =  $request['place_detail'];
        $point['location_latitude'] =  $request['location_latitude'];
        $point['location_longitude'] =  $request['location_longitude'];
        $point['name'] =  $request['name'];
        $point['phone'] =  $request['phone'];


        $result = $point->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $point), 200);
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

        $result = Point::find($id);

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
            'street' => 'required|string',
            'place_detail' => 'required|string',
            'location_latitude' => 'required|numeric',
            'location_longitude' => 'required|numeric',
            'name' => 'required|string',
            'phone' => 'required|string|min:10|max:10',
        ];

        $fialds = [
            'id' => $id,
            'street' => $request->street,
            'place_detail' => $request->place_detail,
            'location_latitude' => $request->location_latitude,
            'location_longitude' => $request->location_longitude,
            'name' => $request->name,
            'phone' => $request->phone,
        ];

        if ($this->getErrorIfAny($fialds, $ruls)) {
            return $this->getErrorIfAny($fialds, $ruls);
        }

        $point = Point::find($id);

        $result = null;

        if ($point != null) {
            $result = $point->update([
                'street' => $request->street,
                'place_detail' => $request->place_detail,
                'location_latitude' => $request->location_latitude,
                'location_longitude' => $request->location_longitude,
                'name' => $request->name,
                'phone' => $request->phone,
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

        $point = Point::find($id);
        $result = null;

        if ($point) {
            $result = $point->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
