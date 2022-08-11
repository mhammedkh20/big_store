<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    use GeneralTrait;

    public function index()
    {
        $result = Brand::orderBy('id', 'desc')->simplePaginate();

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
            'brand_name' => 'required|string',
            'brand_icon' => 'required|image',
        ];

        if ($this->getErrorIfAny($request->all(), $ruls)) {
            return $this->getErrorIfAny($request->all(), $ruls);
        }

        $imageName = $request->brand_icon->store(config('paths.brand_image_path'), 'public');
        $urlImage =  config('paths.storage_path') . $imageName;

        $brand = new Brand();
        $brand['brand_name'] =  $request['brand_name'];
        $brand['brand_icon'] =  $urlImage;


        $result = $brand->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $brand), 200);
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

        $result = Brand::find($id);

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
            'id' =>  'required|numeric',
            'brand_name' => 'required|string',
        ];
        $fialds = [
            'id' => $id,
            'brand_name' => $request->brand_name,
        ];

        if ($this->getErrorIfAny($fialds, $ruls)) {
            return $this->getErrorIfAny($fialds, $ruls);
        }

        $brand = Brand::find($id);

        $result = null;

        if ($brand != null) {
            if ($request->hasFile('brand_icon')) {
        
                $imageName = $request->brand_icon->store(config('paths.brand_image_path'), 'public');
                $urlImage =  config('paths.storage_path') . $imageName;

                
                $result = $brand->update([
                    'brand_name' => $request->brand_name,
                    'brand_icon' => $urlImage,
                ]);
            } else {
                $result = $brand->update([
                    'brand_name' => $request->brand_name,
                ]);
            }
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

        $brand = Brand::find($id);
        $result = null;

        if ($brand) {
            $result = $brand->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
