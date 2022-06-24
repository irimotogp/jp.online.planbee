<template>
  <div class="mb-3 row">
    <label class="col-md-4 col-form-label text-md-right">{{ label }}<span v-if="need" class="col-form-mark">必須</span></label>
    <div class="col-md-8">
      <div :class="{ 'is-invalid': form.errors.has(name) }" class="mt-2 form-row">
        <div class="col-8">
          <b-form-select
            @change="init_day_options"
            :disabled="disabled" 
            v-model="year"
            :options="year_options"
            :class="{ 'is-invalid': form.errors.has(name) }"></b-form-select>
        </div>
        <div class="col-2">
          <b-form-select
            @change="init_day_options"
            :disabled="disabled" 
            v-model="month"
            :options="month_options"
            :class="{ 'is-invalid': form.errors.has(name) }"></b-form-select>
        </div>
        <div class="col-2">
          <b-form-select
            @change="updateParent"
            :disabled="disabled" 
            v-model="day"
            :options="day_options"
            :class="{ 'is-invalid': form.errors.has(name) }"></b-form-select>
        </div>
      </div>
      <has-error :form="form" :field="name" />
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      year: 1990,
      month: 1,
      day: 1,
      days_max: '',
      gengoData: [
        {text: '平成', base: 1988, max: 30},
        {text: '昭和', base: 1925, max: 63},
        {text: '大正', base: 1911, max: 15},
        {text: '明治', base: 1867, max: 45},
      ],
      year_options: [],
      month_options: [],
      day_options: [],
    }
  },
  name: 'BirthDay',
  props: [ 'form', 'name', 'label', 'disabled', 'need' ],

  created: function () {
    this.month_options = Array.from(Array(12).keys()).map((x) => ({ value: x + 1, text: `${x + 1}月`}))
    this.init_year_options()
    this.init_day_options()
    this.updateParent()
  },
  methods: {
    // 日の最大数を取得
    init_day_options: function () {
      const max_days = new Date(this.year, this.month, 0).getDate();
      this.day_options = Array.from(Array(max_days).keys()).map((x) => ({ value: x + 1, text: `${x + 1}日`}))
    },
    init_year_options: function () {
      var obj = this
      this.year_options = Array.from(Array(80).keys()).map((x) => (obj.gengoYear(2011 - x)))
    },
    updateParent: function () {
      let date = this.year + "-" + this.month + "-" + this.day
      this.$emit('update', date)
    },
    gengoYear: function (year) {
      let gengo = this.gengoData.find(x => year > x.base)
      if(gengo) {
        this.updateParent()
        return {
          value: year, 
          text: year + "年（" + gengo.text + (year - gengo.base) + "年）"
        }
      }
      return {
        value: year, 
        text: ""
      }
    },
  }
}
</script>
