<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Menu;
use App\Models\MenuStatusLog;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $beneficiary = Beneficiary::where('user_id', Auth::id())->firstOrFail();

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('feedback', $imageName, 'public');
        }

        Review::create([
            'menu_id' => $request->menu_id,
            'beneficiary_id' => $beneficiary->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imageName,
        ]);
        $beneficiary->update([
            'acceptance_count' => $beneficiary->acceptance_count + 1,
        ]);

        $menustatus = Menu::where('id', $request->menu_id)->firstOrFail();
        $menustatus->update([
            'status' => 'Distributed',
            'distributed_at' => now(),
        ]);

        MenuStatusLog::create([
            'menu_id' => $request->menu_id,
            'status' => 'Distributed',
        ]);

        return back()->with('success', 'Feedback berhasil dikirim!');
    }
}
