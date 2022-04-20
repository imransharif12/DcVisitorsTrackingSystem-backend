<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Company,VistorAccess};
class AuthController extends Controller
{
    public function register(Request $request)
 {
  try {

    $input = $request->all();
    $data = Company::where('email', $input['email'])->first();
    if ($data) {
      return sendResponce(422, 'There is already an account associated with this email', (object)[]);

    }else{
      $data = new User();
      $data->fill($input);
    }
    $data->code= mt_rand(100000, 999999);
    $data->save();
    $company=new Company();
    $company->fill($input);
    $company->user_id=$data->id;
    $company->save();
    $vistor=new VistorAccess();
    $vistor->fill($input);
    $vistor->user_id=$data->id;
    $vistor->save();
    $data->token = $data->createToken($data->id)->accessToken;
    return sendResponce(422, 'Registeration Successfully', (object)[]);
  } catch (Exception $e) {
    $response = sendError(500, "Server Error", (object)[]);
    return $response;
  }
}
}
