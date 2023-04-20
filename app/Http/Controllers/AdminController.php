<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\View;
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
        return view('admin.dashboard');
    }



    public function updatepassword(){
        $r = Admin::find('1');
        $r->password = Hash::make('admin');
        $r->save(); 
    }
}
