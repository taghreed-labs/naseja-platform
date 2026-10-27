@extends('layouts.admin.admin')

@section('title', 'إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين')


@section('content')

<div class="admin-page-heading">

    <div>

        <h1>
            إدارة المستخدمين
        </h1>

        <p>
            عرض جميع حسابات المستخدمين والبحث والتصفية والتفعيل أو التعطيل أو الحذف.
        </p>

    </div>


    <div class="users-summary">

        <div class="users-summary-item">

            <span>الإجمالي</span>

            <strong>
                {{ $totalUsers }}
            </strong>

        </div>

        <div class="users-summary-item active">

            <span>النشطون</span>

            <strong>
                {{ $activeUsers }}
            </strong>

        </div>

        <div class="users-summary-item inactive">

            <span>المعطلون</span>

            <strong>
                {{ $inactiveUsers }}
            </strong>

        </div>

    </div>

</div>


@if(session('success'))

    <div class="users-alert success">

        <i data-lucide="circle-check"></i>

        <span>
            {{ session('success') }}
        </span>

    </div>

@endif


<section class="admin-card users-card">


    <div class="users-toolbar">


        <form
            method="GET"
            action="{{ route('admin.users.index') }}"
            class="users-filters"
        >


            <div class="users-search">

                <i data-lucide="search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="بحث بالاسم أو البريد..."
                >

            </div>


            <select name="status">

                <option value="">
                    كل حالات الحساب
                </option>

                <option
                    value="active"
                    {{ $status === 'active' ? 'selected' : '' }}
                >
                    نشط
                </option>

                <option
                    value="inactive"
                    {{ $status === 'inactive' ? 'selected' : '' }}
                >
                    معطل
                </option>

            </select>


            <select name="approval_status">

                <option value="">
                    كل حالات الاعتماد
                </option>

                <option
                    value="pending"
                    {{ $approvalStatus === 'pending' ? 'selected' : '' }}
                >
                    قيد المراجعة
                </option>

                <option
                    value="approved"
                    {{ $approvalStatus === 'approved' ? 'selected' : '' }}
                >
                    معتمد
                </option>

                <option
                    value="rejected"
                    {{ $approvalStatus === 'rejected' ? 'selected' : '' }}
                >
                    مرفوض
                </option>

            </select>


            <button
                type="submit"
                class="filter-button"
            >

                <i data-lucide="sliders-horizontal"></i>

                تطبيق

            </button>


            <a
                href="{{ route('admin.users.index') }}"
                class="reset-button"
            >

                <i data-lucide="rotate-ccw"></i>

                إعادة ضبط

            </a>

        </form>

    </div>


    @if($users->count())


        <div class="users-table-wrapper">


            <table class="users-table">


                <thead>

                    <tr>

                        <th>
                            المستخدم
                        </th>

                        <th>
                            البريد الإلكتروني
                        </th>

                        <th>
                            حالة الحساب
                        </th>

                        <th>
                            حالة الاعتماد
                        </th>

                        <th>
                            تاريخ التسجيل
                        </th>

                        <th>
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody>


                    @foreach($users as $user)

                        <tr>


                            <td>

                                <div class="user-cell">

                                    <div class="user-avatar">

                                        @if($user->profile?->avatar)

                                            <img
                                                src="{{ asset('storage/' . $user->profile->avatar) }}"
                                                alt="{{ $user->name }}"
                                            >

                                        @else

                                            {{ mb_substr($user->name, 0, 1) }}

                                        @endif

                                    </div>


                                    <div class="user-cell-info">

                                        <strong>
                                            {{ $user->name }}
                                        </strong>

                                        <span>
                                            ID #{{ $user->id }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="user-email">
                                    {{ $user->email }}
                                </span>

                            </td>


                            <td>

                                @if($user->status === 'active')

                                    <span class="status-badge active">

                                        <span></span>

                                        نشط

                                    </span>

                                @else

                                    <span class="status-badge inactive">

                                        <span></span>

                                        معطل

                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($user->approval_status === 'approved')

                                    <span class="approval-badge approved">

                                        <i data-lucide="badge-check"></i>

                                        معتمد

                                    </span>

                                @elseif($user->approval_status === 'pending')

                                    <span class="approval-badge pending">

                                        <i data-lucide="clock-3"></i>

                                        قيد المراجعة

                                    </span>

                                @else

                                    <span class="approval-badge rejected">

                                        <i data-lucide="circle-x"></i>

                                        مرفوض

                                    </span>

                                @endif

                            </td>


                            <td>

                                <span class="user-date">

                                    {{ $user->created_at?->format('Y/m/d') ?? '—' }}

                                </span>

                            </td>


                            <td>

                                <div class="user-actions">


                                    @if($user->approval_status === 'approved')

                                        <a
                                            href="{{ route('users.show', ['slug' => $user->profile->slug]) }}"
                                            target="_blank"
                                            class="action-button view"
                                            title="عرض الملف"
                                        >

                                            <i data-lucide="eye"></i>

                                        </a>

                                    @endif


                                    @if($user->status === 'active')

                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.deactivate', $user) }}"
                                        >

                                            @csrf
                                            @method('PATCH')


                                            <button
                                                type="submit"
                                                class="action-button deactivate"
                                                title="تعطيل الحساب"
                                                onclick="return confirm('هل تريد تعطيل حساب هذا المستخدم؟')"
                                            >

                                                <i data-lucide="user-x"></i>

                                            </button>

                                        </form>


                                    @elseif($user->status === 'inactive')


                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.activate', $user) }}"
                                        >

                                            @csrf
                                            @method('PATCH')


                                            <button
                                                type="submit"
                                                class="action-button activate"
                                                title="تفعيل الحساب"
                                                onclick="return confirm('هل تريد إعادة تفعيل حساب هذا المستخدم؟')"
                                            >

                                                <i data-lucide="user-check"></i>

                                            </button>

                                        </form>


                                    @endif


                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.destroy', $user) }}"
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="action-button delete"
                                            title="حذف المستخدم"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟ سيتم الحذف بشكل آمن ويمكن استرجاعه لاحقًا.')"
                                        >

                                            <i data-lucide="trash-2"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach


                </tbody>


            </table>


        </div>


        <div class="users-pagination">

            {{ $users->links() }}

        </div>


    @else


        <div class="users-empty">


            <div class="users-empty-icon">

                <i data-lucide="users-round"></i>

            </div>


            <h2>
                لا توجد نتائج
            </h2>


            <p>
                لم يتم العثور على مستخدمين مطابقين لخيارات البحث الحالية.
            </p>


            <a
                href="{{ route('admin.users.index') }}"
            >

                إعادة عرض كل المستخدمين

            </a>

        </div>


    @endif


</section>


@endsection



@push('styles')

<style>

    .users-summary {

        display: flex;
        align-items: center;

        gap: 9px;
    }


    .users-summary-item {

        min-width: 85px;

        padding: 9px 12px;

        background: #ffffff;

        border: 1px solid #e8edf5;
        border-radius: 13px;

        text-align: center;
    }


    .users-summary-item span {

        display: block;

        margin-bottom: 2px;

        color: #919bab;

        font-size: 8.5px;
    }


    .users-summary-item strong {

        color: #364156;

        font-size: 15px;
        font-weight: 900;
    }


    .users-summary-item.active strong {
        color: #25916b;
    }


    .users-summary-item.inactive strong {
        color: #d65b62;
    }


    /* ALERT */

    .users-alert {

        min-height: 50px;

        display: flex;
        align-items: center;

        gap: 9px;

        padding: 0 15px;

        margin-bottom: 17px;

        border-radius: 14px;

        font-size: 11px;
        font-weight: 700;
    }


    .users-alert.success {

        background: #edf9f4;

        border: 1px solid #d4efe3;

        color: #23825f;
    }


    .users-alert svg {

        width: 17px;
        height: 17px;
    }


    /* CARD */

    .users-card {

        overflow: hidden;
    }


    /* TOOLBAR */

    .users-toolbar {

        padding: 18px 20px;

        border-bottom: 1px solid #edf1f6;
    }


    .users-filters {

        display: flex;
        align-items: center;

        gap: 9px;

        flex-wrap: wrap;
    }


    .users-search {

        width: 260px;
        height: 42px;

        display: flex;
        align-items: center;

        gap: 8px;

        padding: 0 12px;

        background: #f8fafe;

        border: 1px solid #e9edf4;
        border-radius: 12px;
    }


    .users-search svg {

        width: 16px;
        height: 16px;

        color: #99a4b4;
    }


    .users-search input {

        width: 100%;

        border: 0;
        outline: 0;

        background: transparent;

        color: #3b465a;

        font-size: 10.5px;
    }


    .users-filters select {

        height: 42px;

        min-width: 145px;

        padding: 0 11px;

        border: 1px solid #e9edf4;
        border-radius: 12px;

        outline: 0;

        background: #ffffff;

        color: #657185;

        font-size: 10px;
    }


    .filter-button,
    .reset-button {

        height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;

        padding: 0 13px;

        border-radius: 12px;

        font-size: 10px;
        font-weight: 800;
    }


    .filter-button {

        border: 0;

        background: #5b7cff;

        color: #ffffff;

        cursor: pointer;
    }


    .reset-button {

        border: 1px solid #e8edf5;

        background: #ffffff;

        color: #728095;
    }


    .filter-button svg,
    .reset-button svg {

        width: 15px;
        height: 15px;
    }


    /* TABLE */

    .users-table-wrapper {

        overflow-x: auto;
    }


    .users-table {

        width: 100%;

        border-collapse: collapse;
    }


    .users-table th {

        padding: 13px 17px;

        background: #fafbfe;

        color: #909aaa;

        text-align: right;

        white-space: nowrap;

        font-size: 9px;
        font-weight: 800;
    }


    .users-table td {

        padding: 14px 17px;

        border-top: 1px solid #f0f3f7;

        color: #657185;

        white-space: nowrap;

        font-size: 10px;
    }


    .users-table tbody tr {

        transition: .2s;
    }


    .users-table tbody tr:hover {

        background: #fcfdff;
    }


    /* USER */

    .user-cell {

        display: flex;
        align-items: center;

        gap: 10px;
    }


    .user-avatar {

        width: 40px;
        height: 40px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        overflow: hidden;

        border-radius: 13px;

        background:
            linear-gradient(
                135deg,
                #edf2ff,
                #f3efff
            );

        color: #5a70d4;

        font-weight: 900;
    }


    .user-avatar img {

        width: 100%;
        height: 100%;

        object-fit: cover;
    }


    .user-cell-info strong {

        display: block;

        margin-bottom: 3px;

        color: #364156;

        font-size: 10.5px;
        font-weight: 800;
    }


    .user-cell-info span {

        color: #a1aab7;

        font-size: 8px;
    }


    .user-email,
    .user-date {

        color: #687488;
    }


    /* STATUS */

    .status-badge {

        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding: 5px 8px;

        border-radius: 20px;

        font-size: 8.5px;
        font-weight: 800;
    }


    .status-badge span {

        width: 6px;
        height: 6px;

        border-radius: 50%;

        background: currentColor;
    }


    .status-badge.active {

        background: #eaf8f2;

        color: #248b68;
    }


    .status-badge.inactive {

        background: #fff0f1;

        color: #d6535b;
    }


    /* APPROVAL */

    .approval-badge {

        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding: 5px 8px;

        border-radius: 20px;

        font-size: 8.5px;
        font-weight: 800;
    }


    .approval-badge svg {

        width: 12px;
        height: 12px;
    }


    .approval-badge.approved {

        background: #edf8f3;

        color: #238b67;
    }


    .approval-badge.pending {

        background: #fff6e8;

        color: #c98225;
    }


    .approval-badge.rejected {

        background: #fff0f1;

        color: #d6545d;
    }


    /* ACTIONS */

    .user-actions {

        display: flex;
        align-items: center;

        gap: 6px;
    }


    .user-actions form {

        margin: 0;
    }


    .action-button {

        width: 32px;
        height: 32px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 0;
        border-radius: 9px;

        cursor: pointer;

        transition: .2s;
    }


    .action-button svg {

        width: 14px;
        height: 14px;
    }


    .action-button.view {

        background: #edf2ff;

        color: #5872d9;
    }


    .action-button.activate {

        background: #eaf8f2;

        color: #248b68;
    }


    .action-button.deactivate {

        background: #fff6e8;

        color: #c98225;
    }


    .action-button.delete {

        background: #fff0f1;

        color: #d6545d;
    }


    .action-button:hover {

        transform: translateY(-2px);
    }


    /* PAGINATION */

    .users-pagination {

        padding: 16px 20px;

        border-top: 1px solid #edf1f6;
    }


    /* EMPTY */

    .users-empty {

        min-height: 360px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        padding: 30px;

        text-align: center;
    }


    .users-empty-icon {

        width: 68px;
        height: 68px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 15px;

        border-radius: 21px;

        background:
            linear-gradient(
                135deg,
                #edf2ff,
                #f3efff
            );

        color: #6077d9;
    }


    .users-empty-icon svg {

        width: 28px;
        height: 28px;
    }


    .users-empty h2 {

        margin-bottom: 7px;

        color: #374257;

        font-size: 14px;
        font-weight: 900;
    }


    .users-empty p {

        margin-bottom: 16px;

        color: #929dac;

        font-size: 10px;
    }


    .users-empty a {

        padding: 8px 12px;

        border-radius: 10px;

        background: #edf2ff;

        color: #536ed2;

        font-size: 9px;
        font-weight: 800;
    }


    @media (max-width: 800px) {

        .users-summary {

            width: 100%;

            flex-wrap: wrap;
        }


        .users-summary-item {

            flex: 1;
        }


        .users-search {

            width: 100%;
        }


        .users-filters select {

            flex: 1;
        }

    }

</style>

@endpush