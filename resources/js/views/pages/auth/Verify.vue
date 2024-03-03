<template>
  <form @submit.prevent="attemptVerify" style="width: 500px">
    <div class="border-1 surface-border surface-card border-round py-7 px-4 md:px-7 z-1">
      <div class="mb-2">
        <div class="text-900 text-xl font-bold mb-2">
          Verify your email
        </div>
        <span class="text-600 font-medium">
          Please enter the verification code sent to your email
        </span>
      </div>

      <template v-if="pageLoading">
        <p-skeleton
          class="mx-1"
        />
        <div class="flex justify-content-center gap-4 my-5">
          <p-skeleton
            class="mx-1"
            size="35px"
          />
          <p-skeleton
            class="mx-1"
            size="35px"
          />
          <p-skeleton
            class="mx-1"
            size="35px"
          />
          <p-skeleton
            class="mx-1"
            size="35px"
          />
          <p-skeleton
            class="mx-1"
            size="35px"
          />
          <p-skeleton
            class="mx-1"
            size="35px"
          />
        </div>
        <div class="flex justify-content-center">
          <p-skeleton
            class="mx-1"
            height="40px"
          />
          <p-skeleton
            class="mx-1"
            height="40px"
          />
        </div>
      </template>

      <template v-else>
        <div>
          <i class="pi pi-envelope"></i>

          <strong class="ml-3">{{ userEmail }}</strong>
        </div>

        <div class="flex justify-content-center my-5">
          <p-input-otp
            class=" gap-4 text-xl"
            :length="6"
            integer-only
            v-model="form.code"
            />
        </div>

        <div class="flex flex-wrap gap-2 justify-content-between">
          <router-link :to="{ name: 'auth.login' }" class="flex-auto">
            <p-button
              label="Cancel"
              icon="pi pi-times"
              type="button"
              class="w-full"
              @click="logout"
              outlined
            />
          </router-link>

          <p-button
            label="Submit"
            icon="pi pi-check"
            class="flex-auto"
            :loading="loading"
            :disabled="submitDisabled"
            type="submit"
          />
        </div>
      </template>

    </div>
  </form>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    // Component Name
    name: "VerificationPage",

    // Before Route Enter Guard
    beforeRouteEnter (to, from, next) {
      next(vm => {
        // Called before the route that renders this component is confirmed.
        // Does NOT have access to `this` component instance,
        // because it has not been created yet when this guard is called!

        // Place your code here
        // ...
        vm.authenticate()
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
          // Verification Code
          code: null,
        }
      }
    },

    // Computed Properties
    computed: {
      // Getters from auth module store
      ...mapGetters({
        user: 'auth/USER',
        userLoading: 'auth/USER_LOADING',
        token: 'auth/TOKEN',
        tokenName: 'auth/TOKEN_NAME'
      }),

      submitDisabled () {
        return this.form.code?.length !== 6
      },

      // App Loading
      pageLoading () {
        return !this.user && this.userLoading
      },

      // User email
      userEmail () {
        return this.user?.email
      }
    },

    // Watchers
    watch: {

    },

    // Methods
    methods: {
      // Actions from auth module store
      ...mapActions({
        _authenticateToken: 'auth/AUTHENTICATE_TOKEN',
        _revokeToken: 'auth/REVOKE_TOKEN',
        _getUserData: 'auth/GET_USER_DATA',
        _verify: 'auth/VERIFY_EMAIL',
        _login: 'auth/LOGIN',
        _logout: 'auth/LOGOUT'
      }),
      // Authenticate user using token
      authenticate () {
        let token = localStorage.getItem(this.tokenName)
        this._authenticateToken(token)

        // Get user data
        this._getUserData()
          .then((response) => {
            // If success, login user
            const user = response?.data

            this.login(user)
          })
          .catch((e) => {
            // If error, logout user
            this.logout()
          })
      },

      // Login user
      login (user) {
        // Login user
        if (user?.is_verified) {
          // Redirect to home
          this.$router.replace({
            name: 'home'
          })
        }

        this._login(user)
      },

      // Logout user
      logout () {
        // Logout user
        this._logout()

        // Revoke token
        this._revokeToken()

        // Redirect to login page
        this.$router.replace({
          name: 'auth.login'
        })
      },

      // Attempt verification using the form data
      attemptVerify () {
        if (this.form.code) {
          this.loading = true

          // Attempt verification using the form data
          this._verify(this.form)
            .then((response) => {
              // Redirect to home page after successful verification
              this.$router.replace({
                name: 'home'
              })

              // Display success toast
              this.$toast.add({
                severity: 'success',
                summary: 'Success',
                detail: response.message,
                life: 3000
              })
            })
            .catch((error) => {
              // Set the form error
              this.formError = error.errors

              // Display error toast
              this.$toast.add({
                severity: 'error',
                summary: 'Unable to verify email',
                detail: error.message,
                life: 3000
              })

              // Clear the form code
              this.form.code = null
            })
            .finally(() => {
              this.loading = false
            })
          }
      }
    },
  }
</script>
