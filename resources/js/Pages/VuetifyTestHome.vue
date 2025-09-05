<template>
  <v-app>
    <v-main>
      <v-container>
        <v-row>
          <v-col cols="12">
            <v-card class="pa-6">
              <v-card-title class="text-h4 text-orange">
                🏍️ ManCycle - Vuetify Test
              </v-card-title>
              
              <v-alert type="success" class="mb-4">
                ✅ If you can see this, Vuetify + Inertia + Vue is working!
              </v-alert>

              <v-card class="mb-4" color="grey-lighten-4">
                <v-card-title>Data from Laravel:</v-card-title>
                <v-card-text>
                  <v-chip class="ma-1" color="primary">Categories: {{ categories.length }}</v-chip>
                  <v-chip class="ma-1" color="secondary">Featured Listings: {{ featuredListings.length }}</v-chip>
                  <v-chip class="ma-1" color="accent">Total Users: {{ stats.total_users }}</v-chip>
                </v-card-text>
              </v-card>

              <v-card class="mb-4" color="green-lighten-5">
                <v-card-title>Test Navigation:</v-card-title>
                <v-card-text>
                  <v-btn 
                    :to="'/login'" 
                    color="primary" 
                    class="ma-1"
                    variant="outlined"
                  >
                    Login
                  </v-btn>
                  <v-btn 
                    :to="'/register'" 
                    color="primary" 
                    class="ma-1"
                    variant="outlined"
                  >
                    Register
                  </v-btn>
                  <v-btn 
                    :to="'/listings'" 
                    color="primary" 
                    class="ma-1"
                    variant="outlined"
                  >
                    Listings
                  </v-btn>
                  <v-btn 
                    :to="'/categories'" 
                    color="primary" 
                    class="ma-1"
                    variant="outlined"
                  >
                    Categories
                  </v-btn>
                </v-card-text>
              </v-card>

              <v-card color="amber-lighten-4">
                <v-card-title>Next Steps:</v-card-title>
                <v-card-text>
                  <v-list>
                    <v-list-item>
                      <v-list-item-title>✅ Basic Inertia + Vue working</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title>✅ Vuetify components working</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title>🔄 Test authentication</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                      <v-list-item-title>🔄 Test all pages</v-list-item-title>
                    </v-list-item>
                  </v-list>
                </v-card-text>
              </v-card>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
defineProps({
  categories: {
    type: Array,
    default: () => []
  },
  featuredListings: {
    type: Array,
    default: () => []
  },
  stats: {
    type: Object,
    default: () => ({})
  }
})
</script>