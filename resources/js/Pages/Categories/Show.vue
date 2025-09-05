<template>
  <AppLayout>
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center space-x-4 text-white mb-4">
          <Link href="/categories" class="hover:text-blue-200 transition-colors">Categories</Link>
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
          <span>{{ category.name }}</span>
        </div>
        <h1 class="text-4xl font-bold text-white mb-4">{{ category.name }}</h1>
        <p class="text-xl text-blue-100">{{ category.description || `Browse ${category.name.toLowerCase()} listings` }}</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Subcategories -->
      <div v-if="subcategories.length > 0" class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Subcategories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
          <Link 
            v-for="subcategory in subcategories" 
            :key="subcategory.id"
            :href="`/categories/${subcategory.id}`"
            class="group bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition-all duration-200 hover:-translate-y-1"
          >
            <div class="w-12 h-12 mx-auto mb-3 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <h3 class="font-medium text-gray-900 text-sm mb-1">{{ subcategory.name }}</h3>
            <p class="text-xs text-gray-500">{{ subcategory.listings_count }} items</p>
          </Link>
        </div>
      </div>

      <!-- Filters and Search -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div class="md:col-span-2">
            <input 
              type="text" 
              placeholder="Search in this category..."
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
          </div>
          <div>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              <option value="">Price Range</option>
              <option value="0-1000">$0 - $1,000</option>
              <option value="1000-5000">$1,000 - $5,000</option>
              <option value="5000-10000">$5,000 - $10,000</option>
              <option value="10000+">$10,000+</option>
            </select>
          </div>
          <div>
            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              <option value="latest">Sort by Latest</option>
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
          class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group"
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
            
            <div class="flex items-center justify-between">
              <div class="text-xl font-bold text-green-600">${{ listing.price.toLocaleString() }}</div>
              <Link 
                :href="`/listings/${listing.id}`"
                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
              >
                View
              </Link>
            </div>
            
            <div class="flex items-center mt-3 pt-3 border-t border-gray-100">
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
        <p class="text-gray-600 mb-4">Be the first to list an item in this category!</p>
        <Link 
          href="/listings/create"
          class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
        >
          Create Listing
        </Link>
      </div>

      <!-- Pagination -->
      <div v-if="listings.data.length > 0 && listings.last_page > 1" class="mt-8">
        <nav class="flex items-center justify-between">
          <div class="flex-1 flex justify-between sm:hidden">
            <Link 
              v-if="listings.prev_page_url"
              :href="listings.prev_page_url"
              class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Previous
            </Link>
            <Link 
              v-if="listings.next_page_url"
              :href="listings.next_page_url"
              class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
            >
              Next
            </Link>
          </div>
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing {{ listings.from }} to {{ listings.to }} of {{ listings.total }} results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <Link 
                  v-if="listings.prev_page_url"
                  :href="listings.prev_page_url"
                  class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                >
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                  </svg>
                </Link>
                
                <template v-for="page in getPageNumbers()" :key="page">
                  <Link 
                    v-if="page !== '...'"
                    :href="`${listings.path}?page=${page}`"
                    :class="[
                      'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                      page === listings.current_page 
                        ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' 
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                    ]"
                  >
                    {{ page }}
                  </Link>
                  <span v-else class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                  </span>
                </template>
                
                <Link 
                  v-if="listings.next_page_url"
                  :href="listings.next_page_url"
                  class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                >
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </Link>
              </nav>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  category: Object,
  listings: Object,
  subcategories: Array
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
  // Simple pagination logic - you can enhance this
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