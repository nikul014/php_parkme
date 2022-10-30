<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CommonFiles\KeyConstants;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ParkingAuth
{

    use KeyConstants;

    public function __construct(){
    }

    public function handle(Request $arrParameters, Closure $next)
    {

        $validation = Validator::make($arrParameters->header(), [
            'user-id' => KeyConstants::$REQUIRED,
            'token' => KeyConstants::$REQUIRED,
        ]);

        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$INVALIDREQUEST;
            return Response::json($arrResponse);
        }

        $strDefaultToken = '1q2w3e4r5t6y';
        $strToken = $arrParameters->header('token');
        $userId = $arrParameters->header('user-id');

        if ($strToken == $strDefaultToken && (env('APP_ENV') == 'local')) {
            return $next($arrParameters);
        }
        $blnResult = $this->validateToken($strToken, $userId);
        if ($blnResult <= 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__3;
            $arrResponse[KeyConstants::$DATA] = [];
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__3_DESCRIPTION;
            return Response::json($arrResponse);
        }
        return $next($arrParameters);

    }

    public function validateToken($strToken, $userId)
    {
        try{
            $strSQL = DB::table('userdetails')
                ->where('token', '=', $strToken)
                ->where('user_id', '=', $userId);
            return $strSQL->get()->count();
        }
        catch(QueryException $exception){
            echo $exception;
            return KeyConstants::$CODE_0;
        }
    }

}
