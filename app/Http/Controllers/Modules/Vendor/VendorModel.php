<?php

namespace App\Http\Controllers\Modules\Vendor;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonFiles\KeyConstants;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VendorModel
{
    use KeyConstants;



    // add or update government proof details
    public function addGovernmentProofs($arrParameters)
    {
        try {
            $values = array('government_proof_name' => $arrParameters['government_proof_name'],
                'government_proof_url_one' => $arrParameters['government_proof_one_url'],
                'government_proof_url_two' => $arrParameters ['government_proof_two_url'],
                'government_proof_type' => $arrParameters['government_proof_type'],);
            $governmentProofExist = DB::table('governmentproofs')
                ->where('vendor_id','=',$arrParameters['vendor_id'])
                ->get()->count();
            if($governmentProofExist>0){
                $response = DB::table('governmentproofs')
                    ->where('vendor_id','=',$arrParameters['vendor_id'])
                    ->update($values);
                if($response > 0) {
                    $response = DB::table('governmentproofs')
                        ->where('vendor_id', '=', $arrParameters['vendor_id'])
                        ->get()->first();
                    return $response;
                }
            }else {
                $values['vendor_id']= $arrParameters['vendor_id'];
                $response = DB::table('governmentproofs')->insert($values);
            }
            if ($response > 0) {
                $response = DB::table('governmentproofs')
                    ->where('vendor_id', '=', $arrParameters['vendor_id'])
                    ->get()->first();
                $response = json_decode(json_encode($response), true);
                $arrParameters['government_proof_id'] = $response['government_proof_id'];
                $intResponse = $this->addGovernmentIdVendorId($arrParameters);
                if ($intResponse > 0) {
                    return $response;
                }
                else [];
            }
            return [];
        } catch (QueryException $exception) {
            echo $exception->getMessage();
            return [];
        }
    }

    //add government images for verify the details
    public function addGovernmentProofFileAndGetUrl(Request $arrParameters){
        try {
            if ($arrParameters->has('government_proof_one')) {
                $image_path = Storage::disk('public_uploads')->putFile('media/government', $arrParameters->file('government_proof_one'));
                $arrParameters['government_proof_one_url'] = url('') . '/' . $image_path;
            }
            if($arrParameters->has('government_proof_two')) {
                $image_path = Storage::disk('public_uploads')->putFile('media/government', $arrParameters->file('government_proof_two'));
                $arrParameters['government_proof_two_url'] = url('') . '/' . $image_path;
            }
            return $arrParameters;
        }catch (_){
            return null;
        }
    }

    // add government id into vendor details.  government_proof_id, vendor_id
    public function addGovernmentIdVendorId($arrParameters)
    {
        try {
            $response = DB::table('vendordetails')
                ->where('vendor_id', '=', $arrParameters['vendor_id'])
                ->update(['government_proof_id' => $arrParameters['government_proof_id']]);
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }


    // update government proof status
    public function updateGovernmentProofStatus($arrParameters)
    {
        try {
            $response = DB::table('governmentproofs')
                ->where('government_proof_id', '=', $arrParameters['government_proof_id'])
                ->update(['is_verified' => $arrParameters['is_verified'],'staff_id' => $arrParameters['staff_id']]);

//        echo $arrParameters['is_verified'].':'.$arrParameters['staff_id'].";".;
//           echo $response;
            return $response;
        } catch (QueryException $exception) {
            echo $exception->getMessage();
            return 0;
        }
    }


    // add bank details do not update the bank details as it should be kept for record or scam purpose
    public function addVendorBankDetails($arrParameters)
    {
        try {
            $values = array('bank_name' => $arrParameters['bank_name'],
                'account_number' => $arrParameters['account_number'],
                'ifsc_code' => $arrParameters ['ifsc_code'],
                'contact_number' => $arrParameters['contact_number'],
                'payment_key' => $arrParameters['payment_key'],
                'payment_secret' => $arrParameters['payment_secret'],
                'vendor_id' => $arrParameters['vendor_id'],
            );

            $response = DB::table('vendorbankdetail')->insert($values);
            if ($response > 0) {
                $response = DB::table('vendorbankdetail')
                    ->where('contact_number', '=', $arrParameters['contact_number'])
                    ->where('account_number', '=', $arrParameters['account_number'])
                    ->where('payment_key', '=', $arrParameters['payment_key'])
                    ->where('vendor_id', '=', $arrParameters['vendor_id'])
                    ->orderByDesc('time')
                    ->get()->first();
                $response = json_decode(json_encode($response), true);
                $arrParameters['vendor_bank_id'] = $response['vendor_bank_id'];
                $intResponse = $this->addBankIdVendorId($arrParameters);
                if ($intResponse > 0) {
                    return $response;
                }
            }
            return [];
        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }

    // add bank detail id into vendor details.  vendor_bank_id, vendor_id
    public function addBankIdVendorId($arrParameters)
    {
        try {
            $response = DB::table('vendordetails')
                ->where('vendor_id', '=', $arrParameters['vendor_id'])
                ->update(['vendor_bank_id' => $arrParameters['vendor_bank_id']]);
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    // add bank detail id into vendor details.  vendor_bank_id, vendor_id
    public function addVendorIdForUserId($userId)
    {
        try {
            $response = DB::table('vendordetails')
                ->insert(['user_id' => $userId]);
            if ($response > 0) {
                $response = DB::table('vendordetails')
                    ->where('user_id', '=', $userId)
                    ->get()->first();
                return $response;
            }
            return null;
        } catch (QueryException $exception) {
            echo $exception;
            return null;
        }
    }

}
