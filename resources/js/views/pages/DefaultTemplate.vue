<template>
  <div></div>
</template>

<script>
  export default {
    // Component Name
    name: "PageName",

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

      }
    },

    // Computed Properties
    computed: {

    },

    // Watchers
    watch: {

    },

    // Methods
    methods: {

    },
  }
</script>
