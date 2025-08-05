<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    //
    public function createclass (Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string|min:128',
            'department' => 'string|max:50'
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Class Registration Failed'
            ], 400);
        }

        try {
            $section = new Section;
            $section->title = $request->input('title');
            $section->description = $request->input('description');
            $section->department = $request->input('department');
            
            return response()->json([
                'section' => $section,
                'message' => 'Section created successfully',
            ],201);

        } catch (\Exception $error) {
            return response()->json([
                'message' => 'Error occurred, contact softwate admin',
                'errors' => $error->getMessage(),
            ], 500);
        }  
    }
}
