<?php

namespace App\Http\Controllers;

use App\Models\StoreImages;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class StoreImagesController extends Controller
{
    use GeneralTrait;

    protected $ruls = [
        'store_id' => 'required|numeric',
    ];

    public function index()
    {
        $result = StoreImages::with(['store'])->orderBy('id', 'desc')->simplePaginate();

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


    public function uploadImages($pictures_available_upload, $store_id)
    {
        $number_images_success_uploded = 0;
        $images_urls = array();
        for ($i = 0; $i < count($pictures_available_upload); $i++) {

            $image = $pictures_available_upload[$i];

            $path = config('paths.storage_path') .
                $image->store(config('paths.store_image_path'), 'public');

            //store image file into directory and db
            $store_images = new StoreImages();
            $store_images['store_id'] = $store_id;
            $store_images['image_url'] = $path;
            $result = $store_images->save();
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

        $uploded_files = $this->uploadImages($pictures_available_upload, $request['store_id']);

        $number_images_success_uploded = $uploded_files['number_images_success_uploded'];

        $images_urls = $uploded_files['images_urls'];

        if ($number_images_success_uploded == 0) {
            return response($this->getResponseFail(trans('my_keywords.invalidFileFormat'), false), 422);
        } else {
            $data = [
                'store_id' => (int) $request['store_id'],
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

        $result = StoreImages::with(['store'])->find($id);

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

        $store_images = StoreImages::find($id);
        $result = null;

        if ($store_images) {
            $result = $store_images->delete();
        }

        if ($result) {
            return response($this->getResponseFail(__('my_keywords.operationSuccessfully'), true, $result), 200);
        } else {
            return response($this->getResponseFail(__('my_keywords.somethingWrong'), false, null), 422);
        }
    }
}
