<template>
  <div class="layout-wrapper" v-if="!userLoading">
    <div class="layout-topbar">
      <!-- SIDEBAR TOGGLE BUTTON -->
      <button
        class="p-link layout-menu-button layout-topbar-button"
        @click="toggleSidebar"
      >
        <i class="pi pi-bars" />
      </button>

      <!-- SITE LOGO -->
      <router-link
        :to="{ name: 'home' }"
        class="layout-topbar-logo"
      >
        <img
          src="/images/logo.png"
          alt="logo"
        > {{ appName }}
      </router-link>

      <!-- TOPBAR MENU -->
      <div class="layout-topbar-menu">
        <template v-if="appLoading">
          <p-skeleton
            class="ml-2"
            size="42px"
          />
          <p-skeleton
            class="ml-2"
            size="42px"
          />
        </template>
        <template v-else>
          <button class="p-link layout-topbar-button">
            <i class="pi pi-bell" />
          </button>

          <button
            class="p-link layout-topbar-button"
            @click="toggleProfileMenu"
            aria-haspopup="true"
            aria-controls="profile_menu"
          >
            <user-avatar
              :avatar="userAvatar"
              size="42"
            />
          </button>
          <p-menu
            id="profile_menu"
            ref="profileMenu"
            popup
            style="width: 300px;"
          >
            <template #start>
              <button class="w-full p-link flex align-items-center py-2 px-3 text-color hover:surface-200 border-noround">
                <user-avatar
                  :avatar="userAvatar"
                  class="mr-3"
                  size="38"
                />
                <div class="flex flex-column">
                  <span class="font-bold">{{ userName }}</span>
                </div>
              </button>
            </template>
            <template #end>
              <button
                @click="confirmLogout"
                class="w-full p-link flex align-items-center p-2 px-3 text-red-600 hover:bg-red-100 border-noround"
              >
                <i class="pi pi-sign-out" />
                <span class="ml-2">Log Out</span>
              </button>
            </template>
          </p-menu>
        </template>
      </div>
    </div>

    <!-- SIDEBAR -->
    <p-sidebar
      :style="{ width: '320px' }"
      v-model:visible="sidebar"
      :show-close-icon="false"
    >
      <ul class="layout-menu">
        <app-menu-item
          v-for="(item, i) in sidebarMenu"
          :key="`app-menu-item-${i}`"
          :item="item"
          :index="i"
        />
      </ul>
    </p-sidebar>

    <!-- MAIN CONTAINER -->
    <div class="layout-main-container">
      <div class="layout-main">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'MainLayout',

  beforeMount () {
    // Check if token is present in local storage
    const token = localStorage.getItem(this.tokenName)

    // If token is present, authenticate user using the token
    if (token) {
      this.authenticate(token)
    }
  },

  data () {
    return {
      // Sidebar Model
      sidebar: false,

      // Profile Menu Model
      profileMenu: [
        {
          label: 'Profile',
          icon: 'pi pi-user'
        },
        {
          label: 'Logout',
          icon: 'pi pi-power-off',
          command: () => {
            this.confirmLogout()
          }
        }
      ]
    }
  },

  watch: {
    $route () {
      this.sidebar = false
    }
  },

  computed: {
    // Getters from auth module store
    ...mapGetters({
      user: 'auth/USER',
      userLoading: 'auth/USER_LOADING',
      token: 'auth/TOKEN',
      tokenName: 'auth/TOKEN_NAME'
    }),

    // App Name
    appName () {
      return import.meta.env.VITE_APP_NAME
    },

    // Sidebar Menu
    sidebarMenu () {
      return [
        {
          label: 'Main Navigation',
          items: [
            {
              label: 'Home Screen',
              icon: 'pi pi-th-large',
              to: { name: 'home' }
            }

            // Place your menu items here
            // { ... }
          ]
        }
      ]
    },

    // App Loading
    appLoading () {
      return !this.user && this.userLoading
    },

    // User Name
    userName () {
      return this.user?.name
    },

    // User Avatar
    userAvatar () {
      return this.user?.avatar
    }
  },

  methods: {
    // Actions from auth module store
    ...mapActions({
      _authenticateToken: 'auth/AUTHENTICATE_TOKEN',
      _revokeToken: 'auth/REVOKE_TOKEN',
      _getUserData: 'auth/GET_USER_DATA',
      _login: 'auth/LOGIN',
      _logout: 'auth/LOGOUT'
    }),

    // Toggle Sidebar
    toggleSidebar () {
      this.sidebar = !this.sidebar
    },

    // Toggle Profile Menu
    toggleProfileMenu (event) {
      this.$refs.profileMenu.toggle(event)
    },

    // Authenticate user using token
    authenticate (token) {
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

    login (user) {
      // Login user
      if (!user?.is_verified) {
        // Redirect to verification page
        this.$router.replace({
          name: 'auth.verify'
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

    confirmLogout () {
      // Show confirmation dialog
      this.$confirm.require({
        header: 'Logout',
        icon: 'pi pi-question-circle',
        message: 'Are you sure you want to logout?',
        acceptLabel: 'Logout',
        rejectLabel: 'Cancel',
        accept: () => {
          // Logout user
          this.logout()
        },
        reject: () => {
          // Hide confirmation dialog
          this.$confirm.hide()
        }
      })
    }
  }
}
</script>
