<template>
  <div v-if="loading">
    <div class="d-flex justify-content-center align-items-center">
      <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
  <div v-else class="row">
    <div class="col-lg-10 m-auto">
      <card v-if="step == 1" :title="title" class="privacy">
        <div class="py-3">
          <div class="mb-3">
            <label>プランビーへようこそ！<br>取次店登録申請に進む前に、重要事項の確認を行なってください。<br>下記の重要事項について説明を受け、了承・同意される場合、□に✔️を入れてください。</label>
          </div>
          <div class="list">
            <div v-for="(item, index) in privacy" :key="index" class="mb-2 item">
              <b-form-checkbox
                :id="`privacy_${index}`"
                v-model="item.value"
                value="1"
                unchecked-value="0"
                :class="{ 'is-invalid': item.value == 0 }"
              ><span v-html="item.text"></span></b-form-checkbox>
              <div class="help-block invalid-feedback error" v-if="item.value == 0 && show_errors">必ず選択してください。</div>
            </div>
          </div>
          <div class="mt-5 text-center">
            <a @click="next_step()" class="btn btn-main">登録申請に進む</a>
          </div>
        </div>
      </card>
      <card v-else :title="title" class="agency">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)" class="py-3" >
          <input type="hidden" v-model="form.uuid" name="uuid"/>
          <!-- Name -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-8">
              <div class="row mb-3" :class="{ 'is-invalid': form.errors.has('kanji_sei') || form.errors.has('mei_kanji') }">
                <div class="col-6">
                  <input v-model="form.kanji_sei" class="form-control" type="text" name="kanji_sei" placeholder="姓">
                </div>
                <div class="col-6">
                  <input v-model="form.kanji_mei" class="form-control" type="text" name="kanji_mei" placeholder="名">
                </div>
              </div>
              <has-error :form="form" field="kanji_sei" />
              <has-error :form="form" field="kanji_mei" />
              
              <div class="row" :class="{ 'is-invalid': form.errors.has('kata_sei') || form.errors.has('kata_mei') }">
                <div class="col-6">
                  <input v-model="form.kata_sei" class="form-control" type="text" name="kata_sei" placeholder="ｾｲ">
                </div>
                <div class="col-6">
                  <input v-model="form.kata_mei" class="form-control" type="text" name="kata_mei" placeholder="ﾒｲ">
                </div>
              </div>
              <has-error :form="form" field="kata_sei" />
              <has-error :form="form" field="kata_mei" />
            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">性別</label>
            <div class="col-md-8">
              <b-form-radio-group
                id="radiobox-group-sex_type"
                v-model="form.sex_type"
                class="mt-2"
                :options="sex_options"
                :class="{ 'is-invalid': form.errors.has('sex_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="sex_type" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">生年月日</label>
            <div class="col-md-6">
              <input v-model="form.birthday" :class="{ 'is-invalid': form.errors.has('birthday') }" class="form-control" type="date" name="birthday" id="birthday" placeholder="0123456789">
              <has-error :form="form" field="birthday" />
            </div>
          </div>

          <zip-code 
            zip_t="zip1"
            pref_t="pref1"
            city_t="city1"
            addr_t="addr1"
            @update="updateZipCode1"
            :form="form"/>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">自宅電話番号</label>
            <div class="col-md-6">
              <input v-model="form.home_phone" :class="{ 'is-invalid': form.errors.has('home_phone') }" class="form-control" type="text" name="home_phone" id="home_phone" placeholder="0123456789">
              <has-error :form="form" field="home_phone" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">FAX番号</label>
            <div class="col-md-6">
              <input v-model="form.fax" :class="{ 'is-invalid': form.errors.has('fax') }" class="form-control" type="text" name="fax" id="fax" placeholder="0123456789">
              <has-error :form="form" field="fax" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">携帯電話</label>
            <div class="col-md-6">
              <input v-model="form.mobile_phone" :class="{ 'is-invalid': form.errors.has('mobile_phone') }" class="form-control" type="text" name="mobile_phone" id="mobile_phone" placeholder="0123456789">
              <has-error :form="form" field="mobile_phone" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">携帯電話（予備）</label>
            <div class="col-md-6">
              <input v-model="form.mobile_phone2" :class="{ 'is-invalid': form.errors.has('mobile_phone2') }" class="form-control" type="text" name="mobile_phone2" id="mobile_phone2" placeholder="0123456789">
              <has-error :form="form" field="mobile_phone2" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">PCメール</label>
            <div class="col-md-6">
              <input v-model="form.pc_email" :class="{ 'is-invalid': form.errors.has('pc_email') }" class="form-control" type="text" name="pc_email" id="pc_email">
              <has-error :form="form" field="pc_email" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">携帯メール</label>
            <div class="col-md-6">
              <input v-model="form.phone_email" :class="{ 'is-invalid': form.errors.has('phone_email') }" class="form-control" type="text" name="phone_email" id="phone_email">
              <has-error :form="form" field="phone_email" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">勤務先名</label>
            <div class="col-md-6">
              <input v-model="form.work_place_name" :class="{ 'is-invalid': form.errors.has('work_place_name') }" class="form-control" type="text" name="work_place_name" id="work_place_name">
              <has-error :form="form" field="work_place_name" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">配送先指定</label>
            <div class="col-md-8">
              <b-form-select 
                id="radiobox-group-shipping_address_id"
                v-model="form.shipping_address_id"
                :options="shipping_address_options"
                :class="{ 'is-invalid': form.errors.has('shipping_address_id') }"></b-form-select>
              <has-error :form="form" field="shipping_address_id" />
            </div>
          </div>

          <zip-code 
            zip_t="zip2"
            pref_t="pref2"
            city_t="city2"
            addr_t="addr2"
            @update="updateZipCode2"
            :form="form"/>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">宛名</label>
            <div class="col-md-6">
              <input v-model="form.receiver_name" :class="{ 'is-invalid': form.errors.has('receiver_name') }" class="form-control" type="text" name="receiver_name" id="receiver_name">
              <has-error :form="form" field="receiver_name" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">宛先電話番号</label>
            <div class="col-md-6">
              <input v-model="form.receiver_phone" :class="{ 'is-invalid': form.errors.has('receiver_phone') }" class="form-control" type="text" name="receiver_phone" id="receiver_phone" placeholder="0123456789">
              <has-error :form="form" field="receiver_phone" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">紹介取次店ID</label>
            <div class="col-md-6">
              <input v-model="form.syoukai_id" :class="{ 'is-invalid': form.errors.has('syoukai_id') }" class="form-control" type="text" name="syoukai_id" id="syoukai_id">
              <has-error :form="form" field="syoukai_id" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">紹介取次店名</label>
            <div class="col-md-6">
              <input v-model="form.syoukai_name" :class="{ 'is-invalid': form.errors.has('syoukai_name') }" class="form-control" type="text" name="syoukai_name" id="syoukai_name">
              <has-error :form="form" field="syoukai_name" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">エバンジェリストID</label>
            <div class="col-md-6">
              <input v-model="form.eva_id" :class="{ 'is-invalid': form.errors.has('eva_id') }" class="form-control" type="text" name="eva_id" id="eva_id">
              <has-error :form="form" field="eva_id" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">エバンジェリスト名</label>
            <div class="col-md-6">
              <input v-model="form.eva_name" :class="{ 'is-invalid': form.errors.has('eva_name') }" class="form-control" type="text" name="eva_name" id="eva_name">
              <has-error :form="form" field="eva_name" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">契約タイプ</label>
            <div class="col-md-8">
              <b-form-radio-group
                id="radiobox-group-contract_type"
                v-model="form.contract_type"
                class="mt-2"
                :options="contract_options"
                :class="{ 'is-invalid': form.errors.has('contract_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="contract_type" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">契約商品</label>
            <div class="col-md-8">
              <b-form-select 
                id="radiobox-group-product_id"
                v-model="form.product_id"
                :options="product_options"
                :class="{ 'is-invalid': form.errors.has('product_id') }"></b-form-select>
              <has-error :form="form" field="product_id" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">報酬振込先口座情報</label>
          </div>

          <bank-code 
            @update="updateBank"
            :form="form"/>
          
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">預金種目</label>
            <div class="col-md-8">
              <b-form-select 
                id="radiobox-group-deposit_id"
                v-model="form.deposit_id"
                :options="deposit_options"
                :class="{ 'is-invalid': form.errors.has('deposit_id') }"></b-form-select>
              <has-error :form="form" field="deposit_id" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">口座番号</label>
            <div class="col-md-6">
              <input v-model="form.account_number" :class="{ 'is-invalid': form.errors.has('account_number') }" class="form-control" type="text" name="account_number" id="account_number">
              <has-error :form="form" field="account_number" />
            </div>
          </div>

          <file-upload
            label="本人確認書類"
            name="identity_doc"
            :form="form"
            @update="updateImage"
            />

          <file-upload
            label="本人確認書類（予備）"
            name="identity_doc2"
            :form="form"
            @update="updateImage"
            />

          <div class="mt-5 row">
            <div class="col-md-8 offset-md-4 d-flex">
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
import axios from 'axios'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'
import ZipCode from '~/components/ZipCode'
import BankCode from '~/components/BankCode'
import FileUpload from '~/components/FileUpload'

export default {
  components: {
    ZipCode, BankCode, FileUpload
  },

  metaInfo () {
    return { title: 'オンライン取次店登録申請' }
  },

  created () {
    const { uuid } = this.$route.params
    this.uuid = uuid
    this.form.uuid = uuid
    this.fetch()
    this.type_options = window.config.UserType
    this.nth_options = window.config.NthType
    this.isd_options = window.config.ISDType
    this.contract_options = window.config.ContractType
    this.sex_options = window.config.SexType
  },

  data: () => ({
    title: 'オンライン取次店登録申請',
    loading: true,
    uuid: null,
    step: 1,
    show_errors: false,
    form: new Form({
    }),
    isd_options: {},
    nth_options: {},
    type_options: {},
    shipping_address_options: [],
    product_options: [],
    deposit_options: [],
    privacy: [
      { value: 0, text: "強引・無理矢理な勧誘はなく、商品や契約内容を理解できる説明を受けました。また、何も活動せずに収入が得られるビジネスではないことを理解しました。"},
      { value: 0, text: "取次店登録費用として支払った初期費用は返金されないことを理解しました。（法定解約時を除きます）"},
      { value: 0, text: "商品および契約書面が届いた日から20日を経過するまでは、書面により無条件で契約の解除を行うことができるクーリング・オフについて説明を受けました。（法人は対象外です）"},
      { value: 0, text: "最低利用期間である1年以内に解約する場合、解約手数料(税込10,450円)を支払うことに同意しました。"},
      { value: 0, text: "支払日は毎月20日(口座振替払いのみ金融機関休業日の場合は翌営業日)です。支払いが25日を過ぎた場合、再請求手数料 (税込800円)が発生し、報酬から相殺または銀行振込にて精算することに同意しました。"},
      { value: 0, text: "3年経過後は、いつでも買取できますが、所定の買取申請が必要です。申請するまで同一条件でレンタル自動継続となる ことに同意しました。"},
      { value: 0, text: "5年経過後は、いつでも交換プログラム(新品商品に交換または他契約プランへ変更)を利用できますが、所定の申請が必要 です。申請をするまで同一条件でレンタル自動継続となることに同意しました。月額料金のお支払いが翌月以降になった場合、PRVが発生せず遅延回数にカウントされます。 遅延回数が累積5回以上になると、交換プログラムが受けられなくなります。"},
      { value: 0, text: "取次店特典についての説明を受け理解しました。詳細は概要書面をご確認ください。月額料金に未払いがある場合、全ての取次店特典が受けられません。"},
      { value: 0, text: "還元水素水の効果・効能が認められているのは、「胃腸症状の改善効果」のみです。汲みたての還元水素水を飲用し続けることで効果が期待できますが、個人差があり、効果を保証するものではありません。 勧誘時、他の病気が治るなどのことは発言しないようにしてください。"},
      { value: 0, text: "水分摂取やミネラル摂取を制限されている方に還元水素水の飲用をお勧めする場合、還元水素水は水道水に比べてカリウムやカルシウム等のミネラルが多く含まれますが、バナナやアボカドに比べると少量です。 ご心配の場合は、かかりつけの医師にご相談されることをおすすめしてください。詳細は<a href='http://planbee.co.jp/faq/%E9%9B%BB%E8%A7%A3%E6%B0%B4%E7%94%9F%E6%88%90%E5%99%A8%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6/beefine/1310'>こちら</a>からご確認ください"},
      { value: 0, text: "当社の個人情報保護方針を理解し、同意しました。<br>当社の個人情報保護については<a href='http://planbee.co.jp/privacy/'>こちら</a>からご確認ください。"},
    ],
  }),

  methods: {
    async fetch() {
      try {
        const { data } = await axios.get(`/api/agency/${this.uuid}`)
        if(data.status == 'success') {
          this.shipping_address_options = data.shipping_address_options
          this.product_options = data.product_options
          this.deposit_options = data.deposit_options
          this.loading = false
        } else {
          Swal.fire({
            type: 'error',
            title: "",
            text: data.error,
            reverseButtons: true,
            confirmButtonText: i18n.t('確認'),
            cancelButtonText: i18n.t('cancel')
          }).then((result) => {
            this.$router.push({ name: 'index' })
          })
        }
      } catch(e) {
        Swal.fire({
            type: 'error',
            title: "",
            text: "エラーが発生しました。",
            reverseButtons: true,
            confirmButtonText: i18n.t('確認'),
            cancelButtonText: i18n.t('cancel')
        }).then((result) => {
            this.$router.push({ name: 'index' })
          })
        console.log(e);
      }
    },
    async register () {
      try {
        const { data } = await this.form.post('/api/agency/register')
        if(data.status == "success") {
          Swal.fire({
            type: 'success',
            title: "",
            text: `${this.title}が登録されました。`,
            reverseButtons: true,
            confirmButtonText: i18n.t('閉じる'),
            cancelButtonText: i18n.t('cancel')
          }).then((result) => {
            this.$router.push({ name: 'index' })
          })
        } else {
          Swal.fire({
            type: 'error',
            title: "",
            text: "申請が失敗しました。",
            reverseButtons: true,
            confirmButtonText: i18n.t('閉じる'),
            cancelButtonText: i18n.t('cancel')
          }).then((result) => {
            this.$router.push({ name: 'index' })
          })
          console.log(e);
        }
      } catch(e) {
        console.log(e);
      }
    },
    next_step() {
      let items = this.privacy.filter((x) => { return x.value == 0})
      if(items.length > 0) this.show_errors = true
      else this.step = 2
    },
    updateZipCode1(data) {
      this.form.zip1 = data.zip
      this.form.pref1 = data.pref
      this.form.city1 = data.city
      this.form.addr1 = data.addr
    },
    updateZipCode2(data) {
      this.form.zip2 = data.zip
      this.form.pref2 = data.pref
      this.form.city2 = data.city
      this.form.addr2 = data.addr
    },
    updateBank(data) {
      this.form.bank_name = data.bank_name
      this.form.bank_code = data.bank_code
      this.form.branch_name = data.branch_name
      this.form.branch_code = data.branch_code
    },
    updateImage(name, image) {
      this.form[name] = image
    }
  }
}
</script>
