<template>
  <div class="main_layout">
    <navbar />

    <div class="container-lg py-5">
      <div class="main_content">
        <child />
      </div>
    </div>

  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
export default {
  watch: {
  },
  name: 'MainLayout',

  components: {
    Navbar
  }
}
</script>