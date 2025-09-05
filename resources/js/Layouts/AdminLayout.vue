<template>
  <v-app>
    <!-- Top Navigation Bar -->
    <v-app-bar
      flat
      color="white"
      height="57"
      fixed
      elevation="1"
    >
      <!-- Menu Toggle -->
      <v-btn
        icon
        variant="text"
        @click="drawer = !drawer"
        class="d-lg-none"
      >
        <v-icon>mdi-menu</v-icon>
      </v-btn>
      
      <!-- Left Nav Items -->
      <v-btn variant="text" class="d-none d-md-flex">
        <v-icon>mdi-home</v-icon>
        Home
      </v-btn>
      <v-btn variant="text" class="d-none d-md-flex">
        <v-icon>mdi-email</v-icon>
        Contact
      </v-btn>
      
      <v-toolbar-title class="font-weight-bold">
        <v-icon class="mr-2">mdi-shield-crown</v-icon>
        ManCycle Admin
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <!-- Notifications -->
      <v-menu offset-y>
        <template v-slot:activator="{ props }">
          <v-btn icon v-bind="props">
            <v-badge
              color="red"
              :content="notifications.length"
              v-if="notifications.length > 0"
            >
              <v-icon>mdi-bell</v-icon>
            </v-badge>
            <v-icon v-else>mdi-bell-outline</v-icon>
          </v-btn>
        </template>
        <v-list width="350">
          <v-list-item
            v-for="(notification, i) in notifications"
            :key="i"
          >
            <template v-slot:prepend>
              <v-icon :color="notification.color">{{ notification.icon }}</v-icon>
            </template>
            <v-list-item-title>{{ notification.title }}</v-list-item-title>
            <v-list-item-subtitle>{{ notification.subtitle }}</v-list-item-subtitle>
          </v-list-item>
          <v-list-item v-if="notifications.length === 0">
            <v-list-item-title>No new notifications</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

      <!-- User Menu -->
      <v-menu offset-y>
        <template v-slot:activator="{ props }">
          <v-btn class="ml-2" v-bind="props">
            <v-avatar size="32" class="mr-2">
              <v-img 
                v-if="$page.props.auth.user.avatar"
                :src="$page.props.auth.user.avatar"
              ></v-img>
              <v-icon v-else>mdi-account-circle</v-icon>
            </v-avatar>
            <span class="d-none d-sm-inline">{{ $page.props.auth.user.name }}</span>
            <v-icon>mdi-menu-down</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item @click="$inertia.visit('/profile')">
            <template v-slot:prepend>
              <v-icon>mdi-account</v-icon>
            </template>
            <v-list-item-title>Profile</v-list-item-title>
          </v-list-item>
          <v-list-item @click="$inertia.visit('/admin/settings')">
            <template v-slot:prepend>
              <v-icon>mdi-cog</v-icon>
            </template>
            <v-list-item-title>Settings</v-list-item-title>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item @click="logout">
            <template v-slot:prepend>
              <v-icon>mdi-logout</v-icon>
            </template>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <!-- Navigation Drawer -->
    <v-navigation-drawer
      v-model="drawer"
      :rail="rail"
      permanent
      color="grey-darken-4"
      dark
    >
      <v-list>
        <v-list-item
          prepend-avatar="/images/admin-logo.png"
          :title="rail ? '' : 'Super Admin'"
          :subtitle="rail ? '' : $page.props.auth.user.email"
          class="px-2 py-1"
        >
          <template v-slot:append>
            <v-btn
              variant="text"
              icon="mdi-chevron-left"
              @click.stop="rail = !rail"
              v-if="!rail"
            ></v-btn>
          </template>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list density="compact" nav>
        <v-list-item
          v-for="item in menuItems"
          :key="item.title"
          :prepend-icon="item.icon"
          :title="item.title"
          :value="item.title"
          :color="isActive(item.route) ? 'primary' : ''"
          @click="navigateTo(item)"
          :class="{ 'bg-grey-darken-3': isActive(item.route) }"
        >
          <template v-slot:append v-if="item.badge">
            <v-badge
              :color="item.badgeColor || 'red'"
              :content="item.badge"
              inline
            ></v-badge>
          </template>
        </v-list-item>

        <v-divider class="my-2"></v-divider>

        <v-list-subheader v-if="!rail">MANAGEMENT</v-list-subheader>
        
        <v-list-group
          v-for="group in menuGroups"
          :key="group.title"
          :value="group.title"
        >
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              :prepend-icon="group.icon"
              :title="group.title"
            ></v-list-item>
          </template>

          <v-list-item
            v-for="child in group.children"
            :key="child.title"
            :title="child.title"
            :value="child.title"
            @click="$inertia.visit(child.route)"
            :class="{ 'bg-grey-darken-3': isActive(child.route) }"
          >
            <template v-slot:prepend>
              <v-icon size="small">{{ child.icon }}</v-icon>
            </template>
            <template v-slot:append v-if="child.badge">
              <v-chip size="small" :color="child.badgeColor || 'red'">
                {{ child.badge }}
              </v-chip>
            </template>
          </v-list-item>
        </v-list-group>
      </v-list>

      <template v-slot:append>
        <div class="pa-2">
          <v-btn block color="red" @click="logout">
            <v-icon start>mdi-logout</v-icon>
            {{ rail ? '' : 'Logout' }}
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <!-- Main Content -->
    <v-main class="bg-grey-lighten-5">
      <!-- Breadcrumbs -->
      <v-container fluid class="pa-0">
        <v-card flat class="rounded-0">
          <v-card-text class="pa-4">
            <v-breadcrumbs :items="breadcrumbs" class="pa-0">
              <template v-slot:prepend>
                <v-icon icon="mdi-home" size="small"></v-icon>
              </template>
            </v-breadcrumbs>
          </v-card-text>
        </v-card>
      </v-container>

      <!-- Page Content -->
      <v-container fluid class="pa-4">
        <slot />
      </v-container>
    </v-main>

    <!-- Footer -->
    <v-footer app color="grey-lighten-3" class="px-4 py-2">
      <span class="text-caption">© {{ new Date().getFullYear() }} ManCycle. All rights reserved.</span>
      <v-spacer></v-spacer>
      <span class="text-caption">Version 1.0.0</span>
    </v-footer>
  </v-app>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const drawer = ref(true)
const rail = ref(false)

const notifications = ref([
  {
    icon: 'mdi-account-check',
    title: '5 New User Registrations',
    subtitle: 'Awaiting approval',
    color: 'primary'
  },
  {
    icon: 'mdi-car',
    title: '12 New Listings',
    subtitle: 'Pending review',
    color: 'warning'
  },
  {
    icon: 'mdi-message-alert',
    title: '3 Flagged Messages',
    subtitle: 'Require moderation',
    color: 'error'
  }
])

const menuItems = ref([
  {
    icon: 'mdi-view-dashboard',
    title: 'Dashboard',
    route: '/admin/dashboard'
  },
  {
    icon: 'mdi-trending-up',
    title: 'Analytics',
    route: '/admin/analytics',
    badge: 'New'
  },
  {
    icon: 'mdi-bell',
    title: 'Notifications',
    route: '/admin/notifications',
    badge: '15',
    badgeColor: 'warning'
  }
])

const menuGroups = ref([
  {
    icon: 'mdi-account-group',
    title: 'User Management',
    children: [
      {
        icon: 'mdi-account-multiple',
        title: 'All Users',
        route: '/admin/users'
      },
      {
        icon: 'mdi-account-check',
        title: 'Pending Approvals',
        route: '/admin/users/pending',
        badge: '5',
        badgeColor: 'warning'
      },
      {
        icon: 'mdi-store',
        title: 'Sellers',
        route: '/admin/sellers'
      },
      {
        icon: 'mdi-domain',
        title: 'Brand/Dealers',
        route: '/admin/dealers'
      },
      {
        icon: 'mdi-account-cancel',
        title: 'Blocked Users',
        route: '/admin/users/blocked'
      }
    ]
  },
  {
    icon: 'mdi-car-side',
    title: 'Listing Management',
    children: [
      {
        icon: 'mdi-format-list-bulleted',
        title: 'All Listings',
        route: '/admin/listings'
      },
      {
        icon: 'mdi-clock-outline',
        title: 'Pending Listings',
        route: '/admin/listings/pending',
        badge: '12',
        badgeColor: 'orange'
      },
      {
        icon: 'mdi-star',
        title: 'Featured Listings',
        route: '/admin/listings/featured'
      },
      {
        icon: 'mdi-alert',
        title: 'Reported Listings',
        route: '/admin/listings/reported',
        badge: '3',
        badgeColor: 'error'
      }
    ]
  },
  {
    icon: 'mdi-shape',
    title: 'Categories',
    children: [
      {
        icon: 'mdi-folder',
        title: 'Manage Categories',
        route: '/admin/categories'
      },
      {
        icon: 'mdi-folder-plus',
        title: 'Add Category',
        route: '/admin/categories/create'
      }
    ]
  },
  {
    icon: 'mdi-message',
    title: 'Communication',
    children: [
      {
        icon: 'mdi-chat',
        title: 'Chat Overview',
        route: '/admin/chats'
      },
      {
        icon: 'mdi-message-alert',
        title: 'Flagged Messages',
        route: '/admin/messages/flagged',
        badge: '3',
        badgeColor: 'error'
      },
      {
        icon: 'mdi-comment-multiple',
        title: 'Reviews',
        route: '/admin/reviews'
      }
    ]
  },
  {
    icon: 'mdi-cog',
    title: 'System Settings',
    children: [
      {
        icon: 'mdi-web',
        title: 'General Settings',
        route: '/admin/settings/general'
      },
      {
        icon: 'mdi-translate',
        title: 'Languages',
        route: '/admin/settings/languages'
      },
      {
        icon: 'mdi-map-marker',
        title: 'Location Settings',
        route: '/admin/settings/location'
      },
      {
        icon: 'mdi-email',
        title: 'Email Templates',
        route: '/admin/settings/email'
      },
      {
        icon: 'mdi-backup-restore',
        title: 'Backup & Restore',
        route: '/admin/settings/backup'
      }
    ]
  },
  {
    icon: 'mdi-chart-box',
    title: 'Reports',
    children: [
      {
        icon: 'mdi-file-chart',
        title: 'Sales Reports',
        route: '/admin/reports/sales'
      },
      {
        icon: 'mdi-account-details',
        title: 'User Reports',
        route: '/admin/reports/users'
      },
      {
        icon: 'mdi-car-info',
        title: 'Listing Reports',
        route: '/admin/reports/listings'
      }
    ]
  }
])

const breadcrumbs = computed(() => {
  const path = window.location.pathname
  const segments = path.split('/').filter(s => s)
  
  return segments.map((segment, index) => ({
    title: segment.charAt(0).toUpperCase() + segment.slice(1),
    disabled: index === segments.length - 1,
    href: '/' + segments.slice(0, index + 1).join('/')
  }))
})

const isActive = (route) => {
  return window.location.pathname.startsWith(route)
}

const navigateTo = (item) => {
  if (item.children) {
    // Handle group expansion
  } else {
    router.visit(item.route)
  }
}

const logout = () => {
  router.post('/logout')
}
</script>

<style scoped>
.v-navigation-drawer {
  background: linear-gradient(to bottom, #37474f, #263238) !important;
}

.v-list-item--active {
  background-color: rgba(255, 255, 255, 0.1);
}

.v-list-item:hover {
  background-color: rgba(255, 255, 255, 0.05);
}
</style>
