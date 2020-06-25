<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $error = "";
        $users = User::all();

        return view('welcome', compact('users', 'error'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = "";

        if ( count( $request->all() ) > 0 ) {

            $validator = Validator::make($request->all(), [
                'name'     => 'required|min:2',
                'email'    => 'required|email|unique:users',
                'password' => 'required|min:6',
                'phone'    => 'required|min:11|unique:users'
            ]);

            if ($validator->fails()) {
                $error = $validator->messages()->first();
            }

            if ( !$error ) {
                User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'phone'    => $request->phone,
                    'password' => bcrypt($request->password)
                ]);

                $error = "User successfully added!";
            }
        }

        $users = User::all();

        return view('welcome', compact('users', 'error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $error = "";

        $user = User::findOrFail($id);

        return view('view', compact('error', 'user'));
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
        $error = "";

        $user = User::findOrFail($id);

        if ( count( $request->all() ) > 0 ) {

            $validator = Validator::make($request->all(), [
                'name'     => 'required|min:2',
                'password' => 'required|min:6',
                'phone'    => 'required|min:11'
            ]);

            if ($validator->fails()) {
                $error = $validator->messages()->first();
            }

            if ( $request->phone != $user->phone ) {

                $result = User::isPhoneExist($request->phone);

                if ( $result ) {
                    $error = "Phone Number is already taken!";
                }
            }
        }

        if ( strlen( $error ) == 0 ) {
            $user->update([
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
            ]);

            $error = "Successfully saved!";
        }
        
        return view('view', compact('error', 'user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $error = "";
        $user = User::find($id);

        $user->delete();

        $users = User::all();

        return redirect('/user');
    }

    /**
     * Get All Users API
     *
     * @return \Illuminate\Http\Response
     */

    public function all_users()
    {
        $users = User::all();

        return response()->json([$users], 200);
    }

    /**
     * Get Specific User API
     *
     * @return \Illuminate\Http\Response
     */

    public function get_user($id)
    {
        $user = User::find($id);

        return response()->json([$user], 200);
    }
}
