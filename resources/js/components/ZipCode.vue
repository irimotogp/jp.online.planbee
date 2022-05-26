<template>
  <div>
    <div class="mb-3 row">
      <div class="col-md-4"><label class="col-form-label text-md-right">郵便番号<span class="col-form-mark">必須</span></label></div>
      <div class="col-md-5">
        <input :disabled="disabled" @change="search" v-model="data.zip" :class="{ 'is-invalid': form.errors.has(zip_t) }" class="form-control" type="text" :name="zip_t" :id="zip_t">
        <has-error :form="form" :field="zip_t" />
      </div>
    </div>

    <div class="mb-3 row">
      <div class="col-md-4"><label class="col-form-label text-md-right">都道府県<span class="col-form-mark">必須</span></label></div>
      <div class="col-md-5">
        <b-form-select 
          :disabled="disabled"
          @change="change"
          v-model="data.pref"
          :options="pref_options"
          :id="pref_t"
          :class="{ 'is-invalid': form.errors.has(pref_t) }"
          ></b-form-select>
        <has-error :form="form" :field="pref_t" class="fw-bold"/>
      </div>
    </div>

    <div class="mb-3 row">
      <div class="col-md-4"><label class="col-form-label text-md-right">住所１（番地まで）<span class="col-form-mark">必須</span></label></div>
      <div class="col-md-8">
        <input :disabled="disabled" @change="change" v-model="data.city" :class="{ 'is-invalid': form.errors.has(city_t) }" class="form-control" type="text" :name="city_t" :id="city_t">
        <has-error :form="form" :field="city_t" />
      </div>
    </div>
    <div class="mb-3 row">
      <div class="col-md-4"><label class="col-form-label text-md-right">住所２（マンション名・号室）</label></div>
      <div class="col-md-8">
        <input :disabled="disabled" @change="change" v-model="data.addr" :class="{ 'is-invalid': form.errors.has(addr_t) }" class="form-control" type="text" :name="addr_t" :id="addr_t">
        <has-error :form="form" :field="addr_t" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  created () {
    this.data.zip = this.form[this.zip_t]
    this.data.pref = this.form[this.pref_t]
    this.data.city = this.form[this.city_t]
    this.data.addr = this.form[this.addr_t]
  },
  props: [ 'zip_t', 'pref_t', 'city_t', 'addr_t', 'form', 'update', 'pref_options', 'disabled' ],
  data () {
    return {
      data: {
        zip: null,
        pref: null,
        city: null,
        addr: null,
      },
    }
  },
  methods: {
    search() {
      let obj = this
      window.ZipApi = function (da){
        if( da.zip.length > 0 ) { 
          let code, pref, city, area
          for( let i=0;i<da.zip.length;i++ ){
            code= da.zip[i].d
            pref= da.zip[i].p
            city= da.zip[i].c
            area= da.zip[i].a
          }
          if( da.zip.length == 1 ){
            obj.data.zip = code
            obj.data.pref = pref
            obj.data.city = city + area
          }
          else{
            obj.data.pref = pref
            obj.data.city = city + area
          }	
          obj.change()
        }
      }
      const scriptPromise = new Promise((resolve, reject) => {
        const script = document.createElement('script');
        document.body.appendChild(script);
        script.onload = resolve;
        script.onerror = reject;
        script.async = true;
        script.src = `https://zipaddr.com/api/?d=${obj.data.zip}`;
      });

      scriptPromise.then(() => { });
    },
    change() {
      this.$emit("update", this.data)
    }
  }
}
</script>
