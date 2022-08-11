<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use GeneralTrait;

    public function index()
    {
        $result = Category::orderBy('id', 'desc')->simplePaginate();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponse(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }

    public function categoryParent()
    {
        $result = Category::where('parent_id','=',null)->orderBy('id', 'desc')->simplePaginate();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponse(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }

    public function categoryChildren($id)
    {

        $ruls = ['id' => 'required|numeric'];
        if ($this->getErrorIfAny(['id' => $id], $ruls)) {
            return $this->getErrorIfAny(['id' => $id], $ruls);
        }

        $result = Category::where('parent_id','=',$id)->orderBy('id', 'desc')->simplePaginate();

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
            'category_name' => 'required|string',
            'category_icon' => 'required|image',
        ];

        if ($this->getErrorIfAny($request->all(), $ruls)) {
            return $this->getErrorIfAny($request->all(), $ruls);
        }

        $imageName = $request['category_icon']->store(config('paths.category_image_path'), 'public');
        $urlImage =  config('paths.storage_path') . $imageName;

        $category = new Category();
        $category['category_name'] =  $request['category_name'];
        $category['category_icon'] =  $urlImage;
        $category['parent_id'] =  $request['parent_id'];

        $result = $category->save();

        if ($result) {
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $category), 200);
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

        $result = Category::find($id);

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
            'category_name' => 'required|string',
        ];
        $fialds = [
            'id' => $id,
            'category_name' => $request['category_name'],
        ];

        if ($this->getErrorIfAny($fialds, $ruls)) {
            return $this->getErrorIfAny($fialds, $ruls);
        }

        $category = Category::find($id);

        $result = null;
 
        if ($category != null) {
            if ($request->hasFile('category_icon')) {

                $imageName = $request['category_icon']->store(config('paths.category_image_path'), 'public');
                $urlImage =  config('paths.storage_path') . $imageName;

                $result = $category->update([
                    'category_name' => $request['category_name'],
                    'category_icon' => $urlImage,
                    'parent_id' => $request['parent_id']
                ]);
            } else {
                
                $result = $category->update([
                    'category_name' => $request['category_name'],
                    'parent_id' => $request['parent_id']
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

        $category = Category::find($id);
        $result = null;

        if ($category) {
            $result = $category->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
