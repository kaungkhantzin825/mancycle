<template>
  <VuetifyLayout>
    <!-- Header Section -->
    <v-container fluid class="primary py-8">
      <v-container>
        <v-row align="center">
          <v-col cols="12" md="8">
            <h1 class="text-h3 font-weight-bold text-white mb-2">
              Welcome back, {{ $page.props.auth.user.name }}!
            </h1>
            <p class="text-h6 text-white opacity-90">
              Manage your listings and account
            </p>
          </v-col>
          <v-col cols="12" md="4" class="text-md-right">
            <v-btn
              to="/listings/create"
              color="white"
              size="large"
              variant="flat"
              class="text-primary"
            >
              <v-icon left>mdi-plus</v-icon>
              Create Listing
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-container>

    <v-container class="py-8">
      <!-- Stats Cards -->
      <v-row class="mb-8">
        <v-col cols="6" md="3" v-for="stat in statsCards" :key="stat.title">
          <v-card elevation="2" class="pa-4">
            <div class="d-flex align-center">
              <v-avatar :color="stat.color" size="48" class="mr-4">
                <v-icon color="white">{{ stat.icon }}</v-icon>
              </v-avatar>
              <div>
                <p class="text-body-2 text-grey-darken-1 mb-1">{{ stat.title }}</p>
                <h3 class="text-h4 font-weight-bold">{{ stat.value }}</h3>
              </div>
            </div>
          </v-card>
        </v-col>
      </v-row>

      <!-- Recent Listings -->
      <v-card elevation="2" class="mb-8">
        <v-card-title class="d-flex justify-space-between align-center">
          <span class="text-h5">Your Recent Listings</span>
          <v-btn to="/listings/create" color="primary" variant="text">
            Create New
          </v-btn>
        </v-card-title>

        <v-divider></v-divider>

        <div v-if="recentListings.length > 0">
          <v-list>
            <v-list-item
              v-for="listing in recentListings"
              :key="listing.id"
              :to="`/listings/${listing.id}`"
              class="py-4"
            >
              <template v-slot:prepend>
                <v-avatar size="64" rounded="lg">
                  <v-img
                    :src="listing.image || 'https://via.placeholder.com/80x80'"
                    :alt="listing.title"
                  ></v-img>
                </v-avatar>
              </template>

              <v-list-item-title class="text-h6 font-weight-medium mb-1">
                {{ listing.title }}
              </v-list-item-title>
              
              <v-list-item-subtitle class="d-flex align-center">
                <v-chip
                  :color="getStatusColor(listing.status)"
                  size="small"
                  variant="flat"
                  class="mr-2"
                >
                  {{ listing.status.charAt(0).toUpperCase() + listing.status.slice(1) }}
                </v-chip>
                <span class="text-success font-weight-bold mr-2">
                  ${{ listing.price.toLocaleString() }}
                </span>
                <span class="text-grey-darken-1 mr-2">•</span>
                <span class="text-grey-darken-1 mr-2">{{ listing.category.name }}</span>
                <span class="text-grey-darken-1 mr-2">•</span>
                <span class="text-grey-darken-1">{{ formatDate(listing.created_at) }}</span>
              </v-list-item-subtitle>

              <template v-slot:append>
                <div class="d-flex flex-column ga-2">
                  <v-btn
                    :to="`/listings/${listing.id}`"
                    color="primary"
                    variant="text"
                    size="small"
                  >
                    View
                  </v-btn>
                  <v-btn
                    :to="`/listings/${listing.id}/edit`"
                    color="grey"
                    variant="text"
                    size="small"
                  >
                    Edit
                  </v-btn>
                </div>
              </template>
            </v-list-item>
          </v-list>
        </div>

        <div v-else class="text-center py-12">
          <v-icon size="64" color="grey-lighten-1" class="mb-4">mdi-format-list-bulleted</v-icon>
          <h3 class="text-h5 font-weight-medium mb-2">No listings yet</h3>
          <p class="text-body-1 text-grey-darken-1 mb-4">Create your first listing to start selling.</p>
          <v-btn
            to="/listings/create"
            color="primary"
            size="large"
          >
            <v-icon left>mdi-plus</v-icon>
            Create Your First Listing
          </v-btn>
        </div>
      </v-card>

      <!-- Quick Actions -->
      <v-row>
        <v-col cols="12" md="4" v-for="action in quickActions" :key="action.title">
          <v-card elevation="2" class="pa-6 text-center" hover>
            <v-avatar :color="action.color" size="64" class="mb-4">
              <v-icon color="white" size="32">{{ action.icon }}</v-icon>
            </v-avatar>
            <h3 class="text-h6 font-weight-bold mb-3">{{ action.title }}</h3>
            <p class="text-body-1 text-grey-darken-1 mb-4">{{ action.description }}</p>
            <v-btn
              :to="action.link"
              :color="action.color"
              variant="text"
            >
              {{ action.buttonText }}
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </VuetifyLayout>
</template>

<script setup>
import VuetifyLayout from '@/Layouts/VuetifyLayout.vue'

const props = defineProps({
  stats: Object,
  recentListings: Array
})

const statsCards = [
  {
    title: 'Total Listings',
    value: props.stats.total_listings,
    icon: 'mdi-format-list-bulleted',
    color: 'primary'
  },
  {
    title: 'Active Listings',
    value: props.stats.active_listings,
    icon: 'mdi-check-circle',
    color: 'success'
  },
  {
    title: 'Pending Review',
    value: props.stats.pending_listings,
    icon: 'mdi-clock',
    color: 'warning'
  },
  {
    title: 'Favorites',
    value: props.stats.favorites_count,
    icon: 'mdi-heart',
    color: 'error'
  }
]

const quickActions = [
  {
    title: 'Messages',
    description: 'Check your messages from potential buyers.',
    icon: 'mdi-message',
    color: 'primary',
    link: '/messages',
    buttonText: 'View Messages'
  },
  {
    title: 'Favorites',
    description: 'View items you\'ve saved for later.',
    icon: 'mdi-heart',
    color: 'error',
    link: '/favorites',
    buttonText: 'View Favorites'
  },
  {
    title: 'Profile',
    description: 'Update your profile and account settings.',
    icon: 'mdi-account',
    color: 'success',
    link: '/profile',
    buttonText: 'Edit Profile'
  }
]

const getStatusColor = (status) => {
  switch (status) {
    case 'approved': return 'success'
    case 'pending': return 'warning'
    case 'rejected': return 'error'
    default: return 'grey'
  }
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric',
    year: 'numeric'
  })
}
</script>