<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Province;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function index(){
        $order = Order::all();
        return view('admin.order.order',compact('order'));
    }


    public function detail(Request $request){
        $order = Order::find($request->id);
        $order_detail = OrderDetail::where('order_id',$request->id)->get();

        return view('admin.order.order_detail',compact('order','order_detail'));
    }

    public function invoice(Request $request){
        $order = Order::find($request->id);
        $order_detail = OrderDetail::where('order_id',$request->id)->get();
        return view('admin.order.invoice',compact('order','order_detail'));
    }


    public function create(Request $request)
    {


        $request->validate([

            "fullName" => "required",
            "phoneNumber" => "required",
            "province" => "required",
            "district" => "required",
            "ward" => "required",
            "address" => "required",
        ]);


        $address = implode(',', [

            $request->address,
            Ward::where('wards_id', $request->ward)->first()->name,
            District::where('district_id', $request->district)->first()->name,
            Province::where('province_id', $request->province)->first()->name
        ]);

        $date = Carbon::now()->format('Ymd');
        $length = 8;
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }
        $code = $date . $randomString;

        $order = Order::create([
            'fullname' => $request->fullName,
            'phonenumber' => $request->phoneNumber,
            'address' => $address,
            'status' => 0,
            'total_quantity' => $request->total_quantity,
            'total_price' => $request->total_price,
            'code' => $code,
            'user_id' => $request->session()->get('USER_ID'),
        ]);

        $cartDetails = Cart::where('user_id', session()->get('USER_ID'))->first()->cartDetails()->get();
        foreach($cartDetails as $item){
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'size' => $item->size,
                'color' => $item->color,

            ]);
            $item->delete();
        }

        return redirect()->route('thankyou');

    }
}
