<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="http://localhost/api")
 * @OA\Info(title="Laravel Road", version="4.5.1")
 */
class Controller extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}
