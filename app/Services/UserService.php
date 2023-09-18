<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserService
{
    public function listOfUsers()
    {
        return User::utenti()
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created' => $user->created,
        ]);
    }

    public function listOfArtists()
    {
        return User::artisti()
            ->when(Request::input('search'), function ($query, $search){
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created' => $user->created,
        ]);
    }

    public function countOfUsersGroupByMonths()
    {
      //  dd(User::utenti()->count());
        /*dd(User::utenti()->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year','month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get());*/

        return User::utenti()->select(DB::raw('count(id) as `data`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupby('year','month')
            ->orderBy('month', 'asc')
            ->get();
    }

    public function countOfUsers()
    {
        return User::utenti()->count();
    }

    public function myArtistsPaginate()
    {
        return User::with('artistSales')
            ->find(Auth::id())
            ->artistSales()
            ->when(Request::input('searchArtist'), function ($query, $searchArtist){
                $query->whereHas('user', function ($u) use ($searchArtist){
                    $u->where('name', 'like', "%{$searchArtist}%");
                });
            })
            ->paginate(5)
            ->withQueryString()
            ->through(fn($artist) => [
                'id' => $artist->id,
                'name' => $artist->user->name,
            ]);
    }

    public function userConMyAlbums()
    {
        return User::with(['albumSales' => function($a){
            $a->when(Request::input('searchAlbum'), function ($query, $searchAlbum){
                    $query->where('name', 'like', "%{$searchAlbum}%");
                });
            }])
        ->find(Auth::id());
    }

    public function segnaLettoNotizie($idUser)
    {

        //dd(User::find($idUser)->newsNotRead );
        User::find($idUser)->newsNotRead()->syncWithPivotValues(
            [Auth::id()], ['read' => 1]
        );
    }
}
