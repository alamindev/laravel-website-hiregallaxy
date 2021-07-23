<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\StringHelper;
use App\Http\Controllers\Controller;
use App\Models\CrawlerLink;
use App\Models\CrawlerSite;
use App\Models\WebCrawler;
use Illuminate\Http\Request;

class JobCrawlersController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /*

    WebCrawler list

     */

    public function index()
    {

        $crawlers = WebCrawler::orderBy('id', 'desc')->get();

        return view('backend.pages.crawlers.index', compact('crawlers'));

    }

    /*

    Save crawlers

     */

    public function store(Request $request)
    {

        $this->validate($request, [

            'url' => 'required|url',

        ]);

        $city = new WebCrawler();

        $city->url = $request->url;

        $city->save();

        session()->flash('success', 'Job Crawler added successfully');

        return back();

    }

    /*

    Update crawlers

     */

    public function update(Request $request, $id)
    {

        $city = WebCrawler::find($id);

        if ($city) {

            $this->validate($request, [

                'url' => 'required|url',

            ]);

            $city->url = $request->url;

            $city->save();

            session()->flash('success', 'Job Crawler updated successfully');

            return redirect()->route('admin.crawlers.index');

        } else {

            return redirect()->route('admin.crawlers.index');

        }

    }

    /*

    Delete crawlers and related information

     */

    public function destroy($id)
    {

        $city = WebCrawler::find($id);

        if ($city) {

            $city->delete();

            session()->flash('error', 'Job Crawler deleted successfully');

            return redirect()->route('admin.crawlers.index');

        } else {

            return redirect()->route('admin.crawlers.index');

        }

    }

    public function asignSite()
    {

        $crawlers = WebCrawler::orderBy('id', 'desc')->get();

        $sites = CrawlerSite::orderBy('name', 'asc')->get();

        return view('backend.pages.crawlers.assign-site', compact('crawlers', 'sites'));

    }

    public function asignSiteList()
    {

        $crawler_links = CrawlerLink::orderBy('id', 'desc')->orderBy('updated_at', 'desc')->get();

        return view('backend.pages.crawlers.assign-site-list', compact('crawler_links'));

    }

    public function asignSiteStore(Request $request)
    {

        $this->validate(

            $request,

            [

                'site_id' => 'required|numeric',

            ],

            [

                'site_id.required' => 'Please select a site',

            ]

        );

        $i = 0;

        $selected = [];

        if (isset($request->crawler_ids)) {

            foreach ($request->crawler_ids as $crawler) {

                if (isset($request->crawler_ids[$i])) {

                    $selected[] = $crawler;

                }

                $i++;

            }

        }

        if (count($selected) == 0) {

            $this->validate(

                $request,

                [

                    'web_crawler_id' => 'required|numeric',

                ],

                [

                    'web_crawler_id.required' => 'Please check minimum one link',

                ]

            );

        }

        foreach ($selected as $web_crawler_id) {

            $crawler_link = new CrawlerLink();

            $crawler_link->web_crawler_id = $web_crawler_id;

            $crawler_link->crawler_site_id = $request->site_id;

            $link = CrawlerLink::where('web_crawler_id', $web_crawler_id)->where('crawler_site_id', $request->site_id)->first();

            if (is_null($link)) {

                $crawler_link->save();

            } else {

                $link->crawler_site_id = $request->site_id;

                $link->save();

            }

        }

        if (count($selected) == 0) {

            session()->flash('success', 'No Crawler link has been found .');

        } else {

            session()->flash('success', 'Job Crawler links added to site successfully .');

        }

        return redirect()->route('admin.sites.asignSiteList');

    }

    public function extractLinks($data = [])
    {

        if (!empty($data)) {

            $links = $data['links'];

            $request = $data['request'];

        } else {

            $links = [];

            $request = [];

        }

        return view('backend.pages.crawlers.extract-links', compact('links', 'request'));

    }

    public function extractLinksStore(Request $request)
    {

        $this->validate($request, [

            'url' => 'required|url',

        ]);

        $links = StringHelper::getValidUrlsFrompage($request->url);

        // print_r($links);

        // dd();

        $data = [

            'links' => $links,

            'request' => $request,

        ];

        session()->flash('success', 'Links have been generated .');

        return $this->extractLinks($data);

    }

    public function asignSiteDelete($id)
    {

        $crawler_link = CrawlerLink::find($id);

        if (!is_null($crawler_link)) {

            $crawler_link->delete();

            session()->flash('success', 'Link has been deleted .');

        }

        return back();

    }

}
