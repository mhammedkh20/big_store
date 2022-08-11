<?php

namespace App\Http\Controllers;

use App\Models\ProductVariationsOptions;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ProductVariationOptionController extends Controller
{
    use GeneralTrait;

    protected $ruls = [
        'product_var_id' => 'required|numeric',
        'variation_option' => 'required|string',
        'add_price' => 'required|numeric',
    ];

    public function index()
    {
        $result = ProductVariationsOptions::orderBy('id', 'desc')->simplePaginate();

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

        $product_var_option = new ProductVariationsOptions();
        $product_var_option['product_var_id'] =  $request['product_var_id'];
        $product_var_option['variation_option'] =  $request['variation_option'];
        $product_var_option['add_price'] =  $request['add_price'];

        $result = $product_var_option->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $product_var_option), 200);
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

        $result = ProductVariationsOptions::find($id);

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

        $product_var_option = ProductVariationsOptions::find($id);

        $result = null;

        if ($product_var_option != null) {
            $result = $product_var_option->update([
                'product_var_id' =>  $request['product_var_id'],
                'variation_option' =>  $request['variation_option'],
                'add_price' =>  $request['add_price'],
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

        $product_var_option = ProductVariationsOptions::find($id);
        $result = null;

        if ($product_var_option) {
            $result = $product_var_option->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
