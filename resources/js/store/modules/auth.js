import api from '@/api'

const state = {
  // Authenticated User
  user: null,

  // Authenticated User Loading
  userLoading: false,

  // Auth Token
  authToken: null,

  // Auth Token Name (used for localStorage) from .env
  authTokenName: import.meta.env.VITE_APP_AUTH_TOKEN_NAME
}

const getters = {
  TOKEN_NAME: state => state.authTokenName,
  TOKEN: state => state.authToken,
  USER: state => state.user,
  USER_LOADING: state => state.userLoading,
}

const mutations = {
  SET_TOKEN: (state, payload) => { state.authToken = payload },
  SET_USER: (state, payload) => { state.user = payload },
  SET_USER_LOADING: (state, payload) => { state.userLoading = payload },
}

const actions = {
  // Authenticate Token
  // @param {String} token
  AUTHENTICATE_TOKEN: ({ commit }, token) => {
    api.setAuthToken(token)
    commit('SET_TOKEN', token)
    localStorage.setItem(state.authTokenName, token)
  },

  // Revoke Token
  REVOKE_TOKEN: ({ commit }) => {
    api.removeAuthToken()
    commit('SET_TOKEN', null)
    localStorage.removeItem(state.authTokenName)
  },

  // Get User Data from API
  GET_USER_DATA: async ({ commit }) => {
    commit('SET_USER_LOADING', true)
    const response = await api.get('/api/auth/user')
    commit('SET_USER_LOADING', false)
    return response
  },

  // Attempt Login to API
  ATTEMPT_LOGIN: async ({ dispatch }, credentials) => {
    // Get CSRF token
    await api.get('/sanctum/csrf-cookie')

    // Attempt Login
    return await api.post('/api/auth/login', credentials)
  },

  // Attempt Register to API
  ATTEMPT_REGISTER: async ({ dispatch }, userData) => {
    // Get CSRF token
    await api.get('/sanctum/csrf-cookie')

    return await api.post('/api/auth/register', userData)
  },

  // Attempt Verify Email to API
  VERIFY_EMAIL: async ({ dispatch }, verificationData) => {
    // Get CSRF token
    await api.get('/sanctum/csrf-cookie')

    return await api.post('/api/auth/verify', verificationData)
  },

  // Attempt Forgot Password to API
  FORGOT_PASSWORD: async ({ dispatch }, credentials) => {
    // Get CSRF token
    await api.get('/sanctum/csrf-cookie')

    return await api.post('/api/auth/password/forgot', credentials)
  },

  // Attempt Reset Password to API
  RESET_PASSWORD: async ({ dispatch }, credentials) => {
    // Get CSRF token
    await api.get('/sanctum/csrf-cookie')

    return await api.post('/api/auth/password/reset', credentials)
  },

  // Set the Authenticated User
  LOGIN: ({ commit }, user) => {
    commit('SET_USER', user)
  },

  // Logout the Authenticated User
  LOGOUT: ({ commit }) => {
    commit('SET_USER', null)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
