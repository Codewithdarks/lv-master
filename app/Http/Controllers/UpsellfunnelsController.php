<?php

namespace App\Http\Controllers;

use App\Models\Upsellfunnels;
use App\Models\Upsellfunnel_downsellproducts;
use App\Models\Upsellfunnel_upsellproducts;
use App\Models\StoreSettings;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UpsellfunnelsController extends Controller
{
    /**
     * Returning the Upsell Funnel View targeted with funnels route.
     *
     * @return Application|Factory|View
     */

    public function UpsellfunnelsViewPage(Request $request) {
		$data = upsellfunnels::latest();
        if ($request->ajax()) {
            $data = upsellfunnels::latest();
            return \DataTables::of($data)->addIndexColumn()->addColumn('action', function ($data) {
                if($data->status=='Disable'){$eyeicon = 'fa-eye-slash';$funnelaction="Enable Funnel";}elseif($data->status=='Enable'){$eyeicon = 'fa-eye';$funnelaction="Disable Funnel";}
                return '<a title="Edit Funnel" href="/upsellfunnel/editupsells/'.Crypt::encrypt($data->id).'" class="table-btn btn"><i class="fas fa-edit"></i></a><a title="Delete Funnel" href="/upsellfunnel/deleteupsells/'.Crypt::encrypt($data->id).'" class="dltfunnel table-btn btn"><i class="fas fa-trash-alt"></i></a><a title="'.$funnelaction.'" href="/upsellfunnel/statusupsells/'.Crypt::encrypt($data->id).'" class="table-btn btn"><i class="fas '.$eyeicon.'"></i></a>';
            })->editColumn('created_at', function($data){ $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d M, Y'); return $formatedDate; })->editColumn('tag', function($data){ $formatedTag = 'onepagecheckout_'. $data->tag; return $formatedTag; })->rawColumns(['action'])->make(true);
        }
		if (upsellfunnels::exists()) {$tabledata= 'filled';} else { $tabledata='empty';}
        return view('pages.upsellfunnels',['tabledata' => $tabledata]);
    }
	
	/**
     * Add Upsell funnel with funnel add route.
     *
     * @return Application|Factory|View
     */
	 
	public function Createfunnel(){
        return view('pages.createfunnel');
	}
	
	/**
     * Save Upsell funnel with funnel save route.
     *
     * @return Application|Factory|View
     */	
	 
	 public function Savefunnel(Request $request){
		 //print_r($request->all());
		$this->validate($request, [
            'name' => 'required|unique:upsellfunnels|max:100|min:10',
            'tag' => 'required|alpha_dash|unique:upsellfunnels|max:100|min:3',
            
        ]);
		$data =array(
            'name' => $request['name'],
            'tag' => $request['tag'],
            'status' => 'Disable'
        );

        $insertupsell = Upsellfunnels::create($data);
		
		$upsellmainid = $insertupsell['id'];
			
		return redirect('upsellfunnel/editupsells/'.Crypt::encrypt($upsellmainid))->with('success', 'Funnel Created Successfully');
	 }

    /**
     * Enable Upsell funnel with its upsell and downsell.
     *
     * @return Application|Factory|View
     */	
	 
	 public function Enablefunnel(Request $request){
		 //print_r($request->all());
		$funnelid = Crypt::decrypt($request->funnelID);
        Upsellfunnels::where('id', '=', $funnelid)->update(['status' => 'Enable']);
        Upsellfunnel_upsellproducts::where('funnelid', '=', $funnelid)->update(['upstatus' => 'Enable']);
        Upsellfunnel_downsellproducts::where('funnelid', '=', $funnelid)->update(['dnstatus' => 'Enable']);

        return json_encode(array("message"=>"Funnel Save Successfully."),true); 
	 }
	/**
     * Handle to update the funnel info 
     * 
     */
     public function Updatefunnel(Request $request){
         
        if ($request->ajax()) {
        $Upsellfunnelid = Crypt::decrypt($request->id);
            if(!empty($request->name)){
                $this->validate($request, [
                    'name' => 'required|unique:upsellfunnels|max:100|min:10',
                  ]);
            }
            elseif(!empty($request->tag)){
                $this->validate($request, [
                    'tag' => 'required|alpha_dash|unique:upsellfunnels|max:100|min:3',
                ]);
            }
            $exist = Upsellfunnels::where(['id' => $Upsellfunnelid])->get()->first();
            if ($exist !== null) { 
                if(!empty($request->name)){
                    $exist->update([
                        'name' => $request->name
                    ]);
                    return json_encode(array("message"=>"Funnel name updated sucessfully."),true);
                }
                elseif(!empty($request->tag)){
                    $exist->update([
                        'tag' => $request->tag
                    ]);
                    return json_encode(array("message"=>"Funnel tag updated sucessfully."),true); 
                }
              
            }
        }
     }

    /**
     * Handling to delete the funnel and its upsell and downsells.
     *
     * @param $id
     * @return Application|Factory|View
     */
     public function DeletefunnelUpsells($id){
        $id = Crypt::decrypt($id);
        Upsellfunnels::where('id', $id)->delete();
        Upsellfunnel_upsellproducts::where('funnelid', $id)->delete();
        Upsellfunnel_downsellproducts::where('funnelid', $id)->delete();
        return redirect('upsellfunnels')->with('success', 'Funnel Deleted Successfully.');   
     }
     /**
     * Handling to change the funnel status.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function StatusfunnelUpsells($id){
        $id = Crypt::decrypt($id);
        
        $exist = Upsellfunnels::where(['id' => $id])->get()->first();
        //echo $exist->status;
        if($exist->status=='Disable'){
            Upsellfunnels::where('id', '=', $id)->update(['status' => 'Enable']);
            $newstatus = 'Funnel Enable Successfully.';
        }elseif($exist->status=='Enable'){
            Upsellfunnels::where('id', '=', $id)->update(['status' => 'Disable']);
            $newstatus = 'Funnel Disable Successfully.';
        }
        
        //exit();
        return redirect('upsellfunnels')->with('success', $newstatus);   
     } 
    /**
     * Handling the funnel and create upsell.
     *
     * @param $id
     * @return Application|Factory|View
     */
     Public function Editfunnelupsells($id){
        $Upsellfunnel = $this->FetchFunnelInfo($id);
        $funnelupdnsells = $this->FetchFunnelupdnInfo($id);
        $funnelname = $Upsellfunnel['name'];
        $funneltag =  $Upsellfunnel['tag'];
        $funnelId = $id;
        return view('pages.editfunnelupsells', compact('funnelname', 'funneltag','funnelId','funnelupdnsells'));
     }
	
    
    /**
     * Get the funnel information.
     *
     * @param $id
     * @return Application|Factory|View
     */
    private function FetchFunnelInfo($id) {
        $id = Crypt::decrypt($id);
        return upsellfunnels::find($id);
    }

    /**
     * Get funnel upsell & downsell information.
     *
     * @param $id
     * @return Application|Factory|View
     */
    private function FetchFunnelupdnInfo($id) {
        $funnelid = Crypt::decrypt($id);
        $allupdownsells = Upsellfunnel_upsellproducts::leftJoin('upsellfunnel_downsellproducts', 'upsellfunnel_downsellproducts.upsellid', '=', 'upsellfunnel_upsellproducts.id')
            ->where('upsellfunnel_upsellproducts.funnelid', $funnelid)
            ->get(['upsellfunnel_upsellproducts.id AS upid','upsellfunnel_upsellproducts.upshopify_productid','upsellfunnel_upsellproducts.upshopify_productname','upsellfunnel_upsellproducts.upshopify_producthandle','upsellfunnel_upsellproducts.updiscounttype','upsellfunnel_upsellproducts.updiscountamount','upsellfunnel_downsellproducts.id as dnid','upsellfunnel_downsellproducts.dnshopify_productid','upsellfunnel_downsellproducts.dnshopify_productname','upsellfunnel_downsellproducts.dnshopify_producthandle','upsellfunnel_downsellproducts.dndiscounttype','upsellfunnel_downsellproducts.dndiscountamount']);
            $allfupdownsells = $allupdownsells->map(function ($product) {
                return [
                    'upid'  => Crypt::encrypt($product->upid),
                    'upshopify_productid'  => $product->upshopify_productid,
                    'upshopify_productname'  => $product->upshopify_productname,
                    'upshopify_producthandle'  => $product->upshopify_producthandle,
                    'updiscounttype'  => $product->updiscounttype,
                    'updiscountamount'  => $product->updiscountamount,
                    'dnid'  => Crypt::encrypt($product->dnid),
                    'dnshopify_productid'  => $product->dnshopify_productid,
                    'dnshopify_productname'  => $product->dnshopify_productname,
                    'dnshopify_producthandle'  => $product->dnshopify_producthandle,
                    'dndiscounttype'  => $product->dndiscounttype,
                    'dndiscountamount'  => $product->dndiscountamount,

                ];
            });
        return $allfupdownsells;  
    }

    /**
     * Get funnel upsell information.
     *
     * @param $id
     * @return Application|Factory|View
     */
    private function FetchFunnelupsellInfo($id) {
        $id = Crypt::decrypt($id);
        $singleupsells = Upsellfunnel_upsellproducts::find($id);
        return $singleupsells;  
    }

    /**
     * Get funnel downsell information.
     *
     * @param $id
     * @return Application|Factory|View
     */
    private function FetchFunneldownsellInfo($id) {
        $id = Crypt::decrypt($id);
        $singledownsells = upsellfunnel_downsellproducts::find($id);
        return $singledownsells;
    }

    /**
     * Handle to update the funnel info 
     * 
     */
    public function Updatefunnelupdownsell(Request $request){
        
        if ($request->ajax()) {
            
        $Upsellfunnelid = Crypt::decrypt($request->funnelid);
        if(!empty($request['upselldownid'])){
            $upselldownid = Crypt::decrypt($request->upselldownid);
        }
        if($request['upselltype']=='upsell'){
            $data =array(
                'funnelid' => $Upsellfunnelid,
                'uptype' => $request['upselltype'],
                'upshopify_productid' => $request['shopify_productid'],
                'upshopify_productname' => $request['shopify_productname'],
                'upshopify_producthandle' => $request['shopify_producthandle'],
                'updiscounttype' => $request['discounttype'],
                'updiscountamount' => $request['discountamount'],
                'upstatus' => 'Disable'
            );
            if(empty($upselldownid) && $request['upselltype']=='upsell'){
                $insertfunnelupdownsell = Upsellfunnel_upsellproducts::create($data);
                $upsellmainid = $insertfunnelupdownsell['id'];
                return json_encode(array('type'=>'upsell','upselldownid'=>Crypt::encrypt($upsellmainid),'message'=>'Upsell save sucessfully.'));
            }elseif(!empty($upselldownid) && $request['upselltype']=='upsell'){
                $exist = Upsellfunnel_upsellproducts::where(['id' => $upselldownid])->get()->first();
                if ($exist !== null) { 
                    $exist->update($data);
                    return json_encode(array('type'=>'upsell','upselldownid'=>Crypt::encrypt($upselldownid),'message'=>'Upsell update sucessfully.'));
                }
            }
        }elseif($request['upselltype']=='downsell'){
            $parentupsellid = Crypt::decrypt($request->parentupsellid);
            $data =array(
                'funnelid' => $Upsellfunnelid,
                'upsellid' => $parentupsellid,
                'dntype' => $request['upselltype'],
                'dnshopify_productid' => $request['shopify_productid'],
                'dnshopify_productname' => $request['shopify_productname'],
                'dnshopify_producthandle' => $request['shopify_producthandle'],
                'dndiscounttype' => $request['discounttype'],
                'dndiscountamount' => $request['discountamount'],
                'dnstatus' => 'Disable'
            );
            if(empty($upselldownid) && $request['upselltype']=='downsell'){
                $insertfunnelupdownsell = upsellfunnel_downsellproducts::create($data);
                $upsellmainid = $insertfunnelupdownsell['id'];
                return json_encode(array('type'=>'downsell','upselldownid'=>Crypt::encrypt($upsellmainid),'message'=>'Downsell save sucessfully.'));
            }elseif(!empty($upselldownid) && $request['upselltype']=='downsell'){

                $exist = upsellfunnel_downsellproducts::where(['id' => $upselldownid])->get()->first();
                if ($exist !== null) { 
                    $exist->update($data);
                    return json_encode(array('type'=>'downsell','upselldownid'=>Crypt::encrypt($upselldownid),'message'=>'Downsell update sucessfully.'));
                }
            }
        }
        
        }
     }
    /**
     * Handle to fetch funnel upsell and downsell info 
     * 
     */
    public function FetchFunnelupdownsellInfo(Request $request){
       
       $upsellid = $request->id;
       if($request->type=='upsell'){
        $funnelinfo = $this->FetchFunnelupsellInfo($upsellid);
        $producthandle= $funnelinfo['upshopify_producthandle'];
        $discountamount = $funnelinfo['updiscountamount'];
        $discounttype = $funnelinfo['updiscounttype'];
       }elseif($request->type=='downsell'){
         $funnelinfo = $this->FetchFunneldownsellInfo($upsellid);
         $producthandle= $funnelinfo['dnshopify_producthandle'];
         $discountamount = $funnelinfo['dndiscountamount'];
         $discounttype = $funnelinfo['dndiscounttype'];
       }
       
       $shopify_storeurl = StoreSettings::where(['option_name' => 'shopify_main_domain'])->get(['option_value'])->first();
       $url = $shopify_storeurl['option_value'].'products/'.$producthandle.'.js';
      // exit();
       $ans_ch = curl_init();
       $timeout = 200;
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
       $header = substr($result_get, 0, $header_size);
       $body = substr($result_get, $header_size);
       $httpcode = curl_getinfo($ans_ch, CURLINFO_HTTP_CODE);
       curl_close($ans_ch);
       $result['response_body'] = $body;
       $result['response_extra'] = json_encode(array("discountamount"=>$discountamount, "discounttype"=>$discounttype));
       $result['response_code'] = $httpcode;
       
       if (isset($error_msg)) {
       $result['error_msg'] = $error_msg;
       }
       return $result;
        
    } 
    /**
     * Handle to delete funnel upsell and downsell info 
     * 
     */
    public function Deletefunnelupdownsell(Request $request){
        $type = $request->type;
        $UpDnsellid = Crypt::decrypt($request->updnid);
        $funnelid = Crypt::decrypt($request->funnelid);
        if($type=='downsell'){
            $exist = upsellfunnel_downsellproducts::where(['id' => $UpDnsellid])->get()->first();   
            if ($exist !== null) { 
                upsellfunnel_downsellproducts::where('id', $UpDnsellid)->delete();
                return json_encode(array('message'=>'Downsell Delete sucessfully.'));
            }
        }elseif($type=='upsell'){
            $exist = upsellfunnel_upsellproducts::where(['id' => $UpDnsellid])->get()->first();   
            if ($exist !== null) { 
                upsellfunnel_upsellproducts::where('id', $UpDnsellid)->delete();
                upsellfunnel_downsellproducts::where('upsellid', $UpDnsellid)->delete();
                $countupsell = upsellfunnel_upsellproducts::where(['id' => $UpDnsellid])->get();
                $upsellCounts = $countupsell->count();
                if($upsellCounts==0){
                    $existfunnel = Upsellfunnels::where(['id' => $funnelid])->get()->first();
                    if ($existfunnel !== null) { 
                        Upsellfunnels::where('id', '=', $funnelid)->update(['status' => 'Disable']);
                    }
                }
                return json_encode(array('message'=>'Upsell Delete sucessfully.'));
            }
        }
    }
    
}
