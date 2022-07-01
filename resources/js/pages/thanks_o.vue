<template>
  <div class="text-center">
    <p>お申し込みありがとうございます。<br>
    ご記入頂いたメールアドレスへ、自動返信の確認メールをお送りしております。<br><br>しばらく経ってもメールが届かない場合は、入力頂いたメールアドレスが間違っているか、<br class="d-none d-sm-block"/>迷惑メールフォルダに振り分けられている可能性がございます。<br>また、ドメイン指定をされている場合は、「@planbee.co.jp」からのメールが受信できるよう設定をお願いいたします。<br><br><a href="https://plabnbee.co.jp">株式会社プランビー</a></p>
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



