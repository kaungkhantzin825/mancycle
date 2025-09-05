<template>
  <v-app id="admin-app">
    <!-- Top Navigation Bar -->
    <v-app-bar
      flat
      color="white"
      height="57"
      fixed
      :elevation="1"
    >
      <!-- Left side -->
      <v-toolbar-title class="d-flex align-center">
        <v-btn icon variant="text" @click="drawer = !drawer" class="mr-2">
          <v-icon>mdi-menu</v-icon>
        </v-btn>
        <v-btn variant="text" to="/" class="text-none">Home</v-btn>
        <v-btn variant="text" class="text-none">Contact</v-btn>
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <!-- Right side -->
      <div class="d-flex align-center">
        <!-- Search -->
        <v-btn icon variant="text">
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <!-- Messages -->
        <v-menu>
          <template v-slot:activator="{ props }">
            <v-btn icon variant="text" v-bind="props">
              <v-badge color="red" :content="3" :offset-x="-8" :offset-y="-8">
                <v-icon>mdi-message</v-icon>
              </v-badge>
            </v-btn>
          </template>
          <v-card width="300">
            <v-list>
              <v-list-item v-for="msg in 3" :key="msg">
                <template v-slot:prepend>
                  <v-avatar size="40">
                    <v-img :src="`https://ui-avatars.com/api/?name=User${msg}`"></v-img>
                  </v-avatar>
                </template>
                <v-list-item-title>Message {{ msg }}</v-list-item-title>
                <v-list-item-subtitle>4 hours ago</v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-card>
        </v-menu>

        <!-- Notifications -->
        <v-menu>
          <template v-slot:activator="{ props }">
            <v-btn icon variant="text" v-bind="props">
              <v-badge color="warning" :content="10" :offset-x="-8" :offset-y="-8">
                <v-icon>mdi-bell</v-icon>
              </v-badge>
            </v-btn>
          </template>
          <v-card width="300">
            <v-card-title class="text-subtitle-1">10 Notifications</v-card-title>
            <v-list>
              <v-list-item v-for="n in 5" :key="n">
                <template v-slot:prepend>
                  <v-icon :color="['primary', 'warning', 'success', 'error', 'info'][n-1]">
                    {{ ['mdi-email', 'mdi-account-group', 'mdi-cart', 'mdi-message', 'mdi-folder'][n-1] }}
                  </v-icon>
                </template>
                <v-list-item-title>Notification {{ n }}</v-list-item-title>
                <v-list-item-subtitle>{{ n }} mins ago</v-list-item-subtitle>
              </v-list-item>
            </v-list>
          </v-card>
        </v-menu>

        <!-- Fullscreen -->
        <v-btn icon variant="text" @click="toggleFullscreen">
          <v-icon>mdi-fullscreen</v-icon>
        </v-btn>

        <!-- Control Sidebar Toggle -->
        <v-btn icon variant="text">
          <v-icon>mdi-view-grid</v-icon>
        </v-btn>
      </div>
    </v-app-bar>

    <!-- Left Sidebar -->
    <v-navigation-drawer
      v-model="drawer"
      permanent
      :width="250"
      color="#343a40"
      dark
    >
      <!-- Brand Logo -->
      <div class="brand-link">
        <v-img
          src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="brand-image"
          :width="33"
          :height="33"
        ></v-img>
        <span class="brand-text">AdminLTE 3</span>
      </div>

      <!-- User Panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <v-avatar size="35" class="ml-3">
          <v-img :src="userImage"></v-img>
        </v-avatar>
        <div class="info ml-3">
          <div class="text-white">{{ userName }}</div>
        </div>
      </div>

      <!-- Search Form -->
      <div class="px-3 mb-3">
        <v-text-field
          v-model="searchQuery"
          placeholder="Search"
          prepend-inner-icon="mdi-magnify"
          density="compact"
          variant="outlined"
          hide-details
          dark
          bg-color="rgba(255,255,255,0.1)"
        ></v-text-field>
      </div>

      <!-- Navigation Menu -->
      <v-list nav density="compact" class="sidebar-menu">
        <!-- Dashboard -->
        <v-list-item
          @click="navigate('/admin/dashboard')"
          :active="isActive('/admin/dashboard')"
          prepend-icon="mdi-view-dashboard"
          title="Dashboard"
          class="nav-item"
        >
          <template v-slot:append>
            <v-chip size="x-small" color="primary">2</v-chip>
          </template>
        </v-list-item>

        <!-- Widgets -->
        <v-list-item
          @click="navigate('/admin/widgets')"
          :active="isActive('/admin/widgets')"
          prepend-icon="mdi-widgets"
          title="Widgets"
          class="nav-item"
        >
          <template v-slot:append>
            <v-chip size="x-small" color="red">New</v-chip>
          </template>
        </v-list-item>

        <!-- Layout Options -->
        <v-list-group>
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              prepend-icon="mdi-page-layout-body"
              title="Layout Options"
              class="nav-item"
            >
              <template v-slot:append>
                <v-chip size="x-small" color="teal" class="mr-2">6</v-chip>
              </template>
            </v-list-item>
          </template>
          <v-list-item
            v-for="item in layoutOptions"
            :key="item.title"
            :title="item.title"
            @click="navigate(item.route)"
            class="pl-12"
          ></v-list-item>
        </v-list-group>

        <!-- Charts -->
        <v-list-group :value="true">
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              prepend-icon="mdi-chart-pie"
              title="Charts"
              class="nav-item"
            ></v-list-item>
          </template>
          <v-list-item
            v-for="chart in chartTypes"
            :key="chart"
            :title="chart"
            @click="navigate(`/admin/charts/${chart.toLowerCase()}`)"
            :active="isActive(`/admin/charts/${chart.toLowerCase()}`)"
            class="pl-12"
          >
            <template v-slot:prepend>
              <v-icon size="small">mdi-circle-outline</v-icon>
            </template>
          </v-list-item>
        </v-list-group>

        <!-- UI Elements -->
        <v-list-group>
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              prepend-icon="mdi-palette"
              title="UI Elements"
              class="nav-item"
            ></v-list-item>
          </template>
          <v-list-item
            v-for="element in uiElements"
            :key="element"
            :title="element"
            @click="navigate(`/admin/ui/${element.toLowerCase()}`)"
            class="pl-12"
          >
            <template v-slot:prepend>
              <v-icon size="small">mdi-circle-outline</v-icon>
            </template>
          </v-list-item>
        </v-list-group>

        <!-- Forms -->
        <v-list-group>
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              prepend-icon="mdi-form-select"
              title="Forms"
              class="nav-item"
            ></v-list-item>
          </template>
          <v-list-item
            v-for="form in formTypes"
            :key="form"
            :title="form"
            @click="navigate(`/admin/forms/${form.toLowerCase()}`)"
            class="pl-12"
          >
            <template v-slot:prepend>
              <v-icon size="small">mdi-circle-outline</v-icon>
            </template>
          </v-list-item>
        </v-list-group>

        <!-- Tables -->
        <v-list-group>
          <template v-slot:activator="{ props }">
            <v-list-item
              v-bind="props"
              prepend-icon="mdi-table"
              title="Tables"
              class="nav-item"
            ></v-list-item>
          </template>
          <v-list-item
            v-for="table in tableTypes"
            :key="table"
            :title="table"
            @click="navigate(`/admin/tables/${table.toLowerCase()}`)"
            class="pl-12"
          >
            <template v-slot:prepend>
              <v-icon size="small">mdi-circle-outline</v-icon>
            </template>
          </v-list-item>
        </v-list-group>

        <!-- LABELS Section -->
        <v-list-subheader class="mt-4 text-uppercase">Labels</v-list-subheader>
        
        <v-list-item
          prepend-icon="mdi-circle"
          title="Important"
          class="nav-item"
        >
          <template v-slot:prepend>
            <v-icon color="error" size="x-small">mdi-circle</v-icon>
          </template>
        </v-list-item>

        <v-list-item
          prepend-icon="mdi-circle"
          title="Warning"
          class="nav-item"
        >
          <template v-slot:prepend>
            <v-icon color="warning" size="x-small">mdi-circle</v-icon>
          </template>
        </v-list-item>

        <v-list-item
          prepend-icon="mdi-circle"
          title="Informational"
          class="nav-item"
        >
          <template v-slot:prepend>
            <v-icon color="info" size="x-small">mdi-circle</v-icon>
          </template>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- Main Content Area -->
    <v-main class="main-content">
      <v-container fluid class="pa-4">
        <!-- Page Header -->
        <div class="content-header mb-4" v-if="showHeader">
          <v-row>
            <v-col cols="12" md="6">
              <h1 class="text-h5 font-weight-medium">{{ pageTitle }}</h1>
            </v-col>
            <v-col cols="12" md="6">
              <v-breadcrumbs
                :items="breadcrumbs"
                class="pa-0 justify-end"
              >
                <template v-slot:prepend>
                  <v-icon size="small">mdi-home</v-icon>
                </template>
              </v-breadcrumbs>
            </v-col>
          </v-row>
        </div>

        <!-- Page Content -->
        <slot></slot>
      </v-container>
    </v-main>

    <!-- Footer -->
    <v-footer app height="auto" color="white" elevation="1">
      <v-container fluid>
        <v-row no-gutters align="center">
          <v-col cols="12" md="6">
            <span class="text-caption">
              Copyright © 2024 <a href="#">AdminLTE.io</a>. All rights reserved.
            </span>
          </v-col>
          <v-col cols="12" md="6" class="text-right">
            <span class="text-caption text-grey">Version 3.2.0</span>
          </v-col>
        </v-row>
      </v-container>
    </v-footer>
  </v-app>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const props = defineProps({
  pageTitle: {
    type: String,
    default: 'Dashboard'
  },
  showHeader: {
    type: Boolean,
    default: true
  }
})

const drawer = ref(true)
const searchQuery = ref('')
const page = usePage()

const userName = computed(() => page.props.auth?.user?.name || 'Alexander Pierce')
const userImage = computed(() => page.props.auth?.user?.avatar || 'https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg')

const breadcrumbs = computed(() => {
  const path = window.location.pathname
  const segments = path.split('/').filter(s => s)
  
  return segments.map((segment, index) => ({
    title: segment.charAt(0).toUpperCase() + segment.slice(1),
    disabled: index === segments.length - 1,
    to: '/' + segments.slice(0, index + 1).join('/')
  }))
})

const layoutOptions = [
  { title: 'Top Navigation', route: '/admin/layout/top-nav' },
  { title: 'Top Navigation + Sidebar', route: '/admin/layout/top-nav-sidebar' },
  { title: 'Boxed', route: '/admin/layout/boxed' },
  { title: 'Fixed Sidebar', route: '/admin/layout/fixed-sidebar' },
  { title: 'Fixed Navbar', route: '/admin/layout/fixed-navbar' },
  { title: 'Fixed Footer', route: '/admin/layout/fixed-footer' },
]

const chartTypes = ['ChartJS', 'Flot', 'Inline', 'uPlot']
const uiElements = ['General', 'Icons', 'Buttons', 'Sliders', 'Modals', 'Tabs']
const formTypes = ['General Elements', 'Advanced Elements', 'Editors', 'Validation']
const tableTypes = ['Simple Tables', 'DataTables', 'jsGrid']

const isActive = (route) => {
  return window.location.pathname === route
}

const navigate = (route) => {
  router.visit(route)
}

const toggleFullscreen = () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen()
  } else {
    document.exitFullscreen()
  }
}
</script>

<style scoped>
#admin-app {
  font-family: 'Source Sans Pro', sans-serif;
}

.brand-link {
  display: flex;
  align-items: center;
  padding: 0.8125rem 0.5rem;
  border-bottom: 1px solid #4b545c;
  color: white;
}

.brand-image {
  margin-left: 0.5rem;
  margin-right: 0.5rem;
}

.brand-text {
  font-weight: 300;
  font-size: 1.25rem;
}

.user-panel {
  border-bottom: 1px solid #4b545c;
}

.sidebar-menu .v-list-item {
  color: #c2c7d0;
}

.sidebar-menu .v-list-item:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.sidebar-menu .v-list-item--active {
  background-color: rgba(255, 255, 255, 0.9);
  color: #343a40;
}

.nav-item {
  margin-bottom: 2px;
}

.main-content {
  background-color: #f4f6f9;
  min-height: calc(100vh - 57px - 56px);
}

.content-header {
  padding-top: 0.5rem;
}

:deep(.v-navigation-drawer__content) {
  background-color: #343a40;
}

:deep(.v-list) {
  background: transparent;
}

:deep(.v-list-group__items) {
  background: rgba(0, 0, 0, 0.1);
}
</style>
