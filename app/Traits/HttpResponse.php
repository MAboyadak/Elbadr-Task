<?php

namespace App\Traits;

trait HttpResponse{

    public function success($data, $message=null, $code=200)
    {
        return response()->json([
            'status'    =>  'Success',
            'message'   =>  $message,
            'data'      =>  $data
        ],$code);
    }

    public function error($data, $message=null, $code)
    {
        return response()->json([
            'status'    =>  'Error Occured',
            'message'   =>  $message,
            'data'      =>  $data
        ],$code);
    }

}


?>