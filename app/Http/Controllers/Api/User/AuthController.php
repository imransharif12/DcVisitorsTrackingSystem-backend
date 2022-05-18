<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Company,VistorAccess,AccessDataArea,Admin};
use App\Http\Resources\AuthencationResource;
use App\Validations\GenericValidations;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\EmailController;

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
      $areas = isset($input['areas'])?$input['areas']:[];
      if(!empty($areas)){
        foreach ($areas as $area) {
          $accessdataarea=new AccessDataArea;
          $accessdataarea->name=$area;
          $accessdataarea->user_id=$data->id;
          $accessdataarea->save();
        }
      }
      // $data->token = $data->createToken($data->id)->accessToken;
      $this->sendMail($input['email'],$data->code);
      return sendResponce(200, 'Registeration Successfully', (object)[]);
    } catch (Exception $e) {
      $response = sendError(500, "Server Error", (object)[]);
      return $response;
    }
  }

  public function  sendMail($email, $code)
{
   $layout = \View::make('emails.companyinfo', ['data' => $code]);
    EmailController::send_default_email($email, "Netrics",(string)$layout);
  return true;
} 


    
}
