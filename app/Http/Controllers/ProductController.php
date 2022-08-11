<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    use GeneralTrait;


   protected $ruls = [
        'category_id' => 'required|numeric',
        'store_id' => 'required|numeric',
        'brand_id' => 'required|numeric',
        'product_name' => 'required|string',
        'product_describtion' => 'required|string',
        'price' => 'required|numeric',
        'discount' => 'required|numeric',
    ];

    public function index()
    {
        $result = Product::with(['productImages','ratings','productsVariations'])->orderBy('id', 'desc')->simplePaginate();

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

        $product = new Product();
        $product['category_id'] =  $request['category_id'];
        $product['store_id'] =  $request['store_id'];
        $product['brand_id'] =  $request['brand_id'];
        $product['product_name'] =  $request['product_name'];
        $product['product_describtion'] =  $request['product_describtion'];
        $product['price'] =  $request['price'];
        $product['discount'] =  $request['discount'];

        $result = $product->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $product), 200);
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

        $result = Product::with(['productImages','ratings','productsVariations'])->find($id);

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

        $product = Product::find($id);

        $result = null;

        if ($product != null) {
            $result = $product->update([
                'category_id' =>  $request['category_id'],
                'store_id' =>  $request['store_id'],
                'brand_id' =>  $request['brand_id'],
                'product_name' =>  $request['product_name'],
                'product_describtion' => $request['product_describtion'],
                'price' => $request['price'],
                'discount' => $request['discount'],
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

        $product = Product::find($id);
        $result = null;

        if ($product) {
            $result = $product->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
