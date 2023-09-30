<?php

namespace App\Http\Controllers;

use App\Mail\AlbumBuy;
use App\Services\AlbumService;
use App\Services\ArtistService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Srmklive\PayPal\Services\PayPal;

class UserController extends Controller
{
    public function home(UserService $userService)
    {
        return Inertia::render('User/Home', [
            'myArtistsPaginate' => $userService->myArtistsPaginate(),
            'myAlbumsPaginate' => $userService->myAlbumsPaginate(),
            'myLastAlbumsListen' => $userService->myLastAlbumsListen(),
            'filters' => \Illuminate\Support\Facades\Request::only(['searchArtist', 'searchAlbum'])
        ]);
    }

    public function settings()
    {
        return Inertia::render('User/Settings');
    }

    public function myArtists(UserService $userService)
    {
        return Inertia::render('User/MyArtists', [
            'userConMyArtists' => $userService->userConMyArtists(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function allArtists(ArtistService $artistService)
    {
        return Inertia::render('User/AllArtists', [
            'allArtists' => $artistService->allArtistsPaginate(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function albumsOfArtist($idArtist, ArtistService $artistService)
    {
        return Inertia::render('User/AlbumsOfArtist', [
            'artistConAlbums' => $artistService->artistConAlbums($idArtist)
        ]);
    }

    public function songsOfAlbum($idAlbum, AlbumService $albumService)
    {
        $albumConSongs = $albumService->albumConSongs($idAlbum);
        $albumComprato = $albumConSongs->userSales->contains('id', Auth::id());

        return Inertia::render('User/SongsOfAlbum', [
            'albumConSongs' => $albumConSongs,
            'albumComprato' => $albumComprato
        ]);
    }

    public function readNews(UserService $userService)
    {
        $userService->segnaLettoNotizie(Auth::id());
    }

    public function paypal()
    {
        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('user.paypal.success'),
                "cancel_url" => route('user.paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    'amount' => [
                        "currency_code" => "USD",
                        "value" => "100.00"
                    ]
                ]
            ]
        ]);

     //   dd($response);

        if (isset($response['id']) && $response['id']!=null){
            foreach ($response['links'] as $link){
                if ($link['rel'] === 'approve') {
                    return Inertia::location($link['href']);
        //            return redirect()->away($link['href']);
//                    return Http::get($link['href']);
                }
            }
        } else {
            return to_route('user.paypal.cancel');
 //           return redirect()->route('user.paypal.cancel');
        }
    }

    public function successPaypal(Request $request)
    {
        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

       // dd($response);

        if (isset($response['status']) && $response['status'] == 'COMPLETED'){
            return "Payment is successful";
        } else {
            return to_route('user.paypal.cancel');
        }
    }

    public function cancelPaypal()
    {
        return "Payment is Cancelled";
    }

    public function playMyAlbum(Request $request, AlbumService $albumService)
    {
        $albumService->aggiornaAscoltaAlbum($request);
    }

    public function buyAlbum(Request $request, AlbumService $albumService)
    {
        $albumService->buyAlbum($request);
        Mail::to('coltrida@gmail.com')->queue(new AlbumBuy($request->album));
    }
}
