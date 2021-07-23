<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebCrawler;
use App\Models\CrawlerSite;

class CrawlerSitesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /*
  CrawlerSite list
   */
    public function index()
    {
        $crawler_sites = CrawlerSite::orderBy('id', 'desc')->get();
        return view('backend.pages.crawler_sites.index', compact('crawler_sites'));
    }


    /*
    Save crawler_sites
   */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $city = new CrawlerSite();
        $city->name = $request->name;
        $city->save();

        session()->flash('success', 'Site added successfully');
        return back();
    }


    /*
  Update crawler_sites
   */
    public function update(Request $request, $id)
    {
        $city = CrawlerSite::find($id);

        if ($city) {
            $this->validate($request, [
                'name' => 'required'
            ]);

            $city->name = $request->name;
            $city->save();

            session()->flash('success', 'Site updated successfully');
            return redirect()->route('admin.crawler_sites.index');
        } else {
            return redirect()->route('admin.crawler_sites.index');
        }
    }

    /*
  Delete crawler_sites and related information
   */
    public function destroy($id)
    {
        $city = CrawlerSite::find($id);

        if ($city) {
            $city->delete();
            session()->flash('error', 'Site deleted successfully');
            return redirect()->route('admin.crawler_sites.index');
        } else {
            return redirect()->route('admin.crawler_sites.index');
        }
    }
}
