<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Tag;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'tags' => Tag::orderBy('name')->get()
        ]);
    }

    public function createArtist(): Response
    {
        return Inertia::render('Auth/RegisterArtist', [
            'tags' => Tag::orderBy('name')->get()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($request->role === 'user'){
            $user->tags()->sync($request->tags);
        }elseif ($request->role === 'artist'){

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY_TEST'));
            $stripeAccount = $stripe->accounts->create([
                'type' => 'custom',
                'country' => 'IT',
                'email' => $request->email,
                'business_type' => 'individual',
                'business_profile' => [
                    'url' => 'https://www.coltricat.it',
                    "product_description" => "WEB APP",
                    "mcc" => "5817",
                ],
                'individual' => [
                    'email' => $request->email,
                    'first_name' => 'pino',
                    'last_name' => 'pino',
                    'phone' => "+393920222125",
                    'address' => [
                        'city' => 'Florence',
                        'country' => 'IT',
                        'line1' => 'via Tevere 29',
                        'postal_code' => 52028,
                        'state' => 'Italy',
                    ],
                    'dob' => [
                        'day' => 22,
                        'month' => 9,
                        'year' => 1975,
                    ],
                ],
                /*'external_account' => [
                    'object' => 'card',
                    'number' => '4242424242424242',
                    'currency' => 'eur',
                    'exp_month' => 2,
                    'exp_year' => 2024,
                    "brand" => "Visa",
                    "funding" => "debit",
                    "cvc_check" => "pass",
                    "last4" => "4242",
                    "cvc" => "123",
                ],*/
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            $stripe->accounts->update(
                $stripeAccount->id,
                [
                    'tos_acceptance' => [
                        'date' => 1609798905,
                        'ip' => '8.8.8.8',
                    ],
                ]
            );

            Artist::create([
                'user_id' => $user->id,
                'tag_id' => $request->tag,
                'stripe_id' => $stripeAccount->id,
            ]);
        }


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
