<template>
  <div class="text-center">
    <p class="expired">送信完了しました。<br>引き続き別の方に送信する場合は<router-link :to="'/'">こちら</router-link>から送信してください。</p>
  </div>
</template>

<script>
export default {
  watch: {
  },
  middleware: 'guest',
  data: () => ({
    title: '送信完了しました。引き続き別の方に送信する場合はこちらから送信してください。',
  })
}
</script>
