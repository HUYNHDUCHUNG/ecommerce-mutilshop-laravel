<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Redirect;
class PaypalController extends Controller
{

    
    public function create(Request $request)
    {


        // $request->validate([

        //     "fullName" => "required",
        //     "phoneNumber" => "required",
        //     "province" => "required",
        //     "district" => "required",
        //     "ward" => "required",
        //     "address" => "required",
        // ]);


        // $address = implode(',', [

        //     $request->address,
        //     Ward::where('wards_id', $request->ward)->first()->name,
        //     District::where('district_id', $request->district)->first()->name,
        //     Province::where('province_id', $request->province)->first()->name
        // ]);

        // $date = Carbon::now()->format('Ymd');
        // $length = 8;
        // $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // $randomString = '';

        // for ($i = 0; $i < $length; $i++) {
        //     $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        // }
        // $code = $date . $randomString;

        // $order = Order::create([
        //     'fullname' => $request->fullName,
        //     'phonenumber' => $request->phoneNumber,
        //     'address' => $address,
        //     'status' => 0,
        //     'total_quantity' => $request->total_quantity,
        //     'total_price' => $request->total_price,
        //     'code' => $code,
        //     'user_id' => $request->session()->get('USER_ID'),
        // ]);

        // $cartDetails = Cart::where('user_id', session()->get('USER_ID'))->first()->cartDetails()->get();
        // foreach ($cartDetails as $item) {
        //     OrderDetail::create([
        //         'order_id' => $order->id,
        //         'product_id' => $item->product_id,
        //         'quantity' => $item->quantity,
        //         'price' => $item->price,
        //         'size' => $item->size,
        //         'color' => $item->color,

        //     ]);
        //     $item->delete();
        // }

        // return redirect()->route('thankyou');

        $provider = new PayPalClient;
        $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00"
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('payment.paypal_return'),
                "cancel_url" => route('payment.paypal_cancel'),
            ],
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return Redirect::away($link['href']);
                }
            }
        } else {
            return Redirect::route('payment.paypal_cancel');
        }

    }


    public function return(Request $request){
        return "Ok";
    }
    public function cancel(Request $request){
        return "No";
    }
}

