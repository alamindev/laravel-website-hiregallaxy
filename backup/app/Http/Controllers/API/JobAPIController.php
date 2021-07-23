<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobAPIController extends Controller
{

    public function addFavorite(Request $request)
    {

        $api_token = $request->get('api_token');

        $user = User::where('api_token', $api_token)->first();

        if (!is_null($user->api_token)) {

            if (DB::table('job_favorites')->where('user_id', $user->id)->where('job_id', $request->get('job_id'))->first()) {

                DB::table('job_favorites')->where('user_id', $user->id)->where('job_id', $request->get('job_id'))->delete();

                $total_favorites = count(DB::table('job_favorites')->where('user_id', $user->id)->get());

                return json_encode(['status' => 'success', 'message' => 'Job removed from favorite list .', 'totalFavorite' => $total_favorites]);

            }

            $insert = DB::table('job_favorites')->insert([

                'job_id' => $request->get('job_id'),

                'user_id' => $user->id,

            ]);

            $total_favorites = count(DB::table('job_favorites')->where('user_id', $user->id)->get());

            return json_encode(['status' => 'success', 'message' => 'Job added to favorite list .', 'totalFavorite' => $total_favorites]);

        } else {

            return json_encode(['status' => 'error', 'message' => 'Not Authenticated']);

        }

    }

    public function checkFavorite($job_id, $api_token)
    {

        $api_token = $api_token;

        $user = User::where('api_token', $api_token)->first();

        if (!is_null($user->api_token)) {

            if (DB::table('job_favorites')->where('user_id', $user->id)->where('job_id', $job_id)->first()) {

                return json_encode(['status' => 'success']);

            } else {

                return json_encode(['status' => 'error']);

            }

        } else {

            return json_encode(['status' => 'error']);

        }

    }

    public function getTemplate(Request $request)
    {

        $template = Template::find($request->template_id);

        if (!is_null($template)) {

            return json_encode(['status' => 'success', 'template' => $template]);

        }

        return json_encode(['status' => 'error', 'template' => null]);

    }

    public function templates($search = "")
    {

        $search = trim($search);

        $templates = Template::orderBy('name', 'asc')->where('name', 'like', "%" . $search . "%")->get();

        return ['status' => 'success', 'templates' => $templates];

    }

    public function AllTemplates()
    {

        $templates = Template::orderBy('name', 'asc')->get();

        return ['status' => 'success', 'templates' => $templates];

    }

}
