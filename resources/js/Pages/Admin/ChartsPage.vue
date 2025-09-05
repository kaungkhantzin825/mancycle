<template>
  <AdminLTELayout page-title="ChartJS">
    <!-- Breadcrumb additional info -->
    <v-row class="mb-4">
      <v-col>
        <span class="text-subtitle-2">
          <router-link to="/" class="text-primary">Home</router-link> / ChartJS
        </span>
      </v-col>
    </v-row>

    <!-- Charts Row 1 -->
    <v-row>
      <!-- Area Chart -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="d-flex align-center justify-space-between bg-primary text-white">
            <span>Area Chart</span>
            <div>
              <v-btn icon="mdi-minus" size="x-small" variant="text" color="white"></v-btn>
              <v-btn icon="mdi-close" size="x-small" variant="text" color="white"></v-btn>
            </div>
          </v-card-title>
          <v-card-text class="pa-4">
            <canvas ref="areaChart" height="250"></canvas>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Line Chart -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="d-flex align-center justify-space-between bg-teal text-white">
            <span>Line Chart</span>
            <div>
              <v-btn icon="mdi-minus" size="x-small" variant="text" color="white"></v-btn>
              <v-btn icon="mdi-close" size="x-small" variant="text" color="white"></v-btn>
            </div>
          </v-card-title>
          <v-card-text class="pa-4">
            <canvas ref="lineChart" height="250"></canvas>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Charts Row 2 -->
    <v-row class="mt-4">
      <!-- Donut Chart -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="d-flex align-center justify-space-between bg-red text-white">
            <span>Donut Chart</span>
            <div>
              <v-btn icon="mdi-minus" size="x-small" variant="text" color="white"></v-btn>
              <v-btn icon="mdi-close" size="x-small" variant="text" color="white"></v-btn>
            </div>
          </v-card-title>
          <v-card-text class="pa-4 text-center">
            <canvas ref="donutChart" height="250"></canvas>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Bar Chart -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="d-flex align-center justify-space-between bg-green text-white">
            <span>Bar Chart</span>
            <div>
              <v-btn icon="mdi-minus" size="x-small" variant="text" color="white"></v-btn>
              <v-btn icon="mdi-close" size="x-small" variant="text" color="white"></v-btn>
            </div>
          </v-card-title>
          <v-card-text class="pa-4">
            <canvas ref="barChart" height="250"></canvas>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Charts Row 3 -->
    <v-row class="mt-4">
      <!-- Pie Chart -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="d-flex align-center justify-space-between bg-warning">
            <span>Pie Chart</span>
            <div>
              <v-btn icon="mdi-minus" size="x-small" variant="text"></v-btn>
              <v-btn icon="mdi-close" size="x-small" variant="text"></v-btn>
            </div>
          </v-card-title>
          <v-card-text class="pa-4 text-center">
            <canvas ref="pieChart" height="250"></canvas>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Stacked Bar Chart -->
      <v-col cols="12" md="6">
        <v-card>
          <v-card-title class="d-flex align-center justify-space-between bg-success text-white">
            <span>Stacked Bar Chart</span>
            <div>
              <v-btn icon="mdi-minus" size="x-small" variant="text" color="white"></v-btn>
              <v-btn icon="mdi-close" size="x-small" variant="text" color="white"></v-btn>
            </div>
          </v-card-title>
          <v-card-text class="pa-4">
            <canvas ref="stackedBarChart" height="250"></canvas>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </AdminLTELayout>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import AdminLTELayout from '@/Layouts/AdminLTELayout.vue'
import Chart from 'chart.js/auto'

const areaChart = ref(null)
const lineChart = ref(null)
const donutChart = ref(null)
const barChart = ref(null)
const pieChart = ref(null)
const stackedBarChart = ref(null)

onMounted(() => {
  // Area Chart
  if (areaChart.value) {
    new Chart(areaChart.value, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label: 'Digital Goods',
            backgroundColor: 'rgba(60,141,188,0.5)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [28, 48, 40, 59, 86, 27, 90],
            fill: true,
            tension: 0.1
          },
          {
            label: 'Electronics',
            backgroundColor: 'rgba(210, 214, 222, 0.5)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: true,
            tension: 0.1
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true
          }
        }
      }
    })
  }

  // Line Chart
  if (lineChart.value) {
    new Chart(lineChart.value, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label: 'Dataset 1',
            borderColor: 'rgba(60,141,188,1)',
            backgroundColor: 'transparent',
            data: [65, 59, 80, 81, 56, 55, 40],
            tension: 0.4
          },
          {
            label: 'Dataset 2',
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'transparent',
            data: [28, 48, 40, 59, 86, 27, 90],
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    })
  }

  // Donut Chart
  if (donutChart.value) {
    new Chart(donutChart.value, {
      type: 'doughnut',
      data: {
        labels: ['Chrome', 'IE', 'Firefox', 'Safari', 'Opera', 'Navigator'],
        datasets: [{
          data: [700, 500, 400, 600, 300, 100],
          backgroundColor: [
            '#f56954',
            '#00a65a',
            '#f39c12',
            '#00c0ef',
            '#3c8dbc',
            '#d2d6de'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    })
  }

  // Bar Chart
  if (barChart.value) {
    new Chart(barChart.value, {
      type: 'bar',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label: 'Electronics',
            backgroundColor: 'rgba(60, 179, 113, 0.9)',
            data: [65, 59, 80, 81, 56, 55, 40]
          },
          {
            label: 'Digital Goods',
            backgroundColor: 'rgba(210, 214, 222, 0.9)',
            data: [28, 48, 40, 59, 86, 27, 90]
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    })
  }

  // Pie Chart
  if (pieChart.value) {
    new Chart(pieChart.value, {
      type: 'pie',
      data: {
        labels: ['Chrome', 'IE', 'Firefox', 'Safari', 'Opera', 'Navigator'],
        datasets: [{
          data: [700, 500, 400, 600, 300, 100],
          backgroundColor: [
            '#f56954',
            '#00a65a',
            '#f39c12',
            '#00c0ef',
            '#3c8dbc',
            '#d2d6de'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    })
  }

  // Stacked Bar Chart
  if (stackedBarChart.value) {
    new Chart(stackedBarChart.value, {
      type: 'bar',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label: 'Series 1',
            backgroundColor: '#00a65a',
            data: [30, 40, 50, 60, 70, 80, 90]
          },
          {
            label: 'Series 2',
            backgroundColor: '#f39c12',
            data: [20, 30, 40, 50, 60, 70, 80]
          },
          {
            label: 'Series 3',
            backgroundColor: '#dd4b39',
            data: [10, 20, 30, 40, 50, 60, 70]
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            stacked: true
          },
          y: {
            stacked: true
          }
        }
      }
    })
  }
})
</script>

<style scoped>
canvas {
  max-height: 250px;
}
</style>
