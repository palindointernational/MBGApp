<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Kitchen;
use App\Models\Menu;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $title = "Penilaian";
        $k = Kitchen::where('user_id', Auth::id())->first();
        $m = Menu::where('kitchen_id', $k->id)->first();
        if (!$m) {
            $data = collect();
        } else {
            $data = Review::where('menu_id', $m->id)->orderBy('created_at', 'desc')
                ->get()
                ->unique('menu_id');
        }
        return view('dashboard.components.feedback.index', compact('title', 'data'));
    }

    public function detail($id, $menu)
    {
        $title = "Detail Penilaian";
        $data = Review::where('id', $id)->first();
        $feedback = Review::where('menu_id', $menu)
            ->orderBy('created_at', 'desc')
            ->get();
        // dd($feedback);
        $avgRating = number_format(Review::where('menu_id', $menu)->avg('rating'), 1);
        $totalReview = Review::where('menu_id', $menu)->count();
        return view('dashboard.components.feedback.detail', compact('title', 'data', 'feedback', 'avgRating', 'totalReview'));
    }
}
