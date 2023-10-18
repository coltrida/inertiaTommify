<?php

namespace App\Http\Controllers;

use App\Mail\AlbumBuy;
use App\Models\Album;
use App\Models\Order;
use App\Models\Tag;
use App\Services\AlbumService;
use App\Services\ArtistService;
use App\Services\TagService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Srmklive\PayPal\Services\PayPal;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function settings(UserService $userService)
    {
        return Inertia::render('User/Settings', [
            'userConTags' => $userService->userConTags(Auth::id()),
            'fotoEsiste' => \Storage::disk('public')->fileExists('/users/'.Auth::id().'.jpg'),
        ]);
    }

    public function saveImage(Request $request)
    {
          $file = $request->file('image')[0];
          $filename = $request->idUser . '.jpg';
          $file->storeAs('public/users/', $filename);
    }

    public function postSettings(Request $request, UserService $userService)
    {
        $userService->aggiornaUser($request);
    }

    public function myArtists(UserService $userService)
    {
        return Inertia::render('User/MyArtists', [
            'userConMyArtists' => $userService->userConMyArtists(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function allArtists(ArtistService $artistService, TagService $tagService)
    {
        return Inertia::render('User/AllArtists', [
            'allArtists' => $artistService->allArtistsPaginate(),
            'allTags' => $tagService->list(),
            'filters' => \Illuminate\Support\Facades\Request::only('search')
        ]);
    }

    public function followersArtist($idArtist, ArtistService $artistService)
    {
        return Inertia::render('User/FollowersOfArtist', [
          'artistConFollowers' => $artistService->followersOfArtist($idArtist)
        ]);
    }

    public function followersAlbum($idAlbum, AlbumService $albumService)
    {
        return Inertia::render('User/FollowersOfAlbum', [
            'albumConFollowers' => $albumService->followersOfAlbum($idAlbum)
        ]);
    }

    public function followerUser($idArtist, $idUser, UserService $userService)
    {
        return Inertia::render('User/InfoUser', [
          'userConAlbumArtist' => $userService->userConAlbumArtist($idUser, $idArtist)
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

    public function paypal(Request $request)
    {
     //   dd($request->album);
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
                    'reference_id' => $request->album['id'],
                    'amount' => [
                        "currency_code" => "EUR",
                        "value" => $request->album['price']
                    ],
                    "payee" => [
                        "email_address" => $request->album['artist']['emailPaypal']
                    ]
                ]
            ],
        ]);

        if (isset($response['id']) && $response['id']!=null){
            foreach ($response['links'] as $link){
                if ($link['rel'] === 'approve') {
                    return Inertia::location($link['href']);
                }
            }
        } else {
            return to_route('user.paypal.cancel');
        }
    }

    public function successPaypal(Request $request, AlbumService $albumService)
    {
        //dd($request);
        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

     //   dd($response);

        if (isset($response['status']) && $response['status'] == 'COMPLETED'){
            $album = Album::find($response['purchase_units'][0]['reference_id'])->toArray();
            $albumService->buyAlbum($album);
            Mail::to('coltrida@gmail.com')->queue(new AlbumBuy($album));
            return to_route('user.albumsOfArtist', $album['artist_id']);
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
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY_TEST'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $request->album['name'].' album',
                        ],
                        'unit_amount' => 2000,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            /*'success_url' => 'http://localhost:4242/success',
            'cancel_url' => 'http://localhost:4242/cancel',*/
            'customer_email' => Auth::user()->email,
            'success_url' => route('user.buyAlbum.success', [], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('user.buyAlbum.cancel', [], true),
        ]);

        $order = new Order();
        $order->status = 'unpaid';
        $order->total = 2000;
        $order->user_id = Auth::id();
        $order->artist_id = $request->album['artist_id'];
        $order->stripe_session_id = $checkout_session->id;
        $order->save();

        return Inertia::location($checkout_session->url);


/*        $albumService->buyAlbum($request);
        Mail::to('coltrida@gmail.com')->queue(new AlbumBuy($request->album));*/
    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY_TEST'));

        $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
        //dd($session);
        if (!$session){
            throw new NotFoundHttpException;
        }

        $artist = Order::with(['artist' => function($a){
            $a->with('user');
        }])
            ->where('stripe_session_id', $_GET['session_id'])
            ->first()
            ->artist;

        $stripe->customers->create([
            'description' => 'My First Test Customer (created for API docs at https://www.stripe.com/docs/api)',
        ]);





        $customer = $session->customer_details;

        return Inertia::render('User/PaymentSuccess', [
            'customer' => $customer
        ]);
    }

    public function cancel()
    {
        return to_route('user.home');
    }
}
