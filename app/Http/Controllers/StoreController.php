<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $result = Store::orderBy('id', 'desc')->get();

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
            'store_name' => 'required|string',
            'store_description' => 'required|string',
            'phone' => 'required|string|min:10|max:10',
            'street' => 'required|string',
            'city_id' => 'required|numeric',
            'location_latitude' => 'required|numeric',
            'location_longitude' => 'required|numeric',
            'state' => 'required|boolean',
        ];

        if ($this->getErrorIfAny($request->all(), $ruls)) {
            return $this->getErrorIfAny($request->all(), $ruls);
        }

        $store = new Store();
        $store['store_name'] = $request['store_name'];
        $store['store_description'] =  $request['store_description'];
        $store['phone'] =  $request['phone'];
        $store['phone_whatsapp'] =  $request['phone_whatsapp'];
        $store['url_facebook'] =  $request['url_facebook'];
        $store['url_instegram'] =  $request['url_instegram'];
        $store['street'] =  $request['street'];
        $store['city_id'] =  $request['city_id'];
        $store['location_latitude'] =  $request['location_latitude'];
        $store['location_longitude'] =  $request['location_longitude'];
        $store['state'] =  $request['state'];

        $result = $store->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $store), 200);
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

        $result = Store::find($id);

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
            'store_name' => 'required|string',
            'store_description' => 'required|string',
            'phone' => 'required|string|min:10|max:10',
            'street' => 'required|string',
            'city_id' => 'required|numeric',
            'location_latitude' => 'required|numeric',
            'location_longitude' => 'required|numeric',
            'state' => 'required|boolean',
        ];

        $fialds = [
            'id' => $id,
            'store_name' => $request->store_name,
            'store_description' => $request->store_description,
            'location_latitude' => $request->location_latitude,
            'location_longitude' => $request->location_longitude,
            'street' => $request->street,
            'phone' => $request->phone,
            'state' => $request->state,
            'city_id' => $request->city_id,
        ];
        
        if ($this->getErrorIfAny($fialds, $ruls)) {
            return $this->getErrorIfAny($fialds, $ruls);
        }
        
        $store = Store::find($id);
        
        $result = null;

        if ($store != null) {
            $result = $store->update([
                'store_name' => $request->store_name,
                'phone_whatsapp' => $request->phone_whatsapp,
                'url_facebook' => $request->url_facebook,
                'url_instegram' => $request->url_instegram,
                'store_description' => $request->store_description,
                'location_latitude' => $request->location_latitude,
                'location_longitude' => $request->location_longitude,
                'street' => $request->street,
                'phone' => $request->phone,
                'state' => $request->state,
                'city_id' => $request->city_id,
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

        $point = Store::find($id);
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
