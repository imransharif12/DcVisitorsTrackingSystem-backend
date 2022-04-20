<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Verfications,VerficationCollectionRegister,
    VerficationCriminalRecord,AccessData,AccessDataArea,
    AccessDataBuilding,EscortAuthorizedPerso,ReportedAuthorizedPerson,AuditByDatacube,ApplicableDocument};
use App\Validations\GenericValidations;

class TabController extends Controller
{
   
   public function saveRecord(Request $request){

        $input=$request->all();
        if($input['form_type']=='verfication'){
            $validator = GenericValidations::verfication($request);
                if (!empty($validator)) {
                    $errorsArr = $validator->errors()->toArray();
                    $errorResponse =  validationResponce($errorsArr);
                    return sendResponce(422, $errorResponse, (object) []);
                }
            $this->saveVerficationRecord($input);
            return sendResponce(200, 'Record Added Successfully',(object)[]);
        }
        if($input['form_type']=='access_data'){
            $validator = GenericValidations::accessData($request);
                if (!empty($validator)) {
                    $errorsArr = $validator->errors()->toArray();
                    $errorResponse =  validationResponce($errorsArr);
                    return sendResponce(422, $errorResponse, (object) []);
                }
            $this->saveAccessData($input);
            return sendResponce(200, 'Record Added Successfully',(object)[]);
        }

        if($input['form_type']=='escort_authorized_person'){
            $validator = GenericValidations::escortPerson($request);
                if (!empty($validator)) {
                    $errorsArr = $validator->errors()->toArray();
                    $errorResponse =  validationResponce($errorsArr);
                    return sendResponce(422, $errorResponse, (object) []);
                }
            $this->saveEscortPersonData($input);
            return sendResponce(200, 'Record Added Successfully',(object)[]);
        }

        if($input['form_type']=='datacube_biel'){
            $validator = GenericValidations::DatacubeBiel($request);
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

   }

   public function saveVerficationRecord($input)
   {
        try {
        $verfication=new Verfications();
        $verfication_c_record=new VerficationCriminalRecord();
        $verfication_c_register=new VerficationCollectionRegister();
        if(isset($input['verification_id']) && !empty($input['verification_id'])){
            $verfication=Verfications::where(['id'=>$input['verification_id']])->first();
            $verfication_c_record=VerficationCriminalRecord::where(['verfication_id'=>$input['verification_id']])->first();
            $verfication_c_register=VerficationCollectionRegister::where(['verfication_id'=>$input['verification_id']])->first();
        }
        $verfication->fill($input);
        $verfication->save();
        $verfication_c_record->fill($input);
        $verfication_c_record->verfication_id=$verfication->id;
        $verfication_c_record->save();
        $verfication_c_register->fill($input);
        $verfication_c_register->verfication_id=$verfication->id;
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
        $accessdata=new AccessData();
        $accessdataarea=new AccessDataArea();
        $accessdatabuilding=new AccessDataBuilding();
		$areas = isset($input['areas'])?explode(",",$input['areas']):[];
        if(isset($input['access_id']) && !empty($input['access_id'])){
            $accessdata=AccessData::where(['id'=>$input['access_id']])->first();
            $accessdataarea=AccessDataArea::where(['access_id'=>$input['access_id']])->first();
            $accessdatabuilding=AccessDataBuilding::where(['access_id'=>$input['access_id']])->first();
        }
        $accessdata->fill($input);
        $accessdata->save();
        $accessdatabuilding->fill($input);
        $accessdatabuilding->access_id=$accessdata->id;
        $accessdatabuilding->save();
        if(!empty($areas)){
            AccessDataArea::where(['access_id'=>$accessdata->id])->delete();
            foreach ($areas as $data) {
                $accessdataarea=new AccessDataArea;
                $accessdataarea->name=$data;
                $accessdataarea->access_id=$accessdata->id;
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
         if(isset($input['escort_id']) && !empty($input['escort_id'])){
             $escortData=EscortAuthorizedPerson::where(['id'=>$input['escort_id']])->first();
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
         $data=new ReportedAuthorizedPerson();
         if(isset($input['auth_person_id']) && !empty($input['auth_person_id'])){
             $data=ReportedAuthorizedPerson::where(['id'=>$input['auth_person_id']])->first();
         }
         $data->user_id=$input['user_id']?$input['user_id']:"";
         $data->f_name=$input['auth_person_f_name']?$input['auth_person_f_name']:"";
         $data->l_name=$input['auth_person_l_name']?$input['auth_person_l_name']:"";
         $data->badge_number=$input['auth_person_badge_number']?$input['auth_person_badge_number']:"";
         $data->signature_date=$input['auth_person_signature_date']?$input['auth_person_signature_date']:"0000-00-00";
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
         $data=new AuditByDatacube();
         if(isset($input['datacube_id']) && !empty($input['datacube_id'])){
             $data=AuditByDatacube::where(['id'=>$input['datacube_id']])->first();
         }
         $data->user_id=$input['user_id']?$input['user_id']:"";
         $data->f_name=$input['datacube_f_name']?$input['datacube_f_name']:"";
         $data->l_name=$input['datacube_l_name']?$input['datacube_l_name']:"";
         $data->auditor_signature=$input['datacube_auditor_signature']?$input['datacube_auditor_signature']:"";
         $data->signature_date=$input['datacube_signature_date']?$input['datacube_signature_date']:"0000-00-00";
         $data->save();
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
		$document = isset($input['document'])?explode(",",$input['document']):[];
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

    
}
