<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use App\Support\WebpImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortfolioItemController extends Controller
{
    public function index(): View
    {
        $portfolioItems = auth()->user()->portfolioItems()->with('images')->latest()->get();
        return view('layouts.frontend.user.portfolio', compact('portfolioItems'));
    }

    private function rules(bool $requireImages): array
    {
        return [
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'work_date' => ['nullable', 'date'],
            'images' => [$requireImages ? 'required' : 'nullable', 'array', ...($requireImages ? ['min:1'] : [])],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    private function fields(array $validated): array
    {
        return [
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'work_date' => $validated['work_date'] ?? null,
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(true));
        $paths = [];
        try {
            // جهز كل الصور أولاً؛ إذا فشل أي ملف فلا ننشئ عملاً ناقصاً.
            foreach ($request->file('images', []) as $image) {
                $paths[] = WebpImage::save($image, 'portfolio', 1600);
            }
            DB::transaction(function () use ($validated, $paths) {
                $portfolioItem = PortfolioItem::create($this->fields($validated) + [
                    'user_id' => auth()->id(), 'status' => 'active',
                ]);
                foreach ($paths as $index => $path) {
                    $portfolioItem->images()->create([
                        'file_path' => $path,
                        'alt_text' => $portfolioItem->title_ar,
                        'sort_order' => $index,
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($paths);
            throw $exception;
        }

        return back()->with('success', 'تمت إضافة العمل والصور بنجاح.');
    }

    public function edit(PortfolioItem $portfolioItem): View
    {
        abort_unless((int) $portfolioItem->user_id === (int) auth()->id(), 403);
        $portfolioItem->load('images');
        return view('layouts.frontend.user.portfolio-edit', compact('portfolioItem'));
    }

    public function update(Request $request, PortfolioItem $portfolioItem): RedirectResponse
    {
        abort_unless((int) $portfolioItem->user_id === (int) auth()->id(), 403);
        $validated = $request->validate($this->rules(false));
        $paths = [];
        try {
            foreach ($request->file('images', []) as $image) {
                $paths[] = WebpImage::save($image, 'portfolio', 1600);
            }
            DB::transaction(function () use ($portfolioItem, $validated, $paths) {
                $portfolioItem->update($this->fields($validated));
                $sortOrder = ($portfolioItem->images()->max('sort_order') ?? -1) + 1;
                foreach ($paths as $path) {
                    $portfolioItem->images()->create([
                        'file_path' => $path,
                        'alt_text' => $portfolioItem->title_ar,
                        'sort_order' => $sortOrder++,
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($paths);
            throw $exception;
        }

        return redirect()->route('portfolio.index')->with('success', 'تم حفظ تغييرات العمل بنجاح.');
    }

    public function replaceImage(Request $request, PortfolioItem $portfolioItem, $image): RedirectResponse
    {
        abort_unless((int) $portfolioItem->user_id === (int) auth()->id(), 403);
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $portfolioImage = $portfolioItem->images()->findOrFail($image);
        $oldPath = $portfolioImage->file_path;
        $newPath = WebpImage::save($validated['image'], 'portfolio', 1600);
        try {
            $portfolioImage->update([
                'file_path' => $newPath,
                'alt_text' => $portfolioItem->title_ar,
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($newPath);
            throw $exception;
        }
        if ($oldPath && $oldPath !== $newPath) {
            Storage::disk('public')->delete($oldPath);
        }
        return back()->with('success', 'تم استبدال الصورة بنجاح.');
    }

    public function destroyImage(PortfolioItem $portfolioItem, $image): RedirectResponse
    {
        abort_unless((int) $portfolioItem->user_id === (int) auth()->id(), 403);
        $portfolioImage = $portfolioItem->images()->findOrFail($image);
        if ($portfolioItem->images()->count() <= 1) {
            return back()->with('error', 'يجب أن يبقى للعمل صورة واحدة على الأقل. يمكنك استبدال الصورة بدل حذفها.');
        }
        $path = $portfolioImage->file_path;
        $portfolioImage->delete();
        if ($path) {
            Storage::disk('public')->delete($path);
        }
        return back()->with('success', 'تم حذف الصورة بنجاح.');
    }

    public function destroy(PortfolioItem $portfolioItem): RedirectResponse
    {
        abort_unless((int) $portfolioItem->user_id === (int) auth()->id(), 403);
        $paths = $portfolioItem->images()->pluck('file_path')->filter()->all();
        $portfolioItem->delete();
        Storage::disk('public')->delete($paths);
        return back()->with('success', 'تم حذف العمل بنجاح.');
    }
}
