<?php

namespace App\Traits;

trait GeneralTrait
{

    // public function returnCodeAccordingToInput($validator)
    // {
    //     $inputs = array_keys($validator->errors()->toArray());
    //     $code = $this->getErrorCode($inputs[0]);
    //     return $code;
    // }

    public function getMessageError($validator)
    {
        return $validator->errors()->first();
    }

    
    public function getImagesAvailableUpload($files)
    {
        $allowedfileExtension = ['jpg', 'png', 'jpeg'];
        $images = array();
        $i = 0;
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();

            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $images[$i] = $file;
                $i++;
            }
        }
        return $images;
    }


    public function getResponse($message, $success = true, $data)
    {
        return [
            'message' => $message,
            'success' => $success,
            'data' => $data
        ];
    }

    public function getResponseFail($message, $success)
    {
        return [
            'message' => $message,
            'success' => $success,
        ];
    }

    public function getResponseAuthWithTokenAndUser($message, $token, $user, $success)
    {
        return [
            'message' => $message,
            'success' => $success,
            'user' => $user,
            'token' => $token,
        ];
    }

    public function getErrorIfAny($data, $ruls)
    {

        $validate = Validator($data, $ruls);

        $message = $this->getMessageError($validate);

        if ($validate->fails()) {
            return response($this->getResponseFail($message, false), 422);
        }
    }
}
