<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Response;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     *  GET
     *  - get all user
     */
    public function getAllUser() 
    {
        $response = new Response;
        try {
            if (count(User::all()) > 0)
                $response = ResponseHelper::ResponseBuilder(User::all(), ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], '', null);
            else
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'No data available', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  POST
     *  - create a new staff and immediately register them as a user
     *  @param JSON: $request
     */
    public function registerNewStaffAsUser(Request $request) 
    {
        $reponse = new Response;
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,70}$/|',
                'email' => 'required|email|max:255',
                'mobile_no' => 'required|regex:/^(01)[0-46-9][0-9]{7,8}$/',
                'fullname' => 'required|regex:/^([a-zA-Z\' ]+)$/|min:3|max:255',
                'sex' => 'required|integer|between:0,1',
                'birthdate' => 'required|date',
                'address1' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/|max:255',
                'address2' => 'regex:/([- ,\/0-9a-zA-Z]+)/|max:255',
                'postcode' => 'required|numeric|digits:5',
                'city' => 'required|regex:/^([a-zA-Z\' ]+)$/|max:255',
                'state' => 'required|regex:/^([a-zA-Z\' ]+)$/|max:255',
                'country' => 'required|regex:/^([a-zA-Z\' ]+)$/|max:255',
            ], 
            ['password.regex' => 'Password must be minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter and 1 number']);
            if ($validator->fails())
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], $validator->errors()->first(), null);
            else if (User::where('email', $request->email)->exists()) 
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], 'User already exist!', null);
            else if (Staff::where('email', $request->email)->exists() || Staff::where('mobile_no', $request->mobile_no)->exists()) 
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], 'Staff already exist! Please use a different API to register them as a user.', null);
            else {
                $staff = new Staff;
                $staff->email = $request->email;
                $staff->mobile_no = $request->mobile_no;
                $staff->fullname = $request->fullname;
                $staff->sex = $request->sex;
                $staff->birthdate = $request->birthdate;
                $staff->address1 = $request->address1;
                $staff->address2 = $request->address2;
                $staff->postcode = $request->postcode;
                $staff->city = $request->city;
                $staff->state = $request->state;
                $staff->country = $request->country;
                $staff->save();

                $user = new User;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $staff->user()->save($user);
                
                DB::commit();
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_201[0], ResponseHelper::$HTPP_201[1], 'Successfully added staff and registered as a user', null);
            }
        }
        catch (\Exception $err) {
            DB::rollBack();
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  POST
     *  - register existing staff as a user
     *  @param JSON: $request
     */
    public function registerStaffAsUser(Request $request) 
    {
        $reponse = new Response;
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,70}$/|',
            ], 
            ['password.regex' => 'Password must be minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter and 1 number']);
            if ($validator->fails())
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], $validator->errors()->first(), null);
            else if (User::where('email', $request->email)->exists()) 
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], 'User already exist!', null);
            else if (!Staff::where('email', $request->email)->exists()) 
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], 'Staff does not exist!', null);
            else {
                $staff = Staff::where('email', $request->email)->firstOrFail();
                if ($staff->suspend == "0") {$user = new User;
                    $user->email = $staff->email;
                    $user->password = Hash::make($request->password);
                    $staff->user()->save($user);
                    $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_201[0], ResponseHelper::$HTPP_201[1], 'Successfully added staff and registered as a user', null);
                }
                else $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], 'Unable to register staff as a user due to suspension!', null);
            }
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  PUT
     *  - suspend/activate user by UUID or email
     *  @param uuid/email
     */
    public function toggleSuspendUser($id) 
    {
        $response = new Response;
        try {
            if (User::where('uuid', $id)->exists() || User::where('email', $id)->exists()) {
                $user = User::where('uuid', $id)->exists() ? User::where('uuid', $id)->firstOrFail() : User::where('email', $id)->firstOrFail();
                $user->suspend = $user->suspend == "0" ? "1" : "0";
                $user->save();
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], 'User '.($user->suspend == "0" ? 'activated' : 'suspended'), null);
            }
            else $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'User not exist', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  DELETE
     *  - delete user by UUID or email
     *  @param uuid/email
     */
    public function deleteUser($id)
    {
        $response = new Response;
        try {
            if (User::where('uuid', $id)->exists() || User::where('email', $id)->exists()) {
                $user = User::where('uuid', $id)->exists() ? User::where('uuid', $id)->firstOrFail() : User::where('email', $id)->firstOrFail();
                $user->delete();
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], 'Successfully deleted user', null);
            }
            else $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'User not exist', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }
}