<?php

namespace App\Http\Controllers\authorized;

use App\Http\Controllers\client\CarInformationController;
use App\Http\Controllers\client\UserImageController;
use App\Mail\rejectMessage;
use App\Models\authorized;
use App\Models\userInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AuthorizedController extends Controller
{
    protected $badgeStatus,$userImage,$carInfo,$userId;
    public function __construct(authorized $badgeStatus,UserImageController $userImage,CarInformationController $carInfo)
    {
        $this->badgeStatus = $badgeStatus;
        $this->userImage = $userImage;
        $this->carInfo = $carInfo;
    }
    /**
     * Display a listing of the resource.
     */
    public function requests($name)
    {
        
        $userId = $this->getUserIdByName($name);
    
        $data = DB::table('user_information')
            ->join('users', 'user_information.user_id', '=', 'users.id')
            ->select(
                'user_information.*', 
                'users.name', 
                'users.email' 
            )
            ->get();

        $requestNumber = DB::table('user_information')->count();
        
        
        return response()->json([
            'data' => $data,
            'user image'=>$this->userImage->show($userId),
            'car information'=>$this->carInfo->index($userId),
            'number_of_requests' => $requestNumber
        ], 200);
    }

    public function index()
    {
        $data = DB::table('user_information')
            ->join('users', 'user_information.user_id', '=', 'users.id')
            ->select(
                'user_information.*', 
                'users.name', 
                'users.email' 
            )
            ->get();

        $requestNumber = DB::table('user_information')->count();
        
        
        return response()->json([
            'data' => $data,
            'user image'=>$this->userImage->index(),
            'car information'=>$this->carInfo->index(),
            'number_of_requests' => $requestNumber
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request); 
        $name = $request->user()->name;       
        $data['user_id'] = $this->getUserIdByName($name);
        $req = $this->badgeStatus->create($data);
        return response()->json(['data'=>$req],200);

    }

    public function validateRequest(Request $request)
    {
        return $request->validate([
            'user_id' =>'integer',
            'status'=>'required|in:reject,accept',
            'message' =>'nullable|text',
        ]);

    }
    public function getUserIdByName($name){
        $users = User::where('name', '=', $name)->get();
        if($users->isEmpty()){
            return response()->json([
                'status' => 'error',
                'message' => 'No user found'
             ], 404);
            
        }else{
            return $users[0]->id;
        }
    }
    public function sendMail(Request $request) 
    {
        $this->validateEmail($request);

        $details=[
            'recipientName'=>$request->name,
            'email'=>$request->email,
            'body'=>$request->bodymessage,
        ];
                    
        Mail::to($details['email'])->send(new rejectMessage($details));
    
        return response()->json(['You have successfully sent an email to the client!'], 200);
    }
    public function validateEmail(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'bodymessage' => 'required']
            );

    }
}
