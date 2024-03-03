<template>
  <div>
    <form @submit.prevent="submitForm" style="width: 500px">
      <div class="border-1 surface-border surface-card border-round py-7 px-4 md:px-7 z-1">
        <div class="mb-4">
          <div class="text-900 text-xl font-bold mb-2">Register</div>
          <span class="text-600 font-medium">
            Please enter your details to create an account
          </span>
        </div>

        <div>
          <!-- Name -->
          <div class="field mb-3">
            <div class="flex justify-content-between gap-3">
              <div>
                <p-icon-field icon-position="left">
                  <p-input-icon class="pi pi-user"></p-input-icon>
                  <p-input-text
                    id="first-name"
                    type="text"
                    class="w-full"
                    :class="{ 'p-invalid' : hasFirstNameError }"
                    placeholder="First Name"
                    v-model="form.first_name"
                  />
                </p-icon-field>
              </div>
              <div>
                <p-icon-field icon-position="left">
                  <p-input-icon class="pi pi-user"></p-input-icon>
                  <p-input-text
                    id="last-name"
                    type="text"
                    class="w-full"
                    :class="{ 'p-invalid' : hasLastNameError }"
                    placeholder="Last Name"
                    v-model="form.last_name"
                  />
                </p-icon-field>
              </div>
            </div>


            <small
              v-if="hasNameError"
              class="p-error"
            >
              {{ nameError }}
            </small>
          </div>

          <!-- Username -->
          <div class="field mb-3">
            <p-icon-field icon-position="left">
              <p-input-icon class="pi pi-user"></p-input-icon>
              <p-input-text
                id="username"
                type="text"
                class="w-full"
                :class="{ 'p-invalid' : hasUsernameError }"
                placeholder="Username"
                v-model="form.username"
              />
            </p-icon-field>

            <small
              v-if="hasUsernameError"
              class="p-error"
            >
              {{ formError.username[0] }}
            </small>
          </div>

          <!-- Email Address -->
          <div class="field mb-3">
            <p-icon-field icon-position="left">
              <p-input-icon class="pi pi-envelope"></p-input-icon>
              <p-input-text
                id="email-address"
                type="text"
                class="w-full"
                :class="{ 'p-invalid' : hasEmailError }"
                placeholder="Email Address"
                v-model="form.email"
              />
            </p-icon-field>

            <small
              v-if="hasEmailError"
              class="p-error"
            >
              {{ formError.email[0] }}
            </small>
          </div>

          <!-- Password -->
          <div class="field mb-3">
            <p-icon-field icon-position="left">
              <p-input-icon class="pi pi-lock"></p-input-icon>
              <p-input-text
                id="password"
                type="password"
                class="w-full"
                :class="{ 'p-invalid' : hasPasswordError }"
                v-model="form.password"
                placeholder="Password"
              />
            </p-icon-field>

            <small
              v-if="hasPasswordError"
              class="p-error"
            >
              {{ formError.password[0] }}
            </small>
          </div>

          <!-- Confirm Password -->
          <div class="field mb-3">
            <p-icon-field icon-position="left">
              <p-input-icon class="pi pi-lock"></p-input-icon>
              <p-input-text
                id="confirm-password"
                type="password"
                class="w-full"
                :class="{ 'p-invalid' : hasConfirmPasswordError }"
                v-model="form.password_confirmation"
                placeholder="Confirm Password"
              />
            </p-icon-field>

            <small
              v-if="hasConfirmPasswordError"
              class="p-error"
            >
              {{ formError.password_confirmation[0] }}
            </small>
          </div>

          <!-- Terms and Conditions -->
          <div class="field mb-3">
            <div class="flex">
              <p-checkbox
                id="terms-and-conditions"
                v-model="terms"
                binary
              />
              <label for="terms-and-conditions" class="text-600 ml-2">
                I agree to the <a href="#" class="text-primary-500">Terms and Conditions</a>
              </label>
            </div>
          </div>

          <p-button
            :loading="loading"
            label="Create Account"
            class="my-3 w-full"
            type="submit"
          />

          <p>
            Already have an account? <router-link class="text-600 font-bold hover:text-primary-500" :to="{ name: 'auth.login' }">Login</router-link>
          </p>
        </div>
      </div>
    </form>

    <!-- Dialog that requires terms and conditions -->
    <p-dialog modal v-model:visible="requireAgree" header="Create an Account" :style="{ width: '320px' }">
      <p>You must agree to the terms and conditions to create an account</p>

      <div class="flex justify-content-end">
        <p-button
          label="Close"
          icon="pi pi-times"
          @click="requireAgree = false"
        />
      </div>
    </p-dialog>
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    // Component Name
    name: "RegisterPage",

    // Before Route Enter Guard
    beforeRouteEnter (to, from, next) {
      next(vm => {
        // Called before the route that renders this component is confirmed.
        // Does NOT have access to `this` component instance,
        // because it has not been created yet when this guard is called!

        // Place your code here
        // ...
      })
    },

    beforeRouteUpdate (to, from, next) {
      // Called when the route that renders this component has changed,
      // but this component is reused in the new route.
      // For example, for a route with dynamic params `/foo/:id`, when we
      // navigate between `/foo/1` and `/foo/2`, the same `Foo` component instance
      // will be reused, and this hook will be called when that happens.

      // Place your code here
      // ...

      // Call `next()` to resolve the hook, or `next(false)` to abort it.
      next()
    },

    // Component Data
    data () {
      return {
        // Loading state
        loading: false,

        // Form Errors
        formError: null,

        // Form Data
        form: {
          // First Name
          first_name: null,

          // Last Name
          last_name: null,

          // Username
          username: null,

          // Email Address
          email: null,

          // Password
          password: null,

          // Confirm Password
          password_confirmation: null,
        },

        requireAgree: false,
        terms: false
      }
    },

    // Computed Properties
    computed: {
      // Check if first name has error
      hasFirstNameError () {
        return !!this.formError?.first_name
      },

      // Check if last name has error
      hasLastNameError () {
        return !!this.formError?.last_name
      },

      hasNameError () {
        return this.hasFirstNameError || this.hasLastNameError
      },

      nameError () {
        if (this.hasFirstNameError) {
          return this.formError.first_name[0]
        }

        if (this.hasLastNameError) {
          return this.formError.last_name[0]
        }

        return null
      },

      // Check if username has error
      hasUsernameError () {
        return !!this.formError?.username
      },

      // Check if email has error
      hasEmailError () {
        return !!this.formError?.email
      },

      // Check if password has error
      hasPasswordError () {
        return !!this.formError?.password
      },

      // Check if confirm password has error
      hasConfirmPasswordError () {
        return !!this.formError?.password_confirmation
      },
    },

    // Watchers
    watch: {

    },

    // Methods
    methods: {
      ...mapActions({
        _attemptRegister: 'auth/ATTEMPT_REGISTER',
        _authenticateToken: 'auth/AUTHENTICATE_TOKEN',
      }),


      submitForm () {
        // Must Agree to Terms and Conditions
        if (!this.terms) {
          this.requireAgree = true

          return
        }

        // Set loading state to true
        this.loading = true

        // Attempt registration using the form data
        this._attemptRegister(this.form)
          .then((response) => {
            // Authenticate token to get user data
            this._authenticateToken(response?.access_token)

            // Redirect to home page after successful login
            this.$router.replace({
              name: 'home'
            })
          })
          .catch((e) => {
            // Set form errors to display
            this.formError = e.errors
          })
          .finally(() => {
            // Set loading state to false
            this.loading = false
          })
      }
    },
  }
</script>
