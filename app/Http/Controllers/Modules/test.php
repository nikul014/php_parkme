<?php
namespace App\Http\Controllers\Modules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Test{

    /**
     * @return array
     * This is used to return the details of the backend version and db version when the internal team wants to check the user
     * current version details.
     * Mostly used by the deployment team and QA team to check the version that the client is using.
     */

    public function dbName()
    {
        $strSQL = "SELECT DATABASE() as dbName";
        return DB::selectOne($strSQL)->dbName;
    }


    public function dbTableName()
    {
        $strSQL = "SELECT TABLE_NAME
                   FROM INFORMATION_SCHEMA.TABLES
                   WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='usemyslots'" ;
        return DB::select($strSQL);
    }


    public function defaultResponse(Request $arrParameters){
        $arrResponse["CODE"] = 404;
        $arrResponse["DESCRIPTION"] ="Request not found";
        $arrResponse["DATA"] = array();
        $arrResponse["BACKENDVERSION"] = env('API_VERSION');
        $arrResponse["DBVERSION"] = $this->dbTableName();
        $arrResponse["ENVIRONMENT"] = env('APP_ENV');
        return $arrResponse;
    }


}
