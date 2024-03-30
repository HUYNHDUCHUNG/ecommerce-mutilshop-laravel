<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //

    public function index(){
        return view('admin.login');
    }

    public function auth(Request $request){
        $email = $request->post('email');
        $password = $request->post('password');

        $result = Admin::where(['email'=> $email])->first();
        if(isset($result)){
            if(Hash::check($request->post('password'), $result->password)){
                $request->session()->put('ADMIN_LOGIN',true);
                $request->session()->put('ADMIN_ID',$result->id);
                return redirect('admin/dashboard');
            }else{
                $request->session()->flash('error','Please enter a valid password');
                return redirect('admin');
            }
        }else{
            $request->session()->flash('error', 'Please enter a valid email address');
            return redirect('admin');
        }

    }

    public function dashboard(){
        $total_order = Order::all()->count();
        $total_sale = Order::where('status',2)->sum('total_price');
        $total_sale /= 1000000;
        $customer = User::all()->count();
        $date = Carbon::today()->format('Y-m-d');
        $order_today = Order::whereDate('created_at',$date)->count();
        return view('admin.dashboard',compact('total_order','total_sale','customer','order_today'));
    }



    public function updatepassword(){
        $r = Admin::find('1');
        $r->password = Hash::make('admin');
        $r->save(); 
    }
}
