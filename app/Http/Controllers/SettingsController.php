<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateways;
use App\Models\StoreSettings;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //Checkout Page Related Settings Start From Here.
    /**
     * Returning the Checkout Settings View targeted with checkout.settings route.
     *
     * @return Application|Factory|View
     */
    public function CheckoutSettingsView() {
        $why = StoreSettings::where(['option_for' => 'checkout_page'])->get();
        $review = StoreSettings::where(['option_for' => 'checkout_page'])->get();
        return view('pages.checkout-settings', compact('why', 'review'));
    }

    /**
     * Retrieving the value of Page Settings using name to show on page.
     *
     * @param $name
     * @return string
     */
    public function RetrieveValue($name) {
        $data = StoreSettings::where(['option_name' => $name])->get()->first();
        if ($data !== null) {
            return $data->option_value;
        }
        return '';
    }

    /**
     * Handling the Logo or Favicon Update Request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function HandleSettingsRequest(Request $request) {
        //validating request input
       $data = $this->validate($request, [
            'logo' => 'required|url',
            'favicon' => 'required|url',
            'shipping_note' => 'required|string',
            'checkout_secure_logo' => 'required|url'
        ]);
		$images = array(
            'logo',
            'favicon',
            'checkout_secure_logo'
        );

        //Verifying if the provided url is an image.
        foreach ($data as $key=>$url) {
            $status = true;
            if (in_array($key, $images)) {
                $status = $this->CheckURLisImage($url);
            }
            if ($status !== true) {
                $this->validate($request, [
                    $key => 'mimes:jpeg,png,jpg,svg',
                ]);
            } else {
                $exist = StoreSettings::where(['option_name' => $key])->get()->first();
                if ($exist !== null) {
                    $exist->update([
                        'option_value' => $url
                    ]);
                } else {
                    StoreSettings::create([
                        'option_name' => $key,
                        'option_value' => $url
                    ]);
                }
            }
        }
        return redirect()->back()->with('success', 'Checkout Page Settings Stored Successfully');
    }

    /**
     * Handling the Logo or Favicon Update Request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function HandleConfigSettingsRequest(Request $request) {

        //validating request input
       $data = $this->validate($request, [
            'checkout_domain' => 'required|url',
            'facebook_accesstoken' => 'required|string',
            'facebook_pixelid' => 'required|integer',
            'avalara_username' => 'required|string',
            'avalara_password' => 'required|string',
            'avalara_company' => 'required|string',
            'avalara_accountid' => 'required|integer',
            'avalara_license_key' => 'required|string',
            'avalara_environment' => 'required|string',
            'shopify_domain' => 'required|string',
            'shopify_main_domain' => 'required|url',
            'shopify_adminapi_access_token' => 'required|string',
            'shopify_storefrontapi_access_token' => 'required|string',
            'shopify_api_version' => 'required|string',
            'shopify_currency' => 'required',
            'shopify_currency_code' => 'required|string|max:4',
            'shipping_address1' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_postalcode' => 'required|string',
            'shipping_country' => 'required|string',
        ]);


        foreach ($data as $key=>$value) {

            $exist = StoreSettings::where(['option_name' => $key])->get()->first();
            if ($exist !== null) {
                $exist->update([
                    'option_value' => $value,
                    'option_for' =>'config_setting'
                ]);
            } else {
                StoreSettings::create([
                    'option_name' => $key,
                    'option_value' => $value,
                    'option_for' =>'config_setting'
                ]);
            }
        }



        return redirect()->back()->with('success', 'Config Settings Stored Successfully.');
    }

    /**
     * Checking if the provided url is an Image or Not.
     *
     * @param $url
     * @return bool
     */
    private function CheckURLisImage($url) {
        $http_response_header = @exif_imagetype($url);
        if ($http_response_header !== false) {
            return true;
        }
        return false;
    }



    //Payment Related Settings Start From Here.
    /**
     * Returning the Payment Settings View Targeted with payment.settings route.
     *
     * @return Application|Factory|View
     */
    public function PaymentSettingsView() {
        $information = PaymentGateways::where(['gateway_name' => 'stripe'])->get()->first();
        if (empty($information)) {
            $provider = array();
        } else {
            $data = json_decode($information->gateway_settings);
            $provider = array(
                'status' => $information->status,
                'key' => $data,
            );
        }
        return view('pages.payment-settings', compact('provider'));
    }

    //Payment Related Settings Start From Here.
    /**
     * Returning the Payment Settings View Targeted with payment.settings route.
     *
     * @return Application|Factory|View
     */
    public function ConfigSettingsView() {
        return view('pages.config-settings');
    }

    /**
     * Updating the database accordingly to enable or disable sandbox & production payment method.
     *
     * @param Request $request
     * @return bool
     */
    public function PaymentStateHandling(Request $request) {
        $data = $this->validate($request, [
            'gateway_name' => 'required|string',
            'production_enabled' => 'required|boolean'
        ]);
        $status = 'sandbox';
        if ($data['production_enabled'] == true) {
            $status = 'production';
        }
        $inDB = PaymentGateways::where(['gateway_name' => $data['gateway_name']])->get()->first();
        if ($inDB !== null) {
            $update = $inDB->update([
                'status' => $status
            ]);
            if ($update !== true) {
                return false;
            }
        } else {
            $json = $this->CreateNewJsonData(array(), $status);
            PaymentGateways::create([
                'gateway_name' => $data['gateway_name'],
                'status' => $status,
                'gateway_settings' => $json
            ]);
        }
        return true;
    }

    /**
     * Handling the Submitted Key from User Dashboard & Storing in to DB.
     *
     * @param Request $request
     * @return bool
     */
    public function PaymentKeysFormHandling(Request $request) {
        $state = $request['set'];
        $data = $this->validate($request, [
            'gateway_name' => 'required|string',
            'production_secret' => 'nullable|string',
            'production_publishable' => 'nullable|string',
            'sandbox_secret' => 'nullable|string',
            'sandbox_publishable' => 'nullable|string',
            'set' => 'required|string'
        ]);
        return $this->HandleRequest($data);
    }

    /**
     * Handling the Request if the received Data State is Production
     *
     * @param $data
     * @return bool
     */
    private function HandleRequest($data) {
        $keyInDB = PaymentGateways::where(['gateway_name' => $data['gateway_name']])->get()->first();
        if ($keyInDB !== null) {
            $exData = json_decode($keyInDB->gateway_settings);
            $json = $this->CreateJsonData($exData, $data, $data['set']);
            $updateDB = $keyInDB->update([
                'status' => $data['set'],
                'gateway_settings' => $json
            ]);
            if ($updateDB !== true) {
                return false;
            }
            return true;
        }
        $json = $this->CreateNewJsonData($data, $data['set']);
        PaymentGateways::create([
            'gateway_name' => $data['gateway_name'],
            'gateway_settings' => $json,
            'status' => $data['set']
        ]);
        return true;
    }

    private function CreateJsonData($json, $new, $method) {
        if ($method == 'production') {
            $sandbox_secret = $json->sandbox_secret;
            $sandbox_publishable = $json->sandbox_publishable;
            $data = array(
                'production_secret' => $new['production_secret'],
                'production_publishable' => $new['production_publishable'],
                'sandbox_secret' => $sandbox_secret,
                'sandbox_publishable' => $sandbox_publishable
            );
        } else {
            $production_secret = $json->production_secret;
            $production_publishable = $json->production_publishable;
            $data = array(
                'production_secret' => $production_secret,
                'production_publishable' => $production_publishable,
                'sandbox_secret' => $new['sandbox_secret'],
                'sandbox_publishable' => $new['sandbox_publishable']
            );
        }
        return json_encode($data);
    }

    private function CreateNewJsonData($inp, $method) {
        if (empty($inp)) {
            $data = array(
                'production_secret' => '',
                'production_publishable' => '',
                'sandbox_secret' => '',
                'sandbox_publishable' => ''
            );
        } else {
            if ($method == 'production') {
                $sandbox_secret = '';
                $sandbox_publishable = '';
                $data = array(
                    'production_secret' => $inp['production_secret'],
                    'production_publishable' => $inp['production_publishable'],
                    'sandbox_secret' => $sandbox_secret,
                    'sandbox_publishable' => $sandbox_publishable
                );
            } else {
                $production_secret = '';
                $production_publishable = '';
                $data = array(
                    'production_secret' => $production_secret,
                    'production_publishable' => $production_publishable,
                    'sandbox_secret' => $inp['sandbox_secret'],
                    'sandbox_publishable' => $inp['sandbox_publishable']
                );
            }
        }
        return json_encode($data);
    }
    // Checkout Page Content

    public function CheckOutOptionCreate(Request $request) {
        $this->validate($request, [
            'option_name' => 'string|required',
            'option_value' => 'string|required',
            'option_for' => 'required|string'
        ]);
        $create = StoreSettings::create([
           'option_name' => $request['option_name'],
           'option_value' => $request['option_value'],
           'option_for' => $request['option_for'],
        ]);
        if ($create != null){
            return redirect()->route('checkout.list')->with('success', 'Created Successfully');
        }
        return redirect()->back()-with('error', 'Failed to Create');
    }
    public function CheckoutOptionlist() {
        $display = StoreSettings::where(['option_for' => 'checkout_page_why'])->orWhere(['option_for' => 'checkout_page_review'])->get();
        return view('pages.checkout-option-list', compact('display'));
    }
    public function CheckoutOptionEdit($id) {
        $checkout_update = StoreSettings::find($id);
        if ($checkout_update !== null) {
            return view( 'pages.checkout-option-edit', compact('checkout_update'));
        }
        abort(404);
    }
    public function CheckoutOptionUpdate(Request $request, $id) {
        $this->validate($request, [
            'option_name' => 'string|required',
            'option_value' => 'string|required',
            'option_for' => 'required|string'
        ]);
        $check = StoreSettings::find($id);
        $create = $check->update([
            'option_name' => $request['option_name'] ?? $check->option_name,
            'option_value' => $request['option_value'] ?? $check->option_value,
            'option_for' => $request['option_for'] ?? $check->option_for,
        ]);
        if ($create != null){
            return redirect()->route('checkout.list')->with('success', 'Created Successfully');
        }
        return redirect()->back()-with('error', 'Failed to Create');
    }
    public function CheckoutOptionDelete($id){
        $check = StoreSettings::find($id);
        $delete = $check->delete();
        if ($delete !== true){
            return redirect()->back()->with('error','Failed to delete');
        }
        return redirect()->back()->with('success', 'Deleted Successfully');
    }
    // Checkout Page Why Choose Us

    public function WhyChooseUsCreate(Request $request) {
        $this->validate($request, [
            'title' => 'required|string',
            'image' => 'required|string',
            'description' => 'required|string',
            'option_name' => 'required|string'
        ]);
        $data = array(
            'title' => $request['title'],
            'image' => $request['image'],
            'description' => $request['description']
        );
        $create = StoreSettings::create([
            'option_name' => $request['option_name'],
            'option_value' => json_encode($data),
            'option_for' => 'checkout_page'
        ]);
        return redirect()->route('checkout.settings')->with('success', 'Stored Successfully');

    }


}
