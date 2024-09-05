<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function handleWebhook($domain, $data)
    {

        try {
            $user = User::where('name', $domain)->first();

            $orderExist= Order::where(['user_id'=> $user->id, 'orderNumber'=>$data->order_number, 'orderId'=>$data->id])->first();
            if($orderExist){
                info('exist');
                info(json_encode($orderExist));
            }

            if(!$orderExist){

                $shipping = $data->shipping_address;
                $address = $shipping->address1 . ', ' . ($shipping->address2 ? $shipping->address2 . ', ' : '') . $shipping->city . '-' . $shipping->zip;
        
                $orderData= [
                    'user_id' => $user->id,
                    'orderNumber' => $data->order_number,
                    'orderId' => $data->id,
                    'name' => $shipping->name,
                    'email' => $data->email,
                    'phone' => substr($shipping->phone, -11),
                    'address' => $address,
                    'total' => $data->current_total_price,
                    'shipping' => $data->total_shipping_price_set->shop_money->amount,
                    'tax' => $data->total_tax,
                    'discount' => $data->total_discounts
                ];
        
                $order = Order::create($orderData);
        
                $line_items= collect($data->line_items);
                
                $orderItems = $line_items->map(function ($item) use ($order) {
                    return [
                        'order_id' => $order->id,
                        'name' => $item->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                });
        
                $items= OrderItem::insert($orderItems->toArray());
            }

        } catch (\Exception $e) {
            //throw $th;
        }
        
    }

    public function updateOrder(Request $request, Order $id)
    {
        $order= $id;
        $data= $request->all();

        if(isset($data['updateStatus'])){
            try {
                return $order->update(['steadFastStatus' => $data['updateStatus']]);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        
        $orderData=[
            'steadFastAmount' => $data['cod_amount'],
            'steadFastSend' => true,
            'steadFastId' => $data['consignment_id'],
            'steadFastStatus' => $data['status']
        ];
        
        try {
            return $order->update($orderData);
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
    }

    public function bulkUpdateOrder(Request $request)
    {

        $data= $request->all();
        try {
        $orderData= collect($data)->map(function($item){
           return Order::where('orderId', $item['invoice'])->update(
            [
                'steadFastAmount' => $item['cod_amount'],
                'steadFastSend' => true,
                'steadFastId' => $item['consignment_id'],
                'steadFastStatus' => $item['status']
            ]);
        });
        return $orderData;
        } catch (\Exception $e) {
            return $e->getMessage();
        } 
    }

    public function printOrder(Request $request, User $user){

        $orderId =  $request->all()['orderId'];
        $order= Order::where(['user_id'=>$user->id, 'orderId'=> $orderId])->with('orderItems')->first();
        if($order->steadFastId){
            $subtotal= 0;
            foreach ($order->orderItems as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $terms= explode('<br/>',  $user->businessTerms);
            return view('print', compact('user', 'order', 'subtotal', 'terms'));
        }
        return 'Please send order to SteadFast first.';
    }
}
