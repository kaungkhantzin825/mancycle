<template>
  <VuetifyLayout>
    <!-- Hero Section -->
    <v-container fluid class="pa-0">
      <v-row no-gutters>
        <v-col cols="12">
          <div class="hero-section position-relative">
            <v-img
              src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
              height="600"
              cover
              class="hero-image"
            >
              <div class="hero-overlay"></div>
              <v-container class="hero-content">
                <v-row justify="center" align="center" class="fill-height">
                  <v-col cols="12" md="10" lg="8">
                    <div class="text-center text-white">
                      <h1 class="text-h2 text-md-h1 font-weight-bold mb-4">
                        Find Your Dream
                        <span class="text-primary">Motorcycle</span>
                      </h1>
                      <p class="text-h6 text-md-h5 mb-8 text-grey-lighten-2">
                        Browse thousands of motorcycles, cars, and vehicles from trusted dealers and private sellers
                      </p>
                      
                      <!-- Search Card -->
                      <v-card class="search-card mx-auto" max-width="800" elevation="8">
                        <v-card-text class="pa-6">
                          <v-row>
                            <v-col cols="12" md="6">
                              <v-text-field
                                v-model="searchForm.query"
                                label="Search"
                                placeholder="Enter make, model, or keyword..."
                                prepend-inner-icon="mdi-magnify"
                                variant="outlined"
                                hide-details
                              ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="3">
                              <v-select
                                v-model="searchForm.category"
                                :items="categoryItems"
                                label="Category"
                                variant="outlined"
                                hide-details
                              ></v-select>
                            </v-col>
                            <v-col cols="12" md="3">
                              <v-btn
                                color="primary"
                                size="large"
                                block
                                height="56"
                                @click="performSearch"
                              >
                                <v-icon left>mdi-magnify</v-icon>
                                Search
                              </v-btn>
                            </v-col>
                          </v-row>
                        </v-card-text>
                      </v-card>
                    </div>
                  </v-col>
                </v-row>
              </v-container>
            </v-img>
          </div>
        </v-col>
      </v-row>
    </v-container>

    <!-- Stats Section -->
    <v-container class="py-8">
      <v-row>
        <v-col cols="6" md="3" v-for="stat in stats" :key="stat.label">
          <v-card class="text-center pa-4" elevation="2">
            <v-icon :color="stat.color" size="48" class="mb-2">{{ stat.icon }}</v-icon>
            <h3 class="text-h4 font-weight-bold text-primary">{{ stat.value }}+</h3>
            <p class="text-body-1 text-grey-darken-1">{{ stat.label }}</p>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- Categories Section -->
    <v-container class="py-12">
      <div class="text-center mb-8">
        <h2 class="text-h3 font-weight-bold mb-4">Shop by Category</h2>
        <p class="text-h6 text-grey-darken-1">Find the perfect vehicle for your needs</p>
      </div>
      
      <v-row>
        <v-col 
          cols="6" 
          md="4" 
          lg="2" 
          v-for="category in categories" 
          :key="category.id"
        >
          <v-card
            :to="`/categories/${category.id}`"
            class="category-card text-center pa-4"
            elevation="2"
            hover
          >
            <v-avatar color="primary" size="64" class="mb-3">
              <v-icon color="white" size="32">mdi-motorcycle</v-icon>
            </v-avatar>
            <h4 class="text-h6 font-weight-bold mb-2">{{ category.name }}</h4>
            <p class="text-body-2 text-grey-darken-1">{{ category.listings_count }} vehicles</p>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- Featured Listings -->
    <v-container fluid class="grey-lighten-4 py-12">
      <v-container>
        <div class="text-center mb-8">
          <h2 class="text-h3 font-weight-bold mb-4">Featured Listings</h2>
          <p class="text-h6 text-grey-darken-1">Handpicked deals you don't want to miss</p>
        </div>
        
        <v-row>
          <v-col 
            cols="12" 
            md="6" 
            lg="4" 
            v-for="listing in featuredListings" 
            :key="listing.id"
          >
            <v-card class="listing-card" elevation="4" hover>
              <div class="position-relative">
                <v-img
                  :src="listing.image || 'https://via.placeholder.com/400x250'"
                  height="250"
                  cover
                >
                  <div class="listing-badges">
                    <v-chip color="success" size="small" class="ma-2">
                      Featured
                    </v-chip>
                  </div>
                  <div class="favorite-btn">
                    <v-btn
                      icon="mdi-heart-outline"
                      size="small"
                      color="white"
                      variant="elevated"
                      class="ma-2"
                    ></v-btn>
                  </div>
                </v-img>
              </div>
              
              <v-card-text class="pa-4">
                <div class="d-flex justify-space-between align-center mb-2">
                  <v-chip color="primary" size="small" variant="outlined">
                    {{ listing.category.name }}
                  </v-chip>
                  <span class="text-body-2 text-grey-darken-1">{{ listing.location }}</span>
                </div>
                
                <h3 class="text-h6 font-weight-bold mb-2 text-truncate">{{ listing.title }}</h3>
                <p class="text-body-2 text-grey-darken-1 mb-3" style="height: 40px; overflow: hidden;">
                  {{ listing.description }}
                </p>
                
                <div class="d-flex justify-space-between align-center">
                  <div class="text-h5 font-weight-bold text-success">
                    ${{ listing.price.toLocaleString() }}
                  </div>
                  <v-btn
                    :to="`/listings/${listing.id}`"
                    color="primary"
                    variant="flat"
                    size="small"
                  >
                    View Details
                  </v-btn>
                </div>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        
        <div class="text-center mt-8">
          <v-btn
            :to="'/listings'"
            color="primary"
            size="large"
            variant="outlined"
          >
            View All Listings
            <v-icon right>mdi-arrow-right</v-icon>
          </v-btn>
        </div>
      </v-container>
    </v-container>

    <!-- How It Works -->
    <v-container class="py-12">
      <div class="text-center mb-8">
        <h2 class="text-h3 font-weight-bold mb-4">How It Works</h2>
        <p class="text-h6 text-grey-darken-1">Simple steps to find your perfect match</p>
      </div>
      
      <v-row>
        <v-col cols="12" md="4" v-for="(step, index) in howItWorks" :key="index">
          <v-card class="text-center pa-6" elevation="2">
            <v-avatar :color="step.color" size="80" class="mb-4">
              <span class="text-h4 font-weight-bold text-white">{{ index + 1 }}</span>
            </v-avatar>
            <h3 class="text-h5 font-weight-bold mb-3">{{ step.title }}</h3>
            <p class="text-body-1 text-grey-darken-1">{{ step.description }}</p>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- CTA Section -->
    <v-container fluid class="primary py-12">
      <v-container>
        <v-row justify="center">
          <v-col cols="12" md="8" class="text-center">
            <h2 class="text-h3 font-weight-bold text-white mb-4">Ready to Start Selling?</h2>
            <p class="text-h6 text-white mb-6 opacity-90">
              Join thousands of sellers and turn your vehicles into cash today.
            </p>
            <div class="d-flex flex-column flex-sm-row justify-center ga-4">
              <v-btn
                :to="'/register'"
                color="white"
                size="large"
                variant="flat"
                class="text-primary"
              >
                Get Started Free
              </v-btn>
              <v-btn
                :to="'/help'"
                color="white"
                size="large"
                variant="outlined"
                class="text-white"
              >
                Learn More
              </v-btn>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
  </VuetifyLayout>
</template>

<script setup>
import { ref } from 'vue'
import VuetifyLayout from '@/Layouts/VuetifyLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  categories: Array,
  featuredListings: Array,
  stats: Object
})

const searchForm = ref({
  query: '',
  category: ''
})

const categoryItems = [
  { title: 'All Categories', value: '' },
  ...props.categories.map(cat => ({ title: cat.name, value: cat.id }))
]

const stats = [
  { label: 'Active Listings', value: props.stats.total_listings, icon: 'mdi-format-list-bulleted', color: 'primary' },
  { label: 'Happy Users', value: props.stats.total_users, icon: 'mdi-account-group', color: 'success' },
  { label: 'Categories', value: props.categories.length, icon: 'mdi-shape', color: 'info' },
  { label: 'Support', value: '24/7', icon: 'mdi-headset', color: 'warning' }
]

const howItWorks = [
  {
    title: 'Browse & Search',
    description: 'Explore thousands of listings or use our advanced search to find exactly what you need.',
    color: 'primary'
  },
  {
    title: 'Connect & Chat',
    description: 'Message sellers directly through our secure platform to ask questions and negotiate.',
    color: 'success'
  },
  {
    title: 'Buy with Confidence',
    description: 'Complete your purchase safely with our trusted payment system and buyer protection.',
    color: 'info'
  }
]

const performSearch = () => {
  const params = new URLSearchParams()
  if (searchForm.value.query) params.append('search', searchForm.value.query)
  if (searchForm.value.category) params.append('category', searchForm.value.category)
  
  router.visit(`/listings?${params.toString()}`)
}
</script>

<style scoped>
.hero-section {
  position: relative;
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);
  z-index: 1;
}

.hero-content {
  position: relative;
  z-index: 2;
  height: 600px;
}

.search-card {
  backdrop-filter: blur(10px);
  background: rgba(255, 255, 255, 0.95) !important;
}

.category-card {
  transition: all 0.3s ease;
}

.category-card:hover {
  transform: translateY(-4px);
}

.listing-card {
  transition: all 0.3s ease;
}

.listing-card:hover {
  transform: translateY(-2px);
}

.listing-badges {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 2;
}

.favorite-btn {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 2;
}
</style>