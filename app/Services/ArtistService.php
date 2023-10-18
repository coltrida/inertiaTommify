<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Artist;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ArtistService
{
    public function artistConMyAlbums($idArtist)
    {
        /*dd(Artist::with(['albums' => function($a){
            $a->withCount('songs');
        }])
            ->find($idArtist)
            ->albums()->withCount('songs')
            ->paginate(3)

        );*/

        /*dd(Artist::with(['albums' => function($a){
            $a->withCount('songs');
        }])
            ->find($idArtist)
            ->albums()->withCount('songs')
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(3)
            ->withQueryString()
            ->through(fn($album) => [
                'id' => $album->id,
                'name' => $album->name,
                'artist' => $album->artist->user->name,
                'nrSongs' => $album->songs_count,
            ]));*/

        return Artist::with(['albums' => function($a){
            $a->withCount('songs');
        }])
            ->find($idArtist)
            ->albums()->withCount('songs')
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(3)
            ->withQueryString()
            ->through(fn($album) => [
                'id' => $album->id,
                'name' => $album->name,
                'visible' => $album->visible,
                'artist' => $album->artist->user->name,
                'nrSongs' => $album->songs_count,
        ]);
    }

    public function createAlbum($request)
    {
        return Album::create($request->only(['name', 'artist_id']));
    }

    public function infoArtistConAlbumEvendite($idArtist)
    {
        /*dd(Artist::select('id')
            ->withCount('albums')
            ->withCount('userSales')
            ->find($idArtist));*/

        return Artist::select('id')
            ->with(['albums' => function($a){
                $a->withCount('userSales');
            }])
            ->withCount('albums')
            ->withCount('userSales')
            ->find($idArtist);
    }

    public function BestAlbumSales($idArtist)
    {
        /*dd(Artist::with('albums')
            ->find($idArtist)
            ->albums()->select('id', 'name')->withCount('userSales')
            ->get()->sortByDesc(function ($album){
                return $album->userSales()->count();
            })->first()
        );*/

        return Artist::with('albums')
            ->find($idArtist)
            ->albums()->select('id', 'name')->withCount('userSales')
            ->get()->sortByDesc(function ($album){
                return $album->userSales()->count();
            })->first();
    }

    public function countOfArtistGroupByMonths()
    {
        //  dd(User::utenti()->count());
        /*dd(User::utenti()->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year','month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get());*/

        return Artist::select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupby('year','month')
            ->orderBy('month', 'asc')
            ->get();
    }

    public function countOfArtists()
    {
        return Artist::count();
    }

    public function allArtists()
    {
        return Artist::with('user')
            ->when(Request::input('search'), function ($query, $search){
                $query->whereHas('user', function ($u) use ($search){
                    $u->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();
    }

    public function allArtistsPaginate()
    {
        return Artist::with('user', 'userSales:id')
            ->when(Request::input('search'), function ($query, $search){
                $query->whereHas('user', function ($u) use ($search){
                    $u->where('name', 'like', "%{$search}%");
                });
            })
            ->when(Request::input('tag'), function ($query, $tag){
                $query->where('tag_id', $tag);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString()
            ->through(fn($artist) => [
                'id' => $artist->id,
                'name' => $artist->user->name,
                'tag' => $artist->tag->name,
                'userSales' => $artist->userSales()->get()->pluck('id')->toArray(),
            ]);
    }

    public function artistConAlbums($idArtist)
    {
        /*dd(Artist::with(['user', 'albums' => function($a){
            $a->with('userSales');
        }])
            ->find($idArtist));*/

        return Artist::with(['user', 'albums' => function($a){
            $a->where('visible', 1)->with('userSales','artist');
        }])
            ->find($idArtist);
    }

    public function listOfClients($idArtist)
    {
        return Artist::with('userSales')->find($idArtist)->userSales;
    }

    public function listOfMyAlbumSales($idArtist)
    {
        /*dd(Artist::with(['albums' => function($a){
            $a->whereHas('userSales');
        }])->find($idArtist));*/
        return Artist::with(['albums' => function($a){
            $a->whereHas('userSales')->withCount('userSales');
        }])->find($idArtist)->albums;
    }

    public function followersOfArtist($idArtist)
    {
        return Artist::with('userSales', 'user')->find($idArtist);
    }

    public function infoStripe($idArtist)
    {
        $stripe_id = Artist::find($idArtist)->stripe_id;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY_TEST'));

        return $stripe->accounts->retrieve(
            $stripe_id,
            []
        );
    }
}
