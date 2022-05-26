<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests\CustomerRequest;
use App\Enums\IntroducerType;
use App\Models\ShippingAddress;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\Introducer;
use App\Models\Customer;
use App\Models\ProductOption;
use App\Models\Privacy;

use App\Mail\Customer\ToRegister;

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
                    'error' => 'URLが期限切れになりました。恐れ入りますが、取次店に連絡してください。',
                ];
            } else {
                $privacies = Privacy::query()
                    ->whereIn('introducer_type', [IntroducerType::CUSTOMER, IntroducerType::ALL])
                    ->select(\DB::raw('title as text'))
                    ->get();
                $product_options = Product::query()
                    ->whereIn('introducer_type', [IntroducerType::CUSTOMER, IntroducerType::ALL])
                    ->where('cashback', 1)
                    ->select(\DB::raw('id as value, display_name as text, contract_type, product_field_id'))
                    ->get();
                $product_opt_options = ProductOption::query()
                    ->select(\DB::raw('id as value, name, price'))
                    ->get();
                $deposit_options = Deposit::query()
                    ->select(\DB::raw('id as value, name as text'))
                    ->get();
                return [
                    'status' => 'success',
                    'sinsei_email' => $introducer->sinsei_email,
                    'product_options' => $product_options,
                    'product_opt_options' => $product_opt_options,
                    'deposit_options' => $deposit_options,
                    'privacies' => $privacies,
                    'pref_options' => config('values.prefs')
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
        if($request->input('confirm', false)) {
            return response()->json(['status' => 'confirmed']);
        }
        $introducer = Introducer::query()
            ->where('introducer_type', IntroducerType::CUSTOMER)
            ->where('uuid', $request->input('uuid'))
            ->first();
        $data = $request->input();
        $data['mobile_phone'] = dataToPhoneType($data['mobile_phone']);
        $data['mobile_phone2'] = dataToPhoneType($data['mobile_phone2']);
        $data['pref1'] = $data['pref1'] ? getTextOfProf($data['pref1']) : null;
        $data['pref2'] = $data['pref2'] ? getTextOfProf($data['pref2']) : null;
        $data['introducer_id'] = $introducer->id;
        $customer = Customer::create($data);
        
        Mail::to($customer->introducer->sinsei_email)->queue(new ToRegister($customer));

        return response()->json(['status' => 'success']);
    }
}
