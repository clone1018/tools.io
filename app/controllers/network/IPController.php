<?php

class IPController extends BaseController {
    
    public function getPort() {
        return View::make('network/ip/port');
    }

}