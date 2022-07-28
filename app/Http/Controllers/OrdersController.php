<?php

namespace App\Http\Controllers;

use App\Models\orders;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OrdersController extends Controller
{
    /**
     * Returning the Orders View targeted with orders route.
     *
     * @return Application|Factory|View
     */
    public function OrdersViewPage(Request $request) {
        if ($request->ajax()) {
            $data = orders::latest();
            return \DataTables::of($data)->addIndexColumn()->addColumn('action', function ($data) {
                return '<a href="/order/view/'.Crypt::encrypt($data->id).'" class="handle btn btn-outline-primary btn-sm">View</a>';
            })->addColumn('items', function ($data) {
                $products = json_decode($data['product_info']);
                $qty = 0;
                foreach ($products as $product) {
                    $qty = $qty+$product->quantity;
                }
                return $qty;
            })->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y'); return $formatedDate; })->rawColumns(['action'])->make(true);
        }
        return view('pages.orders');
    }

    /**
     * Handling the Order View Information by clicking on button.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function HandleViewOrder($id) {
        $order = $this->DecrypOrderInfo($id);
        $products = json_decode($order['product_info']);
        $billing = json_decode($order['billing_address']);
        $shipping = json_decode($order['shipping_address']);
		$discount = json_decode($order['discount']);
        $payment_gateway = json_decode($order['payment_gateway']);
        return view('pages.order-detail', compact('order', 'products', 'billing', 'shipping', 'discount', 'payment_gateway'));
    }

    private function DecrypOrderInfo($id) {
        $id = Crypt::decrypt($id);
        return orders::find($id);
    }
}
