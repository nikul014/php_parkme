<?php

namespace App\Http\Controllers\CommonFiles;

trait KeyConstants
{

    public static $CODE = 'code';
    public static $DESCRIPTION = 'description';
    public static $DATA = 'data';

    public static $INCORRECTUSERCREDENTIALS ="Incorrect user credentials.";
    public static $USERNOTEXIST = 'User does not exists.';
    public static $USEREXIST = 'User already exists. Please login or try again with different email address.';
    public static $ERRORCREATINGUSER = 'There was some error while creating a user.';


    public static $CODE_404 = '404';
    public static $REQUESTNOTFOUND = 'The requested service was not found';
    public static $BACKENDVERSION = 'backend_version';
    public static $DBVERSION = 'db_version';
    public static $DBNAME = 'db_name';
    public static $ENVIRONMENT = 'ENVIRONMENT';
    public static $INVALIDREQUEST = 'Invalid Request';
    public static $BARCODEMISSING = 'Barcode cannot be null';
    public static $CHECKINSUCCESSFUL = 'Checkin Successful';
    public static $ALREADYCHECKIN = 'Already checked in.';
    public static $VISITNOTELINKERROR = 'There was some error while linking the visit note.';
    public static $REQUIRED = 'required';
    public static $SUPERVISINGPROVIDER = 'is_supervisingProvider';
    public static $CHECKINID = 'checkin_id';
    public static $CARD_LIST = 'card_list';
    public static $MEDITAB_ID = 'meditab_id';
    public static $PATIENTID = 'patient_id';
    public static $USERNAME = 'username';
    public static $PASSWORD = 'password';
    public static $PRODUCTCODE = 'product-id';
    public static $PROVIDERID = 'provider_id';
    public static $FILENOTFOUND = 'File Not Found.';
    public static $FILEUPLOADED = 'File Successfully Uploaded';
    public static $ERRORUPLOADING = 'Error Uploading Photo';
    public static $RACE = 'race';
    public static $ETHNICITY = 'ethnicity';
    public static $MARTIALSTATUS = 'martial_status';
    public static $REFERRALPROVIDER = 'referral_provider';
    public static $REQUIREDFIELDS = 'required_fields';
    public static $CODE__14 = -14;
    public static $CODE__15 = -15;
    public static $CODE__17 = -17;
    public static $CODE__19 = -19;
    public static $ZIPREQUIRED = 'Please provide the Zip number';
    public static $ZIPNOTFOUND = 'Zip is not found.';
    public static $ERRORINSURANCEDETAILS = 'Error While Fetching Insurance Details';
    public static $DBERRORCODE = -400;
    public static $ERRORPATIENTLOGIN = 'There was an error while authenticating patient credentials';
    public static $MULTILPLEPATIENTS = 'Multiple Patients found. Please enter the remaining fields';
    public static $MULTILPLEPATIENTSVISITFRONTDESK = 'We have found multiple patients with the details you have entered. To proceed with Checkin please visit front desk.';
    public static $INACTIVELOGIN = 'You are no longer an active patient with the clinic. Please contact the Front Desk.';
    public static $QUICKNOTEURL = 'quicknote_url';
    public static $SUMMARY_NOTE = 'summary_note';
    public static $MYDOCUMENT = 'my_document';
    public static $DOC_COUNT = 'doc_count';
    public static $IMSGOVERSION = 'imsgo_version';
    public static $PATIENTAPPVERSION = 'patient_app_version';
    public static $ONARRIVALVERSION = 'imsonArrival_version';
    public static $TELEVISITPORTALVERSION = 'televisit_portal_version';
    public static $FORMS_COUNT = 'forms_count';

    public static $CODE_1 = 1;
    public static $CODE_0 = 0;
    public static $CODE__13 = -13;
    public static $CODE_1_DESCRIPTION = 'Success';
    public static $CODE__7 = -7;
    public static $INACTIVEUSER = 'You are not authorized to log in. Kindly contact the office administrator';
    public static $CREDENTIALSMISSING = 'Username or Password cannot be empty.';
    public static $CODE__8 = -8;
    public static $CODE__10 = -10;
    public static $DEVICENOTREGISTERED = 'The device is not registered.';
    public static $CODE_11 = 11;
    public static $PARAMETERLIST = 'system_parameters';
    public static $OFFICELIST = 'office_list';
    public static $DEFAULTOFFICELIST = 'default_office_id';
    public static $OFFICEGROUPLIST = 'office_group_list';
    public static $PROVIDERLIST = 'provider_list';
    public static $CITY = 'city';
    public static $STATE = 'state';
    public static $APPOINTMENTDATA = 'appointment_data';
    public static $CHECKINDATA = 'checkin_data';
    public static $IS_WALKIN = 'is_walkin';

    public static $PROVIDERREQUIRED = 'provider Required';
    public static $CODE__11 = -11;
    public static $CODE__12 = -12;
    public static $CODE_2 = 2;
    public static $CODE_2_DESCRIPTION = 'Other code Success';
    public static $NO_FORM_SET_UP = "No forms have been setup";
    public static $CODE__1 = -1;
    public static $CODE__1_DESCRIPTION = 'Fail';
    public static $CODE__1_INVALID_BARCODE_DESCRIPTION = 'Invalid Barcode';
    public static $INVALIDCREDENTIALS = 'Invalid Username or Password.';
    public static $USERNOTFOUND = 'User not found on the IMS.';
    public static $DEFAULTOFFICENOTFOUND = 'Set default office for provider first.';

    public static $CODE__3 = -3;
    public static $CODE__3_DESCRIPTION = 'Not Authenticated Token';
    public static $TOKENFETCHFAILED = 'Failed to fetch token';
    public static $INVALIDIMAGE = 'Invalid Image';
    public static $PATIENTEXISTS = 'Patient Already Exists';
    public static $PATIENTADDED = 'Patient Added Successfully';

    /**
     * Primarily used for kiosk. indicate patient token is expire.
     * @var string
     */
    public static $CODE__30 = -30;
    public static $CODE__30_DESCRIPTION = 'Patient token is not valid.';

    public static $CODE__2 = -2;
    public static $CODE__2_DESCRIPTION = 'Missing parameters.';
    /**
     * @var string- This code used when particular module permission.
     */
    public static $code__10 = -10;
    public static $CODE__10_DESCRIPTION = 'Auto checkin is disabled for this clinic. Please enable it from IMS setup screen.';

    /**
     * Primarily used for kiosk. if code is -20 then patient directly go to front desk. for similar kind of situation you will use this code.
     * @var string
     */
    public static $CODE__20 = -20;
    public static $CODE__20_DESCRIPTION = 'Please contact front desk';

    public static $CODE__21 = -21;
    public static $CODE__21_DESCRIPTION = 'is not registered for a valid license. Please register the employee from IMS -> Setup -> Employee/Provider -> Office Billing Address screen under appropriate Employee Type.';

    public static $CODE__22 = -22;
    public static $CODE__22_DESCRIPTION = ' is registered under license type "Only for Scheduling". You cannot perform this action under the selected employee. Please contact the vendor sales team to change the license type of this employee if you want to create a visit note or post the charges under this employee.';
    public static $CODE__23 = -23;
    public static $CODE__24 = -24;
    public static $CODE__25 = -25;
    public static $CODE__26 = -26;
    public static $CODE__27 = -27;
    public static $CODE__28 = -28;
    public static $CODE__29 = -29;
    public static $CODE__31 = -31;
    public static $CODE__32 = -32;
    public static $CODE__33 = -33;
    public static $CODE__34 = -34;
    public static $CODE__36 = -36;
    public static $CODE__37 = -37;
    public static $CODE__38 = -38;
    public static $CODE__39 = -39;
    public static $CODE__40 = -40;
    public static $CODE__41 = -41;
    public static $CODE__42 = -42;
    public static $CODE__43 = -43;
    public static $CODE__44 = -44;
    public static $CODE__45 = -45;
    public static $CODE__46 = -46;
    public static $CODE__47 = -47;
    public static $CODE__48 = -48;
    public static $CODE__49 = -49;
    public static $CODE__4 = -4;
    public static $CODE__4_DESCRIPTION = 'No default office found';

    public static $CODE__5 = -5;
    public static $CODE__5_DESCRIPTION = 'No check-in patients found';

    public static $CODE_3 = 3;

    public static $KIOSK_LOGIN = 'patient_login';
    public static $KIOSK_WELCOME = 'wel_come';
    public static $KIOSK_APPOINTMENT_CHECKED_IN = 'appointment_checked_in';
    public static $KIOSK_PATIENT_DEMOGRAPHIC = 'patient_demographic';
    public static $KIOSK_INSURANCE = 'insurance';
    public static $KIOSK_QUESTION_TEMPLATE = 'question_template';
    public static $KIOSK_SIGN_FORM = 'sign_form';
    public static $KIOSK_COPAY = 'copay';
    public static $KIOSK_THANK_YOU = 'thank_you';
    public static $CODE__6 = -6;

    public static $ACCOUNTDEACTIVATED = 'Your IMS account has been deactivated due to inactivity. Please contact your IT Administrator or Office Administrator for reactivation of your account.';
    public static $ELITE_DISABLED = 'This app is not available. Kindly contact the Office Administrator.';
    public static $PROVIDERTOKEN = 'provider_token';
    public static $EMPID = 'emp_id';
    public static $EMPNAME = 'emp_name';
    public static $PATIENTTOKEN = 'patient_token';
    public static $ERRORWHILEADDINGQUESTION = 'There was some error while adding question.';
    public static $QUESTIONID = 'Question_id';
    public static $SURVEYID = 'Survey_id';
    public static $ERRORWHILESAVINGRESPONSES = 'There was some error while saving the responses.';
    public static $ERRORUPDATING_DETAILS = 'There was some error while updating patient details.';


    public static $PATIENT_LIST = 'patient_list';
    public static $VN = 'vn';
    public static $PN_ID = 'pn_id';
    public static $COUNT = 'count';
    public static $META_DATA = 'meta_data';
    public static $DATE_TYPES = 'date_types';
    public static $INFO = 'info';
    public static $PATIENT_ID_NOT_NULL = 'Patient Id cannot be null.';
    public static $ROOMLIST = 'room_list';

    /**
     * ABS required parameter for respective validations
     */

    public static $NULLABLE_EMAIL_PHONE_VALIDATION = 'nullable|numeric';
    public static $NULLABLE_INTEGER_VALIDATION = 'nullable|string';
    public static $REQUIRED_INTEGER_VALIDATION = 'required|integer';
    public static $REQUIRED_DATE_FORMAT_VALIDATION = 'required|date_format:Y-m-d';
    public static $NULLABLE_DATE_FORMAT_VALIDATION = 'nullable|date_format:Y-m-d';

    public static $PROFILE_MIME_TYPE = 'png,jpg,jpeg,gif';
    public static $FILENAME_REGEX_VALIDATION = 'regex:/^([A-Za-z0-9]+)\.([a-zA-Z\.]{2,6})$/';
    public static $STETEMENT_REGEX_VALIDATION = 'regex:/^[a-zA-Z0-9\_\-\?\:\*\.\\040]*$/';
    public static $STETEMENT_NOTREGEX_VALIDATION_SCRIPT = 'not_regex:/\<script/i';
    public static $BOOLEAN_VALUES = [true, false, 'true', 'false', 1, 0, '1', '0', 'Y', 'N'];
    public static $DEFAULT_IMS_DATE = '1900-01-01';

    public static $CLIENT_CAROUSEL_LIMIT = 4;
    public static $DEFAULT_SLOT_SPAN_DAY = 6;
    public static $ABS_TOKEN_EXPIRE_MIN = 300;
    public static $ABS_ADMIN_TOKEN_EXPIRE_MIN = 300;
    public static $ELITEVERSION = 'elite_version';
    public static $APPUPDATEREQUIRED = 'An updated version of the app is available and required for app use.';
}
