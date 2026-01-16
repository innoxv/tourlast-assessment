<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels in {{ $query }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hotel-image-scroll {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .hotel-image-scroll::-webkit-scrollbar {
            display: none;
        }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background-color: #f9fafb;
        }

        .hotel-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s;
        }

        .hotel-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .amenity-chip {
            background-color: #eff6ff;
            color: #1d4ed8;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
        }

        .price-strike {
            text-decoration: line-through;
            color: #6b7280;
        }

        .star-filled {
            color: #fbbf24;
        }

        .star-empty {
            color: #d1d5db;
        }

        @media (min-width: 768px) {
            .hotel-card-inner {
                display: flex;
            }
            .hotel-images {
                width: 40%;
            }
            .hotel-info {
                width: 60%;
            }
        }
    </style>
</head>
<body>

    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Header -->
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Hotels in {{ $query }}</h1>
            <p class="text-gray-600 mt-2">
                {{ count($hotels) }} {{ count($hotels) === 1 ? 'property' : 'properties' }} found
            </p>
        </header>

        <!-- Hotel Cards -->
        <div class="space-y-6">
            @forelse($hotels as $hotel)
                <div class="hotel-card"
                     x-data="hotelGallery({
                         images: {{ json_encode($hotel['images']) }},
                         initialFavorite: {{ $hotel['is_favorite'] ? 'true' : 'false' }}
                     })">

                    <div class="hotel-card-inner">

                        <!-- Image Gallery -->
                        <div class="hotel-images relative">
                            <div class="relative h-64 md:h-full">
                                <!-- Main Image -->
                                <img
                                    x-bind:src="images[currentImage]"
                                    alt="{{ $hotel['name'] }}"
                                    class="w-full h-full object-cover"
                                    loading="lazy"
                                >

                                <!-- Navigation Buttons -->
                                <template x-if="images.length > 1">
                                    <div>
                                        <button
                                            @click="prev()"
                                            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-lg"
                                            type="button"
                                            aria-label="Previous image"
                                        >←</button>

                                        <button
                                            @click="next()"
                                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white p-2 rounded-full shadow-lg"
                                            type="button"
                                            aria-label="Next image"
                                        >→</button>
                                    </div>
                                </template>

                                <!-- Image Indicators -->
                                <template x-if="images.length > 1">
                                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                        <template x-for="(img, index) in images" :key="index">
                                            <button
                                                @click="currentImage = index"
                                                class="w-2 h-2 rounded-full transition-colors"
                                                :class="currentImage === index ? 'bg-white' : 'bg-white/50'"
                                                :aria-label="`Image ${index + 1}`"
                                            ></button>
                                        </template>
                                    </div>
                                </template>

                                <!-- Favorite Button -->
                                <button
                                    @click="toggleFavorite()"
                                    class="absolute top-4 right-4 p-2 bg-white/80 hover:bg-white rounded-full shadow-lg transition-colors"
                                    type="button"
                                    aria-label="Toggle favorite"
                                    :aria-pressed="isFavorite"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 transition-colors"
                                        :class="isFavorite ? 'text-red-500 fill-current' : 'text-gray-400'"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Hotel Information -->
                        <div class="hotel-info p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $hotel['name'] }}</h2>
                                    <div class="flex items-center mt-2 space-x-4">
                                        <!-- Star Rating -->
                                        <div class="flex items-center">
                                            @for($i = 0; $i < 5; $i++)
                                                <svg class="w-5 h-5 {{ $i < $hotel['stars'] ? 'star-filled' : 'star-empty' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                            <span class="ml-2 text-gray-600">{{ $hotel['stars'] }} stars</span>
                                        </div>

                                        <span class="text-gray-600">
                                            {{ number_format($hotel['review_count']) }} reviews
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Amenities -->
                            <div class="mt-4">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Top Amenities</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(array_slice($hotel['amenities'] ?? [], 0, 4) as $amenity)
                                        <span class="amenity-chip">{{ $amenity }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="mt-6 flex items-center justify-between">
                                <div>
                                    @if($hotel['offer_price'])
                                        <div class="flex items-baseline space-x-2">
                                            <span class="text-3xl font-bold text-gray-900">
                                                ${{ $hotel['offer_price'] }}
                                            </span>
                                            <span class="text-lg text-gray-500 price-strike">
                                                ${{ $hotel['min_price'] }}
                                            </span>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                Special Offer
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-3xl font-bold text-gray-900">
                                            ${{ $hotel['min_price'] }}
                                        </span>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-1">per night</p>
                                </div>

                                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg transition-colors shadow-md hover:shadow-lg">
                                    Check Availability
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-xl shadow">
                    <h2 class="text-2xl font-semibold text-gray-700">No hotels found</h2>
                    <p class="mt-3 text-gray-600">Try adjusting your search</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine component -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('hotelGallery', ({ images = [], initialFavorite = false }) => ({
                currentImage: 0,
                isFavorite: initialFavorite,
                images: typeof images === 'string' ? JSON.parse(images) : images,

                toggleFavorite() {
                    this.isFavorite = !this.isFavorite;
                    console.log('Favorite toggled for hotel', this.isFavorite);
                },

                next() {
                    this.currentImage = (this.currentImage + 1) % this.images.length;
                },

                prev() {
                    this.currentImage = (this.currentImage - 1 + this.images.length) % this.images.length;
                }
            }));
        });
    </script>

</body>
</html>