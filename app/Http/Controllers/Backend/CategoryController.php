<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Models\Category;

class CategoryController extends Controller
{
  public function __construct(){
    $this->middleware('auth:admin');
  }

  /*
  Category list
   */
  public function index()
  {
    $categories = Category::where('status', 1)->orderBy('id', 'desc')->get();
    $parent_categories = Category::where('parent_category_id', NULL)->orderBy('name', 'asc')->get();
    return view('backend.pages.category.index', compact('categories', 'parent_categories'));
  }  

  public function trash()
  {
    $categories = Category::where('status', 0)->orderBy('id', 'desc')->get();
    $parent_categories = Category::where('parent_category_id', NULL)->orderBy('name', 'asc')->get();
    return view('backend.pages.category.index', compact('categories', 'parent_categories'));
  }


  /*
  Save category
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required',
      'slug' => 'nullable|unique:categories'
    ]);

    $category = new Category();
    $category->name = $request->name;
    if ($request->slug) {
      $category->slug = $request->slug;
    }else{
      $category->slug = StringHelper::createSlug($request->name, 'Category', 'slug');
    }
    
    $category->image = ImageUploadHelper::upload('image', $request->file('image'), time(), 'public/images/categories');
    $category->description = $request->description;
    $category->icon = $request->icon;
    $category->parent_category_id = $request->parent_category_id;
    $category->is_featured = $request->is_featured;
    $category->save();

    session()->flash('success', 'Category added successfully');
    return back();
  }


  /*
  Update category
   */
  public function update(Request $request, $id)
  {
    $category = Category::find($id);

    if($category){
      $this->validate($request, [
        'name' => 'required',
        'slug' => 'required|unique:categories,slug,'.$category->id,
      ]);

      $category->name = $request->name;
      if($request->image){
        if($category->image){
          $category->image = ImageUploadHelper::update('image', $request->file('image'), time(), 'public/images/categories', $category->image);
        }
        else{
          $category->image = ImageUploadHelper::upload('image', $request->file('image'), time(), 'public/images/categories');
        }
      }
      $category->description = $request->description;
      $category->icon = $request->icon;
      $category->parent_category_id = $request->parent_category_id;
      $category->is_featured = $request->is_featured;
      $category->save();

      session()->flash('success', 'Category updated successfully');
      return redirect()->route('admin.category.index');
    }
    else{
      return redirect()->route('admin.category.index');
    }
  }

  /*
  Delete category and related information
   */
  public function destroy($id)
  {
    $category = Category::find($id);

    if($category){
      if ($category->status == 1) {
        // Just inactive it
        $category->status = 0;
        $category->save();
        session()->flash('error', 'Category trashed successfully');
      }else{
        if($category->image){
          ImageUploadHelper::delete('public/images/categories/'.$category->image);
        }

        $category->delete();
        session()->flash('error', 'Category deleted successfully');
      }
      
      return redirect()->route('admin.category.index');
    }
    else{
      return redirect()->route('admin.category.index');
    }
  }


  public function active($id)
  {
    $category = Category::find($id);

    if($category){
        $category->status = 1;
        $category->save();
        session()->flash('error', 'Category Activated successfully');
      return redirect()->route('admin.category.index');
    }
    else{
      return redirect()->route('admin.category.index');
    }
  }
}
