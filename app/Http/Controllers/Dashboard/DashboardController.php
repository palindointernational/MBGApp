<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Kitchen;
use App\Models\Menu;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";
        $benCount = 0;
        $menuCount = Menu::whereHas('kitchen', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
        $kitchenCount = Receiver::whereHas('kitchen', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
        $kitchen = Kitchen::where('user_id', Auth::id())->first();
        if ($kitchen) {
            $benCount = Beneficiary::whereHas('receiver', function ($q) use ($kitchen) {
                $q->where('kitchen_id', $kitchen->id);
            })->count();
        }
        return view('dashboard.index', compact('title', 'menuCount', 'kitchenCount', 'benCount'));
    }
}
