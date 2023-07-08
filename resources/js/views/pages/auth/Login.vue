<template>
  <form
    class="auth-form"
    @submit.prevent="attemptLogin"
    style="width: 30rem;"
  >
    <div
      class="surface-card py-6 px-8"
      style="border-radius: 53px"
    >
      <div class="text-center mb-5">
        <img
          src="/images/logo.png"
          alt="Sakai logo"
          class="mb-3 w-6rem flex-shrink-0"
        >

        <div class="text-900 text-2xl font-medium mb-3">
          Sign in to continue
        </div>
      </div>

      <div>
        <div class="field mb-3">
          <label
            for="username"
            :class="{ 'p-error' : hasUsernameError }"
            class="block font-medium"
          >
            Username
          </label>
          <p-input-text
            id="username"
            type="text"
            class="w-full"
            :class="{ 'p-invalid' : hasUsernameError }"
            v-model="form.username"
          />
          <small
            v-if="hasUsernameError"
            class="p-error"
          >
            {{ formError.username[0] }}
          </small>
        </div>

        <div class="field mb-3">
          <label
            for="password"
            :class="{ 'p-error' : hasPasswordError }"
            class="block font-medium"
          >
            Password
          </label>
          <p-input-text
            id="password"
            type="password"
            class="w-full"
            :class="{ 'p-invalid' : hasPasswordError }"
            v-model="form.password"
          />
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
          class="mt-3 w-full"
          type="submit"
        />
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
