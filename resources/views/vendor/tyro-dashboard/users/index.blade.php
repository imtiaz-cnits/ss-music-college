@extends('tyro-dashboard::layouts.admin')
@section('title', 'Users')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    {{-- Header Section --}}
    <div class="p-6 border-b border-gray-100 flex flex-wrap justify-between items-center bg-white gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">ইউজার ম্যানেজমেন্ট</h2>
            <p class="text-sm text-gray-500">অ্যাডমিন, শিক্ষক এবং সাধারণ ইউজারদের অ্যাকাউন্ট নিয়ন্ত্রণ করুন</p>
        </div>
        <a href="{{ route($dashboardRoute::name('users.create')) }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">
            <i class="fa-solid fa-user-plus mr-2"></i> নতুন ইউজার
        </a>
    </div>

    {{-- Filters Section --}}
    <div class="p-5 bg-gray-50/50 border-b border-gray-100">
        <form action="{{ route($dashboardRoute::name('users.index')) }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">সার্চ করুন</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" class="w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="নাম বা ইমেইল..." value="{{ $filters['search'] ?? '' }}">
                </div>
            </div>
            <div class="w-48">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">রোল (Role)</label>
                <select name="role" class="w-full py-2.5 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">সকল রোল</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->slug }}" {{ ($filters['role'] ?? '') === $role->slug ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-40">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">স্ট্যাটাস</label>
                <select name="status" class="w-full py-2.5 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">সকল স্ট্যাটাস</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ ($filters['status'] ?? '') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-xl hover:bg-gray-900 transition-colors">ফিল্টার</button>
                @if(!empty($filters['search']) || !empty($filters['role']) || !empty($filters['status']))
                    <a href="{{ route($dashboardRoute::name('users.index')) }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">মুছুন</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="p-0">
        @if($users->count())
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest font-bold border-b border-gray-100">
                        <th class="px-6 py-4">ইউজার</th>
                        <th class="px-6 py-4">রোলস</th>
                        <th class="px-6 py-4">স্ট্যাটাস</th>
                        <th class="px-6 py-4">যোগদানের তারিখ</th>
                        <th class="px-6 py-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $listUser)
                    <tr class="hover:bg-indigo-50/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold overflow-hidden border border-indigo-200">
                                    @if($listUser->profile_photo_path || ($listUser->use_gravatar && $listUser->email))
                                        <img src="{{ $listUser->profile_photo_url }}" alt="{{ $listUser->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($listUser->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">{{ $listUser->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $listUser->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($listUser->roles as $role)
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-[11px] font-bold rounded-md border border-blue-100">{{ $role->name }}</span>
                                @empty
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 text-[11px] rounded-md">No roles</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $isSuspended = false;
                                if (method_exists($listUser, 'isSuspended')) {
                                    $isSuspended = $listUser->isSuspended();
                                } elseif (isset($listUser->suspended_at) && !is_null($listUser->suspended_at)) {
                                    $isSuspended = true;
                                }
                            @endphp

                            @if($isSuspended)
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-full flex items-center w-max">
                                    <i class="fa-solid fa-ban mr-1"></i> Suspended
                                </span>
                            @else
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full flex items-center w-max">
                                    <i class="fa-regular fa-circle-check mr-1"></i> Active
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                            {{ $listUser->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route($dashboardRoute::name('users.edit'), $listUser->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors" title="এডিট">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                
                                @if($listUser->id !== $user->id)
                                    <form action="{{ route($dashboardRoute::name('users.login-as'), $listUser->id) }}" method="POST" class="inline" id="login-as-form-{{ $listUser->id }}">
                                        @csrf
                                        <button type="button" onclick="event.preventDefault(); showConfirm('লগিন অ্যাজ', 'আপনি কি {{ addslashes($listUser->name) }} হিসেবে লগিন করতে চান?').then(c => { if(c) document.getElementById('login-as-form-{{ $listUser->id }}').submit(); })" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors" title="এই ইউজার হয়ে লগিন করুন">
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </button>
                                    </form>
                                @endif

                                @if($isSuspended)
                                    <form action="{{ route($dashboardRoute::name('users.unsuspend'), $listUser->id) }}" method="POST" class="inline" id="unsuspend-form-{{ $listUser->id }}">
                                        @csrf
                                        <button type="button" onclick="event.preventDefault(); showConfirm('আন-সাসপেন্ড', 'এই ইউজারকে আবার একটিভ করতে চান?').then(c => { if(c) document.getElementById('unsuspend-form-{{ $listUser->id }}').submit(); })" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors" title="আন-সাসপেন্ড">
                                            <i class="fa-solid fa-unlock"></i>
                                        </button>
                                    </form>
                                @elseif(method_exists($listUser, 'suspend'))
                                    <button type="button" onclick="openSuspendModal({{ $listUser->id }}, '{{ addslashes($listUser->name) }}')" class="p-2 bg-orange-50 text-orange-600 rounded-lg hover:bg-orange-600 hover:text-white transition-colors" title="সাসপেন্ড করুন">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                @endif

                                @if($listUser->id !== $user->id)
                                    <form action="{{ route($dashboardRoute::name('users.destroy'), $listUser->id) }}" method="POST" class="inline" id="delete-user-form-{{ $listUser->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="event.preventDefault(); showDanger('ইউজার ডিলিট', 'আপনি কি নিশ্চিত? এটি আর ফেরত আনা যাবে না।').then(c => { if(c) document.getElementById('delete-user-form-{{ $listUser->id }}').submit(); })" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors" title="ডিলিট">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $users->links('pagination::tailwind') }}
        </div>
        @endif
        @else
        <div class="px-6 py-20 text-center">
            <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                <i class="fa-solid fa-users-slash"></i>
            </div>
            <h3 class="text-gray-800 font-bold text-lg">কোনো ইউজার পাওয়া যায়নি</h3>
            <p class="text-gray-500 text-sm mt-1">শুরু করতে নতুন একটি ইউজার অ্যাকাউন্ট তৈরি করুন।</p>
        </div>
        @endif
    </div>
</div>

<div class="modal-overlay hidden fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center backdrop-blur-sm transition-all" id="suspendModal">
    <div class="modal bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden transform scale-100 transition-transform">
        <div class="modal-header p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">অ্যাকাউন্ট সাসপেন্ড</h3>
            <button type="button" class="text-gray-400 hover:text-red-500 transition-colors" onclick="closeModal('suspendModal')">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <form id="suspendForm" method="POST">
            @csrf
            <div class="modal-body p-6">
                <div class="mb-4 p-3 bg-orange-50 border border-orange-100 rounded-lg text-sm text-orange-800">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> আপনি <strong id="suspendUserName" class="font-bold"></strong>-কে সাসপেন্ড করতে যাচ্ছেন।
                </div>
                <div class="form-group">
                    <label for="reason" class="block text-sm font-semibold text-gray-700 mb-2">
                        সাসপেন্ড করার কারণ <span class="text-gray-400 font-normal">(ঐচ্ছিক)</span>
                    </label>
                    <textarea id="reason" name="reason" class="w-full border-gray-300 rounded-xl focus:ring-red-500 focus:border-red-500 sm:text-sm p-3" rows="3" placeholder="এখানে কারণ লিখুন..."></textarea>
                </div>
            </div>
            <div class="modal-footer p-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50">
                <button type="button" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-colors" onclick="closeModal('suspendModal')">বাতিল</button>
                <button type="submit" class="px-5 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition-colors shadow-lg shadow-red-200">সাসপেন্ড করুন</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openSuspendModal(userId, userName) {
        document.getElementById('suspendForm').action = '{{ url(config('tyro-dashboard.route_prefix', 'dashboard')) }}/users/' + userId + '/suspend';
        document.getElementById('suspendUserName').textContent = userName;
        document.getElementById('reason').value = '';
        
        // Show modal Tailwind way
        const modal = document.getElementById('suspendModal');
        modal.classList.remove('hidden');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

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