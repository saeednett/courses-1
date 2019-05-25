<?php

namespace App\Http\Controllers;

use App\Bank;
use App\CenterAccount;
use App\City;
use App\Country;
use App\Coupon;
use App\Course;
use App\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $response = array(
        'status' => array(),
        'errors' => array(),
        'response' => array(),
    );

    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $data = array();

    // This Function Returns All Cities That Belong To A specific Country
    public function cities($id)
    {
        $country = Country::where('id', $id)->first();

        if (count($country) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'Can Not Find The Specific ID Of The Country Please Check And Try Later');
            array_push($this->response['response'], null);

            return response($this->response, 404);
        } else {
            $cities = City::where('country_id', $country->id)->get();
            $this->response['response'][$country->name] = array();
            foreach ($cities as $city) {
                $sudData = array(
                    'id' => $city->id,
                    'name' => $city->name,
                );
                array_push($this->response['response'][$country->name], $sudData);
            }
            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);

            return response()->json($this->response);
        }
    }

    public function banks()
    {
        $banks = Bank::all();
        foreach ($banks as $bank) {
            $sudData = array(
                'id' => $bank->id,
                'name' => $bank->name,
                'image' => $bank->image,
            );
            array_push($this->response['response'], $sudData);
        }
        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);

        return response()->json($this->response);
    }

    public function check_coupon($identifier, $coupon_code)
    {
        $course = Course::where('identifier', $identifier)->first();

        if (count($course) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'Can Not Find The Specific Course, Please Recheck And Try Later');
            array_push($this->response['response'], null);

            return response($this->response, 404);
        } else {
            $coupon = Coupon::where('course_id', $course->id)->where('code', $coupon_code)->first();

            if (count($coupon) < 1) {
                array_push($this->response['status'], 'failed');
                array_push($this->response['errors'], "Can Not Find The Specific Course Coupon, Please Recheck And Try Later");
                array_push($this->response['response'], null);

                return response($this->response, 404);
            } else {
                $subData = array(
                    'code' => $coupon->code,
                    'discount' => $coupon->discount,
                );

                array_push($this->response['status'], 'success');
                array_push($this->response['errors'], null);
                array_push($this->response['response'], $subData);

                return response()->json($this->response);
            }
        }
    }

    public function center_bank_account($center_identifier, $bank_id){
        $center = User::where('username', $center_identifier)->first();

        if ( count($center) < 1 ){
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], "Can Not Find The Specific Center, Please Recheck And Try Later");
            array_push($this->response['response'], null);

            return response($this->response, 404);
        }else {
            $bank = Bank::where('id', $bank_id)->first();
            if ( count($bank) < 1 ){
                array_push($this->response['status'], 'failed');
                array_push($this->response['errors'], "Can Not Find The Specific Bank ID, Please Recheck And Try Later");
                array_push($this->response['response'], null);

                return response($this->response, 404);
            }else{

                $account = CenterAccount::where('center_id', $center->center->id)->where('bank_id', $bank->id)->first();
                if ( count($account) < 1 ){
                    array_push($this->response['status'], 'failed');
                    array_push($this->response['errors'], "Can Not Find The Specific Bank Information That Belongs To The Center, Please Recheck And Try Later");
                    array_push($this->response['response'], null);

                    return response($this->response, 404);
                }else {
                    $subData = array(
                        'bank_id' => $account->bank_id,
                        'center_id' => $account->center_id,
                        'bank_name' => $bank->name,
                        'center_name' => $account->center->name,
                        'account_owner' => $account->account_owner,
                        'account_number' => $account->account_number,
                        'bank_image' => $bank->image,
                    );
                    array_push($this->response['status'], 'success');
                    array_push($this->response['errors'], null);
                    array_push($this->response['response'], $subData);

                    return response()->json($this->response);
                }

            }
        }
    }

    public function center_banks_accounts($center_identifier){

        $center = User::where('username', $center_identifier)->first();

        if ( count($center) < 1 ){
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], "Can Not Find The Specific Center, Please Recheck And Try Later");
            array_push($this->response['response'], null);

            return response($this->response, 404);
        }else {
            $accounts = CenterAccount::where('center_id', $center->id)->get();

            foreach ($accounts as $account){
                $subData = array(
                    'bank_id' => $account->bank_id,
                    'center_id' => $account->center_id,
                    'bank_name' => $account->bank->name,
                    'center_name' => $account->center->name,
                    'account_owner' => $account->account_owner,
                    'account_number' => $account->account_number,
                    'bank_image' => $account->bank->image,
                );
                array_push($this->response['status'], 'success');
                array_push($this->response['errors'], null);
                array_push($this->response['response'], $subData);
            }
            return response()->json($this->response);
        }
    }
}
