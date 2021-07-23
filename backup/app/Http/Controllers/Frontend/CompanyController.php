<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::where('user_id', auth()->user()->id)->get();
        return view('frontend.pages.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id', auth()->user()->id)
            ->with('teams')
            ->first();
        $collection = collect($user->teams);
        $filtered_id = $collection->pluck('id');
        $users = User::where('type', 1)->whereIn('id', $filtered_id)->get();
        return view('frontend.pages.companies.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:companies',
            'assign_id' => 'required',
            'contact_person' => 'required',
        ],
            [

                'email.required' => 'Please give an email address',
                'email.email' => 'Please give a valid email address',
                'email.unique' => 'Sorry   An email is already exists',
                'name.required' => 'Please give your name',
            ]

        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Create location and add location ID

        if (auth()->check() && auth()->user()->is_company == 1) {

            $company = new Company();
            $company->user_id = auth()->user()->id;
            $company->name = $request->name;
            $company->contact_person = $request->contact_person;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->location = $request->location;
            $company->website_url = $request->website_url;
            $company->assign_id = $request->assign_id;
            $company->save();
            return redirect()->route('companies')->with('success', 'Company created successfull');
        } else {
            return redirect()->back()->with('errors', 'Permission denied');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = Company::where('user_id', auth()->user()->id)->where('id', $id)->first();
        if ($show) {

            return view('frontend.pages.companies.show', compact('show'));
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->check() && auth()->user()->type == 0) {
            $user = User::where('id', auth()->user()->id)
                ->with('teams')
                ->first();
            $collection = collect($user->teams);
            $filtered_id = $collection->pluck('id');
            $users = User::where('type', 1)->whereIn('id', $filtered_id)->get();
            $edit = Company::where('user_id', auth()->user()->id)->where('id', $id)->first();
            if ($edit) {
                return view('frontend.pages.companies.edit', compact('edit', 'users'));
            }
            return back();
        } else {
            return redirect()->route('companies');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {$validator = \Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'assign_id' => 'required',
        'contact_person' => 'required',
    ],
        [

            'email.required' => 'Please give an email address',
            'email.email' => 'Please give a valid email address',
            'email.unique' => 'Sorry   An email is already exists',
            'name.required' => 'Please give your name',
        ]

    );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Create location and add location ID

        if (auth()->check() && auth()->user()->is_company == 1) {

            $company = Company::find($id);
            $company->user_id = auth()->user()->id;
            $company->name = $request->name;
            $company->contact_person = $request->contact_person;
            if ($company->email != $request->email) {
                $company->email = $request->email;
            }
            $company->phone = $request->phone;
            $company->location = $request->location;
            $company->website_url = $request->website_url;
            $company->save();
            return redirect()->route('companies')->with('success', 'Company Updated Sucessfully');
        } else {
            return redirect()->back()->with('errors', 'Permission denied');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->check() && auth()->user()->type == 0) {
            $delete = Company::where('id', $id)->first();
            if ($delete) {
                $delete->delete();
                return redirect()->route('companies');
            }
        } else {
            return redirect()->route('companies');
        }
    }
}