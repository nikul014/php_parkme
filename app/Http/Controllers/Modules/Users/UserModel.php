<?php

namespace App\Http\Controllers\Modules\Users;

use App\Http\Controllers\Modules\Vendor\VendorModel;
use App\Http\Controllers\PHPMailerController;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonFiles\KeyConstants;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserModel
{
    use KeyConstants;

    private $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new VendorModel();
    }



    // get users list
    public function getUsers()
    {
        try {
            return DB::table('userdetails')->get();
        } catch (QueryException $exception) {
            echo $exception;
            return -1;
        }
    }

    // creating and return token
    public function getToken()
    {
        $token = bin2hex(random_bytes(16));
        return $token;
    }

    // user exists using ht email address => done
    public function userExists($arrParameters)
    {
        try {
            $response = DB::table('userdetails')
                ->where('email', '=', $arrParameters['email'])
                ->get()->count();
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return -1;
        }
    }

    // login with email and password => done
    public function login($arrParameters)
    {
        try {
            $updateToken = DB::table('userdetails')
                ->where('email', '=', $arrParameters['email'])
                ->where('password', '=', $arrParameters['password'])
                ->update(['token' => $arrParameters['token']]);

            if ($updateToken > 0) {
                $response = DB::table('userdetails')
                    ->join('vendordetails','vendordetails.user_id','=','userdetails.user_id')
                    ->where('userdetails.email', '=', $arrParameters['email'])
                    ->where('userdetails.password', '=', $arrParameters['password'])
                    ->get()->first();
                return $response;
            }
            return [];
        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }

    // update user password with userid => done
    public function updateUserPassword($arrParameters)
    {
        try {
            $updateToken = DB::table('userdetails')
                ->where('user_id', '=', $arrParameters['user_id'])
                ->update(['password' => $arrParameters['password']]);

            return $updateToken;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    // add user sign up details => done
    public function addUserDetails($arrParameters)
    {
        try {

            $values = array('first_name' => $arrParameters['first_name'],
                'last_name' => $arrParameters['last_name'],
                'email' => $arrParameters['email'],
                'device_type' => $arrParameters['device_type'],
                'is_email_verified' => $arrParameters['is_email_verified'],
                'is_notification_enabled' => $arrParameters['is_notification_enabled'],
                'mobile_number' => $arrParameters['mobile_number'],
                'fcm_token' => $arrParameters['fcm_token'],
                'user_type' => $arrParameters['user_type'],
                'password' => $arrParameters['password'],
                'profile_url' => $arrParameters['profile_url'],
                'token' => $arrParameters['token']);
            $response = DB::table('userdetails')->insert($values);
            if ($response) {
                $response = DB::table('userdetails')
                    ->where('email', '=', $arrParameters['email'])
                    ->where('password', '=', $arrParameters['password'])
                    ->get()->first();

                $response = json_decode(json_encode($response), true);

                // add vendor id and get the response data
                $vendorDetails = $this->vendorModel->addVendorIdForUserId($response['user_id']);
                $vendorDetails = json_decode(json_encode($vendorDetails), true);

                return array_merge($response, $vendorDetails);
            }
            return [];
        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }

    //update user details => done
    public  function updateUserDetails($arrParameters){
        try {
            $values = array('first_name' => $arrParameters['first_name'],
                'last_name' => $arrParameters['last_name'],
                'email' => $arrParameters['email'],
                'device_type' => $arrParameters['device_type'],
                'is_email_verified' => $arrParameters['is_email_verified'],
                'is_notification_enabled' => $arrParameters['is_notification_enabled'],
                'mobile_number' => $arrParameters['mobile_number'],
                'fcm_token' => $arrParameters['fcm_token'],
                'user_type' => $arrParameters['user_type'],
                'profile_url' => $arrParameters['profile_url'],
                'password' => $arrParameters['password'],
                'token' => $arrParameters['token']);
            $response = DB::table('userdetails')
                ->where('user_id','=',$arrParameters['user_id'])
                ->update( array_filter($values));
            if ($response > 0) {
                $response = DB::table('userdetails')
                    ->join('vendordetails','vendordetails.user_id','=','userdetails.user_id')
                    ->where('userdetails.user_id', '=', $arrParameters['user_id'])
                    ->get()->first();
                return $response;
            }
            return [];
        } catch (QueryException $exception) {
            print_r($exception);
            return [];
        }
    }

    //update user details => done
    public  function updateProfileImage($arrParameters){
        try {
            $values = array(
                'profile_url' => $arrParameters['profile_image_url'],);
            $response = DB::table('userdetails')
                ->where('user_id','=',$arrParameters['user_id'])
                ->update( array_filter($values));
            return $response;
        } catch (QueryException $exception) {
            return 0;
        }
    }

}
