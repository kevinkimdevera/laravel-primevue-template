<template>
  <form @submit.prevent="attemptLogin" style="width: 500px">
    <div class="border-1 surface-border surface-card border-round py-7 px-4 md:px-7 z-1">
      <div class="mb-4">
        <div class="text-900 text-xl font-bold mb-2">Log in</div>
        <span class="text-600 font-medium">Please enter your details</span>
      </div>

      <div class="flex flex-column">
        <div class="field mb-3">
          <div class="p-input-icon-left w-full">
            <i class="pi pi-user" />
            <p-input-text
              id="username"
              type="text"
              class="w-full"
              :class="{ 'p-invalid' : hasUsernameError }"
              placeholder="Username / Email"
              v-model="form.username"
            />
          </div>

          <small
            v-if="hasUsernameError"
            class="p-error"
          >
            {{ formError.username[0] }}
          </small>
        </div>

        <div class="field mb-3">
          <div class="p-input-icon-left w-full">
            <i class="pi pi-lock" />
            <p-input-text
              id="password"
              type="password"
              class="w-full"
              :class="{ 'p-invalid' : hasPasswordError }"
              v-model="form.password"
              placeholder="Password"
            />
          </div>


          <small
            v-if="hasPasswordError"
            class="p-error"
          >
            {{ formError.password[0] }}
          </small>
        </div>

        <p-button
          :loading="loading"
          label="Login"
          class="my-3 w-full"
          type="submit"
        />

        <router-link :to="{ name: 'auth.password.forgot' }" class="text-600 hover:text-primary-500">Forgot Password?</router-link>

      </div>
    </div>
  </form>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'LoginPage',
  data () {
    return {
      // Loading state
      loading: false,

      // Form Errors
      formError: null,

      // Form Data
      form: {
        // Username
        username: null,

        // Password
        password: null
      }
    }
  },

  computed: {
    // Check if username has error
    hasUsernameError () {
      return !!this.formError?.username
    },

    // Check if password has error
    hasPasswordError () {
      return !!this.formError?.password
    }
  },

  methods: {
    ...mapActions({
      _attemptLogin: 'auth/ATTEMPT_LOGIN',
      _authenticateToken: 'auth/AUTHENTICATE_TOKEN'
    }),

    // Attempt login using the form data
    async attemptLogin () {
      // Set loading state to true
      this.loading = true

      // Attempt login using the form data
      this._attemptLogin(this.form)
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
  }
}
</script>
