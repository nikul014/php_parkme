<?php

namespace App\Http\Controllers\Modules\Admin;

use App\Http\Controllers\Modules\Vendor\VendorModel;
use App\Http\Controllers\CommonFiles\KeyConstants;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AdminModel
{
    use KeyConstants;

    private $vendorModel;

    public function __construct()
    {
        $this->vendorModel = new VendorModel();
    }

    // creating and return token
    public function getToken()
    {
        $token = bin2hex(random_bytes(16));
        return $token;
    }

    // user exists using ht email address => done
    public function staffUserExists($arrParameters)
    {
        try {
            $response = DB::table('staff_details')
                ->where('email', '=', $arrParameters['email'])
                ->get()->count();
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return -1;
        }
    }

    // login with email and password => done
    public function loginStaff($arrParameters)
    {
        try {
            $updateToken = DB::table('staff_details')
                ->where('email', '=', $arrParameters['email'])
                ->where('password', '=', $arrParameters['password'])
                ->update(['token' => $arrParameters['token']]);

            if ($updateToken > 0) {
                $response = DB::table('staff_details')
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

    // update user password with userid => done
    public function updateStaffUserPassword($arrParameters)
    {
        try {
            $updateToken = DB::table('staff_details')
                ->where('staff_id', '=', $arrParameters['staff_id'])
                ->update(['password' => $arrParameters['password']]);

            return $updateToken;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    // add user sign up details => done
    public function addStaffUserDetails($arrParameters)
    {
        try {
            $values = array('name' => $arrParameters['name'],
                'email' => $arrParameters['email'],
                'password' => $arrParameters['password'],
                'token' => $arrParameters['token'],
                'is_admin' => $arrParameters['is_admin'],
                'is_active' => true,
            );
            $response = DB::table('staff_details')->insert($values);
            if ($response) {
                $response = DB::table('staff_details')
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

    //update user details => done
    public function updateStaffUserDetails($arrParameters)
    {
        try {
            $values = array('name' => $arrParameters['name'],
                'email' => $arrParameters['email'],
                'password' => $arrParameters['password'],
                'is_admin' => $arrParameters['is_admin'],
                'is_active' => $arrParameters['is_active'],
            );
            $response = DB::table('staff_details')
                ->where('staff_id', '=', $arrParameters['staff_id'])
                ->update($values);
            if ($response > 0) {
                $response = DB::table('staff_details')
                    ->where('staff_id', '=', $arrParameters['staff_id'])
                    ->get()->first();
                return $response;
            }
            return [];
        } catch (QueryException $exception) {
            print_r($exception);
            return [];
        }
    }

    // add the faqs // question and answer as parameters
    public function addFAQs($arrParameters)
    {
        try {
            $values = array('question' => $arrParameters['question'],
                'answer' => $arrParameters['answer'],
                'staff_id' => $arrParameters['staff_id'],
                'is_active' => 1,
            );
            $response = DB::table('faqs_details')->insert($values);
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    // update the faqs // question and answer as  per the faq_id
    public function updateFAQs($arrParameters)
    {
        try {
            $values = array('question' => $arrParameters['question'],
                'answer' => $arrParameters['answer'],
                'staff_id' => $arrParameters['staff_id'],
                'is_active' => $arrParameters['is_active'],
            );
            $response = DB::table('faqs_details')
                ->where('faq_id', '=', $arrParameters['faq_id'])
                ->update($values);
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    // add the settings for the terms and policy
    public function addSettingsUrl($arrParameters)
    {
        try {
            $values = array('policy_url' => $arrParameters['policy_url'],
                'terms_url' => $arrParameters['terms_url'],
                'staff_id' => $arrParameters['staff_id'],
            );
            $response = DB::table('settings_details')->where('is_active', '=', true)->update($values);
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    //SELECT `contact_us_id`, `user_id`, `email`, `full_name`, `queries`, `is_replied` FROM `contactus_details` WHERE 1
    // add contact us form
    public function addContactUsRequest($arrParameters)
    {
        try {
            $values = array('user_id' => $arrParameters['user_id'],
                'email' => $arrParameters['email'],
                'full_name' => $arrParameters['full_name'],
                'queries' => $arrParameters['queries'],
                'is_replied' => false,
            );
            $response = DB::table('contactus_details')->insert($values);
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    // update contact us time and reply message time staff_id
    public function updateContactUsRequest($arrParameters)
    {
        try {
            $values = array(
                'reply_message' => $arrParameters['reply_message'],
                'staff_id' => $arrParameters['staff_id'],
                'is_replied' => true,
            );
            $response = DB::table('contactus_details')
                ->where('contact_us_id', '=', $arrParameters['contact_us_id'])
                ->update($values);
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return 0;
        }
    }

    public static function isNullStr($str)
    {
        return (strlen($str) == 0);
    }

    // get list of contact us form => is not or replied => by user_id
    // monthly by created and replied
    // => all with pagination list
    // order by last to first and first to last
    public function getCountactUsList($arrParameters)
    {
        try {
            $recordPerPage = $arrParameters['record_per_page'];
            $start = $arrParameters['start'];

            $strSQL = DB::table('contactus_details as cd')
                ->limit($recordPerPage)
                ->offset($start);
            $strSQL->join('userdetails as ud', 'ud.user_id', '=', 'cd.user_id');
            $strSQL->leftJoin('staff_details as sd', 'sd.staff_id', '=', 'cd.staff_id');
            $strSelect = "ud.first_name, ud.last_name, ud.user_type, cd.user_id, cd.email, cd.full_name,
              cd.queries, cd.is_replied, cd.reply_time, cd.reply_message, cd.staff_id, cd.time, sd.name as staff_name, sd.email as staff_email";

            if (!$this->isNullStr($arrParameters['is_replied'])) {
                $strSQL->where('is_replied', "=", $arrParameters['is_replied']);
            }

            if (!$this->isNullStr($arrParameters['user_id'])) {
                $strSQL->where('cd.user_id', "=", $arrParameters['user_id']);
            }

            if (!$this->isNullStr($arrParameters['created_month'])) {
                $strSQL->whereMonth('cd.time', "=", $arrParameters['created_month']);
                $strSQL->whereYear('cd.time', "=", $arrParameters['created_year']);
            }

            if (!$this->isNullStr($arrParameters['replied_month'])) {
                $strSQL->whereMonth('cd.reply_time', "=", $arrParameters['replied_month']);
                $strSQL->whereYear('cd.reply_time', "=", $arrParameters['replied_year']);
            }

            if (!$this->isNullStr($arrParameters['user_id'])) {
                return $strSQL
                    ->selectRaw($strSelect)
                    ->orderByDesc('cd.time')
                    ->get();
            } else {
                return $strSQL
                    ->selectRaw($strSelect)
                    ->orderBy('cd.time')
                    ->get();
            }
        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }

    // get settings urls
    public function getSettingsUrl($arrParameters)
    {
        try {
            $response = DB::table('settings_details')->where('is_active', '=', true)
                ->get();
            return $response;
        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }

    // get faqs list => active => for admin all => pagination list => last to first
    public function getFAQsList($arrParameters)
    {
        try {
            $recordPerPage = $arrParameters['record_per_page'];
            $start = $arrParameters['start'];

            $strSQL = DB::table('faqs_details as fd');
            $strSQL->join('staff_details as sd', 'sd.staff_id', '=', 'fd.staff_id');
            $strSelect = "sd.name, sd.email, sd.staff_id,
            fd.question, fd.answer,fd.is_active, fd.time";

            if (!$this->isNullStr($arrParameters['user_id'])) {
                $strSQL->where('fd.is_active', "=", true);
            }

            return $strSQL
                ->offset($start)
                ->limit($recordPerPage)
                ->selectRaw($strSelect)
                ->orderBy('fd.time')
                ->get();

        } catch (QueryException $exception) {
            echo $exception;
            return [];
        }
    }

}
