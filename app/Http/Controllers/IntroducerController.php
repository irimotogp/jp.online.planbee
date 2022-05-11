<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Http\Requests\IntroducerRequest;

use App\Models\Introducer;
use App\Enums\IntroducerType;
use App\Mail\Introducer\ToRegister;

class IntroducerController extends Controller
{
    public function register(IntroducerRequest $request) {
        $introducer = Introducer::create(array_merge($request->input(), [
            'uuid' => Str::uuid()->toString()
        ]));

        Mail::to($introducer->sinsei_email)->queue(new ToRegister($introducer));

        \DB::commit();
        return response()->json(['status' => 'success']);
    }
}
