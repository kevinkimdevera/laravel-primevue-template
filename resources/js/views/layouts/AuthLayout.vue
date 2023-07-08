<template>
  <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
    <div class="flex flex-column align-items-center justify-content-center">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  name: 'AuthLayout',
  data () {
    return {

    }
  }
}
</script>
