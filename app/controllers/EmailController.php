<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Luke
 * Date: 7/26/13
 * Time: 6:46 PM
 * To change this template use File | Settings | File Templates.
 */

class EmailController extends BaseController {

    public function getValidate() {
        return View::make('email/validate');
    }


}