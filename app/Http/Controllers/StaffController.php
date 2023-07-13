<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Response;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    /**
     *  GET
     *  - get all staff
     */
    public function getAllStaff() 
    {
        $response = new Response;
        try {
            if (count(Staff::all()) > 0)
                $response = ResponseHelper::ResponseBuilder(Staff::all(), ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], '', null);
            else
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'No data available', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  GET
     *  - get staff by UUID or email
     *  @param uuid/email
     */
    public function getStaffById($id) 
    {
        $response = new Response;
        try {
            if (Staff::where('uuid', $id)->exists() || Staff::where('email', $id)->exists()) {
                $staff = Staff::where('uuid', $id)->exists() ? Staff::where('uuid', $id)->firstOrFail() : Staff::where('email', $id)->firstOrFail();
                $response = ResponseHelper::ResponseBuilder($staff, ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], '', null);
            }
            else $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'Staff not exist', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  POST
     *  - create a new staff
     *  @param JsonBody
     */
    public function createStaff(Request $request) 
    {
        //$header = $request->header('Authorization');
        $response = new Response;
        try {
            $validator = Validator::make($request->all(), [
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
            ]);
            if ($validator->fails())
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], $validator->errors()->first(), null);
            else if (Staff::where('email', $request->email)->exists() || Staff::where('mobile_no', $request->mobile_no)->exists()) 
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], 'Duplicated data or staff already exist!', null);
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
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_201[0], ResponseHelper::$HTPP_201[1], 'Successfully added staff', null);
            }
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  PUT
     *  - update/edit staff by UUID or email
     *  @param JsonBody
     */
    public function UpdateStaff(Request $request) {
        //$header = $request->header('Authorization');
        $response = new Response;
        try {
            if (Staff::where('uuid', $request->uuid)->exists() || Staff::where('email', $request->email)->exists()) {
                $staff = Staff::where('uuid', $request->uuid)->exists() ? Staff::where('uuid', $request->uuid)->firstOrFail() : Staff::where('email', $request->email)->firstOrFail();
                if (Staff::where('mobile_no', $request->mobile_no)->exists() && $staff->mobile_no != $request->mobile_no)
                    $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_400[0], ResponseHelper::$HTPP_400[1], 'Mobile no. already exist', null);
                else {
                    $validator = Validator::make($request->all(), [
                        'mobile_no' => 'regex:/^(01)[0-46-9][0-9]{7,8}$/',
                        'fullname' => 'regex:/^([a-zA-Z\' ]+)$/|min:3|max:255',
                        'sex' => 'integer|between:0,1',
                        'birthdate' => 'date',
                        'address1' => 'regex:/([- ,\/0-9a-zA-Z]+)/|max:255',
                        'address2' => 'regex:/([- ,\/0-9a-zA-Z]+)/|max:255',
                        'postcode' => 'numeric|digits:5',
                        'city' => 'regex:/^([a-zA-Z\' ]+)$/|max:255',
                        'state' => 'regex:/^([a-zA-Z\' ]+)$/|max:255',
                        'country' => 'regex:/^([a-zA-Z\' ]+)$/|max:255',
                    ]);
                    if ($validator->passes()) {
                        $staff->mobile_no = empty($request->mobile_no) ? $staff->mobile_no : $request->mobile_no;
                        $staff->fullname = empty($request->fullname) ? $staff->fullname : $request->fullname;
                        $staff->sex = empty($request->sex) ? $staff->sex : $request->sex;
                        $staff->birthdate = empty($request->birthdate) ? $staff->birthdate : $request->birthdate;
                        $staff->address1 = empty($request->address1) ? $staff->address1 : $request->address1;
                        $staff->address2 = empty($request->address2) ? $staff->address2 : $request->address2;
                        $staff->postcode = empty($request->postcode) ? $staff->postcode : $request->postcode;
                        $staff->city = empty($request->city) ? $staff->city : $request->city;
                        $staff->state = empty($request->state) ? $staff->state : $request->state;
                        $staff->country = empty($request->country) ? $staff->country : $request->country;
                        $staff->save();
                    }
                    $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], 'Staff updated'.(!empty($validator->errors()->first()) ? ' but failed to save '.Str::lower(Str::replace('field', 'field because', $validator->errors()->first())) : ''), null);
                }
            }
            else $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'Staff not exist', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->Code);
    }
    
    /**
     *  PUT
     *  - suspend/activate staff by UUID or email
     *  @param uuid/email
     */
    public function toggleSuspendStaff($id) 
    {
        $response = new Response;
        try {
            if (Staff::where('uuid', $id)->exists() || Staff::where('email', $id)->exists()) {
                $staff = Staff::where('uuid', $id)->exists() ? Staff::where('uuid', $id)->firstOrFail() : Staff::where('email', $id)->firstOrFail();
                $staff->suspend = $staff->suspend == "0" ? "1" : "0";
                $staff->save();
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], 'Staff '.($staff->suspend == "0" ? 'activated' : 'suspended'), null);
            }
            else $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'Staff not exist', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }

    /**
     *  DELETE
     *  - delete staff by UUID or email
     *  @param uuid/email
     */
    public function deleteStaff($id)
    {
        $response = new Response;
        try {
            if (Staff::where('uuid', $id)->exists() || Staff::where('email', $id)->exists()) {
                $staff = Staff::where('uuid', $id)->exists() ? Staff::where('uuid', $id)->firstOrFail() : Staff::where('email', $id)->firstOrFail();
                $staff->delete();
                $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_200[0], ResponseHelper::$HTPP_200[1], 'Successfully deleted staff', null);
            }
            else $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_404[0], ResponseHelper::$HTPP_404[1], 'Staff not exist', null);
        }
        catch (\Exception $err) {
            $response = ResponseHelper::ResponseBuilder(null, ResponseHelper::$HTPP_500[0], ResponseHelper::$HTPP_500[1], $err->getMessage(), null);
        }
        return response()->json($response, $response->code);
    }
}