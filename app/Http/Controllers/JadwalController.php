<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JadwalController extends Controller
{
    public function index() {
        $data = Jadwal::all();
        return Inertia::render('Jadwal/Index', compact('data'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama' => 'required',
            'waktu' => 'required',
            'tempat' => 'required',
            'pengajar' => 'required',
        ]);

        Jadwal::create($validatedData);

        return redirect()->back()->with('success', 'Jadwal created successfully.');
    }

    public function update(Request $request, Jadwal $jadwal) {
        $validatedData = $request->validate([
            'nama' => 'required',
            'waktu' => 'required',
            'tempat' => 'required',
            'pengajar' => 'required',
        ]);

        $jadwal->update($validatedData);

        // return redirect()->back()->with('success', 'Task updated successfully.');
        return redirect()->route('jadwal.index');
    }

    public function destroy(Jadwal $jadwal) {
        $jadwal->delete();

        // return redirect()->back()->with('success', 'Task deleted successfully.');
        return redirect()->route('jadwal.index');
    }
}
