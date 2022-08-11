<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = City::orderBy('id','desc')->simplePaginate();

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ruls = ['name' => 'required|string'];

        if ($this->getErrorIfAny($request->all(), $ruls)) {
            return $this->getErrorIfAny($request->all(), $ruls);
        }

        $city = new City();
        $city['name'] = trim(preg_replace('/\t+/', '', $request['name']));


        if (count(City::where('name', '=', $city['name'])->get()) > 0) {

            return response($this->getResponse(__('my_keywords.matchingData'), false, null), 200);
        } else {

            $result = $city->save();

            if ($result) {
                return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $city), 200);
            } else {
                return response($this->getResponse(__('my_keywords.somethingWrong'), false, null), 422);
            }
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

        $result = City::find($id);

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
            'name' => 'required|string'
        ];

        $fialds = [
            'id' => $id,
            'name' => $request->name
        ];

        if ($this->getErrorIfAny($fialds, $ruls)) {
            return $this->getErrorIfAny($fialds, $ruls);
        }

        $cityName = trim(preg_replace('/\t+/', '', $request['name']));

        $city = City::find($id); //->update(['name' => $cityName])

        $result = null;

        if ($city != null) {
            $result = $city->update(['name' => $cityName]);
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

        $city = City::find($id); 
        $result = null;

        if ($city) {
            $result = $city->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
