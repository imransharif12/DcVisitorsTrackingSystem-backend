<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Admin};
use App\Validations\GenericValidations;
use Hash;
use App\Http\Resources\AdminResource;

class AdminController extends Controller
{
	public function  index(Request $request)
	{
		$admins=Admin::query();
		$data=$admins->where(['type'=>'admin','status'=>1])->get();
		return sendResponce(200, 'Record Fetched Successfully',$data);

	}
	public function register(Request $request)
	{
		try {

			$input = $request->all();
			$admin = Admin::where('email', $input['email'])->first();
			if ($admin) {
				return sendResponce(422, 'There is already an account associated with this email', (object)[]);
			}else{
				$admin = new Admin();
			}

			$admin->code= mt_rand(100000, 999999);
			$admin->password = bcrypt($input['password']);
			$admin->fill($input);
			$admin->save();
			return sendResponce(200, 'Registeration Successfully', (object)[]);
		} catch (Exception $e) {
			$response = sendError(500, "Server Error", (object)[]);
			return $response;
		}
	}

	public function login(Request $request)
    {
      try {       
        $input = $request->all();
        $user = Admin::where(['email' => $input['email']])->first();

        if ($user) {
     
          if ($user->status == 1) {
            if (Hash::check($input['password'], $user->password)) {
              $user->token = $user->createToken('basicproject')->accessToken;
              $response = sendResponce(200, 'Login Successful!', new AdminResource($user));
            } else {
              $response = sendResponce(202, 'Password is not correct!', (object)[]);
              return $response;
            }
          } else {
            $response = sendResponce(401, 'Your account is inactive. Please contact system administrator to active your account.', (object)[]);
            return $response;
          }

          
        } else {
          $response = sendResponce(202, 'No user found with this email', (object)[]);
        }
        return $response;
      } catch (\Exception $ex) {
        $response = sendResponce(500, $ex->getMessage(), (object)[]);
        return $response;
      }
    }
}
