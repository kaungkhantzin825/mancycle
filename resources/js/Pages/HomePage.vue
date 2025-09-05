<template>
  <VuetifyLayout>
    <!-- Hero Section -->
    <v-container fluid class="pa-0">
      <v-carousel
        v-model="slide"
        height="500"
        hide-delimiter-background
        show-arrows="hover"
        cycle
      >
        <v-carousel-item
          v-for="(item, i) in heroSlides"
          :key="i"
          :src="item.image"
          cover
        >
          <div class="hero-overlay">
            <v-container>
              <v-row align="center" justify="center" class="fill-height">
                <v-col cols="12" md="8" class="text-center">
                  <h1 class="text-h2 text-white font-weight-bold mb-4">
                    {{ item.title }}
                  </h1>
                  <p class="text-h5 text-white mb-6">
                    {{ item.subtitle }}
                  </p>
                  <v-btn
                    size="x-large"
                    color="primary"
                    rounded="pill"
                    @click="$inertia.visit('/listings')"
                  >
                    Browse Vehicles
                    <v-icon end>mdi-arrow-right</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-container>
          </div>
        </v-carousel-item>
      </v-carousel>

      <!-- Search Section -->
      <v-container class="search-container">
        <v-card elevation="8" class="mx-auto search-card">
          <v-card-text class="pa-6">
            <v-row>
              <v-col cols="12" md="3">
                <v-select
                  v-model="searchFilters.category"
                  :items="categoryOptions"
                  label="Category"
                  prepend-inner-icon="mdi-shape"
                  variant="outlined"
                  hide-details
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  v-model="searchFilters.brand"
                  :items="brandOptions"
                  label="Brand"
                  prepend-inner-icon="mdi-tag"
                  variant="outlined"
                  hide-details
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select
                  v-model="searchFilters.priceRange"
                  :items="priceRanges"
                  label="Price Range"
                  prepend-inner-icon="mdi-currency-usd"
                  variant="outlined"
                  hide-details
                ></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-btn
                  color="primary"
                  size="large"
                  block
                  @click="searchListings"
                >
                  <v-icon start>mdi-magnify</v-icon>
                  Search
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-container>
    </v-container>

    <!-- Categories Section -->
    <v-container class="my-12">
      <div class="text-center mb-8">
        <h2 class="text-h3 font-weight-bold mb-2">Browse by Category</h2>
        <p class="text-h6 text-grey-darken-1">Find the perfect vehicle for your needs</p>
      </div>
      
      <v-row>
        <v-col
          v-for="category in categories"
          :key="category.id"
          cols="6"
          sm="4"
          md="2"
        >
          <v-card
            flat
            class="text-center pa-4 category-card"
            @click="browseCategory(category)"
          >
            <v-avatar
              color="primary"
              size="80"
              class="mb-3"
            >
              <v-icon size="40" color="white">
                {{ getCategoryIcon(category.type) }}
              </v-icon>
            </v-avatar>
            <h3 class="text-subtitle-1 font-weight-bold">{{ category.name }}</h3>
            <p class="text-caption text-grey">{{ category.listings_count || 0 }} Listings</p>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- Featured Listings -->
    <v-container class="my-12">
      <div class="d-flex justify-space-between align-center mb-6">
        <div>
          <h2 class="text-h3 font-weight-bold">Featured Vehicles</h2>
          <p class="text-h6 text-grey-darken-1">Premium listings from verified sellers</p>
        </div>
        <v-btn
          variant="text"
          color="primary"
          @click="$inertia.visit('/listings?featured=true')"
        >
          View All
          <v-icon end>mdi-arrow-right</v-icon>
        </v-btn>
      </div>

      <v-row>
        <v-col
          v-for="listing in featuredListings"
          :key="listing.id"
          cols="12"
          sm="6"
          md="3"
        >
          <v-card
            class="listing-card"
            @click="viewListing(listing)"
          >
            <v-img
              :src="listing.images?.[0] || '/images/placeholder-vehicle.jpg'"
              height="200"
              cover
            >
              <v-chip
                v-if="listing.is_featured"
                class="ma-2"
                color="orange"
                prepend-icon="mdi-star"
                size="small"
              >
                Featured
              </v-chip>
            </v-img>
            
            <v-card-text>
              <div class="d-flex justify-space-between align-center mb-2">
                <v-chip size="small" color="primary" variant="tonal">
                  {{ listing.category?.name }}
                </v-chip>
                <span class="text-caption text-grey">
                  <v-icon size="12">mdi-eye</v-icon>
                  {{ listing.views }}
                </span>
              </div>
              
              <h3 class="text-subtitle-1 font-weight-bold mb-1 listing-title">
                {{ listing.title }}
              </h3>
              
              <div class="text-h5 font-weight-bold text-primary mb-3">
                ${{ formatPrice(listing.price) }}
              </div>
              
              <v-divider class="mb-3"></v-divider>
              
              <div class="listing-specs">
                <div class="d-flex align-center mb-1">
                  <v-icon size="16" class="mr-2">mdi-calendar</v-icon>
                  <span class="text-caption">{{ listing.year }}</span>
                </div>
                <div class="d-flex align-center mb-1">
                  <v-icon size="16" class="mr-2">mdi-speedometer</v-icon>
                  <span class="text-caption">{{ formatMileage(listing.mileage) }} km</span>
                </div>
                <div class="d-flex align-center">
                  <v-icon size="16" class="mr-2">mdi-map-marker</v-icon>
                  <span class="text-caption">{{ listing.location }}</span>
                </div>
              </div>
            </v-card-text>
            
            <v-card-actions>
              <v-btn
                color="primary"
                variant="tonal"
                block
                @click.stop="contactSeller(listing)"
              >
                Contact Seller
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- Popular Brands -->
    <v-container fluid class="brand-section py-12">
      <v-container>
        <div class="text-center mb-8">
          <h2 class="text-h3 font-weight-bold mb-2">Popular Brands</h2>
          <p class="text-h6 text-grey-darken-1">Browse vehicles from top manufacturers</p>
        </div>
        
        <v-row>
          <v-col
            v-for="brand in popularBrands"
            :key="brand"
            cols="6"
            sm="3"
            md="2"
          >
            <v-card
              flat
              class="brand-card text-center pa-4"
              @click="browseBrand(brand)"
            >
              <div class="brand-logo mb-2">
                {{ brand }}
              </div>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-container>

    <!-- Statistics -->
    <v-container class="my-12">
      <v-row>
        <v-col cols="12" sm="6" md="3">
          <v-card class="text-center pa-6 stat-card">
            <v-icon size="48" color="primary" class="mb-3">mdi-motorbike</v-icon>
            <div class="text-h4 font-weight-bold">{{ stats.total_motorcycles || 0 }}</div>
            <div class="text-subtitle-1">Motorcycles</div>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="3">
          <v-card class="text-center pa-6 stat-card">
            <v-icon size="48" color="primary" class="mb-3">mdi-car</v-icon>
            <div class="text-h4 font-weight-bold">{{ stats.total_cars || 0 }}</div>
            <div class="text-subtitle-1">Cars</div>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="3">
          <v-card class="text-center pa-6 stat-card">
            <v-icon size="48" color="primary" class="mb-3">mdi-scooter</v-icon>
            <div class="text-h4 font-weight-bold">{{ stats.total_scooters || 0 }}</div>
            <div class="text-subtitle-1">Scooters</div>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="3">
          <v-card class="text-center pa-6 stat-card">
            <v-icon size="48" color="primary" class="mb-3">mdi-account-group</v-icon>
            <div class="text-h4 font-weight-bold">{{ stats.total_users || 0 }}</div>
            <div class="text-subtitle-1">Happy Customers</div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>

    <!-- CTA Section -->
    <v-container fluid class="cta-section py-12">
      <v-container>
        <v-row align="center">
          <v-col cols="12" md="6">
            <h2 class="text-h3 font-weight-bold mb-4">Ready to Sell Your Vehicle?</h2>
            <p class="text-h6 mb-6">
              Join thousands of sellers and reach millions of potential buyers on ManCycle
            </p>
            <v-btn
              size="x-large"
              color="primary"
              rounded="pill"
              @click="$inertia.visit('/register')"
            >
              Start Selling Now
              <v-icon end>mdi-arrow-right</v-icon>
            </v-btn>
          </v-col>
          <v-col cols="12" md="6" class="text-center">
            <v-img
              src="/images/sell-vehicle.svg"
              max-height="300"
              contain
            ></v-img>
          </v-col>
        </v-row>
      </v-container>
    </v-container>
  </VuetifyLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import VuetifyLayout from '@/Layouts/VuetifyLayout.vue'

const props = defineProps({
  featuredListings: Array,
  recentListings: Array,
  categories: Array,
  stats: Object,
  popularBrands: Array,
})

const slide = ref(0)

const heroSlides = [
  {
    image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1600',
    title: 'Find Your Dream Motorcycle',
    subtitle: 'Browse thousands of motorcycles from trusted sellers'
  },
  {
    image: 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=1600',
    title: 'Premium Vehicles, Best Prices',
    subtitle: 'Compare prices and find the best deals in your area'
  },
  {
    image: 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=1600',
    title: 'Sell Your Vehicle Fast',
    subtitle: 'Reach millions of buyers with our platform'
  }
]

const searchFilters = ref({
  category: null,
  brand: null,
  priceRange: null,
})

const categoryOptions = computed(() => {
  return props.categories?.map(cat => ({
    title: cat.name,
    value: cat.id
  })) || []
})

const brandOptions = [
  'Yamaha', 'Honda', 'Kawasaki', 'Suzuki', 'Harley-Davidson',
  'BMW', 'Ducati', 'KTM', 'Royal Enfield', 'Vespa'
]

const priceRanges = [
  { title: 'Under $5,000', value: '0-5000' },
  { title: '$5,000 - $10,000', value: '5000-10000' },
  { title: '$10,000 - $20,000', value: '10000-20000' },
  { title: '$20,000 - $30,000', value: '20000-30000' },
  { title: 'Over $30,000', value: '30000+' },
]

const getCategoryIcon = (type) => {
  const icons = {
    motorcycles: 'mdi-motorbike',
    cars: 'mdi-car',
    scooters: 'mdi-scooter',
    parts: 'mdi-cog',
    second_hand: 'mdi-tag',
  }
  return icons[type] || 'mdi-help-circle'
}

const formatPrice = (price) => {
  return new Intl.NumberFormat('en-US').format(price)
}

const formatMileage = (mileage) => {
  return new Intl.NumberFormat('en-US').format(mileage)
}

const searchListings = () => {
  router.visit('/listings', {
    data: searchFilters.value
  })
}

const browseCategory = (category) => {
  router.visit(`/categories/${category.slug}`)
}

const browseBrand = (brand) => {
  router.visit('/listings', {
    data: { brand }
  })
}

const viewListing = (listing) => {
  router.visit(`/listings/${listing.id}`)
}

const contactSeller = (listing) => {
  if (usePage().props.auth.user) {
    router.post(`/listings/${listing.id}/message`)
  } else {
    router.visit('/login')
  }
}
</script>

<style scoped>
.hero-overlay {
  background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6));
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
}

.search-container {
  margin-top: -80px;
  position: relative;
  z-index: 2;
}

.search-card {
  max-width: 1000px;
  border-radius: 16px !important;
}

.category-card {
  cursor: pointer;
  transition: all 0.3s;
  border-radius: 12px !important;
}

.category-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.listing-card {
  cursor: pointer;
  transition: all 0.3s;
  border-radius: 12px !important;
  height: 100%;
}

.listing-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.listing-title {
  min-height: 48px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.brand-section {
  background-color: #f5f5f5;
}

.brand-card {
  cursor: pointer;
  transition: all 0.3s;
  border-radius: 12px !important;
  background: white;
}

.brand-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.brand-logo {
  font-weight: bold;
  font-size: 1.1rem;
  color: #333;
}

.stat-card {
  border-radius: 12px !important;
  transition: all 0.3s;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.cta-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.cta-section h2,
.cta-section p {
  color: white;
}
</style>
