<?php

namespace app\api\v1\controller;

use support\Request;

class Index
{

    public function index(Request $request)
    {
        return response('hello webman v1 api');
    }
}
