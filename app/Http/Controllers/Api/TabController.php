<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Verfications,VerficationCollectionRegister,
  VerficationCriminalRecord,AccessData,AccessDataArea,
  AccessDataBuilding,EscortAuthorizedPerson,ReportedAuthorizedPerson,AuditByDatacube,ApplicableDocument,ReturnConfirmation,
  AcknowledgementReceipt,User,Company,VistorAccess};
  use App\Validations\GenericValidations;

  class TabController extends Controller
  {

    public function getRecord(Request $request){
      $user=User::query();
      $data=$user->WhereHas('companyInfo', function($q) {
        $q->where('type','=', 'simple');
      })->with('vistors','companyInfo','verfication','collectionRegister','criminal','accessData','accessDataArea','accessDataBuilding','escort','authorizedPerson','auditByDatacube','applicableDocument','acknowledgementReceipt','returnConfirmation')->get();
      return sendResponce(200, 'Record Fetched Successfully',$data);

    }

    public function companyDetail(Request $request){
      $user=User::query();
      $data=$user->where(['code'=>$request->code])->WhereHas('companyInfo', function($q) {
        $q->where('type','=', 'simple');
      })->with('vistors','companyInfo','verfication','collectionRegister','criminal','accessData','accessDataArea','accessDataBuilding','escort','authorizedPerson','auditByDatacube','applicableDocument','acknowledgementReceipt','returnConfirmation')->first();
      return sendResponce(200, 'Record Fetched Successfully',$data);
    }

    public function changeStatus(Request $request)
    {
      try {
        $validator = GenericValidations::changeStatus($request);
        $validator = GenericValidations::validation($request);
        if (!empty($validator)) {
          $errorsArr = $validator->errors()->toArray();
          $errorResponse =  validationResponce($errorsArr);
          return sendResponce(422, $errorResponse, (object) []);
        }

        $input=$request->all();
        $code = $input['code'];
        $status = $input['status'];
        $user = User::where(['code'=>$code])->first();
        if($user==null){
          return sendResponce(400, 'Record Not Found',(object)[]);
        }
        if($status=='active'){
          $changeStatus=1;
        }else{
          $changeStatus=0;
        }
        $user->status=$changeStatus;
        $user->update();
        $response = sendResponce(200, 'Status Changed Successfully',(object)[]);
        return $response;
      } catch (\Illuminate\Database\QueryException $ex) {
       $response = sendResponce(500, $ex->getMessage(),(object)[]);
       return $response;

     }
   }

   public function saveRecord(Request $request){

    $input=$request->all();
    if($input['form_type']=='verfication'){
      $validator = GenericValidations::validation($request);
      if (!empty($validator)) {
        $errorsArr = $validator->errors()->toArray();
        $errorResponse =  validationResponce($errorsArr);
        return sendResponce(422, $errorResponse, (object) []);
      }
      $this->saveVerficationRecord($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }
    if($input['form_type']=='access_data'){
      $validator = GenericValidations::validation($request);
      if (!empty($validator)) {
        $errorsArr = $validator->errors()->toArray();
        $errorResponse =  validationResponce($errorsArr);
        return sendResponce(422, $errorResponse, (object) []);
      }
      $this->saveAccessData($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }

    if($input['form_type']=='escort_authorized_person'){
      $validator = GenericValidations::validation($request);
      if (!empty($validator)) {
        $errorsArr = $validator->errors()->toArray();
        $errorResponse =  validationResponce($errorsArr);
        return sendResponce(422, $errorResponse, (object) []);
      }
      $this->saveEscortPersonData($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }

    if($input['form_type']=='report_person'){
      $validator = GenericValidations::validation($request);
      if (!empty($validator)) {
        $errorsArr = $validator->errors()->toArray();
        $errorResponse =  validationResponce($errorsArr);
        return sendResponce(422, $errorResponse, (object) []);
      }
      $this->saveReportedPerson($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }

    if($input['form_type']=='datacube_biel'){
      $validator = GenericValidations::validation($request);
      if (!empty($validator)) {
        $errorsArr = $validator->errors()->toArray();
        $errorResponse =  validationResponce($errorsArr);
        return sendResponce(422, $errorResponse, (object) []);
      }
      $this->saveDatacubeBiel($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }
    if($input['form_type']=='applicable_document'){
      $this->saveApplicableDocument($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }
    if($input['form_type']=='acc_receipt'){
      $this->saveAcknowledgeReceipt($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }
    if($input['form_type']=='return_confirmation'){
      $this->saveReturnConfirmation($input);
      return sendResponce(200, 'Record Added Successfully',(object)[]);
    }

  }

  public function saveVerficationRecord($input)
  {
    try {
      $verfication=Verfications::where(['user_id'=>$input['user_id']])->first();
      $verfication_c_record=VerficationCriminalRecord::where(['user_id'=>$input['user_id']])->first();
      $verfication_c_register=VerficationCollectionRegister::where(['user_id'=>$input['user_id']])->first();
      if(!$verfication){
       $verfication=new Verfications();
       $verfication_c_record=new VerficationCriminalRecord();
       $verfication_c_register=new VerficationCollectionRegister();
     }
     $verfication->fill($input);
     $verfication->save();
     $verfication_c_record->fill($input);
     $verfication_c_record->save();
     $verfication_c_register->fill($input);
     $verfication_c_register->save();
   }
   catch (\Exception $ex) {
    $response = sendResponce(500, $ex->getMessage(), (object)[]);
    return $response;
  }
}

public function saveAccessData($input)
{
  try {
   $accessdata=AccessData::where(['user_id'=>$input['user_id']])->first();
   $accessdatabuilding=AccessDataBuilding::where(['user_id'=>$input['user_id']])->first();
   if(!$accessdata){
     $accessdata=new AccessData();
     $accessdatabuilding=new AccessDataBuilding();
   }

   $areas = isset($input['areas'])?$input['areas']:[];
   $accessdata->fill($input);
   $accessdata->save();
   $accessdatabuilding->fill($input);
   $accessdatabuilding->save();
   if(!empty($areas)){
    AccessDataArea::where(['user_id'=>$input['user_id']])->delete();
    foreach ($areas as $data) {
      $accessdataarea=new AccessDataArea;
      $accessdataarea->name=$data;
      $accessdataarea->user_id=$input['user_id'];
      $accessdataarea->save();
    }
  }
}
catch (\Exception $ex) {
  $response = sendResponce(500, $ex->getMessage(), (object)[]);
  return $response;
}
}

public function saveEscortPersonData($input)
{
 try {
   $escortData=new EscortAuthorizedPerson();

   if(!$escortData){
    $escortData=EscortAuthorizedPerson::where(['user_id'=>$input['user_id']])
    ->first();
  }
  $escortData->fill($input);
  $escortData->save();
}
catch (\Exception $ex) {
 $response = sendResponce(500, $ex->getMessage(), (object)[]);
 return $response;
}
}

public function saveReportedPerson($input)
{
 try {
   $data=ReportedAuthorizedPerson::where(['user_id'=>$input['user_id']])->first();
   if(!$data){
     $data=new ReportedAuthorizedPerson();
   }
   $data->fill($input);
   $data->save();
 }
 catch (\Exception $ex) {
   $response = sendResponce(500, $ex->getMessage(), (object)[]);
   return $response;
 }
}

public function saveDatacubeBiel($input)
{
 try {
   $audit=AuditByDatacube::where(['user_id'=>$input['user_id']])->first();
   if(!$audit){
     $audit=new AuditByDatacube();
   }
   $audit->fill($input);
   $audit->save();
 }
 catch (\Exception $ex) {
   $response = sendResponce(500, $ex->getMessage(), (object)[]);
   return $response;
 }
}

public function saveApplicableDocument($input)
{
  try {
    $documentdata=new ApplicableDocument();
    $document = isset($input['document'])?$input['document']:[];
    if(!empty($document)){
      ApplicableDocument::where(['user_id'=>$input['user_id']])->delete();
      foreach ($document as $data) {
        $documentdata=new ApplicableDocument;
        $documentdata->user_id=$input['user_id'];
        $documentdata->name=$data;
        $documentdata->save();
      }
    }
  }
  catch (\Exception $ex) {
    $response = sendResponce(500, $ex->getMessage(), (object)[]);
    return $response;
  }
}

public function saveAcknowledgeReceipt($input)
{
 try {
  $acknowledgement=AcknowledgementReceipt::where(['user_id'=>$input['user_id']])
  ->first();

  if(!$acknowledgement){
   $acknowledgement=new AcknowledgementReceipt();
 }
 $acknowledgement->fill($input);
 $acknowledgement->save();
}
catch (\Exception $ex) {
 $response = sendResponce(500, $ex->getMessage(), (object)[]);
 return $response;
}
}

public function saveReturnConfirmation($input)
{
 try {
  $return=ReturnConfirmation::where(['user_id'=>$input['user_id']])
  ->first();
  if(!$return){
   $return=new ReturnConfirmation();
 }
 $return->fill($input);
 $return->save();
}
catch (\Exception $ex) {
 $response = sendResponce(500, $ex->getMessage(), (object)[]);
 return $response;
}
}


}
