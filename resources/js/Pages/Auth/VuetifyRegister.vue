<template>
  <v-app>
    <v-main>
      <v-container fluid class="fill-height">
        <v-row justify="center" align="center" class="fill-height">
          <v-col cols="12" sm="8" md="6" lg="4">
            <!-- Logo Section -->
            <div class="text-center mb-8">
              <Link href="/" class="text-decoration-none">
                <v-avatar color="primary" size="64" class="mb-4">
                  <v-icon color="white" size="32">mdi-motorcycle</v-icon>
                </v-avatar>
                <h1 class="text-h4 font-weight-bold text-primary">ManCycle</h1>
              </Link>
              <h2 class="text-h5 mt-4 mb-2">Create account</h2>
              <p class="text-body-1 text-grey-darken-1">Join our marketplace today</p>
            </div>

            <!-- Registration Form -->
            <v-card elevation="8" class="pa-6">
              <v-form @submit.prevent="submit">
                <v-text-field
                  v-model="form.name"
                  label="Full name"
                  variant="outlined"
                  prepend-inner-icon="mdi-account"
                  :error-messages="form.errors.name"
                  required
                  class="mb-4"
                ></v-text-field>

                <v-text-field
                  v-model="form.email"
                  label="Email address"
                  type="email"
                  variant="outlined"
                  prepend-inner-icon="mdi-email"
                  :error-messages="form.errors.email"
                  required
                  class="mb-4"
                ></v-text-field>

                <v-text-field
                  v-model="form.password"
                  label="Password"
                  :type="showPassword ? 'text' : 'password'"
                  variant="outlined"
                  prepend-inner-icon="mdi-lock"
                  :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  @click:append-inner="showPassword = !showPassword"
                  :error-messages="form.errors.password"
                  required
                  class="mb-4"
                ></v-text-field>

                <v-text-field
                  v-model="form.password_confirmation"
                  label="Confirm password"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  variant="outlined"
                  prepend-inner-icon="mdi-lock-check"
                  :append-inner-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  @click:append-inner="showConfirmPassword = !showConfirmPassword"
                  required
                  class="mb-4"
                ></v-text-field>

                <v-checkbox
                  v-model="form.terms"
                  required
                  class="mb-4"
                >
                  <template v-slot:label>
                    <div>
                      I agree to the 
                      <Link href="/terms" class="text-primary text-decoration-none">Terms of Service</Link>
                      and 
                      <Link href="/privacy" class="text-primary text-decoration-none">Privacy Policy</Link>
                    </div>
                  </template>
                </v-checkbox>

                <v-btn
                  type="submit"
                  color="primary"
                  size="large"
                  block
                  :loading="form.processing"
                  class="mb-4"
                >
                  <v-icon left>mdi-account-plus</v-icon>
                  Create Account
                </v-btn>
              </v-form>

              <v-divider class="my-4"></v-divider>

              <div class="text-center">
                <p class="text-body-2 text-grey-darken-1 mb-3">Already have an account?</p>
                <v-btn
                  :to="'/login'"
                  variant="outlined"
                  color="primary"
                  size="large"
                  block
                >
                  Sign in instead
                </v-btn>
              </div>
            </v-card>

            <!-- Back to Home -->
            <div class="text-center mt-6">
              <Link href="/" class="text-primary text-decoration-none">
                <v-icon left>mdi-arrow-left</v-icon>
                Back to Home
              </Link>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const showPassword = ref(false)
const showConfirmPassword = ref(false)

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false,
})

const submit = () => {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<style scoped>
.fill-height {
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>