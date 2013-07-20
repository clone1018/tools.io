<?php
namespace Api\VersionZero;

use Validator;
use Response;
use Input;

class NetworkController extends BaseController {

    public function postPing() {

        $rules = array(
            'host' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) {
            return Response::api($validator);
        }

        $domain = Input::get('host');

        $starttime = microtime(true);
        $file      = fsockopen ($domain, 80, $errno, $errstr, 10);
        $stoptime  = microtime(true);
        $status    = 0;

        if (!$file) $status = -1;  // Site is down
        else {
            fclose($file);
            $status = ($stoptime - $starttime) * 1000;
            $status = floor($status);
        }
        return Response::api($status);
    }



    public function postLookup() {

    }

}