<template>
  <p-avatar
    class="text-900 font-medium"
    :class="avatarColor"
    :label="avatarLabel"
    :image="avatarImage"
    :style="avatarStyle"
  />
</template>

<script>
export default {
  props: {
    avatar: {
      type: Object,
      required: true
    },
    size: {
      type: [String, Number],
      default: 36
    }
  },
  data () {
    return {

    }
  },
  computed: {
    avatarStyle () {
      return {
        minWidth: `${this.size}px`,
        minHeight: `${this.size}px`,
        fontSize: `${this.size / 2}px`
      }
    },
    avatarText () {
      return this.avatar?.text
    },
    avatarImage () {
      return this.avatar?.image
    },
    avatarColor () {
      const color = this.avatar?.color ?? 'blue'
      return `bg-${color}-300`
    },
    avatarLabel () {
      return !this.avatarImage
        ? this.avatarText
        : null
    }
  }
}
</script>
