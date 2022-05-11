<template>
  <div class="row">
    <div class="col-lg-10 m-auto">
      <card v-if="mustVerifyEmail" :title="$t('register')">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
      </card>
      <card v-else :title="title">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)" class="py-3">
          <!-- sinsei_name -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">登録申請者氏名</label>
            <div class="col-md-8">
              <input v-model="form.sinsei_name" :class="{ 'is-invalid': form.errors.has('sinsei_name') }" class="form-control" type="text" name="sinsei_name">
              <has-error :form="form" field="sinsei_name" />
            </div>
          </div>

          <!-- sinsei_email -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">登録申請者メールアドレス</label>
            <div class="col-md-8">
              <input v-model="form.sinsei_email" :class="{ 'is-invalid': form.errors.has('sinsei_email') }" class="form-control" type="email" name="sinsei_email">
              <has-error :form="form" field="sinsei_email" />
            </div>
          </div>

          <!-- introducer_type -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end"></label>
            <div class="col-md-8">
              <b-form-radio-group
                id="radiobox-group-introducer_type"
                v-model="form.introducer_type"
                :options="introducer_options"
                :class="{ 'is-invalid': form.errors.has('introducer_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="introducer_type" />
            </div>
          </div>

          <!-- syoukai_id -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">紹介取次店ID</label>
            <div class="col-md-8">
              <input v-model="form.syoukai_id" :class="{ 'is-invalid': form.errors.has('syoukai_id') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="syoukai_id" />
            </div>
          </div>

          <!-- syoukai_name -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">紹介取次店名</label>
            <div class="col-md-8">
              <input v-model="form.syoukai_name" :class="{ 'is-invalid': form.errors.has('syoukai_name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="syoukai_name" />
            </div>
          </div>

          <!-- eva_id -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">エバンジェリストID</label>
            <div class="col-md-8">
              <input v-model="form.eva_id" :class="{ 'is-invalid': form.errors.has('eva_id') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="eva_id" />
            </div>
          </div>

          <!-- eva_name -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">エバンジェリスト名</label>
            <div class="col-md-8">
              <input v-model="form.eva_name" :class="{ 'is-invalid': form.errors.has('eva_name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="eva_name" />
            </div>
          </div>

          <!-- nth_type -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">この登録申請者は紹介者（あなた）の</label>
            <div class="col-md-8">
              <b-form-radio-group
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
            <label class="col-md-4 col-form-label text-md-end">直上者指定</label>
            <div class="col-md-8">
              <b-form-radio-group
                id="radiobox-group-isd_type"
                v-model="form.isd_type"
                class="mt-2"
                :options="isd_type_options"
                :class="{ 'is-invalid': form.errors.has('isd_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="isd_type" />
            </div>
          </div>

          <!-- isd_id -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">直上者ID</label>
            <div class="col-md-8">
              <input v-model="form.isd_id" :class="{ 'is-invalid': form.errors.has('isd_id') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="isd_id" />
            </div>
          </div>

          <!-- isd_name -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-end">直上者名</label>
            <div class="col-md-8">
              <input v-model="form.isd_name" :class="{ 'is-invalid': form.errors.has('isd_name') }" class="form-control" type="text" name="name">
              <has-error :form="form" field="isd_name" />
            </div>
          </div>

          <div class="mt-5 row">
            <div class="col-md-8 offset-md-4 text-center text-md-left">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('register') }}
              </v-button>
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
    this.introducer_options = window.config.IntroducerType
    this.nth_type_options = window.config.NthType
    this.isd_type_options = window.config.ISDType
  },

  data: () => ({
    title: "取次店の画面",
    form: new Form({
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      user_type: null,
      syoukai_id: null,
      syoukai_name: null,
      eva_id: null,
      eva_name: null,
      nth: null,
      isd: null,
      isd_id: null,
      isd_name: null,
    }),
    isd_type_options: [],
    nth_type_options: [],
    user_type_options: [],
    mustVerifyEmail: false
  }),

  methods: {
    async register () {
      try {
        const { data } = await this.form.post('/api/introducer/register')
        Swal.fire({
          type: 'success',
          title: "",
          text: "申請されました。",
          reverseButtons: true,
          confirmButtonText: i18n.t('閉じる'),
          cancelButtonText: i18n.t('cancel')
        }).then((result) => {
          window.location.reload();
        })
      } catch(e) {
        console.log(e);
      }
    }
  }
}
</script>
