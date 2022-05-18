<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class GenericValidations
{

    public static function validation($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'exists:users,id',
            ],
            [
                'user_id.exists' => 'Invalid User Id',
            ]
        );
        if ($validator->fails()) {
            return $validator;
        }
    }

     public static function changeStatus($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
        ],
        [
            'id.required' => 'User Id is required!',
            'status.required' => 'Status is required!',
        ]);
        if ($validator->fails()) {
            return $validator;
        }
    }
    public static function accessData($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'access_id' => 'exists:access_data,id',
            ],
            [
                'access_id.exists' => 'Invalid Access Id',
            ]
        );
        if ($validator->fails()) {
            return $validator;
        }
    }

    public static function escortPerson($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'escort_id' => 'exists:escort_authorized_people,id',
            ],
            [
                'escort_id.exists' => 'Invalid Escort Person Id',
            ]
        );
        if ($validator->fails()) {
            return $validator;
        }
    }
    public static function ReportedPerson($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'auth_person_id' => 'exists:reported_authorized_people,id',
            ],
            [
                'auth_person_id.exists' => 'Invalid Auth Person Id',
            ]
        );
        if ($validator->fails()) {
            return $validator;
        }
    }
    public static function DatacubeBiel($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'datacube_id' => 'exists:audit_by_datacubes,id',
            ],
            [
                'datacube_id.exists' => 'Invalid Datacubes Id',
            ]
        );
        if ($validator->fails()) {
            return $validator;
        }
    }
}