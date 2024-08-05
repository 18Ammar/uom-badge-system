<?php

namespace App\Http\Controllers\superAdmin;

use App\Models\superAdmin;
use App\Http\Controllers\Controller;
use App\Models\authorized;
use App\Models\badgeStatus;
use App\Models\requestStatus;

class SuperAdminController extends Controller
{
   public function receivedBadge()
   {  
      $data = badgeStatus::where('status','=','received')->get();
      return response()->json(['the received Badge' => $data], 200);
   }
   
   public function unReceivedBadge()
   {  
      $data = badgeStatus::where('status','=','unreceived')->get();
      return response()->json(['the unreceived Badge' => $data], 200);
   }
   public function waitToPrinting()
   {
      $data = requestStatus::where('status', '=','accept')->get();
      return response()->json(['the badge waiting to print' => $data], 200);
   }
   public function certifiedFromAuthorizer()
   {
      $data = authorized::where('status', '=', 'accept')->with('user')->get();
      $numberOfCertified = authorized::where('status', '=', 'accept')->count();
      
      $users = [];
      foreach ($data as $data) {
         if ($data->user) {
               $users[] = $data->user;
         }
      }
      return response()->json([
         'the certified badge from authorizer' => $users,
         'number of certified request' => $numberOfCertified
      ], 200);
   }

   public function rejected()
   {
      $rejectedByAuthorizer = authorized::where('status','=','reject')->get();
      $rejectedByAdmin = requestStatus::where('status','=','reject')->get();
      return response()->json(['rejected by authorizer' => $rejectedByAuthorizer, 
                               'rejected by admin' => $rejectedByAdmin]);
   }
   
   
}
