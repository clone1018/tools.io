<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Luke
 * Date: 7/19/13
 * Time: 6:34 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Api\VersionZero\Network;

use Api\VersionZero\BaseController;
use Validator;
use Input;
use Response;

class IPController extends BaseController {

    /**
     * Determine if a port is open on a host
     *
     * @return Response::api
     */
    public function postPort() {

        $rules = array(
            'host' => 'required',
            'port' => 'required|integer'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Response::api($validator);
        }

        $host = Input::get('host');
        $port = Input::get('port');
        $protocol = Input::get('protocol', 'tcp');
        $guess = getservbyport($port, $protocol);

        $response = array(
            'host' => e($host),
            'port' => (int)$port,
            'protocol' => $protocol,
            'results' => array(
                'guess' => strtoupper($guess),
                'status' => 'closed',
            )
        );

        $connection = @fsockopen($host, $port, $errno, $errstr, 1);
        if(!$connection) {
            $response['results']['error'] = trim($errstr);

            return Response::api($response);
        } else {
            fclose($connection);

            $response['results']['status'] = 'open';

            return Response::api($response);
        }

    }
}