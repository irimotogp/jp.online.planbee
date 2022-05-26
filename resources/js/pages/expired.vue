<template>
  <div class="text-center">
    <p class="expired">URLが期限切れになりました。<br class="d-sm-none"/>恐れ入りますが、取次店に連絡してください。</p>
  </div>
</template>

<script>
export default {
  middleware: 'guest',
  data: () => ({
    title: 'URLが期限切れになりました。恐れ入りますが、取次店に連絡してください。',
  })
}
</script>
