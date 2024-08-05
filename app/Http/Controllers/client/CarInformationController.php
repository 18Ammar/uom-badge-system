<?php
namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\carInformation;

class CarInformationController extends Controller
{
    protected $carInformation;

    public function __construct(CarInformation $carInfo)
    {
        $this->carInformation = $carInfo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = $this->carInformation->all()->map(function ($carInfo) {
            // Convert image paths to URLs
            $carInfo->agency_1 = $this->getImageUrl($carInfo->agency_1);
            $carInfo->agency_2 = $this->getImageUrl($carInfo->agency_2);
            $carInfo->driving_license_face = $this->getImageUrl($carInfo->driving_license_face);
            $carInfo->driving_license_back = $this->getImageUrl($carInfo->driving_license_back);
            $carInfo->car_registration_face = $this->getImageUrl($carInfo->car_registration_face);
            $carInfo->car_registration_back = $this->getImageUrl($carInfo->car_registration_back);

            return $carInfo;
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
        $data = array_merge(
            $request->only([
                'car_number',
                'ownership',
                'car_type',
                'car_color',
                'car_model',
                'agency_1',
                'agency_2',
                'driving_license_face',
                'driving_license_back',
                'car_registration_face',
                'car_registration_back',
            ]),
            ['user_id' => auth()->user()->id],
            $path
        );

        $this->carInformation->create($data);

        return response()->json(['message' => 'Car information added successfully.'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($user_id): JsonResponse
    {
        $carInformation = $this->carInformation->where('user_id','=', $user_id)->get();
        $carInformation->agency_1 = $this->getImageUrl($carInformation->agency_1);
        $carInformation->agency_2 = $this->getImageUrl($carInformation->agency_2);
        $carInformation->driving_license_face = $this->getImageUrl($carInformation->driving_license_face);
        $carInformation->driving_license_back = $this->getImageUrl($carInformation->driving_license_back);
        $carInformation->car_registration_face = $this->getImageUrl($carInformation->car_registration_face);
        $carInformation->car_registration_back = $this->getImageUrl($carInformation->car_registration_back);

        return response()->json(['data' => $carInformation], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarInformation $carInformation): JsonResponse
    {
        $this->validateRequest($request);
        $path = $this->storeImage($request);

        $carInformation->update(array_merge(
            $request->only([
                'car_number',
                'ownership',
                'car_type',
                'car_color',
                'car_model',
            ]),
            $path
        ));

        return response()->json(['message' => 'Car information updated successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarInformation $carInformation): JsonResponse
    {
        $carInformation->delete();
        return response()->json(['message' => 'Car information deleted successfully.'], 204);
    }

    /**
     * Validate the request data.
     */
    private function validateRequest(Request $request): void
    {
        $request->validate([
            'car_number' => 'required|integer',
            'ownership' => 'required|string',
            'car_type' => 'required|string',
            'car_color' => 'required|string',
            'car_model' => 'required|integer',
            'agency_1' => 'required|image|mimes:jpeg,png,jpg,gif',
            'agency_2' => 'required|image|mimes:jpeg,png,jpg,gif',
            'driving_license_face' => 'required|image|mimes:jpeg,png,jpg,gif',
            'driving_license_back' => 'required|image|mimes:jpeg,png,jpg,gif',
            'car_registration_face' => 'required|image|mimes:jpeg,png,jpg,gif',
            'car_registration_back' => 'required|image|mimes:jpeg,png,jpg,gif',
            'user_id' => 'string'
        ]);
    }

    /**
     * Store the uploaded images.
     */
    private function storeImage(Request $request): array
    {
        $imageFields = [
            'agency_1', 'agency_2', 'driving_license_face',
            'driving_license_back', 'car_registration_face',
            'car_registration_back'
        ];
        $path = [];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $path[$field] = $request->file($field)->store('public/images');
            }
        }

        return $path;
    }

    /**
     * Get the URL for a given image path.
     */
    private function getImageUrl($path)
    {
        return $path ? Storage::url($path) : null;
    }
}
