<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        $request->type === 'Admin'?  
         $user = Admin::where('email', $credentials['email'])->first(): ( 
         $request->type==='Customer'?   
         $user = Customer::where('email', $credentials['email'])->first():'');


     
        if ($user) {
            if ($request->type === 'Admin'){
                if (Auth::guard('admin')->attempt($credentials)) {
                $authenticatedUser = Auth::guard('admin')->user();

                return response()->json(['user' => $authenticatedUser]);

            } else {
                return response()->json(['message' => 'Invalid login credentials'], 401);
            }
            }if ($request->type === 'Customer'){
                if (Auth::guard('customer')->attempt($credentials)) {
                $authenticatedUser = Auth::guard('customer')->user();
                return response()->json(['user' => $authenticatedUser]);

            } else {
                return response()->json(['message' => 'Invalid Customer login credentials'], 401);
            }
            }if ($request->type === 'Driver'){
                if (Auth::guard('admin')->attempt($credentials)) {
                $authenticatedUser = Auth::guard('admin')->user();
                return response()->json(['user' => $authenticatedUser]);

            } else {
                return response()->json(['message' => 'Invalid login credentials'], 401);
            }
            }
            


            // if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            //     $user = Auth::guard('admin')->user();
            // return response()->json(['user' => $user]);
            // } else {
            //     return response()->json(['message' => 'Invalid login credentials'], 401);
            // }
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function customerRegister(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'email' => 'required|unique:users|email|max:100',
            'password' => 'required',
            'title' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'type' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        } else {
            $user = new Customer;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->title = $request->title;
            $user->gender = $request->gender;
            $user->phone_number = $request->phone_number;
            $user->password = Hash::make($request->password);
            $user->type = $request->type;

            $user->save();



            $token = $user->createToken('druppa')->plainTextToken;

            $codex = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -63);
            $user->verify_token = Str::random(40) . $codex . time();
            $user->save();


            return response()->json(['token' => $token, 'user' => $user, 'message' => 'You have successfully created an account'], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        //
    }


}