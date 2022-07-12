<?php

namespace App\Http\Controllers;

use App\Models\TrackingCode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GlobalCodeController extends Controller
{
    /**
     * Returning the Global Code View targeted with global.code route.
     *
     * @return Application|Factory|View
     */
    public function GlobalCodesView() {
        return view('pages.global-codes');
    }

    public function RetrieveCodeValue($name) {
        $data = TrackingCode::where(['track_page_name' => $name])->get()->first();
        if ($data !== null) {
            return $data->track_code;
        }
        return '';
    }

    public function SubmittedDataHandling(Request $request) {
        $data = $this->validate($request, [
            'checkout_page' => 'nullable|string',
            'thanks_page' => 'nullable|string',
        ]);
        if ($data['checkout_page'] === null) {
            $data['checkout_page'] = '';
        }
        if ($data['thanks_page'] === null) {
            $data['thanks_page'] = '';
        }
        foreach ($data as $key => $code) {
            $codeInDB = TrackingCode::where(['track_page_name' => $key])->get()->first();
            if ($codeInDB !== null) {
                $codeInDB->update([
                    'track_code' => html_entity_decode($code),
                ]);
            } else {
                TrackingCode::create([
                    'track_page_name' => $key,
                    'track_code' => $code
                ]);
            }
        }
        return redirect()->back()->with('success', 'Track Codes Saved Successfully');
    }
}
