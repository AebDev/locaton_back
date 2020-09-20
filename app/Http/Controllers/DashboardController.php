<?php

namespace App\Http\Controllers;

use App\Location;
use App\User;
use App\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function home()
    {
        $today = Carbon::today();
        
        $now = Carbon::now()->addHours(1);

        $reservation = Location::all('montant')->whereBetween('created_at',[$today,$now]);
        $total = $reservation->sum('montant');
        $user = User::all()->whereBetween('created_at',[$today,$now]);
        $vehicule = Location::all()->where('date_debut', '<', $today)->where('date_fin', '>', $today);

        $reservationStatistic = [];
        $userStatistic = [];
        $vehiculeStatistic = [];

        // for ($i=10; $i >0 ; $i--) { 
        //     $before = Carbon::today()->subDays($i);
        //     $beforeRes = Location::all('montant')->whereBetween('created_at',[$before,$before->endOfDay()]);

        //     array_push($listStatistic,[
        //         'id' => $before->format('d/m'),
        //         'order' => $beforeRes->count(),
        //         'total' => $beforeRes->sum('montant'),
        //         'user' => User::all()->whereBetween('created_at',[$before,$before->endOfDay()])->count(),
        //         'vehicule' => Location::all()->where('date_debut', '<', $before)->where('date_fin', '>', $before->endOfDay())->count()
        //     ]);
        // }

        for ($i=10; $i >0 ; $i--) { 
            $before = Carbon::today()->subDays($i);
            $beforeRes = Location::all('montant')->whereBetween('created_at',[$before,$before->endOfDay()]);

            array_push($reservationStatistic,[
                $before->format('d/m'), $beforeRes->count()
            ]);
            array_push($userStatistic,[
                $before->format('d/m'), User::all()->whereBetween('created_at',[$before,$before->endOfDay()])->count()
            ]);
            array_push($vehiculeStatistic,[
                $before->format('d/m'), Location::all()->where('date_debut', '<', $before)->where('date_fin', '>', $before->endOfDay())->count()
            ]);
        }

        

        
        return response()->Json(['today' => ['todayOrders' => $reservation->count(),
                                            'total' => $total,
                                            'user' => $user->count(),
                                            'vehicule' => $vehicule->count()],

                                'reservation' => $reservationStatistic,
                                'user' => $userStatistic,
                                'vehicule' => $vehiculeStatistic]);
    }
}
