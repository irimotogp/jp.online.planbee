<template>
  <div>
    <div class="mb-3 row">
      <label class="col-md-4 col-form-label text-md-right">銀行</label>
      <div class="col-md-8">
        <v-select
          name="bank"
          v-model="bank"
          :options="bank_options"
          :class="{ 'is-invalid': form.errors.has('bank_code') || form.errors.has('bank_name') }"
        ></v-select>
        <has-error :form="form" field="bank_code" />
        <has-error :form="form" field="bank_name" />
        <p v-if="bank" class="mb-0 mt-2">銀行コード: {{ bank.code}}　　銀行名: {{ bank.name}} </p>
      </div>
    </div>
    
    <div class="mb-3 row">
      <label class="col-md-4 col-form-label text-md-right">支店</label>
      <div class="col-md-8">
        <v-select
          name="branch"
          v-model="branch"
          @input="changeBranch"
          :options="branch_options"
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
      var obj = this
      if(value) {
        fetch(`https://zengin-code.github.io/api/branches/${value.code}.json`)
        .then(response => response.json())
        .then(data => {
          obj.branch_options = Object.values(data).map((x) => { x.label = x.code + "　" + x.name; return x; })
        });
      } else {
        obj.branch_options = []
      }
      this.$emit("updateBank", value)
    },

  },
  created () {
    var obj = this
    fetch("https://zengin-code.github.io/api/banks.json")
    .then(response => response.json())
    .then(data => {
      obj.bank_options = Object.values(data).map((x) => { x.label = x.code + "　" + x.name; return x; })
    });
  },
  props: [ 'form', 'update' ],
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
    }
  }
}
</script>
