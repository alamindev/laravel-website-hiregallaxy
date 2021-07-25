<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class Category extends Model

{

	protected $fillable = [

		'name',

		'slug',

		'image',

		'icon',

		'description',

		'is_featured',

		'parent_category_id'

	];



	public function jobs()

	{

		return $this->hasMany(Job::class);

	}



	public function parent()

	{

		return $this->belongsTo(Category::class, 'parent_category_id');

	}



	public static function totalOpenJobs($category_id)

	{

		$category = Category::find($category_id);

		$parent_category_id = $category->parent_category_id;

		$jobs = DB::table('jobs')->where('category_id', $category_id)->orWhere('category_id', $parent_category_id)->where('status_id', 1)->get();

		return count($jobs);

	}

}

