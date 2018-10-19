<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\MakeRequestTrait;
use App\Traits\HelperTrait;
use App\Traits\EncryptTrait;

class Controller extends BaseController
{
    use 
        AuthorizesRequests, 
        DispatchesJobs, 
        ValidatesRequests,
        MakeRequestTrait,
        HelperTrait,
        EncryptTrait
    ;
}
