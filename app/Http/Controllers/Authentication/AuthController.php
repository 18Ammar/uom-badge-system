<?php

namespace App\Http\Controllers\Authentication;

use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    protected $user;

    public function checkRole()
    {
        $user = Auth::user();
        if ($user) {
            $role = $user->getRoleNames()->first();
            return response()->json(['role' => $role]);
        }

        return response()->json(['error' => 'User not authenticated'], 401);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function Csrf_token()
    {
        return csrf_token();
    }
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index():JsonResponse
    {
        $data = $this->user->all();
        return response()->json($data);
    }
    public function show($id):JsonResponse
    {
        $data = $this->user->findOrFail($id);
        return response()->json($data);
    }
    public function destroy($id):JsonResponse
    {
        $data = $this->user->findOrFail($id);
        $data->delete();
        return response()->json([
           'status' => 'deleted',
           'message' => 'User deleted successfully'
        ]);
    }
    public function searchByName($name):JsonResponse
    {
        // dd($name);
        $data = $this->user->where('name', 'like', '%'.$name.'%')->get();
        if($data->isEmpty()){
            return response()->json([
                'status' => 'error',
                'message' => 'No user found'
             ], 404);
            
        }
        else{
            return response()->json([
                'data'=>$data,'status' => 'success'],200);
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            if (!$user || !$user->email) {
                throw new Exception("Unable to retrieve user information from Google.");
            }

            $findUser = User::where('email', $user->email)->first();

            if ($findUser) {
                $token = $findUser->createToken('api token')->plainTextToken;
                $findUser->assignRole('client');
                Auth::login($findUser);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User logged in successfully',
                    'user' => $findUser,
                    'token' => $token
                ]);
            } else {
                $newUser = User::create([
                    'name' => $user->name ?? 'Unnamed User', // Default value if name is missing
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt($user->id)
                ]);

                $token = $newUser->createToken('api')->plainTextToken;
                $newUser->assignRole('client');
                Auth::login($newUser);

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
    public function register(Request $request)
    {
        try
        {
            $validated = Validator::make($request->all(),[
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8',
                ]);
            if($validated->fails())
            {
                return response()->json(array('errors' => $validated->errors()));
            }
            else
            {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $user->assignRole('client');

            }

            $token = $user->createToken('api')->plainTextToken;
            $user->assignRole('client');

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
        catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        
        try
        {
            $validated = Validator::make($request->all(),[
                    'email' => 'required|string|email',
                    'password' => 'required|string|min:8',
                ]);
        
            if($validated->fails())
            {
                return response()->json(array('errors' => $validated->errors()));
            }

        if (!Auth::attempt($request->only('email', 'password'))) 
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $this->user->where('email', $request->only('email'))->first();
        $token = $user->createToken('api')->plainTextToken;
        $user->assignRole('client');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }catch (Exception $e) {
    }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
