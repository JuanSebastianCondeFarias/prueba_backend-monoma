<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Candidate;
use App\Events\UserLoggedIn;

class MonomaApiController extends Controller
{

    public function auth(Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');
        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                "meta" => [
                    "success" => false,
                    "errors" => ["Password incorrect for: ".$request->username]
                ],  
            ]);
        }
        $user = Auth::user();
        event(new UserLoggedIn($user));
        $expiration = Carbon::now()->addMinutes(config('jwt.ttl'));
        return response()->json([
            "meta" => [
                "success" => true,
                "errors" => []
            ],  
            "data" => [
                "token" => $token,
                "minute_to_expire" => $expiration 
            ]
        ]);
    }
    
    public function createCandidate(Request $request){
        $candidate = new Candidate();

        $candidate->name = $request->name;
        $candidate->source = $request->source;
        $candidate->owner = $request->owner;
        $candidate->created_by = Auth::user()->id;
        $candidate->save();

        $response = [
            "meta" => [
                "success" => true,
                "errors" => []
            ],
            "data" => $candidate            
        ];

        return response()->json($response, 200);
    } 
    public function getCandidateById($id){
        $candidate = Candidate::find($id);

        $response = [
            "meta" => [
                "success" => true,
                "errors" => []
            ],
            "data" => $candidate            
        ];

        return response()->json($response, 200);
    } 
    public function getAllCandidates(){
        $candidate = Candidate::all();

        $response = [
            "meta" => [
                "success" => true,
                "errors" => []
            ],
            "data" => $candidate            
        ];

        return response()->json($response, 200);
    } 

}
