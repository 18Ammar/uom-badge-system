<?php

namespace App\Http\Controllers\client;

use App\Models\userInformation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class UserInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userInformation;
    public function __construct(userInformation $userInformation)
    {
        $this->userInformation = $userInformation;
        
    }
    public function index():JsonResponse
    {
        $data = $this->userInformation->all();
        return response()->json(['data'=>$data],200); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):JsonResponse
    {
        $data = $this->validateRequest($request);
        $data['user_id'] = auth()->user()->id;
        $newReq = $this->userInformation->create($data);
        return response()->json(['data'=>$newReq]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($user_id):JsonResponse
    {   
        $data = $this->userInformation->where('user_id','=',$user_id)->get();
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, userInformation $userInformation)
    {
        $data = $this->validateRequest($request);
        $userInformation->update($data);
        return response()->json($userInformation, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userInformation $userInformation)
    {
        $userInformation->delete();
        return response()->json(['message' => 'User deleted successfully'], 204);
    }

    public function validateRequest(Request $request):array
    {
        return $request->validate([
            'user_id' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'grandfather_name' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'mother_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'address' => 'required|string|max:255',
            'nearest_landmark' => 'required|string|max:255',
            'phone_number' => 'required|integer',
            'driver_phone_number' => 'nullable|integer',
            'college' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'academic_title' => 'nullable|string|max:255',
            'id_type' => 'required|in:civil_id,unified_id',
            'civil_or_unified_number' => 'required|integer',
            'civil_or_unified_date' => 'required|date',
            'record' => 'nullable|integer',
            'page' => 'nullable|integer',
            'registry_office' => 'nullable|integer',
           

        ]);
    }
}
