<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\client\CarInformationController;
use App\Http\Controllers\client\UserImageController;
use App\Mail\rejectMessage;
use App\Models\requestStatus;
use App\Models\userInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RequestStatusController extends Controller
{
    protected $status,$userImage,$carInfo,$userId;
    public function __construct(requestStatus $status,UserImageController $userImage,CarInformationController $carInfo)
    {
        $this->status = $status;
        $this->userImage = $userImage;
        $this->carInfo = $carInfo;
    }
    /**
     * Display a listing of the resource.
     */
    public function requests($name)
    {
        
        $userId = $this->getUserIdByName($name);
        if($userId == null) return response()->json(['error'=>'User not found'],404);
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
        $data = $this->status->all();
        return response()->json($data,200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$name)
    {
        $data = $this->validateRequest($request);
        
        $data['user_id'] = $this->getUserIdByName($name);
        $req = $this->status->create($data);
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
    public function getUserIdByName($name)
    {
        Db::enableQueryLog();
        $users = User::where('name', $name)->first();
        if($users==null){
            return null;            
        }
        else{
            return $users->id;
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
