<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceOrderController extends Controller
{
    public function index(): View
    {
        $customer = $this->customerUser();

        $orders = ServiceOrder::with([
                'service',
                'provider.profile',
            ])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view(
            'layouts.frontend.user.orders',
            compact('customer', 'orders')
        );
    }

    public function create(Service $service): View
    {
        $customer = $this->customerUser();

        $this->ensureServiceCanBeOrdered(
            $service,
            $customer
        );

        $service->loadMissing([
            'user.profile',
            'category',
        ]);

        return view(
            'layouts.frontend.user.service-order-create',
            compact('customer', 'service')
        );
    }

    public function store(
        Request $request,
        Service $service
    ): RedirectResponse {
        $customer = $this->customerUser();

        $this->ensureServiceCanBeOrdered(
            $service,
            $customer
        );

        $validated = $request->validate(
            [
                'requirements' => [
                    'required',
                    'string',
                    'min:10',
                    'max:3000',
                ],
                'preferred_deadline' => [
                    'nullable',
                    'date',
                    'after_or_equal:today',
                ],
            ],
            [
                'requirements.required' => 'اكتب تفاصيل طلبك أولًا.',
                'requirements.min' => 'تفاصيل الطلب يجب أن تكون 10 أحرف على الأقل.',
                'requirements.max' => 'تفاصيل الطلب طويلة جدًا.',
                'preferred_deadline.date' => 'تاريخ التسليم غير صحيح.',
                'preferred_deadline.after_or_equal' => 'تاريخ التسليم لا يمكن أن يكون في الماضي.',
            ]
        );

        ServiceOrder::create([
            'service_id' => $service->id,
            'customer_id' => $customer->id,
            'provider_id' => $service->user_id,
            'requirements' => $validated['requirements'],
            'preferred_deadline' => $validated['preferred_deadline'] ?? null,
            'price_snapshot' => $service->price,
            'price_type_snapshot' => $service->price_type,
            'duration_snapshot' => $service->duration,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('orders.index')
            ->with(
                'order_success',
                'تم إرسال طلب الخدمة بنجاح إلى صاحب المهارة.'
            );
    }

    public function providerIndex(): View
    {
        $provider = $this->providerUser();

        $orders = ServiceOrder::with([
                'service',
                'customer.profile',
            ])
            ->where('provider_id', $provider->id)
            ->latest()
            ->get();

        return view(
            'layouts.frontend.user.provider-orders',
            compact('provider', 'orders')
        );
    }

    public function accept(ServiceOrder $serviceOrder): RedirectResponse
    {
        $provider = $this->providerUser();

        $this->ensureProviderOwnsOrder(
            $serviceOrder,
            $provider
        );

        abort_unless(
            $serviceOrder->status === 'pending',
            422,
            'لا يمكن قبول هذا الطلب في حالته الحالية.'
        );

        $serviceOrder->update([
            'status' => 'accepted',
        ]);

        return back()->with(
            'order_status_success',
            'تم قبول الطلب بنجاح.'
        );
    }

    public function reject(ServiceOrder $serviceOrder): RedirectResponse
    {
        $provider = $this->providerUser();

        $this->ensureProviderOwnsOrder(
            $serviceOrder,
            $provider
        );

        abort_unless(
            $serviceOrder->status === 'pending',
            422,
            'لا يمكن رفض هذا الطلب في حالته الحالية.'
        );

        $serviceOrder->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'order_status_success',
            'تم رفض الطلب.'
        );
    }

    public function start(ServiceOrder $serviceOrder): RedirectResponse
    {
        $provider = $this->providerUser();

        $this->ensureProviderOwnsOrder(
            $serviceOrder,
            $provider
        );

        abort_unless(
            $serviceOrder->status === 'accepted',
            422,
            'يجب قبول الطلب أولًا قبل بدء التنفيذ.'
        );

        $serviceOrder->update([
            'status' => 'in_progress',
        ]);

        return back()->with(
            'order_status_success',
            'تم تحويل الطلب إلى قيد التنفيذ.'
        );
    }

    public function complete(ServiceOrder $serviceOrder): RedirectResponse
    {
        $provider = $this->providerUser();

        $this->ensureProviderOwnsOrder(
            $serviceOrder,
            $provider
        );

        abort_unless(
            $serviceOrder->status === 'in_progress',
            422,
            'يجب أن يكون الطلب قيد التنفيذ قبل إكماله.'
        );

        $serviceOrder->update([
            'status' => 'completed',
        ]);

        return back()->with(
            'order_status_success',
            'تم تعليم الطلب كمكتمل.'
        );
    }

    private function ensureProviderOwnsOrder(
        ServiceOrder $serviceOrder,
        User $provider
    ): void {
        abort_unless(
            $serviceOrder->provider_id === $provider->id,
            403,
            'لا يمكنك إدارة طلب لا يخص خدماتك.'
        );
    }

    private function customerUser(): User
    {
        /** @var User $user */
        $user = auth()->user();

        abort_unless(
            $user &&
            $user->roles()
                ->where('slug', 'customer')
                ->exists(),
            403,
            'طلب الخدمات متاح لحساب العميل فقط.'
        );

        return $user;
    }

    private function providerUser(): User
    {
        /** @var User $user */
        $user = auth()->user();

        abort_unless(
            $user &&
            $user->roles()
                ->where('slug', 'provider')
                ->exists(),
            403,
            'هذه الصفحة متاحة لصاحب المهارة فقط.'
        );

        return $user;
    }

    private function ensureServiceCanBeOrdered(
        Service $service,
        User $customer
    ): void {
        $service->loadMissing('user');

        abort_if(
            $service->user_id === $customer->id,
            403,
            'لا يمكنك طلب خدمة من حسابك.'
        );

        abort_unless(
            $service->status === 'active',
            404
        );

        $provider = $service->user;

        abort_unless(
            $provider &&
            $provider->status === 'active' &&
            $provider->approval_status === 'approved',
            404
        );
    }
}
