<template>
  <div class="row">
    <div class="col-lg-10 m-auto">
      <card :title="title">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)" class="py-3">
          <!-- sinsei_name -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end">登録申請者氏名<span class="col-form-mark">必須</span></label>
            <div class="col-md-7">
              <input v-model="form.sinsei_name" :class="{ 'is-invalid': form.errors.has('sinsei_name') }" class="form-control" type="text" name="sinsei_name">
              <has-error :form="form" field="sinsei_name" />
            </div>
          </div>

          <!-- sinsei_email -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end">登録申請者メールアドレス<span class="col-form-mark">必須</span></label>
            <div class="col-md-7">
              <input v-model="form.sinsei_email" :class="{ 'is-invalid': form.errors.has('sinsei_email') }" class="form-control" type="email" name="sinsei_email">
              <has-error :form="form" field="sinsei_email" />
            </div>
          </div>

          <!-- introducer_type -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end"></label>
            <div class="col-md-7">
              <b-form-radio-group
                id="radiobox-group-introducer_type"
                v-model="form.introducer_type"
                :options="introducer_type_options"
                :class="{ 'is-invalid': form.errors.has('introducer_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="introducer_type" />
            </div>
          </div>

          <!-- syoukai_id -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end">紹介取次店ID<span class="col-form-mark">必須</span></label>
            <div class="col-md-7">
              <input v-model="form.syoukai_id" :class="{ 'is-invalid': form.errors.has('syoukai_id') }" class="form-control" type="text" name="syoukai_id">
              <has-error :form="form" field="syoukai_id" />
            </div>
          </div>

          <!-- syoukai_name -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end">紹介取次店名<span class="col-form-mark">必須</span></label>
            <div class="col-md-7">
              <input v-model="form.syoukai_name" :class="{ 'is-invalid': form.errors.has('syoukai_name') }" class="form-control" type="text" name="syoukai_name">
              <has-error :form="form" field="syoukai_name" />
            </div>
          </div>

          <template v-if="form.introducer_type == 'AGENCY'">
            <!-- eva_id -->
            <div class="mb-3 row">
              <label class="col-md-5 col-form-label text-md-end">エバンジェリストID</label>
              <div class="col-md-7">
                <input v-model="form.eva_id" :class="{ 'is-invalid': form.errors.has('eva_id') }" class="form-control" type="text" name="eva_id">
                <has-error :form="form" field="eva_id" />
              </div>
            </div>

            <!-- eva_name -->
            <div class="mb-3 row">
              <label class="col-md-5 col-form-label text-md-end">エバンジェリスト名</label>
              <div class="col-md-7">
                <input v-model="form.eva_name" :class="{ 'is-invalid': form.errors.has('eva_name') }" class="form-control" type="text" name="eva_name">
                <has-error :form="form" field="eva_name" />
              </div>
            </div>
          </template>

          <!-- nth_type -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end">この登録申請者は紹介者（あなた）の<span class="col-form-mark">必須</span></label>
            <div class="col-md-7">
              <b-form-radio-group
                @change="changeNthType"
                id="radiobox-group-nth_type"
                v-model="form.nth_type"
                class="mt-2"
                :options="nth_type_options"
                :class="{ 'is-invalid': form.errors.has('nth_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="nth_type" />
            </div>
          </div>

          <!-- isd_type -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end">直上者指定<span class="col-form-mark">必須</span></label>
            <div class="col-md-7">
              <b-form-radio-group
                @change="changeIdsType"
                id="radiobox-group-isd_type"
                v-model="form.isd_type"
                class="mt-2"
                :options="isd_type_options"
                :class="{ 'is-invalid': form.errors.has('isd_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="isd_type" />
            </div>
          </div>

          <template v-if="form.isd_type == 'DESIGNATE'">
            <!-- isd_id -->
            <div class="mb-3 row">
              <label class="col-md-5 col-form-label text-md-end">直上者ID<span class="col-form-mark">必須</span></label>
              <div class="col-md-7">
                <input v-model="form.isd_id" :class="{ 'is-invalid': form.errors.has('isd_id') }" class="form-control" type="text" name="name">
                <has-error :form="form" field="isd_id" />
              </div>
            </div>

            <!-- isd_name -->
            <div class="mb-3 row">
              <label class="col-md-5 col-form-label text-md-end">直上者名<span class="col-form-mark">必須</span></label>
              <div class="col-md-7">
                <input v-model="form.isd_name" :class="{ 'is-invalid': form.errors.has('isd_name') }" class="form-control" type="text" name="name">
                <has-error :form="form" field="isd_name" />
              </div>
            </div>
            
            <!-- direction_type -->
            <div class="mb-3 row">
              <label class="col-md-5 col-form-label text-md-end">直上者の<span class="col-form-mark">必須</span></label>
              <div class="col-md-7">
                <b-form-radio-group
                  @change="changeDicrectionType"
                  id="radiobox-group-direction_type"
                  v-model="form.direction_type"
                  class="mt-2"
                  :options="direction_type_options"
                  :class="{ 'is-invalid': form.errors.has('direction_type') }"
                ></b-form-radio-group>
                <has-error :form="form" field="direction_type" />
              </div>
            </div>
          </template>
          
          <!-- weg_type -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-left">電解水生成器の取り付けについて<span class="col-form-mark">必須</span></label>
            <div class="col-md-7">
              <b-form-select 
                id="radiobox-group-weg_type"
                v-model="form.weg_type"
                :options="weg_type_options"
                :class="{ 'is-invalid': form.errors.has('weg_type') }"></b-form-select>
              <has-error :form="form" field="weg_type" />
            </div>
          </div>
          
          <!-- note -->
          <div class="mb-3 row">
            <label class="col-md-5 col-form-label text-md-end">備考（通信欄）</label>
            <div class="col-md-7">
              <textarea v-model="form.note" :class="{ 'is-invalid': form.errors.has('note') }" rows="3" max-rows="6" class="form-control"  name="note"></textarea>
              <has-error :form="form" field="note" />
            </div>
          </div>

          <div class="mt-5 row">
            <div class="col-md-7 offset-md-5 text-center text-md-left">
              <!-- Submit Button -->
              <v-button :loading="form.busy">送信</v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import { Form } from 'vform'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {

  middleware: 'guest',

  metaInfo () {
    return { title: "取次店の画面" }
  },
  
  created () {
    this.introducer_type_options = this.dicToArray(window.config.IntroducerType)
    this.nth_type_options = this.dicToArray(window.config.NthType)
    this.isd_type_options = this.dicToArray(window.config.ISDType)
    this.weg_type_options = this.dicToArray(window.config.WEGType)
    this.direction_type_options = this.dicToArray(window.config.DirectionType)
    this.form.introducer_type = 'AGENCY'
    this.form.nth_type = 'FIRST'
    this.form.isd_type = 'AUTOMATIC'
    this.form.weg_type = 'ATTACHABLE'
    this.changeNthType()
  },

  data: () => ({
    title: "取次店の画面",
    form: new Form({
      sinsei_name: null,
      sinsei_email: null,
      introducer_type: null,
      syoukai_id: null,
      syoukai_name: null,
      eva_id: null,
      eva_name: null,
      nth_type: null,
      isd_type: null,
      isd_id: null,
      isd_name: null,
      direction_type: null,
    }),
    isd_type_options: [],
    nth_type_options: [],
    user_type_options: [],
    weg_type_options: [],
  }),

  methods: {
    async register () {
      try {
        const { data } = await this.form.post('/api/introducer/register')
        Swal.fire({
          type: 'success',
          title: "",
          text: `${this.form.sinsei_name}様にオンライン登録のURLをメールで送信しました`,
          reverseButtons: true,
          confirmButtonText: i18n.t('閉じる'),
          cancelButtonText: i18n.t('cancel')
        }).then((result) => {
          window.location.reload();
        })
      } catch(e) {
        console.log(e);
      }
    },
    changeIdsType() {
      if(this.form.isd_type == 'AUTOMATIC') {
        this.form.isd_id = null
        this.form.isd_name = null
        this.form.direction_type = null
      }
    },
    changeNthType() {
      if(this.form.nth_type == 'FIRST') {
        this.form.isd_type = 'AUTOMATIC'
        this.isd_type_options.filter(x => x.value != 'AUTOMATIC').map((x) => { x.disabled = true; return x;})
        this.changeIdsType()  
      } else {
        this.isd_type_options.filter(x => x.value != 'AUTOMATIC').map((x) => { x.disabled = false; return x;})
      }
    },
    changeDicrectionType() {

    },
    dicToArray(dic) {
      var result = []
      Object.keys(dic).forEach(function(key) {
        var obj = {
          value: key,
          text: dic[key],
          disabled: false
        }
        result.push(obj)
      });
      return result
    }
  }
}
</script>
