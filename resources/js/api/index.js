import axios from 'axios'

export default {
  // Set Auth Token to Axios
  setAuthToken: (token) => {
    axios.defaults.headers.common.Authorization = `Bearer ${token}`
  },

  // Remove Auth Token from Axios
  removeAuthToken: () => {
    delete axios.defaults.headers.common.Authorization
  },

  // API Get Request
  get: (url, params) => {
    return new Promise((resolve, reject) => {
      axios.get(url, {
        responseType: 'json',
        params: params
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },

  // API Post Request
  post: (url, data) => {
    return new Promise((resolve, reject) => {
      axios.post(url, data, {
        responseType: 'json'
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },

  // API Patch Request
  patch: (url, data = {}) => {
    return new Promise((resolve, reject) => {
      axios.patch(url, data, {
        responseType: 'json'
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },

  // API Put Request
  put: (url, data = {}) => {
    return new Promise((resolve, reject) => {
      axios.put(url, data, {
        responseType: 'json'
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },

  // API Delete Request
  delete: (url, data = {}) => {
    return new Promise((resolve, reject) => {
      axios.delete(url, data, {
        responseType: 'json'
      }).then((response) => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  }
}
