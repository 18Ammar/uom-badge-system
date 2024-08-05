<?php

namespace App\Http\Controllers\superAdmin;

use App\Models\promoteAdmin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromoteAdminController extends Controller
{
   
    protected $promoteAdmin;
    public function __construct(promoteAdmin $promoteAdmin)
    {
        $this->promoteAdmin = $promoteAdmin;         
    }
    public function index()
    {
        $promoteAdmins = $this->promoteAdmin->all();
        return response()->json($promoteAdmins);
      
    }

  
    public function store(Request $request)
    {
        $validatedData = $this->validateResource($request);
        $user = User::where('email','=',$validatedData['university_email'])->first();
        // dd($user);
        if ($request->hasFile('personal_photo')) {
            $filePath = $request->file('personal_photo')->store('public/image');
            $validatedData['personal_photo'] = $filePath;
        }
    
        if ($request->hasFile('authorization_document')) 
        {
            $filePath = $request->file('authorization_document')->store('public/image');
            $validatedData['authorization_document'] = $filePath;
        }
        if($validatedData['employee_type'] == 'admin')
        {
            $user->assignRole('admin');
        }
        else if($validatedData['employee_type'] == 'authorize')
        {
            $user->assignRole('authorize');
        }
        $validatedData['employee_id'] = $user->id;
        $promoteAdmin = $this->promoteAdmin->create($validatedData);
        return response()->json($promoteAdmin, 201);
    }


    public function show(promoteAdmin $promoteAdmin)
    {
        return response()->json($promoteAdmin);
    }

    
    public function update(Request $request, promoteAdmin $promoteAdmin)
    {
        $validatedData=$this->validateResource($request);
        $promoteAdmin->update($validatedData);
        return response()->json($promoteAdmin);
    }

    
    public function destroy(promoteAdmin $promoteAdmin)
    {
        $promoteAdmin->delete();
        return response()->json(null, 204);
    }
    public function validateResource(Request $request)
    {
        return $request->validate([
            'employee_id' => 'integer',
            'name' => 'required|string|max:255',
            'university_email' => 'required|string|email|max:255|unique:promote_admins',
            'college_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'personal_photo' => 'required|image|mimes:jpeg,png,jpg,gif', 
            'authorization_document' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'employee_type' => 'required|in:authorize,admin',
        ]);
    }

}
