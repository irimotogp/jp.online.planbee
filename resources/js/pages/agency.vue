<template>
  <div v-if="loading">
    <div class="d-flex justify-content-center align-items-center">
      <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
  <form @submit.prevent="register" @keydown="form.onKeydown($event)" v-else class="row">
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
            <a @click="next_step(2)" class="btn btn-main">登録申請に進む</a>
          </div>
        </div>
      </card>
      <card v-else-if="step == 2" :title="title" class="agency">
        <div class="py-3">
          <input type="hidden" v-model="form.uuid" name="uuid"/>
          <!-- Name -->
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">{{ $t('name') }}</label>
            <div class="col-md-8">
              <div class="row mb-3" :class="{ 'is-invalid': form.errors.has('kanji_sei') || form.errors.has('kanji_mei') }">
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
                  <input @change="changeKana('kata_sei')" v-model="form.kata_sei" class="form-control" type="text" name="kata_sei" placeholder="ｾｲ">
                </div>
                <div class="col-6">
                  <input @change="changeKana('kata_mei')" v-model="form.kata_mei" class="form-control" type="text" name="kata_mei" placeholder="ﾒｲ">
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
              <input v-model="form.birthday" :class="{ 'is-invalid': form.errors.has('birthday') }" class="form-control" type="date" name="birthday" id="birthday" placeholder="01234567890">
              <has-error :form="form" field="birthday" />
            </div>
          </div>

          <zip-code 
            zip_t="zip1"
            pref_t="pref1"
            city_t="city1"
            addr_t="addr1"
            :pref_options="pref_options"
            :form="form"
            @update="updateZipCode1"/>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">自宅電話番号</label>
            <div class="col-md-6">
              <input v-model="form.home_phone" :class="{ 'is-invalid': form.errors.has('phone_any') }" class="form-control" type="text" name="home_phone" id="home_phone" placeholder="01234567890">
              <has-error :form="form" field="phone_any" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">FAX番号</label>
            <div class="col-md-6">
              <input v-model="form.fax" :class="{ 'is-invalid': form.errors.has('fax') }" class="form-control" type="text" name="fax" id="fax" placeholder="01234567890">
              <has-error :form="form" field="fax" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">携帯電話</label>
            <div class="col-md-6">
              <input v-model="form.mobile_phone" :class="{ 'is-invalid': form.errors.has('phone_any') }" class="form-control" type="text" name="mobile_phone" id="mobile_phone" placeholder="01234567890">
              <has-error :form="form" field="phone_any" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <label class="col-md-4 col-form-label text-md-right">携帯電話（予備）</label>
            <div class="col-md-6">
              <input v-model="form.mobile_phone2" :class="{ 'is-invalid': form.errors.has('mobile_phone2') }" class="form-control" type="text" name="mobile_phone2" id="mobile_phone2" placeholder="01234567890">
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
            :pref_options="pref_options"
            :form="form"
            @update="updateZipCode2"/>
            
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
              <input v-model="form.receiver_phone" :class="{ 'is-invalid': form.errors.has('receiver_phone') }" class="form-control" type="text" name="receiver_phone" id="receiver_phone" placeholder="01234567890">
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
            @updateBank="updateBank"
            @updateBranch="updateBranch"
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
          <div class="mt-5 text-center">
            <a @click="next_step(3)" class="btn btn-main">確認</a>
          </div>
        </div>
      </card>
      <card v-else :title="title" class="confirm">
        <div class="py-3">
          <table class="table">
            <tr>
              <th class="text-md-right">氏名</th>
              <td>{{ form.kanji_sei }} {{ form.kanji_mei }}</td>
            </tr>
            <tr>
              <th class="text-md-right">氏名(カタカナ)</th>
              <td>{{ form.kata_sei }} {{ form.kata_mei }}</td>
            </tr>
            <tr>
              <th class="text-md-right">性別</th>
              <td>{{ getTextOfOptions(form.sex_type, sex_options) }}</td>
            </tr>
            <tr>
              <th class="text-md-right">生年月日</th>
              <td>{{ form.birthday }}</td>
            </tr>
            <tr>
              <th class="text-md-right">郵便番号</th>
              <td>{{ form.zip1 }}</td>
            </tr>
            <tr>
              <th class="text-md-right">都道府県</th>
              <td>{{ getTextOfOptions(form.pref1, pref_options, 'value', 'text') }}</td>
            </tr>
            <tr>
              <th class="text-md-right">住所１</th>
              <td>{{ form.city1 }}</td>
            </tr>
            <tr>
              <th class="text-md-right">住所２</th>
              <td>{{ form.addr1 }}</td>
            </tr>
            <tr>
              <th class="text-md-right">自宅電話番号</th>
              <td>{{ form.home_phone }}</td>
            </tr>
            <tr>
              <th class="text-md-right">FAX番号</th>
              <td>{{ form.fax }}</td>
            </tr>
            <tr>
              <th class="text-md-right">携帯電話</th>
              <td>{{ form.mobile_phone }}</td>
            </tr>
            <tr>
              <th class="text-md-right">携帯電話（予備）</th>
              <td>{{ form.mobile_phone2 }}</td>
            </tr>
            <tr>
              <th class="text-md-right">PCメール</th>
              <td>{{ form.pc_email }}</td>
            </tr>
            <tr>
              <th class="text-md-right">携帯メール</th>
              <td>{{ form.phone_email }}</td>
            </tr>
            <tr>
              <th class="text-md-right">勤務先名</th>
              <td>{{ form.phone_email }}</td>
            </tr>
            <tr>
              <th class="text-md-right">携帯メール</th>
              <td>{{ form.work_place_name }}</td>
            </tr>
            <tr>
              <th class="text-md-right">配送先指定</th>
              <td>{{ getTextOfOptions(form.shipping_address_id, shipping_address_options, 'value', 'text') }}</td>
            </tr>
            <tr>
              <th class="text-md-right">郵便番号</th>
              <td>{{ form.zip2 }}</td>
            </tr>
            <tr>
              <th class="text-md-right">都道府県</th>
              <td>{{ getTextOfOptions(form.pref2, pref_options, 'value', 'text') }}</td>
            </tr>
            <tr>
              <th class="text-md-right">住所１</th>
              <td>{{ form.city2 }}</td>
            </tr>
            <tr>
              <th class="text-md-right">住所２</th>
              <td>{{ form.addr2 }}</td>
            </tr>
            <tr>
              <th class="text-md-right">宛名</th>
              <td>{{ form.receiver_name }}</td>
            </tr>
            <tr>
              <th class="text-md-right">宛先電話番号</th>
              <td>{{ form.receiver_phone }}</td>
            </tr>
            <tr>
              <th class="text-md-right">紹介取次店ID</th>
              <td>{{ form.syoukai_id }}</td>
            </tr>
            <tr>
              <th class="text-md-right">紹介取次店名</th>
              <td>{{ form.syoukai_name }}</td>
            </tr>
            <tr>
              <th class="text-md-right">エバンジェリストID</th>
              <td>{{ form.eva_id }}</td>
            </tr>
            <tr>
              <th class="text-md-right">エバンジェリスト名</th>
              <td>{{ form.eva_name }}</td>
            </tr>
            <tr>
              <th class="text-md-right">契約タイプ</th>
              <td>{{ getTextOfOptions(form.contract_type, contract_options) }}</td>
            </tr>
            <tr>
              <th class="text-md-right">契約商品</th>
              <td>{{ getTextOfOptions(form.product_id, product_options, 'value', 'text') }}</td>
            </tr>
            <tr>
              <th class="text-md-right">銀行コード</th>
              <td>{{ form.bank_code }}</td>
            </tr>
            <tr>
              <th class="text-md-right">銀行名</th>
              <td>{{ form.bank_name }}</td>
            </tr>
            <tr>
              <th class="text-md-right">支店コード</th>
              <td>{{ form.branch_code }}</td>
            </tr>
            <tr>
              <th class="text-md-right">支店名</th>
              <td>{{ form.branch_name }}</td>
            </tr>
            <tr>
              <th class="text-md-right">預金種目</th>
              <td>{{ getTextOfOptions(form.deposit_id, deposit_options, 'value', 'text') }}</td>
            </tr>
            <tr>
              <th class="text-md-right">口座番号</th>
              <td>{{ form.account_number }}</td>
            </tr>
            <tr>
              <th class="text-md-right">本人確認書類</th>
              <td>
                <template v-if="form.identity_doc">
                  <img :src="form.identity_doc"/>
                </template>
              </td>
            </tr>
            <tr>
              <th class="text-md-right">本人確認書類（予備）</th>
              <td>
                <template v-if="form.identity_doc2">
                  <img :src="form.identity_doc2"/>
                </template>
              </td>
            </tr>
          </table>
          <div class="mt-5 row">
            <div class="col-md-8 offset-md-4 text-center text-md-left">
              <a @click="back_step()" class="btn btn-main mr-2">戻る</a>
              <v-button :loading="form.busy">
                {{ $t('register') }}
              </v-button>
            </div>
          </div>
        </div>
      </card>
    </div>
  </form>
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
    pref_options:  [
      { value: 1, text: "北海道" },
      { value: 2, text: "青森県" },
      { value: 3, text: "岩手県" },
      { value: 4, text: "宮城県" },
      { value: 5, text: "秋田県" },
      { value: 6, text: "山形県" },
      { value: 7, text: "福島県" },
      { value: 8, text: "茨城県" },
      { value: 9, text: "栃木県" },
      { value: 10, text: "群馬県" },
      { value: 11, text: "埼玉県" },
      { value: 12, text: "千葉県" },
      { value: 13, text: "東京都" },
      { value: 14, text: "神奈川県" },
      { value: 15, text: "新潟県" },
      { value: 16, text: "富山県" },
      { value: 17, text: "石川県" },
      { value: 18, text: "福井県" },
      { value: 19, text: "山梨県" },
      { value: 20, text: "長野県" },
      { value: 21, text: "岐阜県" },
      { value: 22, text: "静岡県" },
      { value: 23, text: "愛知県" },
      { value: 24, text: "三重県" },
      { value: 25, text: "滋賀県" },
      { value: 26, text: "京都府" },
      { value: 27, text: "大阪府" },
      { value: 28, text: "兵庫県" },
      { value: 29, text: "奈良県" },
      { value: 30, text: "和歌山県" },
      { value: 31, text: "鳥取県" },
      { value: 32, text: "島根県" },
      { value: 33, text: "岡山県" },
      { value: 34, text: "広島県" },
      { value: 35, text: "山口県" },
      { value: 36, text: "徳島県" },
      { value: 37, text: "香川県" },
      { value: 38, text: "愛媛県" },
      { value: 39, text: "高知県" },
      { value: 40, text: "福岡県" },
      { value: 41, text: "佐賀県" },
      { value: 42, text: "長崎県" },
      { value: 43, text: "熊本県" },
      { value: 44, text: "大分県" },
      { value: 45, text: "宮崎県" },
      { value: 46, text: "鹿児島県" },
      { value: 47, text: "沖縄県" },
      { value: 99, text: "海外" }
    ],
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
        this.back_step()
        console.log(e);
      }
    },
    changeKana(name) {
      const value = this.form[name]
      const charDict = {
        zenkaku: [
          'ア', 'イ', 'ウ', 'エ', 'オ', 'カ', 'キ', 'ク', 'ケ', 'コ', 'サ', 'シ', 'ス', 'セ', 'ソ',
          'タ', 'チ', 'ツ', 'テ', 'ト', 'ナ', 'ニ', 'ヌ', 'ネ', 'ノ', 'ハ', 'ヒ', 'フ', 'ヘ', 'ホ',
          'マ', 'ミ', 'ム', 'メ', 'モ', 'ヤ', 'ユ', 'ヨ', 'ラ', 'リ', 'ル', 'レ', 'ロ', 'ワ', 'ヲ', 'ン',
          'ァ', 'ィ', 'ゥ', 'ェ', 'ォ', 'ッ', 'ャ', 'ュ', 'ョ', 'ー', '。', '、', '「', '」',
          'ガ', 'ギ', 'グ', 'ゲ', 'ゴ', 'ザ', 'ジ', 'ズ', 'ゼ', 'ゾ', 'ダ', 'ヂ', 'ヅ', 'デ', 'ド',
          'バ', 'ビ', 'ブ', 'ベ', 'ボ', 'パ', 'ピ', 'プ', 'ペ', 'ポ', 'ヴ', 'ヷ', 'ヺ',
          '０', '１', '２', '３', '４', '５', '６', '７', '８', '９',
          'Ａ', 'Ｂ', 'Ｃ', 'Ｄ', 'Ｅ', 'Ｆ', 'Ｇ', 'Ｈ', 'Ｉ', 'Ｊ', 'Ｋ', 'Ｌ', 'Ｍ', 'Ｎ',
          'Ｏ', 'Ｐ', 'Ｑ', 'Ｒ', 'Ｓ', 'Ｔ', 'Ｕ', 'Ｖ', 'Ｗ', 'Ｘ', 'Ｙ', 'Ｚ',
          'ａ', 'ｂ', 'ｃ', 'ｄ', 'ｅ', 'ｆ', 'ｇ', 'ｈ', 'ｉ', 'ｊ', 'ｋ', 'ｌ', 'ｍ', 'ｎ',
          'ｏ', 'ｐ', 'ｑ', 'ｒ', 'ｓ', 'ｔ', 'ｕ', 'ｖ', 'ｗ', 'ｘ', 'ｙ', 'ｚ'
        ],
        hankaku: [
          'ｱ', 'ｲ', 'ｳ', 'ｴ', 'ｵ', 'ｶ', 'ｷ', 'ｸ', 'ｹ', 'ｺ', 'ｻ', 'ｼ', 'ｽ', 'ｾ', 'ｿ',
          'ﾀ', 'ﾁ', 'ﾂ', 'ﾃ', 'ﾄ', 'ﾅ', 'ﾆ', 'ﾇ', 'ﾈ', 'ﾉ', 'ﾊ', 'ﾋ', 'ﾌ', 'ﾍ', 'ﾎ',
          'ﾏ', 'ﾐ', 'ﾑ', 'ﾒ', 'ﾓ', 'ﾔ', 'ﾕ', 'ﾖ', 'ﾗ', 'ﾘ', 'ﾙ', 'ﾚ', 'ﾛ', 'ﾜ', 'ｦ', 'ﾝ',
          'ｧ', 'ｨ', 'ｩ', 'ｪ', 'ｫ', 'ｯ', 'ｬ', 'ｭ', 'ｮ', 'ｰ', '｡', '､', '｢', '｣',
          'ｶﾞ', 'ｷﾞ', 'ｸﾞ', 'ｹﾞ', 'ｺﾞ', 'ｻﾞ', 'ｼﾞ', 'ｽﾞ', 'ｾﾞ', 'ｿﾞ', 'ﾀﾞ', 'ﾁﾞ', 'ﾂﾞ', 'ﾃﾞ', 'ﾄﾞ',
          'ﾊﾞ', 'ﾋﾞ', 'ﾌﾞ', 'ﾍﾞ', 'ﾎﾞ', 'ﾊﾟ', 'ﾋﾟ', 'ﾌﾟ', 'ﾍﾟ', 'ﾎﾟ', 'ｳﾞ', 'ﾜﾞ', 'ｦﾞ',
          '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
          'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
          'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
          'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
          'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
        ]
      }

      const regExp = new RegExp(`(${charDict.zenkaku.join('|')})`, 'g')

      const result = value.replace(regExp, match => {
        const index = charDict.zenkaku.indexOf(match)
        return charDict.hankaku[index]
      })
      this.form[name] = result
    },
    next_step(value) {
      if(value == 2) {
        let items = this.privacy.filter((x) => { return x.value == 0})
        if(items.length > 0) this.show_errors = true
        else this.step = 2
      } else {
        this.step = 3
      }
    },
    back_step() {
      this.step = 2
    },
    getTextOfOptions(value, options, value_label = null, text_label = null) {
      if(value_label == null) {
        const key = Object.keys(options).find(x => x == value)
        if(key) { return options[key] } else { return "" }
      } else {
        const option = options.find(x => x[value_label] == value)
        if(option) { return option[text_label] } else { return "" }
      }
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
    updateBank(bank) {
      this.form.bank = bank
      this.form.bank_name = bank ? bank.name : null
      this.form.bank_code = bank ? bank.code : null
    },
    updateBranch(branch) {
      this.form.branch = branch
      this.form.branch_name = branch ? branch.name : null
      this.form.branch_code = branch ? branch.code : null
    },
    updateImage(name, image) {
      this.form[name] = image
    }
  }
}
</script>
