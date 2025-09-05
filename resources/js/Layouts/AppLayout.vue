<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <!-- Logo -->
            <Link href="/" class="flex-shrink-0 flex items-center">
              <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                  </svg>
                </div>
                <span class="text-2xl font-bold text-gray-900">
                  ManCycle
                </span>
              </div>
            </Link>

            <!-- Navigation Links -->
            <div class="hidden md:ml-10 md:flex md:space-x-8">
              <Link 
                href="/" 
                :class="[
                  'inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors duration-200',
                  $page.component === 'Home' 
                    ? 'text-orange-600 border-b-2 border-orange-600' 
                    : 'text-gray-700 hover:text-orange-600 hover:border-orange-300'
                ]"
              >
                Home
              </Link>
              <Link 
                href="/categories" 
                :class="[
                  'inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors duration-200',
                  $page.component.startsWith('Categories') 
                    ? 'text-orange-600 border-b-2 border-orange-600' 
                    : 'text-gray-700 hover:text-orange-600 hover:border-orange-300'
                ]"
              >
                Motorcycles
              </Link>
              <Link 
                href="/listings" 
                :class="[
                  'inline-flex items-center px-1 pt-1 text-sm font-medium transition-colors duration-200',
                  $page.component.startsWith('Listings') 
                    ? 'text-orange-600 border-b-2 border-orange-600' 
                    : 'text-gray-700 hover:text-orange-600 hover:border-orange-300'
                ]"
              >
                Browse All
              </Link>
              <Link 
                href="/dealers" 
                class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors duration-200"
              >
                Dealers
              </Link>
            </div>
          </div>

          <!-- Right side -->
          <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="hidden md:block">
              <div class="relative">
                <input 
                  type="text" 
                  placeholder="Search motorcycles, cars..." 
                  class="w-80 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- User Menu -->
            <div v-if="$page.props.auth.user" class="relative" ref="userMenu">
              <button 
                @click="showUserMenu = !showUserMenu"
                class="flex items-center space-x-2 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                  <span class="text-white font-medium">{{ $page.props.auth.user.name.charAt(0) }}</span>
                </div>
                <span class="hidden md:block text-gray-700 font-medium">{{ $page.props.auth.user.name }}</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>

              <!-- Dropdown Menu -->
              <div 
                v-show="showUserMenu"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
              >
                <Link href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Dashboard
                </Link>
                <Link href="/favorites" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  My Favorites
                </Link>
                <Link href="/messages" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Messages
                </Link>
                <div v-if="$page.props.auth.user.role === 'admin'" class="border-t border-gray-100">
                  <Link href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Admin Panel
                  </Link>
                </div>
                <div class="border-t border-gray-100">
                  <Link href="/logout" method="post" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Sign out
                  </Link>
                </div>
              </div>
            </div>

            <!-- Guest Links -->
            <div v-else class="flex items-center space-x-4">
              <Link href="/login" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                Sign in
              </Link>
              <Link 
                href="/register" 
                class="bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-700 transition-all duration-200"
              >
                Sign up
              </Link>
            </div>

            <!-- Mobile menu button -->
            <button 
              @click="showMobileMenu = !showMobileMenu"
              class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
            >
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path v-if="!showMobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <div v-show="showMobileMenu" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
          <Link href="/" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
            Home
          </Link>
          <Link href="/categories" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
            Categories
          </Link>
          <Link href="/listings" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
            Browse
          </Link>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
      <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div class="col-span-1 md:col-span-2">
            <div class="flex items-center space-x-2 mb-4">
              <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
              </div>
              <span class="text-xl font-bold">ManCycle</span>
            </div>
            <p class="text-gray-400 mb-4">
              Your trusted marketplace for cars, motorcycles, and second-hand products. 
              Find your perfect ride or sell with confidence.
            </p>
          </div>
          
          <div>
            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-4">Quick Links</h3>
            <ul class="space-y-2">
              <li><Link href="/categories" class="text-gray-400 hover:text-white transition-colors">Categories</Link></li>
              <li><Link href="/listings" class="text-gray-400 hover:text-white transition-colors">Browse Listings</Link></li>
              <li><Link href="/help" class="text-gray-400 hover:text-white transition-colors">Help Center</Link></li>
            </ul>
          </div>
          
          <div>
            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase mb-4">Legal</h3>
            <ul class="space-y-2">
              <li><Link href="/privacy" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</Link></li>
              <li><Link href="/terms" class="text-gray-400 hover:text-white transition-colors">Terms of Service</Link></li>
              <li><Link href="/contact" class="text-gray-400 hover:text-white transition-colors">Contact Us</Link></li>
            </ul>
          </div>
        </div>
        
        <div class="mt-8 pt-8 border-t border-gray-800">
          <p class="text-center text-gray-400">
            © {{ new Date().getFullYear() }} ManCycle. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const showUserMenu = ref(false)
const showMobileMenu = ref(false)
const userMenu = ref(null)

const closeUserMenu = (event) => {
  if (userMenu.value && !userMenu.value.contains(event.target)) {
    showUserMenu.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', closeUserMenu)
})

onUnmounted(() => {
  document.removeEventListener('click', closeUserMenu)
})
</script>