<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Retrieval Search Engine</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function highlightQuery(text, query) {
            if (!query.trim()) return text;
            
            const regex = new RegExp(`(${query.trim().split(/\s+/).join('|')})`, 'gi');
            return text.replace(regex, '<mark class="bg-yellow-300 font-semibold">$1</mark>');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const highlightElements = document.querySelectorAll('[data-highlight]');
            const query = document.querySelector('[data-search-query]')?.getAttribute('data-search-query') || '';
            
            highlightElements.forEach(element => {
                const originalText = element.textContent;
                element.innerHTML = highlightQuery(originalText, query);
            });
        });
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <h1 class="text-4xl font-bold text-gray-900 text-center mb-2">
                IR Search Engine
            </h1>
            <p class="text-center text-gray-600">Information Retrieval System powered by Laravel & PostgreSQL</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-6 py-12" data-search-query="{{ $query }}">
        
        <!-- Search Form -->
        <div class="mb-12">
            <form method="GET" action="{{ route('search') }}" class="flex gap-2">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $query }}" 
                    placeholder="Cari dokumen (Python, Laravel, Docker, Information Retrieval, Keamanan Jaringan...)" 
                    class="flex-1 px-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    autocomplete="off"
                >
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Cari
                </button>
            </form>
        </div>

        <!-- Search Statistics -->
        @if($query)
            <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-gray-700">
                    <span class="font-semibold">Hasil Pencarian:</span> 
                    <span class="text-blue-600 font-bold">{{ $totalFound }}</span> dokumen ditemukan 
                    <span class="text-gray-500">({{ $retrievalTime }} ms)</span>
                </p>
            </div>
        @endif

        <!-- Search Results -->
        @if($query)
            @if($totalFound > 0)
                <div class="space-y-6">
                    @foreach($documents as $doc)
                        <div class="bg-white rounded-lg shadow hover:shadow-md transition duration-200 p-6 border-l-4 border-blue-500">
                            <!-- Document Title -->
                            <h2 class="text-xl font-bold text-gray-900 mb-3">
                                <a href="#" class="text-blue-600 hover:text-blue-800">
                                    <span data-highlight>{{ $doc['title'] }}</span>
                                </a>
                            </h2>

                            <!-- Document Content Preview -->
                            <p class="text-gray-700 leading-relaxed mb-4 line-clamp-3">
                                <span data-highlight>{{ $doc['content'] }}</span>
                            </p>

                            <!-- Document Meta -->
                            <div class="text-sm text-gray-500 flex gap-4">
                                <span>📄 ID: {{ $doc['id'] }}</span>
                                <span>📅 {{ \Carbon\Carbon::parse($doc['created_at'])->format('d M Y H:i') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg mb-2">Tidak ada dokumen yang sesuai dengan pencarian Anda.</p>
                    <p class="text-gray-400">Coba gunakan kata kunci lain atau periksa kembali ejaan Anda.</p>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Masukkan kata kunci di atas untuk memulai pencarian</p>
                <p class="text-gray-400 mt-2">Total dokumen tersedia dalam sistem</p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 border-t border-gray-200 mt-16">
        <div class="max-w-4xl mx-auto px-6 py-8 text-center">
            <p class="text-gray-600">
                <span class="font-semibold">Information Retrieval System</span> | 
                Dibangun dengan Laravel, PostgreSQL & Tailwind CSS
            </p>
        </div>
    </footer>
</body>
</html>
