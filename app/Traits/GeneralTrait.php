<?php

namespace app\Traits;

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



    public function getResponse($message, $success, $data)
    {
        return [
            'message' => $message,
            'success' => $success,
            'data' => $data
        ];
    }

    public function getResponseAuth($message, $success)
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
}
