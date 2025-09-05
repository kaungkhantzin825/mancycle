<template>
  <AdminLTELayout page-title="Dashboard v2">
    <!-- Page Header -->
    <div class="mb-6">
      <h1 class="text-h4 font-weight-bold mb-2">Dashboard Overview</h1>
      <p class="text-subtitle-1 text-grey-darken-1">
        Welcome back, {{ $page.props.auth.user.name }}! Here's what's happening with your platform today.
      </p>
    </div>

    <!-- Quick Stats Cards -->
    <v-row class="mb-6">
      <v-col cols="12" sm="6" md="3" v-for="stat in quickStats" :key="stat.title">
        <v-card :color="stat.color" dark elevation="2">
          <v-card-text class="pa-4">
            <div class="d-flex align-center justify-space-between">
              <div>
                <p class="text-subtitle-2 mb-1">{{ stat.title }}</p>
                <p class="text-h4 font-weight-bold">{{ stat.value }}</p>
                <div class="d-flex align-center mt-2">
                  <v-icon size="small" :color="stat.trending > 0 ? 'success' : 'error'">
                    {{ stat.trending > 0 ? 'mdi-trending-up' : 'mdi-trending-down' }}
                  </v-icon>
                  <span class="text-caption ml-1">
                    {{ Math.abs(stat.trending) }}% from last month
                  </span>
                </div>
              </div>
              <v-icon size="48" class="opacity-50">{{ stat.icon }}</v-icon>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Charts Row -->
    <v-row class="mb-6">
      <!-- Revenue Chart -->
      <v-col cols="12" md="8">
        <v-card elevation="2">
          <v-card-title class="d-flex align-center justify-space-between">
            <span>Platform Activity</span>
            <v-btn-toggle v-model="chartPeriod" mandatory density="compact">
              <v-btn value="day">Day</v-btn>
              <v-btn value="week">Week</v-btn>
              <v-btn value="month">Month</v-btn>
              <v-btn value="year">Year</v-btn>
            </v-btn-toggle>
          </v-card-title>
          <v-card-text>
            <v-sparkline
              :value="activityData"
              :gradient="['#f72047', '#ffd200', '#1feaea']"
              :line-width="3"
              :padding="8"
              stroke-linecap="round"
              smooth
              height="250"
              auto-draw
            >
              <template v-slot:label="item">
                {{ item.value }} listings
              </template>
            </v-sparkline>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Category Distribution -->
      <v-col cols="12" md="4">
        <v-card elevation="2" height="100%">
          <v-card-title>Category Distribution</v-card-title>
          <v-card-text>
            <v-progress-circular
              :model-value="75"
              :size="150"
              :width="15"
              color="primary"
              class="mx-auto d-block mb-4"
            >
              <span class="text-h5 font-weight-bold">75%</span>
            </v-progress-circular>
            <v-list density="compact">
              <v-list-item v-for="cat in categoryStats" :key="cat.name">
                <template v-slot:prepend>
                  <v-icon :color="cat.color" size="small">mdi-circle</v-icon>
                </template>
                <v-list-item-title>{{ cat.name }}</v-list-item-title>
                <template v-slot:append>
                  <span class="text-caption">{{ cat.value }}%</span>
                </template>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Recent Activities -->
    <v-row class="mb-6">
      <!-- Pending Approvals -->
      <v-col cols="12" md="6">
        <v-card elevation="2">
          <v-card-title class="d-flex align-center justify-space-between">
            <span>
              <v-icon class="mr-2">mdi-clock-outline</v-icon>
              Pending Approvals
            </span>
            <v-chip color="warning" size="small">{{ pendingApprovals.length }} Items</v-chip>
          </v-card-title>
          <v-card-text class="pa-0">
            <v-list lines="two">
              <v-list-item
                v-for="item in pendingApprovals"
                :key="item.id"
                @click="viewApproval(item)"
              >
                <template v-slot:prepend>
                  <v-avatar :color="item.color">
                    <v-icon>{{ item.icon }}</v-icon>
                  </v-avatar>
                </template>
                <v-list-item-title>{{ item.title }}</v-list-item-title>
                <v-list-item-subtitle>{{ item.subtitle }}</v-list-item-subtitle>
                <template v-slot:append>
                  <div class="text-center">
                    <v-btn icon="mdi-check" size="small" color="success" variant="text"></v-btn>
                    <v-btn icon="mdi-close" size="small" color="error" variant="text"></v-btn>
                  </div>
                </template>
              </v-list-item>
            </v-list>
            <v-divider></v-divider>
            <v-card-actions>
              <v-btn variant="text" color="primary" block>
                View All Pending
                <v-icon end>mdi-arrow-right</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Recent Users -->
      <v-col cols="12" md="6">
        <v-card elevation="2">
          <v-card-title>
            <v-icon class="mr-2">mdi-account-multiple</v-icon>
            Recent User Registrations
          </v-card-title>
          <v-card-text class="pa-0">
            <v-data-table
              :headers="userHeaders"
              :items="recentUsers"
              :items-per-page="5"
              density="compact"
            >
              <template v-slot:item.status="{ item }">
                <v-chip
                  :color="item.status === 'approved' ? 'success' : 'warning'"
                  size="small"
                >
                  {{ item.status }}
                </v-chip>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn icon="mdi-eye" size="small" variant="text"></v-btn>
                <v-btn icon="mdi-pencil" size="small" variant="text"></v-btn>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Quick Actions & System Health -->
    <v-row>
      <!-- Quick Actions -->
      <v-col cols="12" md="4">
        <v-card elevation="2">
          <v-card-title>
            <v-icon class="mr-2">mdi-lightning-bolt</v-icon>
            Quick Actions
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item
                v-for="action in quickActions"
                :key="action.title"
                @click="$inertia.visit(action.route)"
                :prepend-icon="action.icon"
                :title="action.title"
                :subtitle="action.subtitle"
                class="mb-2"
              >
                <template v-slot:prepend>
                  <v-avatar :color="action.color">
                    <v-icon>{{ action.icon }}</v-icon>
                  </v-avatar>
                </template>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- System Health -->
      <v-col cols="12" md="4">
        <v-card elevation="2">
          <v-card-title>
            <v-icon class="mr-2">mdi-heart-pulse</v-icon>
            System Health
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item v-for="item in systemHealth" :key="item.name">
                <v-list-item-title>{{ item.name }}</v-list-item-title>
                <template v-slot:append>
                  <div class="d-flex align-center">
                    <v-progress-linear
                      :model-value="item.value"
                      :color="item.value > 80 ? 'error' : item.value > 50 ? 'warning' : 'success'"
                      height="6"
                      rounded
                      class="mr-2"
                      style="min-width: 100px"
                    ></v-progress-linear>
                    <span class="text-caption">{{ item.value }}%</span>
                  </div>
                </template>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Recent Activity Log -->
      <v-col cols="12" md="4">
        <v-card elevation="2">
          <v-card-title>
            <v-icon class="mr-2">mdi-history</v-icon>
            Recent Activity
          </v-card-title>
          <v-card-text class="pa-0">
            <v-timeline density="compact" side="end">
              <v-timeline-item
                v-for="activity in recentActivities"
                :key="activity.id"
                :dot-color="activity.color"
                size="small"
              >
                <div class="mb-3">
                  <div class="font-weight-bold">{{ activity.title }}</div>
                  <div class="text-caption">{{ activity.time }}</div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Floating Action Button -->
    <v-btn
      color="primary"
      icon="mdi-plus"
      size="large"
      position="fixed"
      location="bottom end"
      class="mb-4 mr-4"
      elevation="8"
      @click="showQuickAdd = true"
    ></v-btn>

    <!-- Quick Add Dialog -->
    <v-dialog v-model="showQuickAdd" width="500">
      <v-card>
        <v-card-title>Quick Add</v-card-title>
        <v-card-text>
          <v-list>
            <v-list-item
              v-for="item in quickAddItems"
              :key="item.title"
              @click="quickAddAction(item)"
              :prepend-icon="item.icon"
              :title="item.title"
              :subtitle="item.subtitle"
            ></v-list-item>
          </v-list>
        </v-card-text>
      </v-card>
    </v-dialog>
  </AdminLTELayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import AdminLTELayout from '@/Layouts/AdminLTELayout.vue'

const props = defineProps({
  stats: Object,
  pendingUsers: Array,
  pendingListings: Array,
  recentUsers: Array,
  recentListings: Array,
})

const chartPeriod = ref('month')
const showQuickAdd = ref(false)

const quickStats = ref([
  {
    title: 'Total Users',
    value: props.stats?.totalUsers || '0',
    icon: 'mdi-account-group',
    color: 'primary',
    trending: 12.5
  },
  {
    title: 'Active Listings',
    value: props.stats?.activeListings || '0',
    icon: 'mdi-car',
    color: 'success',
    trending: 8.3
  },
  {
    title: 'Pending Approvals',
    value: props.stats?.pendingApprovals || '0',
    icon: 'mdi-clock-alert',
    color: 'warning',
    trending: -5.2
  },
  {
    title: 'Monthly Views',
    value: props.stats?.monthlyViews || '0',
    icon: 'mdi-eye',
    color: 'info',
    trending: 15.7
  }
])

const activityData = ref([5, 10, 5, 15, 10, 20, 15, 25, 20, 30, 25, 35])

const categoryStats = ref([
  { name: 'Motorcycles', value: 45, color: 'primary' },
  { name: 'Cars', value: 30, color: 'success' },
  { name: 'Scooters', value: 15, color: 'warning' },
  { name: 'Parts', value: 10, color: 'info' }
])

const pendingApprovals = ref(props.pendingUsers?.slice(0, 3) || [
  {
    id: 1,
    title: 'New Seller Registration',
    subtitle: 'John Doe - Dealer Account',
    icon: 'mdi-account',
    color: 'primary'
  },
  {
    id: 2,
    title: '2023 Harley Davidson',
    subtitle: 'Listing pending review',
    icon: 'mdi-motorbike',
    color: 'warning'
  },
  {
    id: 3,
    title: 'Reported Content',
    subtitle: 'User complaint about listing',
    icon: 'mdi-alert',
    color: 'error'
  }
])

const recentUsers = ref(props.recentUsers || [
  {
    id: 1,
    name: 'John Smith',
    email: 'john@example.com',
    role: 'Seller',
    status: 'pending',
    joined: '2 hours ago'
  },
  {
    id: 2,
    name: 'Sarah Johnson',
    email: 'sarah@example.com',
    role: 'Buyer',
    status: 'approved',
    joined: '5 hours ago'
  },
  {
    id: 3,
    name: 'Mike Chen',
    email: 'mike@example.com',
    role: 'Dealer',
    status: 'pending',
    joined: '1 day ago'
  }
])

const userHeaders = [
  { title: 'Name', key: 'name' },
  { title: 'Email', key: 'email' },
  { title: 'Role', key: 'role' },
  { title: 'Status', key: 'status' },
  { title: 'Actions', key: 'actions', sortable: false }
]

const quickActions = ref([
  {
    title: 'Add New Category',
    subtitle: 'Create vehicle category',
    icon: 'mdi-folder-plus',
    color: 'primary',
    route: '/admin/categories/create'
  },
  {
    title: 'Broadcast Message',
    subtitle: 'Send to all users',
    icon: 'mdi-broadcast',
    color: 'success',
    route: '/admin/broadcast'
  },
  {
    title: 'Generate Report',
    subtitle: 'Export analytics data',
    icon: 'mdi-file-chart',
    color: 'info',
    route: '/admin/reports'
  },
  {
    title: 'Backup Database',
    subtitle: 'Create system backup',
    icon: 'mdi-database-export',
    color: 'warning',
    route: '/admin/backup'
  }
])

const systemHealth = ref([
  { name: 'CPU Usage', value: 45 },
  { name: 'Memory', value: 62 },
  { name: 'Storage', value: 78 },
  { name: 'Database', value: 35 },
  { name: 'Cache', value: 25 }
])

const recentActivities = ref([
  {
    id: 1,
    title: 'New user registered',
    time: '2 minutes ago',
    color: 'primary'
  },
  {
    id: 2,
    title: 'Listing approved',
    time: '15 minutes ago',
    color: 'success'
  },
  {
    id: 3,
    title: 'System backup completed',
    time: '1 hour ago',
    color: 'info'
  },
  {
    id: 4,
    title: 'User reported content',
    time: '2 hours ago',
    color: 'warning'
  }
])

const quickAddItems = ref([
  {
    title: 'Add User',
    subtitle: 'Create new user account',
    icon: 'mdi-account-plus',
    route: '/admin/users/create'
  },
  {
    title: 'Add Category',
    subtitle: 'Create new category',
    icon: 'mdi-folder-plus',
    route: '/admin/categories/create'
  },
  {
    title: 'Send Notification',
    subtitle: 'Broadcast to users',
    icon: 'mdi-bell-plus',
    route: '/admin/notifications/create'
  }
])

const viewApproval = (item) => {
  console.log('View approval:', item)
}

const quickAddAction = (item) => {
  showQuickAdd.value = false
  router.visit(item.route)
}
</script>

<style scoped>
.v-card {
  transition: transform 0.2s;
}

.v-card:hover {
  transform: translateY(-2px);
}
</style>
