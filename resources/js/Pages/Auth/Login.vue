<template>
  <VuetifyLayout>
    <v-container class="fill-height d-flex align-center justify-center">
      <v-card max-width="500" class="mx-auto pa-6" elevation="8">
        <v-card-title class="text-center">
          <v-avatar color="primary" size="60" class="mb-4">
            <v-icon size="35" color="white">mdi-motorcycle</v-icon>
          </v-avatar>
          <h2 class="text-h4 font-weight-bold">Welcome Back!</h2>
          <p class="text-subtitle-1 text-grey mt-2">Sign in to your ManCycle account</p>
        </v-card-title>

        <v-card-text>
          <v-form @submit.prevent="submit" v-model="formValid">
            <!-- Email Field -->
            <v-text-field
              v-model="form.email"
              label="Email Address"
              type="email"
              prepend-inner-icon="mdi-email"
              variant="outlined"
              required
              :rules="[rules.required, rules.email]"
              :error-messages="form.errors.email"
              class="mb-3"
            ></v-text-field>

            <!-- Password Field -->
            <v-text-field
              v-model="form.password"
              label="Password"
              :type="showPassword ? 'text' : 'password'"
              prepend-inner-icon="mdi-lock"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              @click:append-inner="showPassword = !showPassword"
              variant="outlined"
              required
              :rules="[rules.required]"
              :error-messages="form.errors.password"
              class="mb-2"
            ></v-text-field>

            <!-- Remember Me -->
            <div class="d-flex justify-space-between align-center mb-4">
              <v-checkbox
                v-model="form.remember"
                label="Remember me"
                hide-details
                density="compact"
                color="primary"
              ></v-checkbox>
              <Link
                href="/forgot-password"
                class="text-primary text-decoration-none"
              >
                Forgot password?
              </Link>
            </div>

            <!-- Submit Button -->
            <v-btn
              type="submit"
              color="primary"
              size="large"
              block
              :loading="form.processing"
              :disabled="!formValid"
            >
              Sign In
            </v-btn>
          </v-form>

          <v-divider class="my-6"></v-divider>

          <!-- Sign Up Link -->
          <div class="text-center">
            <span class="text-body-2">Don't have an account?</span>
            <Link
              href="/register"
              class="text-primary text-decoration-none font-weight-bold ms-1"
            >
              Sign up
            </Link>
          </div>
        </v-card-text>
      </v-card>
    </v-container>
  </VuetifyLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import VuetifyLayout from '@/Layouts/VuetifyLayout.vue'

const props = defineProps({
  canResetPassword: Boolean,
  status: String,
})

const showPassword = ref(false)
const formValid = ref(false)

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const rules = {
  required: value => !!value || 'This field is required',
  email: value => {
    const pattern = /^[^@]+@[^@]+\.[^@]+$/
    return pattern.test(value) || 'Enter a valid email'
  },
}

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  })
}
</script>

<style scoped>
.v-container {
  min-height: calc(100vh - 200px);
}
</style>
