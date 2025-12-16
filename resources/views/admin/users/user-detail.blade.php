<div class="flex flex-col gap-4">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <div class="text-lg font-semibold text-gray-900">{{ $user->name }}</div>
            <div class="text-sm text-gray-500">{{ $user->email }}</div>
        </div>
    </div>
    <div class="flex flex-col gap-2 mt-2">
        <div class="flex items-center gap-2">
            <span class="font-medium text-gray-700 w-24">Role</span>
            @if($user->role === 'admin')
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">Admin</span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">Kasir</span>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <span class="font-medium text-gray-700 w-24">Bergabung</span>
            <span class="text-sm text-gray-700">{{ $user->created_at->format('d M Y') }}</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="font-medium text-gray-700 w-24">Status</span>
            <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">Active</span>
        </div>
    </div>
</div>
