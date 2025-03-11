<?php

namespace App\Http\Controllers;

use App\Models\Clothes;
use Illuminate\Http\Request;

class ClothesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clothes = Clothes::paginate(10); // Menampilkan 10 data per halaman
        return view('clothes.index', compact('clothes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clothes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'label' => 'required|in:dewasa,anak',
        ]);

        Clothes::create($request->all());

        return redirect()->route('clothes.index')->with('success', 'Clothes added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clothes $clothes)
    {
        return view('clothes.edit', compact('clothes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clothes $clothes)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'label' => 'required|in:dewasa,anak',
        ]);

        $clothes->update($request->all());

        return redirect()->route('clothes.index')->with('success', 'Clothes updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clothes $clothes)
    {
        $clothes->delete();
        return redirect()->route('clothes.index')->with('success', 'Clothes deleted successfully.');
    }
}
