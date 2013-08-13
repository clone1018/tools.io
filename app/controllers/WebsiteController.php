<?php

class WebsiteController extends BaseController {

    public function getMonitor() {
        return View::make('website/monitor', array(
            'title' => 'Uptime Monitor'
        ));
    }

}
