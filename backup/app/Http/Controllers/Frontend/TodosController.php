<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\User;
use Auth;
use Illuminate\Http\Request;

class TodosController extends Controller
{

    public function getAll(Request $request)
    {
        $todos = '';
        if ($request->has('id')) {
            $todos = User::where('id', $request->id)->first()->todos;
        } else {
            $todos = Auth::user()->todos;
        }
        return response()->json([
            'status' => 200,
            'todos' => $todos,
        ]);
    }

    public function toggleTodo($id)
    {

        $todo = Todo::find($id);

        $todo->status = $todo->status == '0' ? '1' : '0';

        $todo->save();

        return response()->json([

            'status' => 200,

            'todo' => $todo,

        ]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()
    {

        //

    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()
    {

        //

        return view('frontend.pages.todo._form_fields');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {

        //

        // return $request;

        $this->validate($request, [

            'title' => 'required|string',

        ]);

        $data_array = $request->only(['title', 'status']);

        if ($request->id) {

            $todo = Todo::find($request->id);

            if ($todo->user_id == Auth::id()) {

                $todo->update($data_array);

            }

        } else {

            $data_array['user_id'] = Auth::id();

            $todo = Todo::create($data_array);

        }

        return response()->json([

            'status' => 200,

            'todo' => $todo,

        ]);

    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)
    {

        //

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)
    {

        //

        $todo = Todo::find($id);

        return view('frontend.pages.todo._form_fields', compact('todo'));

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

        //

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)
    {

        $todo = Todo::find($id);

        if ($todo->user_id == Auth::id()) {
            $todo->delete();
            $response = [
                'status' => 200,
                'message' => 'Todo Deleted Successfully',
            ];

        } else {

            $response = [

                'status' => 401,

                'message' => 'Unauthorized Action',

            ];

        }

        return response()->json($response);

    }

}
