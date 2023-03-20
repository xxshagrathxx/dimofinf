<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Auth;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
      
            $user = Socialite::driver('google')->stateless()->user();
       
            $finduser = User::where('google_id', $user->id)->first();
       
            if($finduser){
                Auth::login($finduser);
      
                return redirect()->route('home');
       
            }else{
                $emailExists = User::where('email', $user->email)->first();
                if($emailExists) {
                    $emailExists->update([
                        'google_id' => $user->id,
                    ]);

                    Auth::login($emailExists);
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'email_verified_at' => now(),
                        'password' => Hash::make('123456dummy'),
                    ]);

                    Auth::login($newUser);
                }
      
                return redirect()->route('home');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
      
            $user = Socialite::driver('facebook')->stateless()->user();
       
            $finduser = User::where('facebook_id', $user->id)->first();
       
            if($finduser){
                Auth::login($finduser);
      
                return redirect()->route('home');
       
            }else{
                $emailExists = User::where('email', $user->email)->first();
                if($emailExists) {
                    $emailExists->update([
                        'facebook_id' => $user->id,
                    ]);

                    Auth::login($emailExists);
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'facebook_id' => $user->id,
                        'email_verified_at' => now(),
                        'password' => Hash::make('123456dummy'),
                    ]);

                    Auth::login($newUser);
                }
      
                return redirect()->route('home');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleLinkedinCallback()
    {
        try {
      
            $user = Socialite::driver('linkedin')->stateless()->user();
       
            $finduser = User::where('linkedin_id', $user->id)->first();
       
            if($finduser){
                Auth::login($finduser);
      
                return redirect()->route('home');
       
            }else{
                $emailExists = User::where('email', $user->email)->first();
                if($emailExists) {
                    $emailExists->update([
                        'linkedin_id' => $user->id,
                    ]);

                    Auth::login($emailExists);
                } else {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'linkedin_id' => $user->id,
                        'email_verified_at' => now(),
                        'password' => Hash::make('123456dummy'),
                    ]);

                    Auth::login($newUser);
                }
      
                return redirect()->route('home');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
