<template>
  <AppLayout>
    <!-- Hero Section -->
    <section class="relative bg-white overflow-hidden">
      <!-- Background Image -->
      <div class="absolute inset-0">
        <img 
          src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
          alt="Motorcycles" 
          class="w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-black opacity-50"></div>
      </div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
            Find Your Dream
            <span class="text-orange-500">Motorcycle</span>
          </h1>
          <p class="text-xl text-gray-200 mb-8 max-w-3xl mx-auto">
            Browse thousands of motorcycles, cars, and vehicles from trusted dealers and private sellers across the country.
          </p>
          
          <!-- Search Bar -->
          <div class="max-w-5xl mx-auto mb-8">
            <div class="bg-white rounded-xl shadow-2xl p-6">
              <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                  <input 
                    type="text" 
                    placeholder="Enter make, model, or keyword..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                  >
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                  <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                  <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Any Price</option>
                    <option value="0-5000">Under $5,000</option>
                    <option value="5000-15000">$5,000 - $15,000</option>
                    <option value="15000-30000">$15,000 - $30,000</option>
                    <option value="30000+">$30,000+</option>
                  </select>
                </div>
                <div class="flex items-end">
                  <button class="w-full bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-all duration-200 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Stats -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="text-center">
              <div class="text-3xl font-bold text-white mb-2">{{ stats.total_listings }}+</div>
              <div class="text-blue-200">Active Listings</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-white mb-2">{{ stats.total_users }}+</div>
              <div class="text-blue-200">Happy Users</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-white mb-2">{{ categories.length }}+</div>
              <div class="text-blue-200">Categories</div>
            </div>
            <div class="text-center">
              <div class="text-3xl font-bold text-white mb-2">24/7</div>
              <div class="text-blue-200">Support</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Shop by Category</h2>
          <p class="text-lg text-gray-600">Find the perfect vehicle for your needs</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
          <Link 
            v-for="category in categories" 
            :key="category.id"
            :href="`/categories/${category.id}`"
            class="group bg-white rounded-xl p-6 text-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200"
          >
            <div class="w-16 h-16 mx-auto mb-4 bg-orange-100 rounded-full flex items-center justify-center group-hover:bg-orange-200 transition-colors duration-300">
              <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">{{ category.name }}</h3>
            <p class="text-sm text-gray-600">{{ category.listings_count }} vehicles</p>
          </Link>
        </div>
      </div>
    </section>

    <!-- Featured Listings -->
    <section class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Listings</h2>
          <p class="text-lg text-gray-600">Handpicked deals you don't want to miss</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div 
            v-for="listing in featuredListings" 
            :key="listing.id"
            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 group"
          >
            <div class="relative">
              <img 
                :src="listing.image || '/api/placeholder/400/250'" 
                :alt="listing.title"
                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
              >
              <div class="absolute top-4 left-4">
                <span class="bg-gradient-to-r from-green-500 to-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                  Featured
                </span>
              </div>
              <div class="absolute top-4 right-4">
                <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-red-50 transition-colors">
                  <svg class="w-4 h-4 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                  </svg>
                </button>
              </div>
            </div>
            
            <div class="p-6">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-blue-600 font-medium">{{ listing.category.name }}</span>
                <span class="text-sm text-gray-500">{{ listing.location }}</span>
              </div>
              
              <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ listing.title }}</h3>
              <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ listing.description }}</p>
              
              <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-green-600">${{ listing.price.toLocaleString() }}</div>
                <Link 
                  :href="`/listings/${listing.id}`"
                  class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
                >
                  View Details
                </Link>
              </div>
            </div>
          </div>
        </div>
        
        <div class="text-center mt-12">
          <Link 
            href="/listings"
            class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
          >
            View All Listings
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
            </svg>
          </Link>
        </div>
      </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
          <p class="text-lg text-gray-600">Simple steps to find your perfect match</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
              <span class="text-2xl font-bold text-white">1</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Browse & Search</h3>
            <p class="text-gray-600">Explore thousands of listings or use our advanced search to find exactly what you need.</p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
              <span class="text-2xl font-bold text-white">2</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Connect & Chat</h3>
            <p class="text-gray-600">Message sellers directly through our secure platform to ask questions and negotiate.</p>
          </div>
          
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-6 bg-gradient-to-r from-pink-500 to-red-500 rounded-full flex items-center justify-center">
              <span class="text-2xl font-bold text-white">3</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Buy with Confidence</h3>
            <p class="text-gray-600">Complete your purchase safely with our trusted payment system and buyer protection.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600">
      <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Selling?</h2>
        <p class="text-xl text-blue-100 mb-8">Join thousands of sellers and turn your items into cash today.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Link 
            href="/register"
            class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200"
          >
            Get Started Free
          </Link>
          <Link 
            href="/help"
            class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-all duration-200"
          >
            Learn More
          </Link>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  categories: Array,
  featuredListings: Array,
  stats: Object
})
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>