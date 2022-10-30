<?php

namespace App\Http\Controllers\Modules\Users;

use App\Http\Controllers\CommonFiles\KeyConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }


    public function getUsers(Request $arrParameters)
    {
        //$intEmpId = $arrParameters->header('emp-id');

        $arrDetails = $this->userModel->getUsers();
        $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
        $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
        $arrResponse[KeyConstants::$DATA] = $arrDetails;
        return $arrResponse;
    }

    public function login(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'email' => KeyConstants::$REQUIRED,
            'password' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $hasValue = $this->userModel->userExists($arrParameters);
        if ($hasValue <= 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$USERNOTEXIST;
            return $arrResponse;
        }
        $token = $this->userModel->getToken();
        $arrParameters['token'] = $token;
        $arrDetails = $this->userModel->login($arrParameters);
        if ($arrDetails) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$INCORRECTUSERCREDENTIALS;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        }
        return $arrResponse;
    }


    public function addUserDetails(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'first_name' => KeyConstants::$REQUIRED,
            'last_name' => KeyConstants::$REQUIRED,
            'email' => KeyConstants::$REQUIRED,
            'device_type' => KeyConstants::$REQUIRED,
            'is_email_verified' => KeyConstants::$REQUIRED,
            'is_notification_enabled' => KeyConstants::$REQUIRED,
            'mobile_number' => KeyConstants::$REQUIRED,
            'user_type' => KeyConstants::$REQUIRED,
            'password' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $hasValue = $this->userModel->userExists($arrParameters);
        if ($hasValue > 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$USEREXIST;
            return $arrResponse;
        }

        $token = $this->userModel->getToken();
        $arrParameters['token'] = $token;
        $arrDetails = $this->userModel->addUserDetails($arrParameters);
        if ($arrDetails) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORCREATINGUSER;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        }
        return $arrResponse;
    }

}
