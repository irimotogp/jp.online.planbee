<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
use App\Mail\Customer\ToAdmin;

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
                    ->select(\DB::raw('id as value, 
                        display_name as text, 
                        contract_type, 
                        product_field_id, 
                        cashback,
                        initial_price,
                        month_price'))
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
                    'syoukai_id' => $introducer->syoukai_id,
                    'syoukai_name' => $introducer->syoukai_name,
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
        \DB::beginTransaction();
        try {        
            $validator = $request->validate([
                'uuid' => 'required',
            ]);
            if($request->input('confirm', false)) {
                return response()->json(['status' => 'confirmed']);
            }
            $introducer = Introducer::query()
                ->where('introducer_type', IntroducerType::CUSTOMER)
                ->where('uuid', $request->input('uuid'))
                ->first();
            $data = $request->input();
            $data['mobile_phone'] = isset($data['mobile_phone']) ? dataToPhoneType($data['mobile_phone']) : null;
            $data['mobile_phone2'] = isset($data['mobile_phone2']) ? dataToPhoneType($data['mobile_phone2']) : null;
            $data['pref1'] = isset($data['pref1']) ? getTextOfProf($data['pref1']) : null;
            $data['pref2'] = isset($data['pref2']) ? getTextOfProf($data['pref2']) : null;
            $data['introducer_id'] = $introducer->id;
            $data['account_number'] = isset($data['account_number']) ? substr("0000000" . $data['account_number'], -7) : null;
            $customer = Customer::create($data);

            if(count($request->input('product_option_ids')) > 0) {
                $customer->product_options()->sync($request->input('product_option_ids'));
            }
            \DB::commit();
            Mail::to($customer->introducer->sinsei_email)->queue(new ToRegister($customer));
            Mail::to(config('mail.send.admin'))->queue(new ToAdmin($customer));

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            \DB::rollBack();

            return response()->json(['status' => 'failed', 'error' => $e->getMessage()]);
        }
    }
}
