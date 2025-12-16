<div id="viewUserModal" class="fixed inset-0 z-[10000] flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-8 relative">
        <h3 class="text-lg font-semibold mb-4 text-gray-900">Detail User</h3>
        <div id="viewUserModalContent">
            <!-- Konten detail user akan di-load via AJAX -->
            <div class="flex justify-center items-center h-32">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
            </div>
        </div>
        <button id="closeViewUserModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
