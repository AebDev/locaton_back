<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public $loginAfterSignUp = true;

    public function register(Request $request)
    {

        $d = strtotime($request->dateNaissance);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->cin_passport = $request->cin;
        $user->date_naissance = date('Y-m-d',$d);
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->ville = $request->ville;
        $user->pays = $request->pays;
        $user->code_postal = $request->postal;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();


        // return response()->json([

        //     'nom' => $request->nom,
        //     'prenom' => $request->prenom,
        //     'cin_passport' => $request->cin,
        //     'date_naissance' => date('Y-m-d',$d),
        //     'adresse' => $request->adresse,
        //     'telephone' => $request->telephone,
        //     'ville' => $request->ville,
        //     'pays' => $request->pays,
        //     'code_postal' => $request->postal,
        //     'email' => $request->email,
        //     'password' => $request->password,
        //     'role' => $request->role,
        //     // 'user' => $user
        // ]);

        

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }
        
        return response()->json([
            'success' => true,
            'data' => $user
        ], Response::HTTP_OK);

        
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
            'role' => Auth::user()->role,
            'user' => Auth::user()
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAuthUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }



    public function updateAuthUser(Request $request)
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        $user->update($request->all());

        return response()->json(compact('user'));
    }

    
    public function getUsers()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            if ($user->role != 'admin') {
                return response()->json(['you_should_be_admin'], 400);
            }
            
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        
        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function addUsers(Request $request)
    {
        if (JWTAuth::parseToken()->authenticate()->role !== 'admin') {
            return response()->json(['you should be admin'], 400);
        }

        $d = strtotime($request->date_naissance);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->cin_passport = $request->cin_passport;
        $user->date_naissance = date('Y-m-d',$d);
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->ville = $request->ville;
        $user->pays = $request->pays;
        $user->code_postal = $request->code_postal;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ],200);
    }

    public function updateUsers(Request $request, $id)
    {
        if (JWTAuth::parseToken()->authenticate()->role !== 'admin') {
            return response()->json(['you should be admin'], 400);
        }

        $user = User::find($id);


        $user->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $user
        ]);

    }

    public function deleteUsers(Request $request)
    {
        foreach ($request->deleteList as $id) {

            $user = User::find($id);

            if($user !== null){
                $user->delete();
            } 
        }
        
        return response()->json([
            'success' => true,
            'data' => null
        ],'200');
    }

}
