<template>
  <div>
    <div class="mb-3 row">
      <label class="col-md-4 col-form-label text-md-right">銀行コード</label>
      <div class="col-md-5">
        <input @change="change" v-model="data.bank_code" :class="{ 'is-invalid': form.errors.has('bank_code') }" class="form-control" type="text" name="bank_code" id="bank_code">
        <has-error :form="form" field="bank_code" />
      </div>
    </div>
    <div class="mb-3 row">
      <label class="col-md-4 col-form-label text-md-right">銀行名</label>
      <div class="col-md-5">
        <input @change="change" v-model="data.bank_name" :class="{ 'is-invalid': form.errors.has('bank_name') }" class="form-control" type="text" name="bank_name" id="bank_name">
        <has-error :form="form" field="bank_name" />
      </div>
    </div>
    
    <div class="mb-3 row">
      <label class="col-md-4 col-form-label text-md-right">支店コード</label>
      <div class="col-md-5">
        <input @change="change" v-model="data.branch_code" :class="{ 'is-invalid': form.errors.has('branch_code') }" class="form-control" type="text" name="branch_code" id="branch_code">
        <has-error :form="form" field="branch_code" />
      </div>
    </div>
    <div class="mb-3 row">
      <label class="col-md-4 col-form-label text-md-right">支店名</label>
      <div class="col-md-5">
        <input @change="change" v-model="data.branch_name" :class="{ 'is-invalid': form.errors.has('branch_name') }" class="form-control" type="text" name="branch_name" id="branch_name">
        <has-error :form="form" field="branch_name" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  watch: {
  },
  created () {
    this.data.bank_name = this.form.bank_name
    this.data.bank_code = this.form.bank_code
    this.data.branch_name = this.form.branch_name
    this.data.branch_code = this.form.branch_code
  },
  props: [ 'form', 'update' ],
  data () {
    return {
      data: {
        bank_name: null,
        bank_code: null,
        branch_name: null,
        branch_code: null,
      },
    }
  },
  methods: {
    change() {
      this.$emit("update", this.data)
    }
  }
}
</script>
