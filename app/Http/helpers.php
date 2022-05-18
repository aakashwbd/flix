<?php

if (!function_exists('validateError')) {
    function validateError($errors)
    {

        $messages = [];
        foreach ($errors as $key => $value) {

            array_push($messages, [
                'field' => $key,
                'error' => $value[0],
            ]);
        }
        return response([
            'status' => 'validate_error',
            'status_code' => 422,
            'message' => $messages,
        ], 422);
    }
}
