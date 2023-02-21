<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor') ) {
            return User::latest()->paginate(5);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request,[
         'name' => 'required|string|max:100',
         'email' => 'required|string|email|max:100|unique:users',
         'password' => 'required|string|min:8',

        ]);
        return User::create([
           'name' => $request['name'],
           'email' => $request['email'],
           'type' => $request['type'],
           'bio' => $request['bio'],
           'photo' => 'profile.png',
           'password' =>Hash::make($request['password']) ,
        ]);
    }


     // display user profile info
    public function profile()
    {
        return auth('api')->user();
    }

    // update user profile info
    public function updateProfile(Request $request)
    {
        $user=auth('api')->user();

        $this->validate($request,[
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',

           ]);


        $currentPhoto=$user->photo;

        if ($request->photo != $currentPhoto) {
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);
           $request->merge(['photo' => $name]);

           $userPhoto=public_path('img/profile/').$currentPhoto;
           if (file_exists($userPhoto) ) {
               @unlink($userPhoto);
           }
        }

        if (!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);

        }

        $user->update($request->all());

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $user=User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',

           ]);

        $user->update($request->all());
        return ['message' => 'updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        //delete the user
        $user=User::findorfail($id);

        $user->delete();
        return ['message' => 'user deleted succefuly'];
    }
    public function search(){

        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(5);
        }else{
            $users = User::latest()->paginate(5);
        }

        return $users;

    }
}
