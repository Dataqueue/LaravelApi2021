<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;
use App\Models\User;
// use App\Http\Controllers\Api\Hash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $users->map(function($user){
            if ($user->role){
                $user['role_name'] = $user->role->name;
            }else{
                $user['role_name'] = null;
            }
        });
        return (
            $users
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            "name"=> $request->name,
            "email"=> $request->email,
            "contact"=> $request->contact,
            "password"=> bcrypt($request->password),
            "role_id"=> $request->role_id,
            'remember_token' => Str::random(10),
            'designation' => $request->designation,
            'prefix' => $request->prefix,
        ]);

        if($user){
                PaymentAccount::create([
                'name' => $user->name,
                'user_id' => $user->id,
            ]);
        }
       
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user['role_name'] = $user->role->name;

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if($request->password){
            $request['password'] = bcrypt($request->password);
        }else{
            $request['password'] = $user->password;
        }
        if($request->name){
            $payment_account = PaymentAccount::where('user_id',$user->id)->first();
            if(!$payment_account){
                return response()->json(["msg" => "There is no payment account by the given user name for update"], 201);
            }
            $payment_account->update([
                'name'=>$request->name,
            ]);
        }
        $user->update($request->all());


        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['msg' => "User is successfully deleted."]);
    }


    public function add(Request $request)
    {
        User::where('email', '=', $request->email)->first();
        if (Hash::check('admin123',bcrypt($request->password))) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function oldPassword(Request $request)
    {
        $user = User::where('id',$request->id)->first();
        if(!$user){
            return response()->json(['msg'=>"No user by the given id"]);
        }
        if( Hash::check($request->password, $user->password  ) )
        {
            return response()->json(['msg'=>true]);
        }
        return response()->json(['msg'=>false]);
    }

}
