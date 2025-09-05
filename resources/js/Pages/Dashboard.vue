<template>
  <AppLayout>
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-white">Welcome back, {{ $page.props.auth.user.name }}!</h1>
            <p class="text-blue-100 mt-1">Manage your listings and account</p>
          </div>
          <Link 
            href="/listings/create"
            class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200 flex items-center"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create Listing
          </Link>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Listings</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.total_listings }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Active Listings</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.active_listings }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pending Review</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.pending_listings }}</p>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Favorites</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.favorites_count }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Listings -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Your Recent Listings</h2>
            <Link href="/listings/create" class="text-blue-600 hover:text-blue-500 font-medium">
              Create New
            </Link>
          </div>
        </div>

        <div v-if="recentListings.length > 0" class="divide-y divide-gray-200">
          <div 
            v-for="listing in recentListings" 
            :key="listing.id"
            class="p-6 hover:bg-gray-50 transition-colors duration-200"
          >
            <div class="flex items-center space-x-4">
              <img 
                :src="listing.image || '/api/placeholder/80/80'" 
                :alt="listing.title"
                class="w-16 h-16 rounded-lg object-cover"
              >
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                  <h3 class="text-lg font-medium text-gray-900 truncate">{{ listing.title }}</h3>
                  <div class="flex items-center space-x-2">
                    <span 
                      :class="[
                        'px-2 py-1 text-xs font-semibold rounded-full',
                        listing.status === 'approved' ? 'bg-green-100 text-green-800' :
                        listing.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                        'bg-red-100 text-red-800'
                      ]"
                    >
                      {{ listing.status.charAt(0).toUpperCase() + listing.status.slice(1) }}
                    </span>
                  </div>
                </div>
                <div class="flex items-center mt-1 text-sm text-gray-500">
                  <span class="font-medium text-green-600">${{ listing.price.toLocaleString() }}</span>
                  <span class="mx-2">•</span>
                  <span>{{ listing.category.name }}</span>
                  <span class="mx-2">•</span>
                  <span>{{ formatDate(listing.created_at) }}</span>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <Link 
                  :href="`/listings/${listing.id}`"
                  class="text-blue-600 hover:text-blue-500 font-medium"
                >
                  View
                </Link>
                <Link 
                  :href="`/listings/${listing.id}/edit`"
                  class="text-gray-600 hover:text-gray-500 font-medium"
                >
                  Edit
                </Link>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="p-12 text-center">
          <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
          <h3 class="text-lg font-medium text-gray-900 mb-2">No listings yet</h3>
          <p class="text-gray-600 mb-4">Create your first listing to start selling.</p>
          <Link 
            href="/listings/create"
            class="btn-primary"
          >
            Create Your First Listing
          </Link>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 ml-3">Messages</h3>
          </div>
          <p class="text-gray-600 mb-4">Check your messages from potential buyers.</p>
          <Link href="/messages" class="text-blue-600 hover:text-blue-500 font-medium">
            View Messages →
          </Link>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 ml-3">Favorites</h3>
          </div>
          <p class="text-gray-600 mb-4">View items you've saved for later.</p>
          <Link href="/favorites" class="text-purple-600 hover:text-purple-500 font-medium">
            View Favorites →
          </Link>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 ml-3">Profile</h3>
          </div>
          <p class="text-gray-600 mb-4">Update your profile and account settings.</p>
          <Link href="/profile" class="text-green-600 hover:text-green-500 font-medium">
            Edit Profile →
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  stats: Object,
  recentListings: Array
})

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric',
    year: 'numeric'
  })
}
</script>