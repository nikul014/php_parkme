<?php

/**
 * @Author              : prasanthk
 * @CreatedDate         : 1/28/2020
 * @Description         : This file is used for the Provider related actions.
 * Copyright © 2020 Meditab. All rights reserved.
 **/

namespace App\Http\Controllers\Modules\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonFiles\KeyConstants;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserModel
{
    use KeyConstants;

    public function getUsers()
    {
        try {
            return DB::table('userdetails')->get();
        } catch (QueryException $exception) {
            echo $exception;
            return -1;
        }
    }


    public function getToken()
    {
        $token = bin2hex(random_bytes(16));
        return $token;
    }

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

    public function login($arrParameters)
    {
        try {
            $updateToken = DB::table('userdetails')
                ->where('email', '=', $arrParameters['email'])
                ->where('password', '=', $arrParameters['password'])
                ->update(['token' => $arrParameters['token']]);

            if ($updateToken > 0) {
                $response = DB::table('userdetails')
                    ->where('email', '=', $arrParameters['email'])
                    ->where('password', '=', $arrParameters['password'])
                    ->get()->first();
                return $response;
            }
            return [];
        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }


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
                'token' => $arrParameters['token']);
            $response =  DB::table('userdetails')->insert($values);
            if ($response) {
                $response = DB::table('userdetails')
                    ->where('email', '=', $arrParameters['email'])
                    ->where('password', '=', $arrParameters['password'])
                    ->get()->first();
                return $response;
            }
            return [];
        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }

}
