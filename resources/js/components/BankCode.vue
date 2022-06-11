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
        <p v-if="bank" class="mb-0 mt-2">銀行コード: {{ bank.code}}　　銀行名: {{ bank.name}} </p>
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
        <p v-if="branch" class="mb-0 mt-2">支店コード: {{ branch.code}}　　支店名: {{ branch.name}} </p>
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
      obj.bank_options = Object.values(data).map((x) => { x.name = this.hankaku2Zenkaku(x.name); x.label = x.code + "　" + x.name; return x; })
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
        obj.branch_options = Object.values(data).map((x) => { x.name = this.hankaku2Zenkaku(x.name); x.label = x.code + "　" + x.name; return x; })
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
        return str.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
            return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
        });
    }

  }
}
</script>
