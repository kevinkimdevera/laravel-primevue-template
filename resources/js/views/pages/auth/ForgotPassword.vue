<template>
  <form @submit.prevent="attemptPasswordReset" style="width: 500px">
    <div class="border-1 surface-border surface-card border-round py-7 px-4 md:px-7 z-1">
      <div class="mb-4">
        <div class="text-900 text-xl font-bold mb-2">Forgot Password</div>
        <span class="text-600 font-medium">Enter your email to reset your password</span>
      </div>

      <div class="flex flex-column">
        <div class="field mb-3">
          <p-icon-field icon-position="left">
            <p-input-icon class="pi pi-envelope"></p-input-icon>
            <p-input-text
              id="username"
              type="text"
              class="w-full"
              :class="{ 'p-invalid' : hasEmailError }"
              placeholder="Email"
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

        <div class="flex flex-wrap gap-2 justify-content-between">
          <router-link :to="{ name: 'auth.login' }" class="flex-auto">
            <p-button
              label="Cancel"
              icon="pi pi-times"
              type="button"
              class="w-full"
              outlined
            />
          </router-link>

          <p-button
            label="Submit"
            icon="pi pi-check"
            class="flex-auto"
            :loading="loading"
            type="submit"
          />
        </div>

      </div>
    </div>
  </form>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    // Component Name
    name: "ForgotPasswordPage",

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
        formError: null,

        // Form Data
        form: {
          // Username
          email: null,
        },

        loading: false,
      }
    },

    // Computed Properties
    computed: {
      hasEmailError () {
        return !!this.formError?.email
      }
    },

    // Watchers
    watch: {

    },

    // Methods
    methods: {
      ...mapActions({
        _forgotPassword: 'auth/FORGOT_PASSWORD',
      }),

      // Attempt Password Reset
      async attemptPasswordReset () {
        this.loading = true

        // Attempt password reset using the form data
        this._forgotPassword(this.form)
          .then((response) => {
            // Redirect to login page after successful password reset
            this.$toast.add({
              severity: 'success',
              summary: 'Success',
              detail: response.message,
              life: 3000
            })

            this.$router.replace({
              name: 'auth.login'
            })
          })
          .catch((e) => {
            // Set form errors to display
            this.formError = e.errors

            // Display error toast
            this.$toast.add({
              severity: 'error',
              summary: 'Unable to reset password',
              detail: e.message,
              life: 3000
            })
          })
          .finally(() => {
            // Set loading state to false
            this.loading = false
          })
      }
    },
  }
</script>
