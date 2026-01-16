<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Search</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8 p-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900">Find Your Perfect Stay</h2>
            <p class="mt-2 text-gray-600">Search hotels by destination</p>
        </div>
        
        <form method="GET" action="{{ route('results') }}" class="mt-8 space-y-6">
            <div>
                <input 
                    type="text" 
                    name="query" 
                    required 
                    placeholder="Search destination (e.g., Paris)"
                    class="appearance-none rounded-lg relative block w-full px-3 py-4 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            
            <button 
                type="submit"
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Search Hotels
            </button>
        </form>
    </div>
</body>
</html>