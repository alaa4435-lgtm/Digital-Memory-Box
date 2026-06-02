<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Http\Requests\StoreMemoryRequest;
use App\Http\Requests\UpdateMemoryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemoryController extends Controller
{
    public function create()
    {
        return view('memories.create');
    }

    public function store(StoreMemoryRequest $request)
    {
        $memory = Memory::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('media')) {

            $file = $request->file('media');
            $memory->media_path = $file->store('memories', 'public');

            $memory->media_type = str_starts_with(
                $file->getMimeType(),
                'image/'
            ) ? 'image' : 'video';

           $memory->save();
        }

        return redirect()->route('memories.index');
    }

    public function index()
    {
        $memories = Memory::where('user_id', Auth::id())->get();
        return view('memories.index', compact('memories'));
    }

    public function show(int $id)
    {
        $memory = Memory::where('user_id', Auth::id())->findOrFail($id);
        return view('memories.show', compact('memory'));
    }

    public function edit(int $id)
    {
        $memory = Memory::where('user_id', Auth::id())->findOrFail($id);
        return view('memories.edit', compact('memory'));
    }

    public function update(UpdateMemoryRequest $request, int $id)
    {
        $memory = Memory::where('user_id', Auth::id())->findOrFail($id);
        $memory->update($request->validated());

        if ($request->hasFile('media')) {

            if ($memory->media_path && Storage::disk('public')->exists($memory->media_path)) {
                Storage::disk('public')->delete($memory->media_path);
            }

            $file = $request->file('media');

            $mediaData['media_path'] = $file->store('memories', 'public');
            $mediaData['media_type'] = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video';

            $memory->update($mediaData);
        }

        return redirect()->route('memories.index');
    }

    public function destroy(int $id)
    {
        $memory = Memory::where('user_id', Auth::id())->findOrFail($id);

        if ($memory->media_path) {
            Storage::disk('public')->delete($memory->media_path);
        }
        $memory->delete();
        return redirect()->route('memories.index');
    }
}
