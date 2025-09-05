<template>
  <VuetifyLayout>
    <!-- Header -->
    <v-container fluid class="primary py-8">
      <v-container>
        <div class="text-center text-white">
          <h1 class="text-h3 font-weight-bold mb-2">All Listings</h1>
          <p class="text-h6 opacity-90">Discover amazing deals from trusted sellers</p>
        </div>
      </v-container>
    </v-container>

    <v-container class="py-8">
      <!-- Filters Card -->
      <v-card elevation="2" class="mb-8">
        <v-card-text class="pa-6">
          <v-row>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="filters.search"
                label="Search listings..."
                prepend-inner-icon="mdi-magnify"
                variant="outlined"
                hide-details
                clearable
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
              <v-select
                v-model="filters.category"
                :items="categoryItems"
                label="Category"
                variant="outlined"
                hide-details
                clearable
              ></v-select>
            </v-col>
            <v-col cols="12" md="3">
              <v-select
                v-model="filters.priceRange"
                :items="priceRangeItems"
                label="Price Range"
                variant="outlined"
                hide-details
                clearable
              ></v-select>
            </v-col>
            <v-col cols="12" md="2">
              <v-select
                v-model="filters.sort"
                :items="sortItems"
                label="Sort by"
                variant="outlined"
                hide-details
              ></v-select>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>

      <!-- Results Info -->
      <div class="d-flex justify-space-between align-center mb-6">
        <div>
          <h2 class="text-h5 font-weight-bold">
            {{ listings.total }} {{ listings.total === 1 ? 'listing' : 'listings' }} found
          </h2>
          <p class="text-body-1 text-grey-darken-1">
            Showing {{ listings.from }} to {{ listings.to }} of {{ listings.total }} results
          </p>
        </div>
        
        <v-btn-toggle v-model="viewMode" mandatory>
          <v-btn value="grid" icon="mdi-view-grid"></v-btn>
          <v-btn value="list" icon="mdi-view-list"></v-btn>
        </v-btn-toggle>
      </div>

      <!-- Listings Grid -->
      <div v-if="viewMode === 'grid'">
        <v-row>
          <v-col 
            cols="12" 
            sm="6" 
            md="4" 
            lg="3" 
            v-for="listing in listings.data" 
            :key="listing.id"
          >
            <v-card elevation="2" hover class="listing-card">
              <div class="position-relative">
                <v-img
                  :src="listing.image || 'https://via.placeholder.com/300x200'"
                  height="200"
                  cover
                >
                  <div class="listing-badges">
                    <v-chip 
                      v-if="listing.is_featured"
                      color="success" 
                      size="small" 
                      class="ma-2"
                    >
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
      </div>

      <!-- Listings List -->
      <div v-else>
        <v-card elevation="2">
          <v-list>
            <template v-for="(listing, index) in listings.data" :key="listing.id">
              <v-list-item :to="`/listings/${listing.id}`" class="py-4">
                <template v-slot:prepend>
                  <v-avatar size="80" rounded="lg" class="mr-4">
                    <v-img
                      :src="listing.image || 'https://via.placeholder.com/80x80'"
                      :alt="listing.title"
                    ></v-img>
                  </v-avatar>
                </template>

                <div class="flex-grow-1">
                  <div class="d-flex justify-space-between align-start mb-2">
                    <div>
                      <h3 class="text-h6 font-weight-bold mb-1">{{ listing.title }}</h3>
                      <div class="d-flex align-center mb-2">
                        <v-chip color="primary" size="small" variant="outlined" class="mr-2">
                          {{ listing.category.name }}
                        </v-chip>
                        <v-chip 
                          v-if="listing.is_featured"
                          color="success" 
                          size="small" 
                          class="mr-2"
                        >
                          Featured
                        </v-chip>
                        <span class="text-body-2 text-grey-darken-1">{{ listing.location }}</span>
                      </div>
                    </div>
                    <div class="text-right">
                      <div class="text-h5 font-weight-bold text-success mb-1">
                        ${{ listing.price.toLocaleString() }}
                      </div>
                      <v-btn
                        icon="mdi-heart-outline"
                        size="small"
                        variant="text"
                      ></v-btn>
                    </div>
                  </div>
                  
                  <p class="text-body-2 text-grey-darken-1 mb-2">
                    {{ listing.description.substring(0, 150) }}{{ listing.description.length > 150 ? '...' : '' }}
                  </p>
                  
                  <div class="d-flex align-center text-body-2 text-grey-darken-1">
                    <v-icon size="16" class="mr-1">mdi-account</v-icon>
                    <span class="mr-3">{{ listing.user.name }}</span>
                    <v-icon size="16" class="mr-1">mdi-calendar</v-icon>
                    <span>{{ formatDate(listing.created_at) }}</span>
                  </div>
                </div>
              </v-list-item>
              
              <v-divider v-if="index < listings.data.length - 1"></v-divider>
            </template>
          </v-list>
        </v-card>
      </div>

      <!-- Empty State -->
      <div v-if="listings.data.length === 0" class="text-center py-12">
        <v-icon size="64" color="grey-lighten-1" class="mb-4">mdi-magnify</v-icon>
        <h3 class="text-h5 font-weight-medium mb-2">No listings found</h3>
        <p class="text-body-1 text-grey-darken-1 mb-4">Try adjusting your search criteria or browse categories.</p>
        <v-btn to="/categories" color="primary" size="large">
          Browse Categories
        </v-btn>
      </div>

      <!-- Pagination -->
      <div v-if="listings.data.length > 0 && listings.last_page > 1" class="d-flex justify-center mt-8">
        <v-pagination
          :model-value="listings.current_page"
          :length="listings.last_page"
          :total-visible="7"
          @update:model-value="changePage"
        ></v-pagination>
      </div>
    </v-container>
  </VuetifyLayout>
</template>

<script setup>
import { ref } from 'vue'
import VuetifyLayout from '@/Layouts/VuetifyLayout.vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  listings: Object,
  categories: Array
})

const viewMode = ref('grid')

const filters = ref({
  search: '',
  category: '',
  priceRange: '',
  sort: 'latest'
})

const categoryItems = [
  { title: 'All Categories', value: '' },
  ...props.categories.map(cat => ({ title: cat.name, value: cat.id }))
]

const priceRangeItems = [
  { title: 'Any Price', value: '' },
  { title: 'Under $5,000', value: '0-5000' },
  { title: '$5,000 - $15,000', value: '5000-15000' },
  { title: '$15,000 - $30,000', value: '15000-30000' },
  { title: '$30,000+', value: '30000+' }
]

const sortItems = [
  { title: 'Latest', value: 'latest' },
  { title: 'Price: Low to High', value: 'price_low' },
  { title: 'Price: High to Low', value: 'price_high' },
  { title: 'Most Popular', value: 'popular' }
]

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric',
    year: 'numeric'
  })
}

const changePage = (page) => {
  router.visit(`/listings?page=${page}`, {
    preserveState: true,
    preserveScroll: true
  })
}
</script>

<style scoped>
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