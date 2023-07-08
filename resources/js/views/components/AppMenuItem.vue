<template>
  <li :class="{ 'layout-root-menuitem': root, 'active-menuitem': isActiveMenu }">
    <div v-if="root && item.visible !== false" class="layout-menuitem-root-text">{{ item.label }}</div>
    <a v-if="(!item.to || item.items) && item.visible !== false" :href="item.url" @click="itemClick($event, item, index)" :class="item.class" :target="item.target" tabindex="0">
      <i :class="item.icon" class="layout-menuitem-icon"></i>
      <span class="layout-menuitem-text">{{ item.label }}</span>
      <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items"></i>
    </a>
    <router-link v-if="item.to && !item.items && item.visible !== false" @click="itemClick($event, item, index)" :class="[item.class, { 'active-route': isActive }]" tabindex="0" :to="item.to">
      <i :class="item.icon" class="layout-menuitem-icon"></i>
      <span class="layout-menuitem-text">{{ item.label }}</span>
      <i class="pi pi-fw pi-angle-down layout-submenu-toggler" v-if="item.items"></i>
    </router-link>
    <Transition v-if="item.items && item.visible !== false" name="layout-submenu">
      <ul v-show="root ? true : isActiveMenu" class="layout-submenu">
        <app-menu-item v-for="(child, i) in item.items" :key="child" :index="i" :item="child" :parentItemKey="itemKey" :root="false"></app-menu-item>
      </ul>
    </Transition>
  </li>
</template>

<script>
  export default {
    beforeMount () {
      this.itemKey = this.parentItemKey
        ? this.parentItemKey + '-' + this.index
        : String(this.index)
    },
    props: {
      item: {
        type: Object,
        default: () => ({})
      },
      index: {
        type: Number,
        default: 0
      },
      root: {
        type: Boolean,
        default: true
      },
      parentItemKey: {
        type: String,
        default: null
      }
    },
    data () {
      return {
        isActiveMenu: false,
        itemKey: false
      }
    },
    computed: {
      isActive () {
        return this.item.to.name == this.$route.name
      }
    },
    methods: {
      itemClick (event, item) {
        if (item.disabled) {
          event.preventDefault();
          return;
        }

        if (item.items) {
          this.isActiveMenu = !this.isActiveMenu
        }
      },
    },
  }
</script>

<style lang="scss" scoped></style>
