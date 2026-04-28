@extends('tyro-dashboard::layouts.admin')
@section('title', 'Roles')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    {{-- Header Section --}}
    <div class="p-6 border-b border-gray-100 flex flex-wrap justify-between items-center bg-white gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">রোলস (Roles)</h2>
            <p class="text-sm text-gray-500">ইউজারদের বিভিন্ন রোল এবং পারমিশন (Privileges) ম্যানেজ করুন</p>
        </div>
        <a href="{{ route($dashboardRoute::name('roles.create')) }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">
            <i class="fa-solid fa-shield-halved mr-2"></i> নতুন রোল
        </a>
    </div>

    {{-- Filters Section --}}
    <div class="p-5 bg-gray-50/50 border-b border-gray-100">
        <form action="{{ route($dashboardRoute::name('roles.index')) }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[250px] max-w-md">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">রোল খুঁজুন</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="রোলের নাম লিখুন..." value="{{ $filters['search'] ?? '' }}">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-xl hover:bg-gray-900 transition-colors">খুঁজুন</button>
                @if(!empty($filters['search']))
                    <a href="{{ route($dashboardRoute::name('roles.index')) }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">মুছুন</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Roles Table --}}
    <div class="p-0">
        @if($roles->count())
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest font-bold border-b border-gray-100">
                        <th class="px-6 py-4">রোলের নাম</th>
                        <th class="px-6 py-4">স্লাগ (Slug)</th>
                        <th class="px-6 py-4 text-center">মোট ইউজার</th>
                        <th class="px-6 py-4 text-center">পারমিশন সংখ্যা</th>
                        <th class="px-6 py-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($roles as $role)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <a href="{{ route($dashboardRoute::name('roles.show'), $role->id) }}" class="flex items-center gap-3 w-max">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white shadow-sm">
                                    <i class="fa-solid fa-crown text-sm"></i>
                                </div>
                                <span class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $role->name }}</span>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <code class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs rounded-md border border-gray-200">{{ $role->slug }}</code>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-full border border-blue-100">{{ $role->users_count }} জন</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full border border-emerald-100">{{ $role->privileges_count }} টি</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route($dashboardRoute::name('roles.show'), $role->id) }}" class="p-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-600 hover:text-white transition-colors" title="বিস্তারিত দেখুন">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route($dashboardRoute::name('roles.edit'), $role->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors" title="এডিট">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                
                                @if(!in_array($role->slug, $protectedRoles))
                                    <form action="{{ route($dashboardRoute::name('roles.destroy'), $role->id) }}" method="POST" class="inline" id="delete-role-form-{{ $role->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="event.preventDefault(); showDanger('রোল ডিলিট', 'আপনি কি নিশ্চিত? এই রোলের অধীনে থাকা সকল ইউজার তাদের পারমিশন হারাবে।').then(c => { if(c) document.getElementById('delete-role-form-{{ $role->id }}').submit(); })" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors" title="ডিলিট">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="p-2 bg-gray-100 text-gray-300 rounded-lg cursor-not-allowed" title="এটি প্রোটেক্টেড রোল, ডিলিট করা যাবে না">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($roles->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $roles->links('pagination::tailwind') }}
        </div>
        @endif
        @else
        <div class="px-6 py-20 text-center">
            <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h3 class="text-gray-800 font-bold text-lg">কোনো রোল পাওয়া যায়নি</h3>
            <p class="text-gray-500 text-sm mt-1">শুরু করতে নতুন একটি রোল (Role) তৈরি করুন।</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput && searchInput.value) {
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        }
    });
</script>
@endpush
@endsection