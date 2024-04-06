<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Laporan;
use App\Models\Penilaian;
use App\Models\KlausulItem;
use App\Models\Klausul;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:user',
            'password' => 'required',
            'departements_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages());
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'departements_id' => request('departements_id'),
        ]);
        $laporan = Laporan::create([
            'user_id' => $user->id,
            'departements_id' => $user->departements_id,
        ]);
        $klausuls = Klausul::all();
        foreach ($klausuls as $klausul) {
            DB::table('klausuls_laporans')->insert([
                'id' => Str::uuid(),
                'laporan_id' => $laporan->laporan_id,
                'klausul_id' => $klausul->id,
            ]);
        }
            
        $klausulItems = KlausulItem::all();
            // dd($klausulItems);
        foreach ($klausulItems as $klausulItem) {
            Penilaian::create([
                'laporan_id' => $laporan->laporan_id,
                'klausul_item_id' => $klausulItem->id,
             ]);
        }
        if($user){
            return response()->json(['message' => 'Register Berhasil'], 201);
        }else{
            return response()->json(['message' => 'Registrasi Gagal'], 400);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
    
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}