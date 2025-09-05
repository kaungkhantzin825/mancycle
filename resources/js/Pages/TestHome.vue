<template>
  <div style="padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="color: #FF6B35;">🏍️ ManCycle - Test Page</h1>
    <p style="color: green; font-weight: bold;">✅ If you can see this, Inertia + Vue is working!</p>
    
    <div style="background: #f5f5f5; padding: 15px; margin: 20px 0; border-radius: 5px;">
      <h3>Data from Laravel:</h3>
      <p><strong>Categories:</strong> {{ categories.length }} found</p>
      <p><strong>Featured Listings:</strong> {{ featuredListings.length }} found</p>
      <p><strong>Stats:</strong> {{ JSON.stringify(stats) }}</p>
    </div>

    <div style="background: #e8f5e8; padding: 15px; margin: 20px 0; border-radius: 5px;">
      <h3>Test Navigation (Inertia Links):</h3>
      <Link href="/login" style="color: #FF6B35; margin-right: 20px; text-decoration: underline;">Login</Link>
      <Link href="/register" style="color: #FF6B35; margin-right: 20px; text-decoration: underline;">Register</Link>
      <Link href="/listings" style="color: #FF6B35; margin-right: 20px; text-decoration: underline;">Listings</Link>
      <Link href="/categories" style="color: #FF6B35; text-decoration: underline;">Categories</Link>
    </div>

    <div style="background: #fff3cd; padding: 15px; margin: 20px 0; border-radius: 5px;">
      <h3>Next Steps:</h3>
      <p>1. ✅ Basic Inertia + Vue working</p>
      <p>2. 🔄 Enable Vuetify components</p>
      <p>3. 🔄 Test authentication</p>
      <p>4. 🔄 Test all pages</p>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

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