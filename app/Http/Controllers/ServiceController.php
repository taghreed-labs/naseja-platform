<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    private function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'price_type' => ['nullable', 'required_with:price', Rule::in(['ثابت', 'يبدأ من', 'حسب الطلب'])],
            'price' => ['nullable', 'numeric', 'min:0', 'required_if:price_type,ثابت,يبدأ من', 'prohibited_if:price_type,حسب الطلب'],
            'duration' => ['nullable', 'string', 'max:100'],
        ];
    }

    private function messages(): array
    {
        return [
            'price_type.required_with' => 'حدد نوع السعر عند إدخال مبلغ.',
            'price.required_if' => 'أدخل المبلغ عند اختيار سعر ثابت أو يبدأ من.',
            'price.prohibited_if' => 'احذف المبلغ عند اختيار السعر حسب الطلب.',
        ];
    }

    private function fields(array $validated): array
    {
        return [
            'category_id' => $validated['category_id'],
            'title_ar' => $validated['title_ar'],
            'title_en' => $validated['title_en'] ?? null,
            'description_ar' => $validated['description_ar'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'price_type' => $validated['price_type'] ?? null,
            'price' => ($validated['price_type'] ?? null) === 'حسب الطلب' ? null : ($validated['price'] ?? null),
            'duration' => $validated['duration'] ?? null,
        ];
    }
    /**
     * عرض خدمات المستخدم الحالي.
     */
    public function index(): View
    {
        $user = auth()->user();

        $services = $user->services()
            ->with('category')
            ->latest()
            ->get();

        // جلب التصنيفات النشطة
        $categories = Category::where('status', 'active')
            ->orderBy('name_ar')
            ->get();

        return view(
            'layouts.frontend.user.services',
            compact('services', 'categories')
        );
    }

    /**
     * إضافة خدمة جديدة.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

$data = $this->fields($validated);
$data['price'] = $data['price'] ?? 0;

Service::create($data + [
    'user_id' => auth()->id(),
    'status'  => 'active',
]);
        return back()->with(
            'success',
            'تمت إضافة الخدمة بنجاح.'
        );
    }

    /**
     * عرض نموذج تعديل الخدمة.
     */
    public function edit(Service $service): View
    {
        // التأكد أن الخدمة تخص المستخدم الحالي
        abort_unless(
            $service->user_id === auth()->id(),
            403
        );

        // جلب التصنيفات النشطة
        $categories = Category::where('status', 'active')
            ->orderBy('name_ar')
            ->get();

        // تحميل التصنيف المرتبط بالخدمة
        $service->load('category');

        return view(
            'layouts.frontend.user.services-edit',
            compact('service', 'categories')
        );
    }

    /**
     * حفظ تعديلات الخدمة.
     */
    public function update(
        Request $request,
        Service $service
    ): RedirectResponse {
        // التأكد أن الخدمة تخص المستخدم الحالي
        abort_unless(
            $service->user_id === auth()->id(),
            403
        );

        $validated = $request->validate($this->rules(), $this->messages());

        $service->update($this->fields($validated));

        return redirect()
            ->route('services.index')
            ->with(
                'success',
                'تم حفظ تغييرات الخدمة بنجاح.'
            );
    }

    /**
     * حذف الخدمة.
     */
    public function destroy(Service $service): RedirectResponse
    {
        // التأكد أن الخدمة تخص المستخدم الحالي
        abort_unless(
            $service->user_id === auth()->id(),
            403
        );

        $service->delete();

        return back()->with(
            'success',
            'تم حذف الخدمة بنجاح.'
        );
    }
}
