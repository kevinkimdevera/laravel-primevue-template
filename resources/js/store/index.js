import { createStore } from "vuex";

// auto import all modules with subfolders
const modulesFiles = import.meta.globEager('./modules/**/*.js')

// map modules
const modules = Object.keys(modulesFiles).reduce((modules, modulePath) => {
  const moduleName = modulePath.replace(/^\.\/modules\/(.*)\.\w+$/, '$1')
  const value = modulesFiles[modulePath]
  modules[moduleName] = value.default
  return modules
}, {})

// create store
const store = createStore({
  modules: modules
})

// export store
export default store
