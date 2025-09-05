<template>
  <div style="padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="color: #FF6B35;">🔐 Login Test Page</h1>
    <p style="color: green; font-weight: bold;">✅ Login page is working!</p>
    
    <div style="background: #f5f5f5; padding: 15px; margin: 20px 0; border-radius: 5px;">
      <p>This is a test page to verify routing works.</p>
      <p>The actual login form will be implemented with Vuetify.</p>
    </div>

    <Link href="/" style="color: #FF6B35; text-decoration: underline;">← Back to Home</Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>