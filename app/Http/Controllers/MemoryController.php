<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\MemoryMedia;
use App\Http\Requests\StoreMemoryRequest;
use App\Http\Requests\UpdateMemoryRequest;
use Illuminate\Http\Request;
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
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('memories', 'public');
                $mimeType = $file->getMimeType();

                if (str_starts_with($mimeType, 'image/')) {
                    $mediaType = 'image';
                } elseif (str_starts_with($mimeType, 'audio/')) {
                    $mediaType = 'audio';
                } else {
                    $mediaType = 'video';
                }

                $memory->media()->create([
                    'media_path' => $path,
                    'media_type' => $mediaType,
                ]);
            }
        }

        return redirect()->route('memories.index');
    }

    public function index()
    {
        $memories = Memory::with('media')->where('user_id', Auth::id())->get();
        return view('memories.index', compact('memories'));
    }

    public function show(int $id)
    {
        $memory = Memory::with('media')->where('user_id', Auth::id())->findOrFail($id);
        return view('memories.show', compact('memory'));
    }

    public function edit(int $id)
    {
        $memory = Memory::with('media')->where('user_id', Auth::id())->findOrFail($id);
        return view('memories.edit', compact('memory'));
    }

    public function update(UpdateMemoryRequest $request, int $id)
    {
        $memory = Memory::where('user_id', Auth::id())->findOrFail($id);

        $memory->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // 2. معالجة حذف الميديا المحددة فردياً
        if ($request->has('deleted_media')) {
            foreach ($request->deleted_media as $mediaId) {
                if (!empty($mediaId)) {
                    $oldMedia = $memory->media()->find($mediaId);
                    if ($oldMedia) {
                        if (Storage::disk('public')->exists($oldMedia->media_path)) {
                            Storage::disk('public')->delete($oldMedia->media_path);
                        }
                        $oldMedia->delete();
                    }
                }
            }
        }

        // 3. معالجة استبدال الميديا الفردية
        if ($request->hasFile('replaced_media')) {
            foreach ($request->file('replaced_media') as $mediaId => $file) {
                $oldMedia = $memory->media()->find($mediaId);
                if ($oldMedia) {
                    // حذف الملف القديم المستبدل من التخزين
                    if (Storage::disk('public')->exists($oldMedia->media_path)) {
                        Storage::disk('public')->delete($oldMedia->media_path);
                    }

                    // رفع الملف الجديد
                    $path = $file->store('memories', 'public');
                    $mimeType = $file->getMimeType();

                    if (str_starts_with($mimeType, 'image/')) {
                        $mediaType = 'image';
                    } elseif (str_starts_with($mimeType, 'audio/')) {
                        $mediaType = 'audio';
                    } else {
                        $mediaType = 'video';
                    }

                    // تحديث السجل في قاعدة البيانات بدلاً من إنشائه مجدداً
                    $oldMedia->update([
                        'media_path' => $path,
                        'media_type' => $mediaType,
                    ]);
                }
            }
        }

        // 4. معالجة إضافة ميديا جديدة تماماً (بدون مسح القديم)
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('memories', 'public');
                $mimeType = $file->getMimeType();

                if (str_starts_with($mimeType, 'image/')) {
                    $mediaType = 'image';
                } elseif (str_starts_with($mimeType, 'audio/')) {
                    $mediaType = 'audio';
                } else {
                    $mediaType = 'video';
                }

                $memory->media()->create([
                    'media_path' => $path,
                    'media_type' => $mediaType,
                ]);
            }
        }

        return redirect()->route('memories.index');
    }

    public function destroy(int $id)
    {
        $memory = Memory::with('media')->where('user_id', Auth::id())->findOrFail($id);

        foreach ($memory->media as $media) {
            if ($media->media_path) {
                Storage::disk('public')->delete($media->media_path);
            }
        }

        $memory->delete();

        return redirect()->route('memories.index');
    }

    public function toggleFavorite(int $id)
    {
        $memory = Memory::where('user_id', Auth::id())->findOrFail($id);
        $memory->is_favorite = !$memory->is_favorite;
        $memory->save();

        return back();
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $memories = Memory::with('media')->where('user_id', Auth::id())
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12);

        return view('memories.search', compact('memories', 'search'));
    }
}
