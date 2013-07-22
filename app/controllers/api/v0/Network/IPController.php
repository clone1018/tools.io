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

    /**
     * Ping a host, count abd interval is up to client
     *
     * @return Response::api
     */
    public function postPing() {

        $rules = array(
            'host' => 'required', // Host we're trying to ping
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Response::api($validator);
        }

        $host = Input::get('host');

        $time = self::ping($host);

        if($time) {
            return Response::api(array(
                'status' => 'success',
                'host' => e($host),
                'results' => array(
                    'time' => $time
                )
            ));
        } else {
            return Response::api(array(
                'status' => 'failure',
                'host' => e($host)
            ));
        }

    }

    private static function ping($host, $timeout = 1) {
        /* ICMP ping packet with a pre-calculated checksum */
        $package = "\x08\x00\x19\x2f\x00\x00\x00\x00\x70\x69\x6e\x67";

        $socket  = socket_create(AF_INET, SOCK_RAW, 1);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $timeout, 'usec' => 0));
        socket_connect($socket, $host, null);

        $ts = microtime(true);
        socket_send($socket, $package, strLen($package), 0);
        if (socket_read($socket, 255)) {
            $result = microtime(true) - $ts;
        } else {
            $result = false;
        }

        socket_close($socket);

        return round($result * 1000);
    }

}
