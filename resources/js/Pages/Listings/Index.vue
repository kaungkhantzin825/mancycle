<template>
  <AppLayout>
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-white mb-4">All Listings</h1>
        <p class="text-xl text-blue-100">Discover amazing deals from trusted sellers</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Filters -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div class="md:col-span-2">
            <input 
              type="text" 
              placeholder="Search listings..."
              class="input-field"
            >
          </div>
          <div>
            <select class="input-field">
              <option value="">All Categories</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>
          <div>
            <select class="input-field">
              <option value="">Price Range</option>
              <option value="0-1000">$0 - $1,000</option>
              <option value="1000-5000">$1,000 - $5,000</option>
              <option value="5000-10000">$5,000 - $10,000</option>
              <option value="10000+">$10,000+</option>
            </select>
          </div>
          <div>
            <select class="input-field">
              <option value="latest">Latest</option>
              <option value="price_low">Price: Low to High</option>
              <option value="price_high">Price: High to Low</option>
              <option value="popular">Most Popular</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Listings Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div 
          v-for="listing in listings.data" 
          :key="listing.id"
          class="card group"
        >
          <div class="relative">
            <img 
              :src="listing.image || '/api/placeholder/300/200'" 
              :alt="listing.title"
              class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
            >
            <div class="absolute top-3 right-3">
              <button class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-md hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4 text-gray-600 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
              </button>
            </div>
            <div v-if="listing.is_featured" class="absolute top-3 left-3">
              <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                Featured
              </span>
            </div>
          </div>
          
          <div class="p-4">
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs text-blue-600 font-medium">{{ listing.category.name }}</span>
              <span class="text-xs text-gray-500">{{ listing.location }}</span>
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ listing.title }}</h3>
            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ listing.description }}</p>
            
            <div class="flex items-center justify-between mb-3">
              <div class="text-xl font-bold text-green-600">${{ listing.price.toLocaleString() }}</div>
              <Link 
                :href="`/listings/${listing.id}`"
                class="btn-primary text-sm px-3 py-1.5"
              >
                View Details
              </Link>
            </div>
            
            <div class="flex items-center pt-3 border-t border-gray-100">
              <div class="w-6 h-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-2">
                <span class="text-white text-xs font-medium">{{ listing.user.name.charAt(0) }}</span>
              </div>
              <span class="text-sm text-gray-600">{{ listing.user.name }}</span>
              <span class="text-xs text-gray-400 ml-auto">{{ formatDate(listing.created_at) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="listings.data.length === 0" class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No listings found</h3>
        <p class="text-gray-600 mb-4">Try adjusting your search criteria or browse categories.</p>
        <Link href="/categories" class="btn-primary">
          Browse Categories
        </Link>
      </div>

      <!-- Pagination -->
      <div v-if="listings.data.length > 0 && listings.last_page > 1" class="mt-8 flex justify-center">
        <nav class="flex items-center space-x-2">
          <Link 
            v-if="listings.prev_page_url"
            :href="listings.prev_page_url"
            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
          >
            Previous
          </Link>
          
          <template v-for="page in getPageNumbers()" :key="page">
            <Link 
              v-if="page !== '...'"
              :href="`${listings.path}?page=${page}`"
              :class="[
                'px-3 py-2 text-sm font-medium border rounded-md',
                page === listings.current_page 
                  ? 'bg-blue-50 border-blue-500 text-blue-600' 
                  : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-50'
              ]"
            >
              {{ page }}
            </Link>
            <span v-else class="px-3 py-2 text-sm font-medium text-gray-500">...</span>
          </template>
          
          <Link 
            v-if="listings.next_page_url"
            :href="listings.next_page_url"
            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
          >
            Next
          </Link>
        </nav>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  listings: Object,
  categories: Array
})

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric',
    year: 'numeric'
  })
}

const getPageNumbers = () => {
  const pages = []
  const current = listings.current_page
  const last = listings.last_page
  
  for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
    pages.push(i)
  }
  
  return pages
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>