<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discipline;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:admin');

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()
    {

        $templates = Template::with('category')->orderBy('id', 'desc')->get();

        return view('backend.pages.template.index', compact('templates'));

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {

        $categories = Category::orderBy('name', 'asc')->select('id', 'name')->get();

        $disciplines = Discipline::orderBy('name', 'asc')->select('id', 'name')->get();

        return view('backend.pages.template.create', compact('categories', 'disciplines'));

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {

        $this->validate(

            $request,

            [

                'category_id' => 'required',

            ],

            [

                'category_id.required' => 'Please select a category',

            ]

        );

        $category = Category::where('id', $request->category_id)->first();

        $template = new Template();

        $template->name = $category->name;

        $template->category_id = $request->category_id;

        $template->responsibilities = $request->responsibilities;

        $template->job_summery = $request->job_summery;

        $template->qualification = $request->qualification;

        $template->certification = $request->certification;

        $template->experience = $request->experience;

        $template->about_company = $request->about_company;

        $template->save();

        session()->flash('success', 'New Template added successfully');

        return redirect()->route('admin.templates.index');

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)
    {

        $template = Template::find($id);

        if (!is_null($template)) {

            return view('backend.pages.template.show', compact('template'));

        }

        session()->flash('error', 'Template not found');

        return redirect()->route('admin.templates.index');

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {

        $template = Template::find($id);

        $categories = Category::orderBy('name', 'asc')->get();

        $disciplines = Discipline::orderBy('name', 'asc')->select('id', 'name')->get();

        if (!is_null($template)) {

            return view('backend.pages.template.edit', compact('template', 'categories', 'disciplines'));

        }

        session()->flash('error', 'Template not found');

        return redirect()->route('admin.templates.index');

    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)
    {

        $template = Template::find($id);

        if (!is_null($template)) {

            $this->validate(

                $request,

                [

                    'category_id' => 'required',

                ],

                [

                    'category_id.required' => 'Please select a category',

                ]

            );

            $category = Category::where('id', $request->category_id)->first();

            $template->name = $category->name;

            $template->category_id = $request->category_id;

            $template->responsibilities = $request->responsibilities;

            $template->job_summery = $request->job_summery;

            $template->qualification = $request->qualification;

            $template->certification = $request->certification;

            $template->experience = $request->experience;

            $template->about_company = $request->about_company;

            $template->save();

            session()->flash('success', 'Template has been updated');

        } else {

            session()->flash('error', 'Template not found');

        }

        return redirect()->route('admin.templates.index');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {

        $template = Template::find($id);

        if (!is_null($template)) {

            $template->delete();

        }

        session()->flash('success', 'Template has been deleted successfully  ');

        return back();

    }

}
