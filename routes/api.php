<?php

use App\Http\Controllers\Modules\Admin\AdminController;
use App\Http\Controllers\Modules\Vendor\VendorController;
use App\Http\Controllers\PHPMailerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Users\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$strDefaultPath = 'App\Http\Controllers\Modules\test@defaultResponse';
Route::get('/',$strDefaultPath);

Route::get('/login',[UserController::class,'login']);// email, password//done
Route::post('/addUserDetails',[UserController::class,'addUserDetails']);//done

Route::post("send-email", [PHPMailerController::class, "composeEmail"])->name("send-email");
Route::get('/sentEmailOtp',[UserController::class,'sentEmailOtp']);// email , otp
Route::get('/getSettingsUrl',[AdminController::class,'getSettingsUrl']);

Route::middleware('ParkingAuth')->group(function (){
    Route::get('/get_users',[UserController::class,'getUsers']);
    Route::post('/updateUserPassword',[UserController::class,'updateUserPassword']);// user_id, password//done
    Route::post('/updateUserDetails',[UserController::class,'updateUserDetails']);// Done
    Route::post('/addGovernmentProofs',[VendorController::class,'addGovernmentProofs']);// Done
    Route::post('/addVendorBankDetails',[VendorController::class,'addVendorBankDetails']);//Done
    Route::post('/addVendorIdForUserId',[VendorController::class,'addVendorIdForUserId']);//Done
    Route::post('/addContactUsRequest',[AdminController::class,'addContactUsRequest']);// contact us form//done
    Route::get('/getUserCountactUsList',[AdminController::class,'getCountactUsList']);//is_replied user_id//done
    Route::get('/getUserFAQsList',[AdminController::class,'getFAQsList']);//user_id//done
    Route::post('/uploadProfileImage',[UserController::class,'uploadProfileImage']);//user_id//done

});

Route::get('/loginStaff',[AdminController::class,'loginStaff']);// email, password//done
Route::post('/addStaffUserDetails',[AdminController::class,'addStaffUserDetails']);//done

Route::middleware('AdminAuth')->group(function (){
    Route::post('/updateStaffUserDetails',[AdminController::class,'updateStaffUserDetails']);//done
    Route::post('/updateStaffUserPassword',[AdminController::class,'updateStaffUserPassword']);// user_id, password//done
    Route::post('/addFAQs',[AdminController::class,'addFAQs']);//done
    Route::post('/updateFAQs',[AdminController::class,'updateFAQs']);//done
    Route::post('/addSettingsUrl',[AdminController::class,'addSettingsUrl']);//done
    Route::post('/updateContactUsRequest',[AdminController::class,'updateContactUsRequest']);//done
    Route::get('/getCountactUsList',[AdminController::class,'getCountactUsList']);//is_replied, user_id, //done
    Route::get('/getFAQsList',[AdminController::class,'getFAQsList']);//user_id//done
    Route::post('/updateGovernmentProofStatus',[VendorController::class,'updateGovernmentProofStatus']);//done
});

//Done tables
/*
 * FAQ_details
 * contact_us_details
 * settings_details
 * staff_details
 * user_details
 * government_details
 * bank_details
 * vehicle_details
 */


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
