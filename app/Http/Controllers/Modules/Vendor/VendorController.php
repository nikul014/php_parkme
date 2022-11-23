<?php

namespace App\Http\Controllers\Modules\Vendor;

use App\Http\Controllers\CommonFiles\KeyConstants;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Modules\Vendor\VendorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{

    private $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new VendorModel();
    }

    //Add vendorId for user id => done
    public function addVendorIdForUserId(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'vendor_id' => KeyConstants::$REQUIRED,
            'user_id' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }

        $arrDetails = $this->vendorModel->addVendorIdForUserId($arrParameters['user_id']);
        if ($arrDetails) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORADDINGGOVERNMENTPROOFS;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        }
        return $arrResponse;
    }

    // add vendor government proofs
    public function addGovernmentProofs(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'vendor_id' => KeyConstants::$REQUIRED,
            'government_proof_name' => KeyConstants::$REQUIRED,
            'government_proof_type' => KeyConstants::$REQUIRED,
            'government_proof_one' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'government_proof_two' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }

        $arrParameters = $this->vendorModel->addGovernmentProofFileAndGetUrl($arrParameters);
        if ($arrParameters == null) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORADDINGGOVERNMENTPROOFS;
            return $arrResponse;
        }
        $arrDetails = $this->vendorModel->addGovernmentProofs($arrParameters);
        if ($arrDetails) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORADDINGGOVERNMENTPROOFS;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        }
        return $arrResponse;
    }

    // add vendor government proofs status
    public function updateGovernmentProofStatus(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'government_proof_id' => KeyConstants::$REQUIRED,
            'is_verified' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrDetails = $this->vendorModel->updateGovernmentProofStatus($arrParameters);
        if ($arrDetails > 0) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        } else {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORADDINGGOVERNMENTPROOFS;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
        }
        return $arrResponse;
    }

    //Add or update vendor bank details
    public function addVendorBankDetails(Request $arrParameters)
    {
        $validation = Validator::make($arrParameters->all(), [
            'vendor_id' => KeyConstants::$REQUIRED,
            'bank_name' => KeyConstants::$REQUIRED,
            'account_number' => KeyConstants::$REQUIRED,
            'contact_number' => KeyConstants::$REQUIRED,
            'payment_key' => KeyConstants::$REQUIRED,
            'payment_secret' => KeyConstants::$REQUIRED,
            'ifsc_code' => KeyConstants::$REQUIRED,
        ]);
        if ($validation->fails()) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__2;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE__2_DESCRIPTION;
            return $arrResponse;
        }
        $arrDetails = $this->vendorModel->addVendorBankDetails($arrParameters);
        if ($arrDetails) {
            $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE_1;
            $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$CODE_1_DESCRIPTION;
            $arrResponse[KeyConstants::$DATA] = $arrDetails;
            return $arrResponse;
        }
        $arrResponse[KeyConstants::$CODE] = KeyConstants::$CODE__1;
        $arrResponse[KeyConstants::$DESCRIPTION] = KeyConstants::$ERRORADDINGBANKDETAILS;
        $arrResponse[KeyConstants::$DATA] = $arrDetails;
        return $arrResponse;
    }


}
