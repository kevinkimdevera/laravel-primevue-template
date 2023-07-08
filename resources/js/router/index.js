import { createWebHistory, createRouter } from 'vue-router'

// MAIN LAYOUT
import MainLayout from '@/views/layouts/MainLayout.vue'

// AUTH LAYOUT
import AuthLayout from '@/views/layouts/AuthLayout.vue'

// PAGES
import LoginPage from '@/views/pages/auth/Login.vue'
import HomePage from '@/views/pages/Home.vue'

// YOUR PAGES HERE

// ROUTES
const routes = [
  {
    // MAIN LAYOUT
    path: '/',
    component: MainLayout,
    meta: {
      auth: true,
    },
    children: [
      // HOME PAGE
      {
        path: '',
        alias: 'home',
        name: 'home',
        component: HomePage
      },

      // =================================
      // PUT YOUR ROUTES HERE
      // =================================
    ]
  },
  {
    // AUTH LAYOUT
    path: '/auth',
    component: AuthLayout,
    children: [
      // LOGIN PAGE
      {
        path: 'login',
        name: 'auth.login',
        component: LoginPage
      }
    ]
  }
]

// ROUTER OBJECT
const router = createRouter({
  history: createWebHistory(),
  routes
})

// ROUTER GUARDS
router.beforeEach((to, from, next) => {
  const tokenName = import.meta.env.VITE_APP_AUTH_TOKEN_NAME
  const userToken = localStorage.getItem(tokenName)

  if (to.meta.auth) {
    if (!userToken) {
      next({ name: 'auth.login' })
    }
    next()
  } else {
    if (userToken) {
      next({ name: 'home' })
    }
    next()
  }
})

// EXPORT
export default router
