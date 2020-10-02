<?php

namespace App\Http\Controllers;

use App\Services\ParsService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function test(Request $request)
    {
        $test_text = $request->test_text?? '';
        $result = [
            ['name' => 'domain', 'pars' => ParsService::domain($test_text)],
            ['name' => 'ip', 'pars' => ParsService::ip($test_text)],
            ['name' => 'prohibited schemes', 'pars' => [ParsService::prohibitedSchemes($test_text)? 'true': 'false']],
        ];
        return view('test', compact('result', 'test_text'));
    }
}
