<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Kitchen;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecepientController extends Controller
{
    public function index()
    {
        $title = "Instansi Penerima";
        $data = Receiver::whereHas('kitchen', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('dashboard.components.receipent.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = "Tambah Instansi Penerima";
        $kitchens = Kitchen::where('user_id', Auth::id())->first();
        return view('dashboard.components.receipent.create', compact('title', 'kitchens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kitchen_id' => 'required|exists:kitchens,id',
            'name' => 'required',
            'phone' => 'nullable',
            'type' => 'nullable',
            'portion' => 'nullable|integer',
            'address' => 'nullable',
        ]);

        Receiver::create([
            'kitchen_id' => $request->kitchen_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'type' => $request->type,
            'portion' => 0,
            'address' => $request->address,
        ]);

        return redirect('/recipient')->with('success', 'Instansi penerima berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $title = "Edit Instansi Penerima";
        $recipient = Receiver::findOrFail($id);
        $kitchens = Kitchen::all();
        return view('dashboard.components.receipent.update', compact('title', 'recipient', 'kitchens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kitchen_id' => 'required|exists:kitchens,id',
            'name' => 'required',
            'phone' => 'nullable',
            'type' => 'nullable',
            'portion' => 'nullable|integer',
            'address' => 'nullable',
        ]);

        $recipient = Receiver::findOrFail($id);
        $recipient->update([
            'kitchen_id' => $request->kitchen_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'type' => $request->type,
            'portion' => $recipient->portion, // Keep existing portion value
            'address' => $request->address,
        ]);

        return redirect('/recipient')->with('success', 'Instansi penerima berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $recipient = Receiver::findOrFail($id);
        $recipient->delete();

        return redirect('/recipient')->with('success', 'Instansi penerima berhasil dihapus.');
    }
}
