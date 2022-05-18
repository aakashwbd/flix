<?php

    namespace App\Http\Controllers;

    use App\Services\SocialTwitterAccountService;
    use Illuminate\Http\Request;
    use Laravel\Socialite\Facades\Socialite;
    use Hash;
    use App\Models\User;

    class SocialAuthTwitterController extends Controller
    {
        /**
         * Create a redirect method to twitter api.
         *
         * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
         */
        public function redirect()
        {
            return Socialite::driver('twitter')->redirect();
        }

        /**
         * Return a callback method from twitter api.
         *
         * @return \Illuminate\Http\RedirectResponse URL from twitter
         */
        public function callback()
        {
            if(request()->exists('denied') || request()->exists('error')){
                return redirect('/');
            }else{
                $getUserData = Socialite::driver('twitter')->user();

                $user = User::where('provider_id', $getUserData->id)->where('provider', 'twitter')->first();
                $accessToken = null;
                $twitterUser = null;


                if($user){
                    $accessToken = $user->createToken('accessToken')->plainTextToken;
                }else{
                    $user = User::create([
                                             'user_role_id' => 3,
                                             'username' => $getUserData->name,
                                             'image' => $getUserData->avatar,
                                             'provider_id'=> $getUserData->id,
                                             'provider'=> 'twitter',
                                             'password'=> Hash::make('password')
                                         ]);

                    $accessToken = $user->createToken('accessToken')->plainTextToken;
                }

                return redirect('/')->with([
                                               'token' => 'Bearer '. $accessToken,
                                               'user' => $user
                                           ]);
            }


        }
    }
