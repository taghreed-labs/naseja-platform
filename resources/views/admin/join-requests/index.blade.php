@extends('layouts.admin.admin')

@section('title', 'طلبات الانضمام')

@section('page-title', 'طلبات الانضمام')


@section('content')

<div class="admin-page-heading">

    <div>

        <h1>
            طلبات الانضمام
        </h1>

        <p>
            راجعي حسابات أصحاب المهارات الجديدة ثم اختاري قبول الطلب أو رفضه.
        </p>

    </div>


    <div class="join-count">

        <i data-lucide="user-round-check"></i>

        <span>
            {{ $requests->count() }}
            طلب قيد المراجعة
        </span>

    </div>

</div>


{{-- رسالة نجاح --}}

@if(session('success'))

    <div class="join-alert success">

        <i data-lucide="circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


{{-- الطلبات --}}

@if($requests->count())


    <div class="join-card admin-card">


        <div class="join-table-header">

            <div>
                <h2>
                    الطلبات الجديدة
                </h2>

                <p>
                    الحسابات التي لم يتم اعتمادها حتى الآن
                </p>
            </div>

        </div>


        <div class="join-table-wrapper">

            <table class="join-table">

                <thead>

                    <tr>

                        <th>
                            المستخدم
                        </th>

                        <th>
                            البريد الإلكتروني
                        </th>

                        <th>
                            تاريخ التسجيل
                        </th>

                        <th>
                            الحالة
                        </th>

                        <th>
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($requests as $user)

                        <tr>

                            {{-- المستخدم --}}

                            <td>

                                <div class="join-user">

                                    <div class="join-avatar">

                                        {{ mb_substr($user->name, 0, 1) }}

                                    </div>


                                    <div class="join-user-info">

                                        <strong>
                                            {{ $user->name }}
                                        </strong>

                                        <span>
                                            ID #{{ $user->id }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            {{-- البريد --}}

                            <td>

                                <span class="join-email">
                                    {{ $user->email }}
                                </span>

                            </td>


                            {{-- التاريخ --}}

                            <td>

                                <span class="join-date">

                                    {{ $user->created_at?->format('Y/m/d') ?? '—' }}

                                </span>

                            </td>


                            {{-- الحالة --}}

                            <td>

                                <span class="join-status pending">

                                    <span></span>

                                    قيد المراجعة

                                </span>

                            </td>


                            {{-- الإجراءات --}}

                            <td>

                                <div class="join-actions">


                                    {{-- قبول --}}

                                    <form
                                        method="POST"
                                        action="{{ route('admin.join-requests.approve', $user) }}"
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="join-btn approve"
                                            onclick="return confirm('هل تريد قبول طلب هذا المستخدم؟')"
                                        >

                                            <i data-lucide="check"></i>

                                            قبول

                                        </button>

                                    </form>


                                    {{-- رفض --}}

                                    <form
                                        method="POST"
                                        action="{{ route('admin.join-requests.reject', $user) }}"
                                    >

                                        @csrf
                                        @method('PATCH')


                                        <button
                                            type="submit"
                                            class="join-btn reject"
                                            onclick="return confirm('هل تريد رفض طلب هذا المستخدم؟')"
                                        >

                                            <i data-lucide="x"></i>

                                            رفض

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


@else


    {{-- لا توجد طلبات --}}

    <div class="join-empty admin-card">


        <div class="join-empty-icon">

            <i data-lucide="user-round-check"></i>

        </div>


        <h2>
            لا توجد طلبات معلقة
        </h2>


        <p>
            عندما يقوم صاحب مهارة جديد بالتسجيل سيظهر طلبه هنا للمراجعة.
        </p>

    </div>


@endif

@endsection



@push('styles')

<style>

    .join-count {

        min-height: 40px;

        display: inline-flex;
        align-items: center;

        gap: 8px;

        padding: 0 13px;

        border: 1px solid #e7ebf4;
        border-radius: 12px;

        background: #ffffff;

        color: #637086;

        font-size: 11px;
        font-weight: 800;

        box-shadow:
            0 8px 20px rgba(30, 45, 72, .03);
    }


    .join-count svg {

        width: 17px;
        height: 17px;

        color: #5b7cff;
    }


    /* =========================
       ALERT
    ========================== */

    .join-alert {

        min-height: 50px;

        display: flex;
        align-items: center;

        gap: 10px;

        padding: 0 15px;

        margin-bottom: 17px;

        border-radius: 14px;

        font-size: 11px;
        font-weight: 700;
    }


    .join-alert.success {

        background: #edf9f4;

        border: 1px solid #d5f0e4;

        color: #23825f;
    }


    .join-alert svg {

        width: 18px;
        height: 18px;
    }


    /* =========================
       CARD
    ========================== */

    .join-card {

        overflow: hidden;
    }


    .join-table-header {

        padding: 21px 22px;

        border-bottom: 1px solid #edf1f6;
    }


    .join-table-header h2 {

        margin-bottom: 5px;

        color: #2f394d;

        font-size: 14px;
        font-weight: 900;
    }


    .join-table-header p {

        color: #929dac;

        font-size: 9.5px;
    }


    .join-table-wrapper {

        overflow-x: auto;
    }


    /* =========================
       TABLE
    ========================== */

    .join-table {

        width: 100%;

        border-collapse: collapse;
    }


    .join-table th {

        padding: 13px 18px;

        background: #fafbfe;

        color: #929cab;

        text-align: right;

        white-space: nowrap;

        font-size: 9.5px;
        font-weight: 800;
    }


    .join-table td {

        padding: 15px 18px;

        border-top: 1px solid #f0f3f7;

        color: #5f6b7e;

        white-space: nowrap;

        font-size: 10.5px;
    }


    .join-table tbody tr {

        transition: .2s;
    }


    .join-table tbody tr:hover {

        background: #fcfdff;
    }


    /* =========================
       USER
    ========================== */

    .join-user {

        display: flex;
        align-items: center;

        gap: 10px;
    }


    .join-avatar {

        width: 41px;
        height: 41px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #edf2ff,
                #f3efff
            );

        color: #5871d8;

        font-size: 14px;
        font-weight: 900;
    }


    .join-user-info strong {

        display: block;

        margin-bottom: 4px;

        color: #364156;

        font-size: 11px;
        font-weight: 800;
    }


    .join-user-info span {

        color: #a2abb8;

        font-size: 8.5px;
    }


    .join-email,
    .join-date {

        color: #697589;
    }


    /* =========================
       STATUS
    ========================== */

    .join-status {

        min-height: 28px;

        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding: 0 9px;

        border-radius: 20px;

        font-size: 9px;
        font-weight: 800;
    }


    .join-status.pending {

        background: #fff6e8;

        color: #cb8123;
    }


    .join-status > span {

        width: 6px;
        height: 6px;

        border-radius: 50%;

        background: currentColor;
    }


    /* =========================
       ACTIONS
    ========================== */

    .join-actions {

        display: flex;
        align-items: center;

        gap: 7px;
    }


    .join-actions form {

        margin: 0;
    }


    .join-btn {

        min-height: 34px;

        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding: 0 10px;

        border: 0;
        border-radius: 10px;

        font-family: 'Tajawal', Arial, sans-serif;

        font-size: 9.5px;
        font-weight: 800;

        cursor: pointer;

        transition: .2s;
    }


    .join-btn svg {

        width: 14px;
        height: 14px;
    }


    .join-btn.approve {

        background: #eaf8f2;

        color: #238b67;
    }


    .join-btn.approve:hover {

        background: #dff4eb;
    }


    .join-btn.reject {

        background: #fff0f1;

        color: #d84f59;
    }


    .join-btn.reject:hover {

        background: #ffe5e7;
    }


    /* =========================
       EMPTY
    ========================== */

    .join-empty {

        min-height: 390px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        padding: 30px;

        text-align: center;
    }


    .join-empty-icon {

        width: 70px;
        height: 70px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 17px;

        border-radius: 22px;

        background:
            linear-gradient(
                135deg,
                #edf2ff,
                #f4efff
            );

        color: #6178d9;
    }


    .join-empty-icon svg {

        width: 28px;
        height: 28px;

        stroke-width: 1.7;
    }


    .join-empty h2 {

        margin-bottom: 7px;

        color: #354056;

        font-size: 15px;
        font-weight: 900;
    }


    .join-empty p {

        max-width: 400px;

        color: #929dac;

        font-size: 10.5px;
        line-height: 1.8;
    }


    @media (max-width: 700px) {

        .join-count {

            width: 100%;
            justify-content: center;
        }

    }

</style>

@endpush