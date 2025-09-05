<template>
  <v-app>
    <!-- Navigation Bar -->
    <v-app-bar 
      :elevation="2" 
      color="white" 
      height="70"
      fixed
    >
      <v-container class="d-flex align-center">
        <!-- Logo -->
        <Link href="/" class="text-decoration-none">
          <div class="d-flex align-center">
            <v-avatar color="primary" size="40" class="mr-3">
              <v-icon color="white">mdi-motorcycle</v-icon>
            </v-avatar>
            <div>
              <h2 class="text-h5 font-weight-bold text-primary">ManCycle</h2>
            </div>
          </div>
        </Link>

        <v-spacer></v-spacer>

        <!-- Navigation Links -->
        <v-btn-group variant="text" class="d-none d-md-flex mr-4">
          <v-btn 
            @click="$inertia.visit('/')"
            :color="$page.component === 'HomePage' ? 'primary' : 'grey-darken-1'"
            variant="text"
          >
            Home
          </v-btn>
          <v-btn 
            @click="$inertia.visit('/categories')"
            :color="$page.component.startsWith('Categories') ? 'primary' : 'grey-darken-1'"
            variant="text"
          >
            Motorcycles
          </v-btn>
          <v-btn 
            @click="$inertia.visit('/listings')"
            :color="$page.component.startsWith('Listings') ? 'primary' : 'grey-darken-1'"
            variant="text"
          >
            Browse All
          </v-btn>
          <v-btn 
            @click="$inertia.visit('/dealers')"
            variant="text"
            color="grey-darken-1"
          >
            Dealers
          </v-btn>
        </v-btn-group>

        <!-- Search -->
        <v-text-field
          v-model="searchQuery"
          prepend-inner-icon="mdi-magnify"
          placeholder="Search motorcycles, cars..."
          variant="outlined"
          density="compact"
          hide-details
          class="d-none d-lg-flex mr-4"
          style="max-width: 300px;"
        ></v-text-field>

        <!-- User Menu -->
        <div v-if="$page.props.auth.user">
          <v-menu>
            <template v-slot:activator="{ props }">
              <v-btn
                v-bind="props"
                variant="text"
                class="text-none"
              >
                <v-avatar size="32" class="mr-2">
                  <v-img 
                    v-if="$page.props.auth.user.avatar"
                    :src="$page.props.auth.user.avatar"
                    :alt="$page.props.auth.user.name"
                  ></v-img>
                  <span v-else class="text-h6">{{ $page.props.auth.user.name.charAt(0) }}</span>
                </v-avatar>
                <span class="d-none d-sm-inline">{{ $page.props.auth.user.name }}</span>
                <v-icon>mdi-chevron-down</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item @click="$inertia.visit('/dashboard')">
                <template v-slot:prepend>
                  <v-icon>mdi-view-dashboard</v-icon>
                </template>
                <v-list-item-title>Dashboard</v-list-item-title>
              </v-list-item>
              
              <v-list-item @click="$inertia.visit('/favorites')">
                <template v-slot:prepend>
                  <v-icon>mdi-heart</v-icon>
                </template>
                <v-list-item-title>My Favorites</v-list-item-title>
              </v-list-item>
              
              <v-list-item @click="$inertia.visit('/messages')">
                <template v-slot:prepend>
                  <v-icon>mdi-message</v-icon>
                </template>
                <v-list-item-title>Messages</v-list-item-title>
              </v-list-item>

              <v-divider v-if="$page.props.auth.user.role === 'super_admin'"></v-divider>
              
              <v-list-item 
                v-if="$page.props.auth.user.role === 'super_admin'"
                @click="$inertia.visit('/admin/dashboard')"
              >
                <template v-slot:prepend>
                  <v-icon>mdi-shield-crown</v-icon>
                </template>
                <v-list-item-title>Admin Panel</v-list-item-title>
              </v-list-item>

              <v-divider></v-divider>
              
              <v-list-item @click="logout">
                <template v-slot:prepend>
                  <v-icon>mdi-logout</v-icon>
                </template>
                <v-list-item-title>Sign Out</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </div>

        <!-- Guest Actions -->
        <div v-else class="d-flex align-center">
          <v-btn 
            @click="$inertia.visit('/login')"
            variant="text"
            color="grey-darken-1"
            class="mr-2"
          >
            Sign In
          </v-btn>
          <v-btn 
            @click="$inertia.visit('/register')"
            color="primary"
            variant="flat"
          >
            Sign Up
          </v-btn>
        </div>

        <!-- Mobile Menu -->
        <v-btn
          icon="mdi-menu"
          variant="text"
          class="d-md-none ml-2"
          @click="drawer = !drawer"
        ></v-btn>
      </v-container>
    </v-app-bar>

    <!-- Mobile Navigation Drawer -->
    <v-navigation-drawer
      v-model="drawer"
      temporary
      location="right"
      class="d-md-none"
    >
      <v-list>
        <v-list-item :to="'/'" @click="drawer = false">
          <template v-slot:prepend>
            <v-icon>mdi-home</v-icon>
          </template>
          <v-list-item-title>Home</v-list-item-title>
        </v-list-item>
        
        <v-list-item :to="'/categories'" @click="drawer = false">
          <template v-slot:prepend>
            <v-icon>mdi-motorcycle</v-icon>
          </template>
          <v-list-item-title>Motorcycles</v-list-item-title>
        </v-list-item>
        
        <v-list-item :to="'/listings'" @click="drawer = false">
          <template v-slot:prepend>
            <v-icon>mdi-view-grid</v-icon>
          </template>
          <v-list-item-title>Browse All</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- Main Content -->
    <v-main>
      <slot />
    </v-main>

    <!-- Footer -->
    <v-footer color="grey-darken-4" class="text-white">
      <v-container>
        <v-row>
          <v-col cols="12" md="4">
            <div class="d-flex align-center mb-4">
              <v-avatar color="primary" size="32" class="mr-2">
                <v-icon color="white">mdi-motorcycle</v-icon>
              </v-avatar>
              <h3 class="text-h6 font-weight-bold">ManCycle</h3>
            </div>
            <p class="text-grey-lighten-1">
              Your trusted marketplace for motorcycles, cars, and vehicles. 
              Find your perfect ride or sell with confidence.
            </p>
          </v-col>
          
          <v-col cols="12" md="4">
            <h4 class="text-h6 font-weight-bold mb-3">Quick Links</h4>
            <v-list color="transparent" class="pa-0">
              <v-list-item :to="'/categories'" class="pa-0 mb-1">
                <v-list-item-title class="text-grey-lighten-1">Browse Motorcycles</v-list-item-title>
              </v-list-item>
              <v-list-item :to="'/listings'" class="pa-0 mb-1">
                <v-list-item-title class="text-grey-lighten-1">All Listings</v-list-item-title>
              </v-list-item>
              <v-list-item :to="'/help'" class="pa-0 mb-1">
                <v-list-item-title class="text-grey-lighten-1">Help Center</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-col>
          
          <v-col cols="12" md="4">
            <h4 class="text-h6 font-weight-bold mb-3">Legal</h4>
            <v-list color="transparent" class="pa-0">
              <v-list-item :to="'/privacy'" class="pa-0 mb-1">
                <v-list-item-title class="text-grey-lighten-1">Privacy Policy</v-list-item-title>
              </v-list-item>
              <v-list-item :to="'/terms'" class="pa-0 mb-1">
                <v-list-item-title class="text-grey-lighten-1">Terms of Service</v-list-item-title>
              </v-list-item>
              <v-list-item :to="'/contact'" class="pa-0 mb-1">
                <v-list-item-title class="text-grey-lighten-1">Contact Us</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-col>
        </v-row>
        
        <v-divider class="my-4"></v-divider>
        
        <v-row>
          <v-col cols="12" class="text-center">
            <p class="text-grey-lighten-1 mb-0">
              © {{ new Date().getFullYear() }} ManCycle. All rights reserved.
            </p>
          </v-col>
        </v-row>
      </v-container>
    </v-footer>

    <!-- Snackbar for notifications -->
    <v-snackbar
      v-model="showSnackbar"
      :color="snackbarColor"
      :timeout="4000"
      location="top right"
    >
      {{ snackbarMessage }}
      <template v-slot:actions>
        <v-btn
          variant="text"
          @click="showSnackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script setup>
import { ref, watch } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const drawer = ref(false)
const searchQuery = ref('')
const showSnackbar = ref(false)
const snackbarMessage = ref('')
const snackbarColor = ref('success')

// Watch for flash messages
watch(() => usePage().props.flash, (flash) => {
  if (flash && flash.success) {
    snackbarMessage.value = flash.success
    snackbarColor.value = 'success'
    showSnackbar.value = true
  }
  if (flash && flash.error) {
    snackbarMessage.value = flash.error
    snackbarColor.value = 'error'
    showSnackbar.value = true
  }
}, { deep: true })

const logout = () => {
  router.post('/logout')
}
</script>