<?php

namespace App\Http\Controllers\Modules\Users;

use App\Http\Controllers\CommonFiles\KeyConstants;
use App\Http\Controllers\PHPMailerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController
{

    private $userModel;
    private $phpMailerController;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->phpMailerController = new PHPMailerController();
    }

    // get users details
    public function getUsers(Request $arrParameters)
    {
        //$intEmpId = $arrParameters->header('emp-id');
        $arrDetails = $this->userModel->getUsers();
        $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
        $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
        $arrResponse[KeyConstants::$DATA] = $arrDetails;
        return $arrResponse;
    }

    // login with the login
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

    // update password with user_id and password => done
    public function updateUserPassword(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'password' => KeyConstants::$REQUIRED,
            'user_id' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrDetails = $this->userModel->updateUserPassword($arrParameters);
        if ($arrDetails > 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORUPDATINGPASSWORD;
        }
        return $arrResponse;
    }


    // sent otp mail with otp and email
    public function sentEmailOtp(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'email' => KeyConstants::$REQUIRED,
            'otp' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrDetails = $this->userModel->userExists($arrParameters);
        if ($arrDetails > 0) {
            // sent email to the user.
            $arrParameters['emailRecipient'] = $arrParameters['email'];
            $arrParameters['emailSubject'] = "BookISpot - Support Team";
            $arrParameters['emailBody'] = "Hello User, \nEnter the following verification code in application to verify the email address.\n\nVerification code : " . $arrParameters[""] . " \n\nThanks,\nSupport Team - BookISpot";
            $message = $this->phpMailerController->composeEmail($arrParameters);
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = $message;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$USERNOTEXIST;
        }
        return $arrResponse;
    }

    //Sign up the user details
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

    public function updateUserDetails(Request $arrParameters)
    {
        $arrParameters['user_id'] = $arrParameters->header('user-id');
        $arrDetails = $this->userModel->updateUserDetails($arrParameters);
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


    public function uploadProfileImage(Request $arrParameters)
    {
        $arrParameters->validate([
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($arrParameters->has('profile_image')) {
            $image_path = Storage::disk('public_uploads')->putFile('media/profile', $arrParameters->file('profile_image'));
            $arrParameters['profile_image_url'] = url('').'/'.$image_path;
            $response = $this->userModel->updateProfileImage($arrParameters);
            if($response > 0){
                $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
                $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
                $arrResponse[KeyConstants::$DATA] = url('').'/'.$image_path;
            }else{
                $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
                $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORCREATINGUSER;
            }
        }
        return $arrResponse;
    }


}
