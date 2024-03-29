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
  // AUTHENTICATED ROUTES
  {
    path: '/',
    component: () => import('@/views/layouts/MainLayout.vue'),
    meta: {
      auth: true,
    },
    children: [
      // HOME PAGE
      {
        path: '',
        alias: 'home',
        name: 'home',
        component: () => import('@/views/pages/Home.vue')
      },

      // =================================
      // PUT YOUR ROUTES HERE
      // =================================
    ]
  },

  // AUTHENTICATED AUTH ROUTES
  {
    path: '/auth',
    component:() => import('@/views/layouts/AuthLayout.vue'),
    meta: {
      auth: true,
    },
    children:[
      // EMAIL VERIFICATION PAGE
      {
        path: 'verification',
        name: 'auth.verify',
        component: () => import('@/views/pages/auth/Verify.vue')
      },
    ]
  },

  // GUEST AUTH ROUTES
  {
    path: '/auth',
    component:() => import('@/views/layouts/AuthLayout.vue'),
    children: [
      // Redirect '/' to '/auth/login'
      {
        path: '',
        redirect: { name: 'auth.login' }
      },
      // LOGIN PAGE
      {
        path: 'login',
        name: 'auth.login',
        component: () => import('@/views/pages/auth/Login.vue')
      },
      // REGISTER PAGE
      {
        path: 'register',
        name: 'auth.register',
        component: () => import('@/views/pages/auth/Register.vue')
      },
      // FORGOT PASSWORD PAGE
      {
        path: 'forgot-password',
        name: 'auth.password.forgot',
        component: () => import('@/views/pages/auth/ForgotPassword.vue')
      },
      // RESET PASSWORD PAGE
      {
        path: 'password/reset/:token',
        name: 'auth.password.reset',
        component: () => import('@/views/pages/auth/ResetPassword.vue'),
        props: true
      },
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
