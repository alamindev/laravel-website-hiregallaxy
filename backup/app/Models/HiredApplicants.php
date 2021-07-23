<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class HiredApplicants extends Model

{

	protected $fillable = [

		'user_id',
		'user_name',
		'job_title',
		'job_id',
		'company_id',
		'status'

	];


	public static function totalHired()

	{

		$apps = DB::table('applicants')->where('status', 'hired')->get();

		return count($apps);

	}

}

