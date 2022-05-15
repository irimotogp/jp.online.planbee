<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Enums\IntroducerType;

use App\Models\ShippingAddress;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\Introducer;
use App\Models\Agency;

use App\Http\Requests\AgencyRequest;

use App\Models\Privacy;

class AgencyController extends Controller
{
    public function index($uuid) {
        $introducer = Introducer::query()
            ->where('introducer_type', IntroducerType::AGENCY)
            ->where('uuid', $uuid)
            ->first();
        if($introducer) {
            $now = Carbon::now();
            $diffHours = $introducer->created_at->diffInHours($now);
            if($diffHours >= 24) {
                return [
                    'status' => 'error',
                    'error' => '有効期限が切れました。',
                ];
            } else {
                $privacies = Privacy::query()
                    ->whereIn('introducer_type', [IntroducerType::AGENCY, IntroducerType::ALL])
                    ->select(\DB::raw('title as text'))
                    ->get();
                $product_options = Product::query()
                    ->whereIn('introducer_type', [IntroducerType::AGENCY, IntroducerType::ALL])
                    ->where('cashback', 1)
                    ->select(\DB::raw('id as value, product_name as text'))
                    ->get();
                $deposit_options = Deposit::query()
                    ->select(\DB::raw('id as value, name as text'))
                    ->get();
                return [
                    'status' => 'success',
                    'syoukai_id' => $introducer->syoukai_id,
                    'syoukai_name' => $introducer->syoukai_name,
                    'eva_id' => $introducer->eva_id,
                    'eva_name' => $introducer->eva_name,
                    'product_options' => $product_options,
                    'deposit_options' => $deposit_options,
                    'privacies' => $privacies,
                ];
            }
        } else {
            return [
                'status' => 'error',
                'error' => '申請されたURLではないです。',
            ];
        }
    }

    public function register(AgencyRequest $request) {
        $introducer = Introducer::query()
            ->where('introducer_type', IntroducerType::AGENCY)
            ->where('uuid', $request->input('uuid'))
            ->first();
        Agency::create(array_merge($request->input(), [
            'introducer_id' => $introducer->id
        ]));
        return response()->json(['status' => 'success']);
    }
}
