@if (session('success'))
    <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-md">
        <div class="flex items-center">
            <div class="py-1 mr-3">
                <svg class="h-6 w-6 text-green-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 100 20 10 10 0 000-20zm5.293 7.293l-6 6a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L8.5 11.586l5.293-5.293a1 1 0 111.414 1.414z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if (session('error'))
    <div id="error-alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-md">
        <div class="flex items-center">
            <div class="py-1 mr-3">
                <svg class="h-6 w-6 text-red-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 100 20 10 10 0 000-20zm2 14.59L8.41 11 12 7.41 10.59 6 7 9.59 3.41 6 2 7.41 5.59 11 2 14.59 3.41 16 7 12.41 10.59 16 12 14.59z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

@if (session('warning'))
    <div id="warning-alert" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">تحذير!</strong>
        <span class="block sm:inline">{{ session('warning') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('warning-alert').style.display = 'none';">
            <svg class="fill-current h-6 w-6 text-yellow-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>إغلاق</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
@endif

@if (session('info'))
    <div id="info-alert" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">معلومات!</strong>
        <span class="block sm:inline">{{ session('info') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('info-alert').style.display = 'none';">
            <svg class="fill-current h-6 w-6 text-blue-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>إغلاق</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
@endif

@if ($errors->any())
    <div id="validation-errors" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-md">
        <div class="flex items-center">
            <div class="py-1 mr-3">
                <svg class="h-6 w-6 text-red-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 0a10 10 0 100 20 10 10 0 000-20zm0 18a8 8 0 110-16 8 8 0 010 16zm0-9a1 1 0 00-1 1v4a1 1 0 002 0v-4a1 1 0 00-1-1zm0-4a1 1 0 100 2 1 1 0 000-2z"/>
                </svg>
            </div>
            <div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<script>
    // Auto-hide success and error messages after 5 seconds
    setTimeout(function() {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');
        const validationErrors = document.getElementById('validation-errors');
        
        if (successAlert) {
            successAlert.style.opacity = '0';
            successAlert.style.transition = 'opacity 1s';
            setTimeout(() => successAlert.style.display = 'none', 1000);
        }
        
        if (errorAlert) {
            errorAlert.style.opacity = '0';
            errorAlert.style.transition = 'opacity 1s';
            setTimeout(() => errorAlert.style.display = 'none', 1000);
        }
        
        if (validationErrors) {
            validationErrors.style.opacity = '0';
            validationErrors.style.transition = 'opacity 1s';
            setTimeout(() => validationErrors.style.display = 'none', 1000);
        }
    }, 5000);
</script> 