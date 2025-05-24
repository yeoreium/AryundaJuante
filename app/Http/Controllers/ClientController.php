<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Client::create($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil ditambahkan');
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $client->update($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Data klien berhasil diperbarui');
    }

    public function destroy(Client $client)
    {
        // Cek apakah client memiliki pekerjaan
        if ($client->pekerjaan()->count() > 0) {
            return redirect()->route('clients.index')
                ->with('error', 'Klien tidak dapat dihapus karena masih memiliki pekerjaan');
        }

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil dihapus');
    }
}
