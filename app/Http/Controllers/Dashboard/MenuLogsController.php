<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuLogsController extends Controller
{
    public function index()
    {
        $menu = Menu::whereHas('kitchen', function ($query) {
            $query->where('user_id', Auth::id());
        })->latest()->first();
        if (!$menu) {
            $data = collect();
        } else {
            $data = MenuStatusLog::where('menu_id', $menu->id)->latest()->get();
        }
        return view('dashboard.components.menulogs.index', [
            'title' => 'Menu Logs',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $menu = MenuStatusLog::findOrFail($id);
        $menu->delete();
        return redirect()->route('menuLogs')->with('success', 'Menu log berhasil dihapus.');
    }
}
