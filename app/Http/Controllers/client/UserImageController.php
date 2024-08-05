<?php

namespace App\Http\Controllers\client;
use App\Models\userImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserImageController extends Controller
{
    protected $userImage;
    public function __construct(UserImage $userImage)
    {  
       $this->userImage = $userImage;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = $this->userImage->all()->map(function ($image) {
            $image->driver_photo = $this->getImageUrl($image->driver_photo);
            $image->applicant_photo = $this->getImageUrl($image->applicant_photo);
            $image->civil_or_unified_id_front = $this->getImageUrl($image->civil_or_unified_id_front);
            $image->civil_or_unified_id_back = $this->getImageUrl($image->civil_or_unified_id_back);
            $image->iraqi_nationality = $this->getImageUrl($image->iraqi_nationality);
            $image->ration_card = $this->getImageUrl($image->ration_card);
            $image->green_card_front = $this->getImageUrl($image->green_card_front);
            $image->green_card_back = $this->getImageUrl($image->green_card_back);
            $image->residence_certification = $this->getImageUrl($image->residence_certification);
            $image->continuous_service_letter = $this->getImageUrl($image->continuous_service_letter);
            $image->university_id_front = $this->getImageUrl($image->university_id_front);
            $image->university_id_back = $this->getImageUrl($image->university_id_back);

            return $image;
        });

        return response()->json(['data' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $path = $this->storeImage($request); 
        $path['user_id'] = auth()->user()->id;
        $userImage = $this->userImage->create($path);

        $storedImageUrls = [];
        foreach ($path as $key => $value) {
            $storedImageUrls[$key] = $this->getImageUrl($value);
        }

        return response()->json(['success' => 'Images uploaded successfully', 'urls' => $storedImageUrls]);
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $data = $this->userImage->where('user_id','=',$user_id)->get()->map(function ($image) {
            $image->driver_photo = $this->getImageUrl($image->driver_photo);
            $image->applicant_photo = $this->getImageUrl($image->applicant_photo);
            $image->civil_or_unified_id_front = $this->getImageUrl($image->civil_or_unified_id_front);
            $image->civil_or_unified_id_back = $this->getImageUrl($image->civil_or_unified_id_back);
            $image->iraqi_nationality = $this->getImageUrl($image->iraqi_nationality);
            $image->ration_card = $this->getImageUrl($image->ration_card);
            $image->green_card_front = $this->getImageUrl($image->green_card_front);
            $image->green_card_back = $this->getImageUrl($image->green_card_back);
            $image->residence_certification = $this->getImageUrl($image->residence_certification);
            $image->continuous_service_letter = $this->getImageUrl($image->continuous_service_letter);
            $image->university_id_front = $this->getImageUrl($image->university_id_front);
            $image->university_id_back = $this->getImageUrl($image->university_id_back);

            return $image;
        });

        return response()->json(['data' => $data], 200);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, userImage $userImage):JsonResponse
    {
        // updating images in the database
        $this->validateRequest($request);
        $path = $this->storeImage($request);
        $userImage->update($path);
        return response()->json(['message' => 'Car information updated successfully.'], 200);

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(userImage $userImage)
    {
        $userImage->delete();
        return response()->json(['message' => 'Image deleted successfully.'], 200);
    }
    public function validateRequest(Request $request):void
    {
        $request->validate(
            [
                'driver_photo' => 'required|image|mimes:jpeg,png,jpg,gif',
                'applicant_photo' => 'required|image|mimes:jpeg,png,jpg,gif', 
                'civil_or_unified_id_front' => 'required|image|mimes:jpeg,png,jpg,gif', 
                'civil_or_unified_id_back' => 'required|image|mimes:jpeg,png,jpg,gif',
                'iraqi_nationality' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'ration_card' => 'required|image|mimes:jpeg,png,jpg,gif',
                'green_card_front' => 'required|image|mimes:jpeg,png,jpg,gif',
                'green_card_back' => 'required|image|mimes:jpeg,png,jpg,gif',
                'residence_certification' => 'required|image|mimes:jpeg,png,jpg,gif',
                'continuous_service_letter' => 'required|image|mimes:jpeg,png,jpg,gif',
                'university_id_front' => 'required|image|mimes:jpeg,png,jpg,gif',
                'university_id_back' => 'required|image|mimes:jpeg,png,jpg,gif',
                'user_id'=>'string'
            ]);
    }
    public function storeImage(Request $request):array
    {
        $images = [
        'driver_photo', 
        'applicant_photo', 
        'civil_or_unified_id_front', 
        'civil_or_unified_id_back',
        'iraqi_nationality',
        'ration_card',
        'green_card_front',
        'green_card_back',
        'residence_certification',
        'continuous_service_letter',
        'university_id_front',
        'university_id_back'];
        $path = [];
        foreach($images as $image){
            if($request->hasFile($image)){
                $path[$image] = $request->file($image)->store('public/image');
                
            }
        }
        return $path;

    }
    public function getImageUrl($path)
    {
        return $path ? Storage::url($path) : null;
    }
}
