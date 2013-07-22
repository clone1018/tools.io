<?php

class IPController extends BaseController {
    
    public function getPort() {
        return View::make('network/ip/port', array(
            'title' => 'Port Status'
        ));
    }

    public function getPing() {
        return View::make('network/ip/ping', array(
            'title' => 'Ping IP Address'
        ));
    }

}
