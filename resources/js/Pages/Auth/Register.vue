<template>
  <VuetifyLayout>
    <v-container class="fill-height d-flex align-center justify-center">
      <v-card max-width="600" class="mx-auto pa-6" elevation="8">
        <v-card-title class="text-center">
          <v-avatar color="primary" size="60" class="mb-4">
            <v-icon size="35" color="white">mdi-motorcycle</v-icon>
          </v-avatar>
          <h2 class="text-h4 font-weight-bold">Create Account</h2>
          <p class="text-subtitle-1 text-grey mt-2">Join ManCycle to start buying and selling</p>
        </v-card-title>

        <v-card-text>
          <v-form @submit.prevent="submit" v-model="formValid">
            <!-- Account Type Selection -->
            <v-radio-group
              v-model="form.account_type"
              inline
              class="mb-4"
            >
              <template v-slot:label>
                <div class="text-subtitle-1 font-weight-bold mb-2">Account Type</div>
              </template>
              <v-radio label="Buyer" value="buyer"></v-radio>
              <v-radio label="Individual Seller" value="seller"></v-radio>
              <v-radio label="Dealer/Brand" value="brand_admin"></v-radio>
            </v-radio-group>

            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="form.name"
                  label="Full Name"
                  prepend-inner-icon="mdi-account"
                  variant="outlined"
                  required
                  :rules="[rules.required]"
                  :error-messages="form.errors.name"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="form.phone"
                  label="Phone Number"
                  prepend-inner-icon="mdi-phone"
                  variant="outlined"
                  :rules="[rules.phone]"
                  :error-messages="form.errors.phone"
                ></v-text-field>
              </v-col>
            </v-row>

            <!-- Company Name for Dealers -->
            <v-text-field
              v-if="form.account_type === 'brand_admin'"
              v-model="form.company_name"
              label="Company/Dealership Name"
              prepend-inner-icon="mdi-domain"
              variant="outlined"
              required
              :rules="form.account_type === 'brand_admin' ? [rules.required] : []"
              :error-messages="form.errors.company_name"
              class="mb-3"
            ></v-text-field>

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

            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="form.password"
                  label="Password"
                  :type="showPassword ? 'text' : 'password'"
                  prepend-inner-icon="mdi-lock"
                  :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                  @click:append-inner="showPassword = !showPassword"
                  variant="outlined"
                  required
                  :rules="[rules.required, rules.password]"
                  :error-messages="form.errors.password"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="form.password_confirmation"
                  label="Confirm Password"
                  :type="showPassword ? 'text' : 'password'"
                  prepend-inner-icon="mdi-lock-check"
                  variant="outlined"
                  required
                  :rules="[rules.required, rules.passwordMatch]"
                  :error-messages="form.errors.password_confirmation"
                ></v-text-field>
              </v-col>
            </v-row>

            <!-- Location Field -->
            <v-text-field
              v-model="form.address"
              label="City/Location"
              prepend-inner-icon="mdi-map-marker"
              variant="outlined"
              :error-messages="form.errors.address"
              class="mb-3"
            ></v-text-field>

            <!-- Terms and Conditions -->
            <v-checkbox
              v-model="form.terms"
              color="primary"
              class="mb-4"
              :rules="[rules.terms]"
            >
              <template v-slot:label>
                <div>
                  I agree to the
                  <Link href="/terms" class="text-primary">Terms and Conditions</Link>
                  and
                  <Link href="/privacy" class="text-primary">Privacy Policy</Link>
                </div>
              </template>
            </v-checkbox>

            <!-- Submit Button -->
            <v-btn
              type="submit"
              color="primary"
              size="large"
              block
              :loading="form.processing"
              :disabled="!formValid || !form.terms"
            >
              Create Account
            </v-btn>
          </v-form>

          <v-divider class="my-6"></v-divider>

          <!-- Sign In Link -->
          <div class="text-center">
            <span class="text-body-2">Already have an account?</span>
            <Link
              href="/login"
              class="text-primary text-decoration-none font-weight-bold ms-1"
            >
              Sign in
            </Link>
          </div>
        </v-card-text>
      </v-card>
    </v-container>
  </VuetifyLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import VuetifyLayout from '@/Layouts/VuetifyLayout.vue'

const showPassword = ref(false)
const formValid = ref(false)

const form = useForm({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
  account_type: 'buyer',
  company_name: '',
  address: '',
  terms: false,
})

const rules = {
  required: value => !!value || 'This field is required',
  email: value => {
    const pattern = /^[^@]+@[^@]+\.[^@]+$/
    return pattern.test(value) || 'Enter a valid email'
  },
  phone: value => {
    if (!value) return true
    const pattern = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/
    return pattern.test(value) || 'Enter a valid phone number'
  },
  password: value => {
    if (!value) return 'Password is required'
    if (value.length < 8) return 'Password must be at least 8 characters'
    return true
  },
  passwordMatch: value => {
    return value === form.password || 'Passwords do not match'
  },
  terms: value => !!value || 'You must agree to the terms',
}

const submit = () => {
  // Set role based on account type
  const roleMap = {
    'buyer': 'user',
    'seller': 'seller',
    'brand_admin': 'brand_admin'
  }
  
  const data = {
    ...form.data(),
    role: roleMap[form.account_type],
    seller_type: form.account_type === 'brand_admin' ? 'brand' : 
                 form.account_type === 'seller' ? 'individual' : null
  }
  
  form.transform(() => data).post('/register', {
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<style scoped>
.v-container {
  min-height: calc(100vh - 200px);
}
</style>
