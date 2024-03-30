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


    public function index()
    {
        $order = Order::latest()->get();
        $status = OrderStatus::all();
        return view('admin.order.order', compact('order', 'status'));
    }
    public function edit_status(Request $request)
    {
        $model = Order::find($request->order_id);
        $model->status = $request->status_id;
        $model->update();
        $html = OrderStatus::find($request->status_id)->name;
        return response()->json($html);
    }

    public function detail(Request $request)
    {
        $order = Order::find($request->id);
        $order_detail = OrderDetail::where('order_id', $request->id)->get();

        return view('admin.order.order_detail', compact('order', 'order_detail'));
    }

    public function confirm(Request $request)
    {
        $model = Order::find($request->id);
        $model->status = 1;
        $model->update();
        return back();
    }
    public function completed(Request $request)
    {
        $model = Order::find($request->id);
        $model->status = 2;
        $model->update();
        return back();
    }
    public function order_filter(Request $request)
    {

        if ($request->status == 'all') {
            $order = Order::latest()->get();
        } else {
            $order = Order::where('status', $request->status)->latest()->get();
        }
        $html = '';
        $status = OrderStatus::all();
        foreach ($order as $item) {
            $html .= "<tr class='action' data-id = " . $item->id . ">
            <th><input type='checkbox'></th>
            <td>#" . $item->code . "</td>
            
            <td>" . $item->fullname . "</td>
            <td>" . $item->total_price . "</td>
            <td class = 'status'>" . $item->orderStatus->name . "</td>
            <td>" . $item->created_at . "</td>
            <td>" . $item->updated_at . "</td>
            
            <td class='text-center'>
                <a href='order-detail/" . $item->id . "'><i class='fas fa-eye' style='font-size: 30px'></i></a>
                
            </td>
            
            <td>
                                    
                <div class='dropdown'>
                    <button class='btn btn-info dropdown-toggle' type='button' data-toggle='dropdown'>Status
                    <span class='caret'></span></button>
                    <ul class='dropdown-menu'>";

            foreach ($status as $item_status) {
                $html .= "<li><a href='#' class='edit_status' data-order = '" . $item->id . "' data-status = '" . $item_status->id . "'> $item_status->name </a></li>";
            }

            $html .= "</ul> </div> </td></tr>";
        }
        return $html;
    }

    public function invoice(Request $request)
    {
        $order = Order::find($request->id);
        $order_detail = OrderDetail::where('order_id', $request->id)->get();
        return view('admin.order.invoice', compact('order', 'order_detail'));
    }


}
