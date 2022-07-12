<?php

namespace App\Http\Controllers;

use App\Models\orders;
use App\Models\Payments;
use App\Models\PaymentGateways;
use App\Models\StoreSettings;
use App\Models\Country;
use App\Models\States;
use App\Models\TrackingCode;
use Illuminate\Http\Request;
use App\Models\Upsellfunnels;
use App\Models\Upsellfunnel_downsellproducts;
use App\Models\Upsellfunnel_upsellproducts;
use Illuminate\Support\Facades\Log;
use Validator;
use Stripe;
use Illuminate\Support\Facades\Crypt;

class ApiController extends Controller
{
    public function GetPaymentCredentials(Request $request) {
        $key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
        $response = array(
            'status' => true,
            'logo' => (new SettingsController)->RetrieveValue('logo'),
            'favicon' => (new SettingsController)->RetrieveValue('favicon'),
            'checkout_code' => (new GlobalCodeController)->RetrieveCodeValue('checkout_page'),
			'checkout_secure_logo' => (new SettingsController)->RetrieveValue('checkout_secure_logo'),
            'shipping_note' => (new SettingsController)->RetrieveValue('shipping_note'),
        );
        $keys = PaymentGateways::where(['gateway_name' => 'stripe'])->get()->first();
        if ($keys !== null) {
            $key = json_decode($keys['gateway_settings']);
            if ($keys->status == 'sandbox') {
                $show = $key->sandbox_publishable;
            } else {
                $show = $key->production_publishable;
            }
            $response['publishable_key'] = $show;
            $response['key_status'] = $keys->status;
        } else {
            $response['publishable_key'] = '';
            $response['key_status'] = 'sandbox';
        }
        return response($response);
    }
	
	public function GetThankyouCredentials(Request $request) {
        $key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
        $response = array(
            'status' => true,
            'logo' => (new SettingsController)->RetrieveValue('logo'),
            'favicon' => (new SettingsController)->RetrieveValue('favicon'),
            'thankyou_code' => (new GlobalCodeController)->RetrieveCodeValue('thanks_page'),
        );
		return response($response);
    }

	public function FetchOrderInDB(Request $request){
		$key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
		$validate = Validator::make($request->all(), [
           'id' => 'required|numeric|exists:orders,id',
		]);
		if ($validate->fails()) {
            return response($validate->messages());
        }
		
		$orders = orders::where(['id' => $request['id']])->get()->first();
		return $orders;
		}
    public function CreateOrderInDB(Request $request) {
        $key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
        $validate = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'product_info' => 'nullable|array',
            'billing_address' => 'nullable|array',
            'shipping_address' => 'nullable|array',
            'subtotal_price' => 'nullable|string',
            'shipping' => 'nullable|string',
            'shipping_detail' => 'nullable|array',
            'discount' => 'nullable|array',
            'tax' => 'nullable|string',
            'total_price' => 'nullable|string',
            'refunded_amount' => 'nullable|string',
            'refunded_date' => 'nullable|date',
			'token'=>'nullable|string',
        ]);
        if ($validate->fails()) {
            return response($validate->messages());
        }
		
		$stripetoken = $request['token'];
		$keys = PaymentGateways::where(['gateway_name' => 'stripe'])->get()->first();
        if ($keys !== null) {
            $key = json_decode($keys['gateway_settings']);
            if ($keys->status == 'sandbox') {
                $stripesecretkey = $key->sandbox_secret;
            } else {
                $stripesecretkey = $key->production_secret;
            }
        } else {
            $stripesecretkey ='';
        }
		

		Stripe\Stripe::setApiKey($stripesecretkey);
		$charge = Stripe\Charge::create ([
                "amount" => $request['total_price'] * 100,
                "currency" => "USD",
                "source" =>$stripetoken,
                "description" => "Payment from onepage checkout",
        ]);
		
		//return $charge;
		if($charge['status'] == 'paid') {
			$data = array(
            'name' => $request['name'],
            'email' => $request['email'],
            'product_info' => json_encode($request['product_info']),
            'billing_address' => json_encode($request['billing_address']),
            'shipping_address' => json_encode($request['shipping_address']),
            'subtotal_price' => $request['subtotal_price'],
            'shipping' => $request['shipping'],
            'shipping_detail' => json_encode($request['shipping_detail']),
            'discount' => json_encode($request['discount']),
            'tax' => $request['tax'],
            'total_price' => $request['total_price'],
            'payment_gateway' => $request['payment_gateway'],
			'shopify_customerid'=>$request['shopify_customerid'],
        );
        
		$insertorder = orders::create($data);
		
		$paydata = array("transaction_id" => $charge['id'],
		"payment_status" => $charge['status'],
		"gateway_response" => $charge,
		"order_id" => $insertorder['id'],
		);
		$insertpayment = payments::create($paydata);
		$response = array(
            'status' => true,
            'response' => 'Order Created Successfully!',
			'orderid'=>$insertorder['id'],
			'transaction_id'=>$charge['id'],
        );
        if (!$insertorder) {
            $response = array(
                'status' => false,
                'response' => 'Order Creation Failed!'
            );
        }
		}else{
			 $response = array(
				'status' => false,
				'response' => 'Payment failed!'
			 );
		}
        
        return response($response);
    }
	
	public function UpdateOrderInDB(Request $request) {
        $key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
        $validate = Validator::make($request->all(), [
			'id' => 'required|numeric|exists:orders,id',
            'shopify_order_id' => 'nullable|numeric',
            'shopify_order_name' => 'nullable|string',
            'shopify_order_number' => 'nullable|numeric',
            'orders_status' => 'nullable|string',
            'fulfillment_status' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return response($validate->messages());
        }
			$data = array(
            'shopify_order_id' => $request['shopify_order_id'],
            'shopify_order_name' => $request['shopify_order_name'],
            'shopify_order_number' => $request['shopify_order_number'],
            'orders_status' => $request['orders_status'],
            'fulfillment_status' => $request['fulfillment_status'],
        );
        $updateorder = orders::find($request['id'])->update($data);
		//$update = $findorder->update($data);
		
		$response = array(
            'status' => true,
            'response' => 'Order Update Successfully!',
        );
        if ($updateorder !== true) {
            $response = array(
                'status' => false,
                'response' => 'Order Update Failed!'
            );
        }
		
        return response($response);
    }
	
	
	/**
     * Returning Country Information Through Get Request.
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function CountriesResponse(Request $request){
        $key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
       $countries = Country::all();
        $response = array(
            'status' => true,
            'response' => $countries
        );
        return response($response, 200);

    }

    /**
     * Returning the State List based on Country Code..
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function StatesResponse(Request $request){
        $key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
        $validate = Validator::make($request->all(), [
            'country_code' => 'required|string'
        ]);
        if ($validate->fails()){
            return response($validate->messages(), 400);
        }
        $states = States::where(['country_code' => $request['country_code']])->orderBy('name','ASC')->get();
        $response = array(
            'status' => true,
            'response' => $states
        );
        return response($response, 200);
    }

    /**
     * Authenticating access token.
     *
     * @param $token
     * @return bool
     */
    private function AuthenticateToken($token) {
        if (env('API_KEY') !== $token) {
            return false;
        }
        return true;
    }
	
	/**
     * Verify Shopify Webhook.
     *
     * @param $token
     * @return bool
     */
	
	private function VerifyShopifyWebhook($data, $hmac_header){
	  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, env('SHOPIFY_APP_SECRET'), true));
	  return hash_equals($hmac_header, $calculated_hmac);
	}

    /**
     * Returning the single upsell or downsell based on ID..
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function SingleupdnsellResponse(Request $request){
        
        $key = $request->header('Authorization');
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
        
        $validate = Validator::make($request->all(), [
            'id' => 'required|string',
            'type' => 'required|string'
        ]);
        if ($validate->fails()){
            return response($validate->messages(), 400);
        }
        
        if($request['type']=='upsell'){
            $upselllid = Crypt::decrypt($request->id);
            //$states = Upsellfunnel_upsellproducts::where(['id' => $upselllid])->get(['upshopify_producthandle','updiscounttype','updiscountamount']);
            $states = Upsellfunnel_upsellproducts::find($upselllid);
            $producthandle = $states->upshopify_producthandle;
            $discountamount = $states->updiscountamount;
            $discounttype = $states->updiscounttype;
        }elseif($request['type']=='downsell'){
            $downselllid = Crypt::decrypt($request->id);
            $states = Upsellfunnel_downsellproducts::find($downselllid);
            $producthandle = $states->dnshopify_producthandle;
            $discountamount = $states->dndiscountamount;
            $discounttype = $states->dndiscounttype;
        }
        $shopify_storeurl = StoreSettings::where(['option_name' => 'shopify_main_domain'])->get(['option_value'])->first();
       $url = $shopify_storeurl['option_value'].'products/'.$producthandle.'.js';
        
        $ans_ch = curl_init();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        curl_setopt($ans_ch, CURLOPT_URL, $url);
        curl_setopt($ans_ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json','User-Agent:'.$user_agent.''));	
        curl_setopt($ans_ch, CURLOPT_HEADER, true);
        curl_setopt($ans_ch, CURLOPT_RETURNTRANSFER, true);
        $result_get = curl_exec($ans_ch);
        if (curl_error($ans_ch)) {
        $error_msg = curl_error($ans_ch);
        }
        $header_size = curl_getinfo($ans_ch, CURLINFO_HEADER_SIZE);
        $body = substr($result_get, $header_size);
        $httpcode = curl_getinfo($ans_ch, CURLINFO_HTTP_CODE);
        curl_close($ans_ch);
         $result['productinfo'] = json_decode($body,true);
         $result['discountamount'] = $discountamount;
         $result['discounttype'] =  $discounttype;
        
         if (isset($error_msg)) {
         $result['error_msg'] = $error_msg;
         }
        
       $response = array(
           'status' => true,
           'response' => $result
       );
        return response($response, 200);
    }

    /**
     * Returning all config settings..
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function GetConfigSettings(Request $request){
        $key = $request->header('Authorization');
        
        if ($this->AuthenticateToken($key) !== true) {
            $response = array(
                'status' => false,
                'response' => 'API key is invalid, please check and try again.'
            );
            return response($response);
        }
        $allconfigs = StoreSettings::where(['option_for' => 'config_setting'])->get(['option_name','option_value']);
        $response = array(
            'status' => true,
            'response' => $allconfigs
        );
        return response($response, 200);
    }  
}
