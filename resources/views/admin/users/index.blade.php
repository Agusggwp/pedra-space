<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR COMPONENT -->
    @include('components.sidebar')

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden">

        <!-- TOPBAR COMPONENT -->
        @include('components.topbar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">

            <!-- Header Section -->
            <div class="mb-8 mt-20">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">User Management</h1>
                <p class="text-gray-600">Manage users, roles, and permissions in the system</p>
            </div>

            <!-- Search Bar & Add Button -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 mb-8 shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
                    <!-- Search Bar -->
                    <div class="relative flex-1 max-w-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input type="text" placeholder="Search users..." 
                               class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    </div>

                    <!-- Add User Button -->
                    <a href="{{ url('/admin/users/create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-xl flex items-center justify-center gap-2 transition font-medium shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>
                        Add User
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-6 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m15 9-6 6"/>
                        <path d="m9 9 6 6"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- User List Card -->
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-900">User List</h2>
                    </div>
                    <span class="text-sm text-gray-500">{{ $users->count() }} user</span>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Join</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- Name with Avatar -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-600 text-sm">{{ $user->email }}</span>
                                </td>

                                <!-- Role Badge -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                                                <path d="m2 17 10 5 10-5"/>
                                                <path d="m2 12 10 5 10-5"/>
                                            </svg>
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                                <circle cx="9" cy="7" r="4"/>
                                            </svg>
                                            Kasir
                                        </span>
                                    @endif
                                </td>

                                <!-- Join Date -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-gray-600 text-sm">{{ $user->created_at->format('d M Y') }}</span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                        Active
                                    </span>
                                </td>

                                <!-- Action -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button type="button" class="text-gray-400 hover:text-gray-600 transition p-2 rounded-lg hover:bg-gray-100" onclick="toggleMenu(event, {{ $user->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="1"/>
                                            <circle cx="12" cy="5" r="1"/>
                                            <circle cx="12" cy="19" r="1"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 opacity-30">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                        <p class="text-lg font-medium">No users found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                        <!-- Dropdown Menus (outside table) -->
                        @foreach($users as $user)
                        <div id="menu-{{ $user->id }}" class="hidden absolute w-52 bg-white border border-gray-200 rounded-lg shadow-xl z-[9999] py-2" style="position: absolute;">
                            <button type="button" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition view-user-btn" data-userid="{{ $user->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View Details
                            </button>
                            <a href="{{ url('/admin/users/'.$user->id.'/edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                </svg>
                                Edit User
                            </a>
                            <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                Reset Password
                            </a>
                            <div class="border-t border-gray-200 my-1"></div>
                            <form action="{{ url('/admin/users/'.$user->id) }}" method="POST" class="delete-user-form" data-username="{{ $user->name }}">
                                @csrf @method('DELETE')
                                <button type="button" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition delete-user-btn" data-userid="{{ $user->id }}" data-username="{{ $user->name }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                    Delete User
                                </button>
                            </form>
                        </table>

                        <!-- Delete Confirmation Modal -->
                        <div id="deleteUserModal" class="fixed inset-0 z-[10000] flex items-center justify-center bg-black bg-opacity-40 hidden">
                            <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-8 relative">
                                <h3 class="text-lg font-semibold mb-4 text-gray-900">Konfirmasi Hapus User</h3>
                                <p class="mb-6 text-gray-700" id="deleteUserModalText">Apakah anda yakin untuk hapus user ini?</p>
                                <div class="flex justify-end gap-3">
                                    <button id="cancelDeleteUserBtn" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Batal</button>
                                    <button id="confirmDeleteUserBtn" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">Hapus</button>
                                </div>
                                <button id="closeDeleteUserModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- View User Modal (Partial) -->
                        @include('admin.users.view-modal')
                        </div>
                        @endforeach
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between bg-gray-50">
                    <div class="text-sm text-gray-600">
                        Showing {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} users
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <!-- First Page -->
                        <a href="{{ $users->url(1) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition {{ $users->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}"
                           {{ $users->onFirstPage() ? 'onclick="return false;"' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m11 17-5-5 5-5"/>
                                <path d="m18 17-5-5 5-5"/>
                            </svg>
                        </a>

                        <!-- Previous Page -->
                        <a href="{{ $users->previousPageUrl() }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition {{ $users->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}"
                           {{ $users->onFirstPage() ? 'onclick="return false;"' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6"/>
                            </svg>
                        </a>

                        <!-- Page Number -->
                        <div class="px-4 py-2 text-sm font-medium text-gray-700">
                            {{ $users->currentPage() }} / {{ $users->lastPage() }}
                        </div>

                        <!-- Next Page -->
                        <a href="{{ $users->nextPageUrl() }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition {{ !$users->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}"
                           {{ !$users->hasMorePages() ? 'onclick="return false;"' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                        </a>

                        <!-- Last Page -->
                        <a href="{{ $users->url($users->lastPage()) }}" 
                           class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition {{ !$users->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}"
                           {{ !$users->hasMorePages() ? 'onclick="return false;"' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m13 17 5-5-5-5"/>
                                <path d="m6 17 5-5-5-5"/>
                            </svg>
                        </a>
                    </div>

                    <div class="text-sm text-gray-600">
                        Page {{ $users->currentPage() }} dari {{ $users->lastPage() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function toggleMenu(event, userId) {
    event.stopPropagation();
    const button = event.currentTarget;
    const menu = document.getElementById('menu-' + userId);
    const rect = button.getBoundingClientRect();
    // Close all other menus
    document.querySelectorAll('[id^="menu-"]').forEach(m => {
        if (m.id !== 'menu-' + userId) {
            m.classList.add('hidden');
        }
    });
    // Position menu relative to button
    if (menu.classList.contains('hidden')) {
        const menuWidth = 208; // w-52 = 208px
        const menuHeight = 200; // approximate height
        const padding = 16;
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        // Calculate horizontal position (align to right of button by default)
        let leftPosition = rect.right - menuWidth + window.scrollX;
        // Check if menu overflows right edge
        if (rect.right - menuWidth + 208 > viewportWidth) {
            // Align to left edge of button instead
            leftPosition = rect.left + window.scrollX;
        }
        // Check if still overflows right
        if (leftPosition + menuWidth > viewportWidth + window.scrollX) {
            leftPosition = viewportWidth + window.scrollX - menuWidth - padding;
        }
        // Check if overflows left
        if (leftPosition < window.scrollX + padding) {
            leftPosition = window.scrollX + padding;
        }
        // Calculate vertical position
        let topPosition = rect.bottom + window.scrollY + 8;
        // Check if menu overflows bottom
        if (rect.bottom + menuHeight > viewportHeight) {
            // Show above button instead
            topPosition = rect.top + window.scrollY - menuHeight - 8;
        }
        menu.style.top = topPosition + 'px';
        menu.style.left = leftPosition + 'px';
    }
    // Toggle current menu
    menu.classList.toggle('hidden');
}

// Close menus when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('button[onclick^="toggleMenu"]') && !event.target.closest('[id^="menu-"]')) {
        document.querySelectorAll('[id^="menu-"]').forEach(m => m.classList.add('hidden'));
    }
});

// Delete User Modal Logic
let deleteUserForm = null;
let deleteUserName = '';
let deleteUserModal = document.getElementById('deleteUserModal');
let deleteUserModalText = document.getElementById('deleteUserModalText');

document.querySelectorAll('.delete-user-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        deleteUserForm = btn.closest('form');
        deleteUserName = btn.getAttribute('data-username') || btn.closest('form').getAttribute('data-username') || '';
        deleteUserModalText.textContent = `Apakah anda yakin untuk hapus user "${deleteUserName}"?`;
        deleteUserModal.classList.remove('hidden');
    });
});

document.getElementById('cancelDeleteUserBtn').onclick = closeDeleteUserModal;
document.getElementById('closeDeleteUserModal').onclick = closeDeleteUserModal;

function closeDeleteUserModal() {
    deleteUserModal.classList.add('hidden');
    deleteUserForm = null;
    deleteUserName = '';
}

document.getElementById('confirmDeleteUserBtn').onclick = function() {
    if (deleteUserForm) {
        deleteUserForm.submit();
        closeDeleteUserModal();
    }
};

// View User Modal Logic
let viewUserModal = document.getElementById('viewUserModal');
let viewUserModalContent = document.getElementById('viewUserModalContent');
if (viewUserModal) {
    document.querySelectorAll('.view-user-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = btn.getAttribute('data-userid');
            viewUserModal.classList.remove('hidden');
            viewUserModalContent.innerHTML = `<div class='flex justify-center items-center h-32'><svg class='animate-spin h-8 w-8 text-blue-600' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'><circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle><path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8v8z'></path></svg></div>`;
            fetch(`/admin/users/${userId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal memuat detail user');
                    return res.text();
                })
                .then(html => {
                    viewUserModalContent.innerHTML = html;
                })
                .catch(() => {
                    viewUserModalContent.innerHTML = '<div class="text-red-600 text-center">Gagal memuat detail user.</div>';
                });
        });
    });
    document.getElementById('closeViewUserModal').onclick = function() {
        viewUserModal.classList.add('hidden');
        viewUserModalContent.innerHTML = '';
    };
}
</script>

</body>
</html>