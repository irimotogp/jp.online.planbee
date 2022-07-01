<template>
  <div>
    <div class="mb-3 row">
      <div class="col-md-4"><label class="col-form-label text-md-right">銀行<span class="col-form-mark">必須</span></label></div>
      <div class="col-md-8">
        <v-select
          :disabled="disabled"
          name="bank"
          v-model="bank"
          :options="bank_options"
          class="cus_v_select"
          :class="{ 'is-invalid': form.errors.has('bank_code') || form.errors.has('bank_name') }"
        ></v-select>
        <has-error :form="form" field="bank_code" />
        <has-error :form="form" field="bank_name" />
        <p v-if="bank" class="mb-0 mt-2">銀行コード: {{ bank.code}}　　銀行名: {{ bank.kana}} </p>
      </div>
    </div>
    
    <div class="mb-3 row">
      <div class="col-md-4"><label class="col-form-label text-md-right">支店<span class="col-form-mark">必須</span></label></div>
      <div class="col-md-8">
        <v-select
          :disabled="disabled"
          name="branch"
          v-model="branch"
          @input="changeBranch"
          :options="branch_options"
          class="cus_v_select"
          :class="{ 'is-invalid': form.errors.has('branch_code') || form.errors.has('branch_name') }"/>
        <has-error :form="form" field="branch_code" />
        <has-error :form="form" field="branch_name" />
        <p v-if="branch" class="mb-0 mt-2">支店コード: {{ branch.code}}　　支店名: {{ branch.kana}} </p>
      </div>
    </div>
  </div>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
export default {
  components: {
     vSelect
  },
  watch: {
    bank(value) {
      this.branch = null
      this.branch_options = []
      if(value) {
        this.fetchBranch(value)
      } else {
        this.branch_options = []
        this.$emit("updateBranch", null)
      }
      this.$emit("updateBank", value)
    },
  },
  created () {
    var obj = this
    fetch("https://zengin-code.github.io/api/banks.json")
    .then(response => response.json())
    .then(data => {
      obj.bank_options = Object.values(data).map((x) => { x.kana = this.hankaku2Zenkaku(x.kana); x.label = x.code + "　" + x.kana; return x; })
      if(obj.form.bank) {
        obj.bank = obj.form.bank
        this.fetchBranch(obj.bank)
      }
    });
  },
  props: [ 'form', 'update', 'disabled' ],
  data () {
    return {
      bank_options: [],
      branch_options: [],
      bank: null,
      branch: null
    }
  },
  methods: {
    changeBranch() {
      this.$emit("updateBranch", this.branch)
    },
    fetchBranch(value) {
      var obj = this
      fetch(`https://zengin-code.github.io/api/branches/${value.code}.json`)
      .then(response => response.json())
      .then(data => {
        obj.branch_options = Object.values(data).map((x) => { x.kana = this.hankaku2Zenkaku(x.kana); x.label = x.code + "　" + x.kana; return x; })
        const option = obj.form.branch ? obj.branch_options.find(x => x.code == obj.form.branch.code) : null
        if(option) {
          obj.branch = obj.form.branch
          this.$emit("updateBranch", obj.branch)
        } else {
          this.$emit("updateBranch", null)
        }
      });
    },
    hankaku2Zenkaku(str) {
      const charDict = {
        zenkaku: [
          'ア','イ','ウ','エ','オ','カ','キ','ク','ケ','コ'
          ,'サ','シ','ス','セ','ソ','タ','チ','ツ','テ','ト'
          ,'ナ','ニ','ヌ','ネ','ノ','ハ','ヒ','フ','ヘ','ホ'
          ,'マ','ミ','ム','メ','モ','ヤ','ヰ','ユ','ヱ','ヨ'
          ,'ラ','リ','ル','レ','ロ','ワ','ヲ','ン'
          ,'ガ','ギ','グ','ゲ','ゴ','ザ','ジ','ズ','ゼ','ゾ'
          ,'ダ','ヂ','ヅ','デ','ド','バ','ビ','ブ','ベ','ボ'
          ,'パ','ピ','プ','ペ','ポ'
          ,'ァ','ィ','ゥ','ェ','ォ','ャ','ュ','ョ','ッ'
          ,'゛','°','、','。','「','」','ー','・',
          '０', '１', '２', '３', '４', '５', '６', '７', '８', '９',
          'Ａ', 'Ｂ', 'Ｃ', 'Ｄ', 'Ｅ', 'Ｆ', 'Ｇ', 'Ｈ', 'Ｉ', 'Ｊ', 'Ｋ', 'Ｌ', 'Ｍ', 'Ｎ',
          'Ｏ', 'Ｐ', 'Ｑ', 'Ｒ', 'Ｓ', 'Ｔ', 'Ｕ', 'Ｖ', 'Ｗ', 'Ｘ', 'Ｙ', 'Ｚ',
          'ａ', 'ｂ', 'ｃ', 'ｄ', 'ｅ', 'ｆ', 'ｇ', 'ｈ', 'ｉ', 'ｊ', 'ｋ', 'ｌ', 'ｍ', 'ｎ',
          'ｏ', 'ｐ', 'ｑ', 'ｒ', 'ｓ', 'ｔ', 'ｕ', 'ｖ', 'ｗ', 'ｘ', 'ｙ', 'ｚ'
        ],
        hankaku: [
          'ｱ','ｲ','ｳ','ｴ','ｵ','ｶ','ｷ','ｸ','ｹ','ｺ'
          ,'ｻ','ｼ','ｽ','ｾ','ｿ','ﾀ','ﾁ','ﾂ','ﾃ','ﾄ'
          ,'ﾅ','ﾆ','ﾇ','ﾈ','ﾉ','ﾊ','ﾋ','ﾌ','ﾍ','ﾎ'
          ,'ﾏ','ﾐ','ﾑ','ﾒ','ﾓ','ﾔ','ｲ','ﾕ','ｴ','ﾖ'
          ,'ﾗ','ﾘ','ﾙ','ﾚ','ﾛ','ﾜ','ｦ','ﾝ'
          ,'ｶﾞ','ｷﾞ','ｸﾞ','ｹﾞ','ｺﾞ','ｻﾞ','ｼﾞ','ｽﾞ','ｾﾞ','ｿﾞ'
          ,'ﾀﾞ','ﾁﾞ','ﾂﾞ','ﾃﾞ','ﾄﾞ','ﾊﾞ','ﾋﾞ','ﾌﾞ','ﾍﾞ','ﾎﾞ'
          ,'ﾊﾟ','ﾋﾟ','ﾌﾟ','ﾍﾟ','ﾎﾟ'
          ,'ｧ','ｨ','ｩ','ｪ','ｫ','ｬ','ｭ','ｮ','ｯ'
          ,'ﾞ','ﾟ','､','｡','｢','｣','ｰ','･',
          '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
          'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
          'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
          'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
          'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
        ]
      }

      const regExp = new RegExp(`(${charDict.hankaku.join('|')})`, 'g')
      
      return str.replace(regExp, match => {
        const index = charDict.hankaku.indexOf(match)
        return charDict.zenkaku[index]
      })
    }

  }
}
</script>
