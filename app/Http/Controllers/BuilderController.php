<?php

namespace App\Http\Controllers;

define('MAX_FILE_LIMIT', 1024 * 1024 * 2); //2 Megabytes max html file size
define('UPLOAD_PATH', 'media'); //upload path
use App\Models\PageBuilder;
use App\Models\Upsellfunnels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class BuilderController extends Controller
{
    public function PagesListing(Request $request) {
        if ($request->ajax()) {
            $data = PageBuilder::latest()->get();
            return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($data) {
                if(!$data->published){$eyeicon = 'fa-eye-slash';$funnelaction="Publish Page";}else{$eyeicon = 'fa-eye';$funnelaction="Un-Publish Page";}
                return '<a title="Edit Page Details" href="'.route('builder.edit.page', encrypt($data->id)).'" class="table-btn btn"><i class="fas fa-edit"></i></a><a title="Delete Page" href="'.route('builder.delete.page', encrypt($data->id)).'" class="delete-page-confirm table-btn btn"><i class="fas fa-trash-alt"></i></a><a title="'.$funnelaction.'" href="'.route('builder.page.publish-unpublish', encrypt($data->id)).'" class="table-btn btn"><i class="fas '.$eyeicon.'"></i></a><a href="'.route('editor', $data->url_slug).'" class="btn btn-primary btn-sm">Editor</a>';
            })->editColumn('funnel_id', function($data){ $funnel = Upsellfunnels::find($data->funnel_id); if (is_null($funnel) || empty($funnel)) { return 'N/A'; } else { return $funnel->name; } })->editColumn('published', function($data){ return $data->published ? 'Published' : 'Un-Published'; })->rawColumns(['action'])->make(true);
        }
        return view('builder.pages.listing');
    }

    public function CreatePageForBuilder() {
        $funnels = Upsellfunnels::all();
        return view('builder.pages.create', compact('funnels'));
    }

    public function StorePageForBuilder(Request $request) {
        $data = $this->validate($request, [
            'page_name' => 'required|string',
            'funnel_id' => 'nullable|integer'
        ]);
        $data['url_slug'] = $this->CreateSlug($data['page_name']);
        $build = PageBuilder::create([
            'name' => $data['page_name'],
            'url_slug' => $data['url_slug'],
            'funnel_id' => $data['funnel_id'] ?? null,
            'html' => view('builder.vvvejs.blank')
        ]);
        return redirect()->route('editor', $build->url_slug);
    }

    private function CreateSlug($string) {
        $delimiter = '-';
        return strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z\d-]+/', $delimiter, preg_replace('/&/', 'and', preg_replace('/\'/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $string))))), $delimiter));
    }

    public function Editor($active) {
        $find = PageBuilder::where(['url_slug' => $active])->first();
        if (is_null($find) || empty($find)) {
            abort(404);
        }
        $list = array(
            'name' => $find->url_slug,
            'title' => 'Current Page ('.$find->name.')',
            'url' => route('get.content', encrypt($find->id)),
            'file' => encrypt($find->id),
        );
        $file = encrypt($find->id);
        $all = json_encode($list);
        return view('builder.vvvejs.editor', compact('all', 'active', 'file'));
    }

    public function GetPageContent($id) {
        $page = PageBuilder::find(decrypt($id));
        return $page['html'];
    }

    public function EditPageForBuilder($id) {
        $page = PageBuilder::find(decrypt($id));
        $funnels = Upsellfunnels::all();
        return view('builder.pages.update_page', compact('page', 'funnels'));
    }

    public function UpdatePageForBuilder(Request $request, $id) {
        $data = $this->validate($request, [
            'page_name' => 'required|string',
            'funnel_id' => 'nullable|string',
        ]);
        $page = PageBuilder::find(decrypt($id));
        $slug = $this->CreateSlug($data['page_name']);

        $update = $page->update([
            'name' => $data['page_name'],
            'funnel_id' => $data['funnel_id'] ?? null,
            'url_slug' => $slug,
        ]);
        if ($update !== true){
            return redirect()->route('builder.listing')->with('error', 'Something Went Wrong');
        }
        return  redirect()->route('builder.listing')->with('success', 'Updated Successfully');
    }

    public function DeletePageForBuilder($id) {
        $page = PageBuilder::find(decrypt($id));
        $status = $page->delete();
        if ($status) {
            return redirect()->back()->with('success', 'Deleted Successfully');
        }
        return redirect()->back()->with('error', 'Something Went Wrong.');
    }

    public function PagePublishUnpublish($id) {
        $page = PageBuilder::find(decrypt($id));
        if ($page->published) {
            $page->update(['published' => false]);
        } else {
            $page->update(['published' => true]);
        }
        return redirect()->back()->with('success', 'Status changed successfully');
    }

    public function SaveContent(Request $request) {
        $data = $request->all();
        if (!empty($data['startTemplateUrl'])) {
            $html = file_get_contents(resource_path('views/vvvebjs/blank.blade.php'));
        } elseif ($data['html'] !== null) {
            $html = substr($data['html'], 0, MAX_FILE_LIMIT);
        }
        $file = $data['file'];
        $data = PageBuilder::find(decrypt($file));
        $status = $data->update(['html' => $html]);
        if ($status) {
            return response('Saved Successfully.', 200);
        } else {
            return response('Something Went Wrong.', 500);
        }
    }

    public function FileContent($loc) {
        return view('builder.vvvejs.themes.'.$loc);
    }

    public function UploadImage(Request $request) {
        logger(json_encode($request->all()));
        $upload_path = public_path('media/');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = strtotime(now()).$file->getClientOriginalName();
            $file->move($upload_path, $name);
            return 'media/'.$name;
        }
        return false;
    }

    public function ScanFileDirectory(Request $request) {
        $path = public_path('media');
        $files = array_diff(scandir($path), array('.', '..'));
        $assets = array();
        foreach ($files as $one) {
            if (! $one || $one[0] == '.') {
                continue; // Ignore hidden files
            }
            if (is_dir($path.'/'.$one)) {
                $assets[] = array(
                    'name' => $one,
                    'type' => 'folder',
                    'path' => $one,
                    'size' => filesize($path.'/'.$one)
                );
            } else {
                $assets[] = array(
                    'name' => $one,
                    'type' => 'file',
                    'path' => $one,
                    'size' => filesize($path.'/'.$one)
                );
            }
        }
        dd($assets);
        $images = implode(',', $assets);

        $scandir = asset('media');
        $files = array();
        if (file_exists($scandir)) {
            foreach (scandir($scandir) as $one) {
                if (! $one || $one[0] == '.') {
                    continue; // Ignore hidden files
                }
                if (is_dir($scandir . '/' . $one)) {
                    // The path is a folder

                    $files[] = [
                        'name'  => $one,
                        'type'  => 'folder',
                        'path'  => str_replace($scandir, '', $scandir) . '/' . $one,
                        'items' => $scandir($scandir . '/' . $one), // Recursively get the contents of the folder
                    ];
                } else {
                    // It is a file

                    $files[] = [
                        'name' => $one,
                        'type' => 'file',
                        'path' => str_replace($scandir, '', $scandir) . '/' . $one,
                        'size' => filesize($scandir . '/' . $one), // Gets the size of this file
                    ];
                }
            }
        }
        return json_encode($files);
    }
}
