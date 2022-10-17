<template>
  <div class="main_layout">
    <navbar />

    <div class="container-lg py-5">
      <div class="main_content">
        <child />
      </div>
    </div>
            <div style="margin: 0px 0px 45px 0px;" align="center"><img src="https://online.planbee.co.jp/planbee_maillogo.png"></div>
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