<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Enums\IntroducerType;

use App\Models\ShippingAddress;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\Introducer;
use App\Models\Customer;

use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    
    public function index($uuid) {
        $introducer = Introducer::query()
            ->where('introducer_type', IntroducerType::CUSTOMER)
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
                $shipping_address_options = ShippingAddress::query()
                    ->select(\DB::raw('id as value, name as text'))
                    ->get();
                $product_options = Product::query()
                    ->where('introducer_type', IntroducerType::CUSTOMER)
                    ->select(\DB::raw('id as value, product_name as text'))
                    ->get();
                $deposit_options = Deposit::query()
                    ->select(\DB::raw('id as value, name as text'))
                    ->get();
                return [
                    'status' => 'success',
                    'shipping_address_options' => $shipping_address_options,
                    'product_options' => $product_options,
                    'deposit_options' => $deposit_options,
                ];
            }
        } else {
            return [
                'status' => 'error',
                'error' => '申請されたURLではないです。',
            ];
        }
    }

    public function register(CustomerRequest $request) {
        $introducer = Introducer::query()
            ->where('introducer_type', IntroducerType::CUSTOMER)
            ->where('uuid', $request->input('uuid'))
            ->first();
        Customer::create(array_merge($request->input(), [
            'introducer_id' => $introducer->id
        ]));
        return response()->json(['status' => 'success']);
    }
}
