<?php

namespace App\Http\Controllers\Modules\Admin;

use App\Http\Controllers\CommonFiles\KeyConstants;
use App\Http\Controllers\PHPMailerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController
{

    private $adminModel;
    private $phpMailerController;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->phpMailerController = new PHPMailerController();
    }

    // login with the login
    public function loginStaff(Request $arrParameters)
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
        $hasValue = $this->adminModel->staffUserExists($arrParameters);
        if ($hasValue <= 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$USERNOTEXIST;
            return $arrResponse;
        }
        $token = $this->adminModel->getToken();
        $arrParameters['token'] = $token;
        $arrDetails = $this->adminModel->loginStaff($arrParameters);
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
    public function updateStaffUserPassword(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'password' => KeyConstants::$REQUIRED,
            'staff_id' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrDetails = $this->adminModel->updateStaffUserPassword($arrParameters);
        if ($arrDetails > 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORUPDATINGPASSWORD;
        }
        return $arrResponse;
    }

    //Sign up the user details
    public function addStaffUserDetails(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'name' => KeyConstants::$REQUIRED,
            'email' => KeyConstants::$REQUIRED,
            'password' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $hasValue = $this->adminModel->staffUserExists($arrParameters);
        if ($hasValue > 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$USEREXIST;
            return $arrResponse;
        }
        $token = $this->adminModel->getToken();
        $arrParameters['token'] = $token;
        $arrDetails = $this->adminModel->addStaffUserDetails($arrParameters);
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

    // update staff details with active
    public function updateStaffUserDetails(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'name' => KeyConstants::$REQUIRED,
            'email' => KeyConstants::$REQUIRED,
            'password' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrParameters['staff_id'] = $arrParameters->header('staff-id');
        $arrDetails = $this->adminModel->updateStaffUserDetails($arrParameters);
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

    //add FAQs
    public function addFAQs(Request $arrParameters): array
    {
        $validation = Validator::make($arrParameters->all(), [
            'question' => KeyConstants::$REQUIRED,
            'answer' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrParameters['staff_id'] = $arrParameters->header('staff-id');
        $arrDetails = $this->adminModel->addFAQs($arrParameters);
        if ($arrDetails > 0) {
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

    //update FAQs
    public function updateFAQs(Request $arrParameters): array
    {
        $validation = Validator::make($arrParameters->all(), [
            'question' => KeyConstants::$REQUIRED,
            'answer' => KeyConstants::$REQUIRED,
            'is_active' => KeyConstants::$REQUIRED,
            'faq_id' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrParameters['staff_id'] = $arrParameters->header('staff-id');
        $arrDetails = $this->adminModel->updateFAQs($arrParameters);
        if ($arrDetails > 0) {
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

    // Add or Update settings url
    public function addSettingsUrl(Request $arrParameters): array
    {   $validation = Validator::make($arrParameters->all(), [
            'policy_url' => KeyConstants::$REQUIRED,
            'terms_url' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrParameters['staff_id'] = $arrParameters->header('staff-id');
        $arrDetails = $this->adminModel->addSettingsUrl($arrParameters);
        if ($arrDetails > 0) {
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

    //add Contact us
    public function addContactUsRequest(Request $arrParameters): array
    {
        $validation = Validator::make($arrParameters->all(), [
            'email' => KeyConstants::$REQUIRED,
            'full_name' => KeyConstants::$REQUIRED,
            'queries' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrParameters['user_id'] = $arrParameters->header('user-id');
        $arrDetails = $this->adminModel->addContactUsRequest($arrParameters);
        if ($arrDetails > 0) {
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

    //update contact us details and replies
    public function updateContactUsRequest(Request $arrParameters): array
    {
        $validation = Validator::make($arrParameters->all(), [
            'reply_message' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrParameters['staff_id'] = $arrParameters->header('staff-id');
        $arrDetails = $this->adminModel->updateContactUsRequest($arrParameters);
        if ($arrDetails > 0) {
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

    //is_replied, user_id, is_user
    public function getCountactUsList(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'record_per_page' => KeyConstants::$REQUIRED,
            'start' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrDetails = $this->adminModel->getCountactUsList($arrParameters);
        $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
        $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
        $arrResponse[KeyConstants::$DATA] = $arrDetails;
        return $arrResponse;

    }

    // user_id
    public function getFAQsList(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'record_per_page' => KeyConstants::$REQUIRED,
            'start' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrDetails = $this->adminModel->getFAQsList($arrParameters);
        $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
        $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
        $arrResponse[KeyConstants::$DATA] = $arrDetails;
        return $arrResponse;

    }

    //is_replied, user_id, is_user
    public function getSettingsUrl(Request $arrParameters)
    {
        $arrDetails = $this->adminModel->getSettingsUrl($arrParameters);
        $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
        $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
        $arrResponse[KeyConstants::$DATA] = $arrDetails;
        return $arrResponse;

    }
}
