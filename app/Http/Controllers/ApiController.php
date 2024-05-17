<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $domain = $request->domain;
        $url = "https://portal.qwords.com/apitest/whois.php";
        $request = Http::get($url."?domain=$domain");
        return $request->json();
    }
}
