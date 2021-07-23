<?php



namespace App\Http\Controllers\Backend;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Notifications\AdminAccountCreateNotification;

use App\Helpers\ImageUploadHelper;

use App\Helpers\StringHelper;

use App\Models\Admin;

use App\Models\Role;

use Hash;

use DB;

class AdminController extends Controller

{

  public function __construct(){

    $this->middleware('auth:admin', ['except' => ['activateAccount']]);

  }



  /*

  Admin List

   */

  public function index()

  {

    $admins = Admin::orderBy('id', 'DESC')->get();

    return view('backend.pages.admin.index', compact('admins'));

  }



  /*

  Add admin form

   */

  public function create()

  {

    $roles = Role::get();

    return view('backend.pages.admin.add-admin',compact('roles'));

  }



  /*

  Save admin

   */

  public function store(Request $request)

  {

    $this->validate($request, [

      'username' => 'required',

      'email' => 'required|unique:admins',

      'password'  => 'required|min:8|confirmed',

      'role'  => 'required',

    ]);



    $admin = new Admin;

    $admin->first_name = $request->first_name;

    $admin->last_name = $request->last_name;

    $admin->username = $request->username;

    $admin->email = $request->email;

    $admin->phone_no = $request->phone_no;

    $admin->is_approved  = 1;

    $admin->password = Hash::make($request->password);

    $admin->image =  ImageUploadHelper::upload('image', $request->file('image'), time(), 'images/admins');

    $admin->address = $request->address;

    $admin->save();

    $admin->role()->sync($request->role);



    session()->flash('success', 'User Account Created Sucessfully ');

    return redirect()->route('admin.account.index');

  }



  public function access(Request $request)

  {

    $found = DB::table('editor_access')->where('user_id', $request->user_id)->first();



      if($request->access){

        $access = json_encode($request->access);

        if(!$found){

          DB::table('editor_access')->insert(

              ['user_id' => $request->user_id, 'access' => $access]

          );

        }else{

          DB::table('editor_access')->where('id', $found->id)->update(['access' => $access]);

        }

        session()->flash('success', 'Access control added!');

          return redirect()->route('admin.account.index');

      }else{

        session()->flash('error', 'Not Selected access control');

        return redirect()->route('admin.account.index');

      }

  }

  /*

  Activate account

   */

  // public function activateAccount($verifyToken)

  // {

  //     $admin = Admin::where('verify_token', $verifyToken)->update(['verify_token' => 1]);

  //     session()->flash('login_error', 'Account Activated Successfully');

  //     return redirect()->route('admin.login');

  // }





  public function show($id)

  {

    $view = Admin::where('id', $id)->first();

    return view('backend.pages.admin.view-admin', compact('view'));

  }



  /*

  Edit admin account form

   */

  public function edit($id)

  {

    $edit = Admin::where('id', $id)->first();

    $roles = Role::get();

    if($edit){

      return view('backend.pages.admin.edit-admin', compact('edit','roles'));

    }

    else{

      return redirect()->route('admin.account.index');

    }

  }



  /*

  Update admin account

   */

  public function update(Request $request, $id)

  {

    $admin = Admin::where('id', $id)->first();



    if($admin){

      $this->validate($request, [

        'email' => 'required|unique:admins,email,'.$admin->id,

        'phone_no' => 'unique:admins,phone_no,'.$admin->id,

        'username' => 'required|unique:admins,username,'.$admin->id

      ]);



      $admin->first_name = $request->first_name;

      $admin->last_name = $request->last_name;

      $admin->email = $request->email;

      $admin->phone_no = $request->phone_no;

      if($request->image){

        if($admin->iamge){

          $admin->image = ImageUploadHelper::update('image', $request->file('image'), time(), 'images/admins', $category->image);

        }

        else{

          $admin->image =ImageUploadHelper::upload('image', $request->file('image'), time(), 'images/admins');

        }

      }



     if($request->username !==  $admin->username){

        $admin->username = $request->username;

     }

      $admin->address = $request->address;

      $admin->save();

      $admin->role()->sync($request->role);

      session()->flash('success', ' User Account Updated Sucessfully');

      return redirect()->route('admin.account.index');

    }

    else{

      return back();

    }

  }



  /*

  Delete admin

   */

  public function destroy($id)

  {

    $admin = Admin::where('id', $id)->first();

    if($admin){

      if($admin->image){

        ImageUploadHelper::delete('uploads/admins/'.$admin->image);

      }



      $admin->delete();



      session()->flash('success', ' User Account Deleted Sucessfully');

      return redirect()->route('admin.account.index');

    }

    else{

      return back();

    }

  }

}