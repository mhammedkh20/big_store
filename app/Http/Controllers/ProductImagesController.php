<?php

namespace App\Http\Controllers;

use App\Models\ProductImages;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ProductImagesController extends Controller
{
    use GeneralTrait;

    protected $ruls = [
        'product_id' => 'required|numeric'
    ];

    public function uploadImages($pictures_available_upload, $product_id)
    {
        $number_images_success_uploded = 0;
        $images_urls = array();
        for ($i = 0; $i < count($pictures_available_upload); $i++) {

            $image = $pictures_available_upload[$i];

            $path = config('paths.storage_path') .
                $image->store(config('paths.product_image_path'), 'public');

            //store image file into directory and db
            $product_image = new ProductImages();
            $product_image['product_id'] = $product_id;
            $product_image['image_url'] = $path;
            $result = $product_image->save();
            if ($result) {
                $images_urls[$i] = $path;
                $number_images_success_uploded = $number_images_success_uploded + 1;
            }
        }
        return [
            'number_images_success_uploded' => $number_images_success_uploded,
            'images_urls' => $images_urls,
        ];
    }

    public function index()
    {
        $result = ProductImages::with(['product'])->orderBy('id', 'desc')->simplePaginate();

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

        if (!$request->hasFile('image_url')) {
            return response($this->getResponseFail(trans('my_keywords.uploadFileNotFound'), false), 400);
        }

        $files = $request->file('image_url');

        $number_photos_upload = count($files);

        $pictures_available_upload = $this->getImagesAvailableUpload($files);

        $uploded_files = $this->uploadImages($pictures_available_upload, $request['product_id']);

        $number_images_success_uploded = $uploded_files['number_images_success_uploded'];

        $images_urls = $uploded_files['images_urls'];

        if ($number_images_success_uploded == 0) {
            return response($this->getResponseFail(trans('my_keywords.invalidFileFormat'), false), 422);
        } else {
            $data = [
                'product_id' => (int) $request['product_id'],
                'number_photos_upload' => $number_photos_upload,
                'number_images_success_uploded' => $number_images_success_uploded,
                'images' => $images_urls,
            ];
            return response($this->getResponse(__('my_keywords.operationSuccessfully'), true, $data), 200);
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

        $result = ProductImages::with(['product'])->find($id);

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
        //
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

        $product_images = ProductImages::find($id);
        $result = null;

        if ($product_images) {
            $result = $product_images->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
