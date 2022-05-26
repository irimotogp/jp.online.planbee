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
        <div class="mb-3">
          <label>プランビーへようこそ！<br>取次店登録申請に進む前に、重要事項の確認を行なってください。<br>下記の重要事項について説明を受け、了承・同意される場合、□に✔️を入れてください。</label>
        </div>
        <div class="list">
          <div v-for="(item, index) in privacies" :key="index" class="mb-2 item">
            <b-form-checkbox
              :id="`privacies_${index}`"
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
      </card>
      <card v-else-if="step == 2" :title="title">
        <form id="submitForm" @submit.prevent="register" @keydown="form.onKeydown($event)">
          <input type="hidden" v-model="form.uuid" name="uuid"/>
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">性別<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                @change="changeSex"
                id="radiobox-group-sex_type"
                v-model="form.sex_type"
                class="mt-2"
                :options="sex_options"
                :class="{ 'is-invalid': form.errors.has('sex_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="sex_type" />
            </div>
          </div>
          
          <template v-if="form.sex_type == 'CORPORATION'">
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">法人名<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-6">
                <input :disabled="disabled" v-model="form.corp_kanji" :class="{ 'is-invalid': form.errors.has('corp_kanji') }" class="form-control" type="text" name="corp_kanji" placeholder="姓名">
                <has-error :form="form" field="corp_kanji" />
                <input :disabled="disabled" @change="changeKana('corp_kata')" v-model="form.corp_kata" :class="{ 'is-invalid': form.errors.has('corp_kata') }" class="form-control mt-3" type="text" name="corp_kata" placeholder="ｾｲﾒｲ">
                <has-error :form="form" field="corp_kata" />
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">代表者<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-8">
                <div class="row" :class="{ 'is-invalid': form.errors.has('rep_kanji_sei') || form.errors.has('rep_kanji_mei') }">
                  <div class="col-6">
                    <input :disabled="disabled" v-model="form.rep_kanji_sei" class="form-control" type="text" name="rep_kanji_sei" placeholder="姓">
                  </div>
                  <div class="col-6">
                    <input :disabled="disabled" v-model="form.rep_kanji_mei" class="form-control" type="text" name="rep_kanji_mei" placeholder="名">
                  </div>
                </div>
                <has-error :form="form" field="rep_kanji_sei" />
                <has-error :form="form" field="rep_kanji_mei" />
                
                <div class="row  mt-3" :class="{ 'is-invalid': form.errors.has('rep_kata_sei') || form.errors.has('rep_kata_mei') }">
                  <div class="col-6">
                    <input :disabled="disabled" @change="changeKana('rep_kata_sei')" v-model="form.rep_kata_sei" class="form-control" type="text" name="rep_kata_sei" placeholder="ｾｲ">
                  </div>
                  <div class="col-6">
                    <input :disabled="disabled" @change="changeKana('rep_kata_mei')" v-model="form.rep_kata_mei" class="form-control" type="text" name="rep_kata_mei" placeholder="ﾒｲ">
                  </div>
                </div>
                <has-error :form="form" field="rep_kata_sei" />
                <has-error :form="form" field="rep_kata_mei" />
              </div>
            </div>
          </template>
          
          <template v-else>
            <!-- Name -->
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">{{ $t('name') }}<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-8">
                <div class="row" :class="{ 'is-invalid': form.errors.has('kanji_sei') || form.errors.has('kanji_mei') }">
                  <div class="col-6">
                    <input :disabled="disabled" v-model="form.kanji_sei" class="form-control" type="text" name="kanji_sei" placeholder="姓">
                  </div>
                  <div class="col-6">
                    <input :disabled="disabled" v-model="form.kanji_mei" class="form-control" type="text" name="kanji_mei" placeholder="名">
                  </div>
                </div>
                <has-error :form="form" field="kanji_sei" />
                <has-error :form="form" field="kanji_mei" />
                
                <div class="row mt-3" :class="{ 'is-invalid': form.errors.has('kata_sei') || form.errors.has('kata_mei') }">
                  <div class="col-6">
                    <input :disabled="disabled" @change="changeKana('kata_sei')" v-model="form.kata_sei" class="form-control" type="text" name="kata_sei" placeholder="ｾｲ">
                  </div>
                  <div class="col-6">
                    <input :disabled="disabled" @change="changeKana('kata_mei')" v-model="form.kata_mei" class="form-control" type="text" name="kata_mei" placeholder="ﾒｲ">
                  </div>
                </div>
                <has-error :form="form" field="kata_sei" />
                <has-error :form="form" field="kata_mei" />
              </div>
            </div>
          </template>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">生年月日<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.birthday" :class="{ 'is-invalid': form.errors.has('birthday') }" class="form-control" type="date" name="birthday" id="birthday" placeholder="01234567890">
              <has-error :form="form" field="birthday" />
            </div>
          </div>

          <zip-code 
            :disabled="disabled"
            zip_t="zip1"
            pref_t="pref1"
            city_t="city1"
            addr_t="addr1"
            :pref_options="pref_options"
            :form="form"
            @update="updateZipCode1"/>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">自宅電話番号<span class="col-form-mark">必須</span><span class="col-form-desc">（ない場合は実家の電話番号またはご家族の携帯電話）</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.home_phone" :class="{ 'is-invalid': form.errors.has('phone_any') || form.errors.has('home_phone') }" class="form-control" type="text" name="home_phone" id="home_phone" placeholder="012-345-6789">
              <has-error :form="form" field="home_phone" />
              <has-error :form="form" field="phone_any" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">FAX番号</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.fax" :class="{ 'is-invalid': form.errors.has('fax') }" class="form-control" type="text" name="fax" id="fax" placeholder="012-345-6789">
              <has-error :form="form" field="fax" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">携帯電話<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.mobile_phone" :class="{ 'is-invalid': form.errors.has('phone_any') || form.errors.has('mobile_phone') }" class="form-control" type="text" name="mobile_phone" id="mobile_phone" placeholder="012-3456-7890">
              <has-error :form="form" field="mobile_phone" />
              <has-error :form="form" field="phone_any" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">携帯電話（予備）</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.mobile_phone2" :class="{ 'is-invalid': form.errors.has('mobile_phone2') }" class="form-control" type="text" name="mobile_phone2" id="mobile_phone2" placeholder="012-3456-7890">
              <has-error :form="form" field="mobile_phone2" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">メールアドレス<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-6">
              <input disabled v-model="form.sinsei_email" :class="{ 'is-invalid': form.errors.has('sinsei_email') }" class="form-control" type="text" name="sinsei_email" id="sinsei_email">
              <has-error :form="form" field="sinsei_email" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">メールアドレス（予備）</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.phone_email" :class="{ 'is-invalid': form.errors.has('phone_email') }" class="form-control" type="text" name="phone_email" id="phone_email">
              <has-error :form="form" field="phone_email" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">勤務先名<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.work_place_name" :class="{ 'is-invalid': form.errors.has('work_place_name') }" class="form-control" type="text" name="work_place_name" id="work_place_name">
              <has-error :form="form" field="work_place_name" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">勤務先電話番号<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.work_place_phone" :class="{ 'is-invalid': form.errors.has('work_place_phone') }" class="form-control" type="text" name="work_place_phone" id="work_place_phone" placeholder="012-345-6789">
              <has-error :form="form" field="work_place_phone" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">契約タイプ</label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                @change="changeContractType"
                id="radiobox-group-contract_type"
                v-model="form.contract_type"
                class="mt-2"
                :options="contract_options"
                :class="{ 'is-invalid': form.errors.has('contract_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="contract_type" />
            </div>
          </div>
          
          <template v-if="form.contract_type == 'BULK'">
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">配送先指定</label></div>
              <div class="col-md-8">
                <b-form-select
                  :disabled="disabled" 
                  @change="changeShippingAddressType"
                  id="radiobox-group-shipping_address_type"
                  v-model="form.shipping_address_type"
                  :options="shipping_address_options"
                  :class="{ 'is-invalid': form.errors.has('shipping_address_type') }"></b-form-select>
                <has-error :form="form" field="shipping_address_type" />
              </div>
            </div>

            <zip-code 
              :disabled="disabled"
              v-if="form.shipping_address_type != 'CURRENT'"
              zip_t="zip2"
              pref_t="pref2"
              city_t="city2"
              addr_t="addr2"
              :pref_options="pref_options"
              :form="form"
              @update="updateZipCode2"/>
              
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">宛名</label></div>
              <div class="col-md-6">
                <input :disabled="disabled" v-model="form.receiver_name" :class="{ 'is-invalid': form.errors.has('receiver_name') }" class="form-control" type="text" name="receiver_name" id="receiver_name">
                <has-error :form="form" field="receiver_name" />
              </div>
            </div>
              
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">宛先電話番号</label></div>
              <div class="col-md-6">
                <input :disabled="disabled" v-model="form.receiver_phone" :class="{ 'is-invalid': form.errors.has('receiver_phone') }" class="form-control" type="text" name="receiver_phone" id="receiver_phone" placeholder="01234567890">
                <has-error :form="form" field="receiver_phone" />
              </div>
            </div>
          </template>

          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">紹介取次店ID</label></div>
            <div class="col-md-6">
              <input disabled v-model="form.syoukai_id" :class="{ 'is-invalid': form.errors.has('syoukai_id') }" class="form-control" type="text" name="syoukai_id" id="syoukai_id">
              <has-error :form="form" field="syoukai_id" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">紹介取次店名</label></div>
            <div class="col-md-6">
              <input disabled v-model="form.syoukai_name" :class="{ 'is-invalid': form.errors.has('syoukai_name') }" class="form-control" type="text" name="syoukai_name" id="syoukai_name">
              <has-error :form="form" field="syoukai_name" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">エバンジェリストID</label></div>
            <div class="col-md-6">
              <input disabled v-model="form.eva_id" :class="{ 'is-invalid': form.errors.has('eva_id') }" class="form-control" type="text" name="eva_id" id="eva_id">
              <has-error :form="form" field="eva_id" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">エバンジェリスト名</label></div>
            <div class="col-md-6">
              <input disabled v-model="form.eva_name" :class="{ 'is-invalid': form.errors.has('eva_name') }" class="form-control" type="text" name="eva_name" id="eva_name">
              <has-error :form="form" field="eva_name" />
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">初期費用支払方法</label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                @change="changeInitialPaymentType"
                id="radiobox-group-initial_payment_type"
                v-model="form.initial_payment_type"
                class="mt-2"
                :options="initial_payment_options"
                :class="{ 'is-invalid': form.errors.has('initial_payment_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="initial_payment_type" />
            </div>
          </div>

          <template v-if="form.initial_payment_type == 'CREDITCARD'">
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">支払い回数<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-8">
                <b-form-select 
                  :disabled="disabled"
                  id="radiobox-group-payment_number_type"
                  v-model="form.payment_number_type"
                  :options="payment_number_options"
                  :class="{ 'is-invalid': form.errors.has('payment_number_type') }"></b-form-select>
                <has-error :form="form" field="payment_number_type" />
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">カード会社<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-8">
                <b-form-radio-group
                  :disabled="disabled"
                  id="radiobox-group-card_company_type"
                  v-model="form.card_company_type"
                  class="mt-2"
                  :options="card_company_options"
                  :class="{ 'is-invalid': form.errors.has('card_company_type') }"
                ></b-form-radio-group>
                <has-error :form="form" field="card_company_type" />
              </div>
            </div>
              
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">カード番号<span class="col-form-mark">必須</span><span class="col-form-desc">（上6桁。残りは電話でお伺いします。）</span></label></div>
              <div class="col-md-6">
                <input :disabled="disabled" v-model="form.card_number" :class="{ 'is-invalid': form.errors.has('card_number') }" class="form-control" type="text" name="card_number" id="card_number">
                <has-error :form="form" field="card_number" />
              </div>
            </div>
              
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">カード名義<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-6">
                <input :disabled="disabled" v-model="form.card_name" :class="{ 'is-invalid': form.errors.has('card_name') }" class="form-control" type="text" name="card_name" id="card_name">
                <has-error :form="form" field="card_name" />
              </div>
            </div>
              
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">有効期限<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-6">
                <input :disabled="disabled" v-model="form.expiration_date" type="month" :class="{ 'is-invalid': form.errors.has('expiration_date') }" class="form-control"  name="expiration_date" id="expiration_date" >
                <has-error :form="form" field="expiration_date" />
              </div>
            </div>
          </template>

          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">月額料支払方法<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                id="radiobox-group-monthly_payment_type"
                v-model="form.monthly_payment_type"
                class="mt-2"
                :options="monthly_payment_options"
                :class="{ 'is-invalid': form.errors.has('monthly_payment_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="monthly_payment_type" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">契約商品<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-select 
                :disabled="disabled"
                id="radiobox-group-product_id"
                v-model="form.product_id"
                :options="product_options_filter"
                :class="{ 'is-invalid': form.errors.has('product_id') }"></b-form-select>
              <has-error :form="form" field="product_id" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">報酬振込先口座情報</label></div>
          </div>

          <bank-code 
            :disabled="disabled"
            @updateBank="updateBank"
            @updateBranch="updateBranch"
            :form="form"/>
          
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">預金種目<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-select 
                :disabled="disabled"
                id="radiobox-group-deposit_id"
                v-model="form.deposit_id"
                :options="deposit_options"
                :class="{ 'is-invalid': form.errors.has('deposit_id') }"></b-form-select>
              <has-error :form="form" field="deposit_id" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">口座番号<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.account_number" :class="{ 'is-invalid': form.errors.has('account_number') }" class="form-control" type="text" name="account_number" id="account_number">
              <has-error :form="form" field="account_number" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">口座名義（ｶﾅ）<span class="col-form-mark">必須</span><span class="col-form-desc">※銀行に届け出ている名義を省略せずに入力してください。</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" @change="changeKana('account_name')" v-model="form.account_name" :class="{ 'is-invalid': form.errors.has('account_name') }" class="form-control" type="text" name="account_name" id="account_name">
              <has-error :form="form" field="account_name" />
            </div>
          </div>

          <file-upload
            :disabled="disabled"
            label="本人確認書類"
            name="identity_doc"
            :form="form"
            @update="updateImage"
            />

          <file-upload
            :disabled="disabled"
            label="本人確認書類（予備）"
            name="identity_doc2"
            :form="form"
            @update="updateImage"
            />

          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">希望登録月<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-select 
                :disabled="disabled"
                id="radiobox-group-deposit_id"
                v-model="form.desire_month"
                :options="desire_month_options"
                :class="{ 'is-invalid': form.errors.has('desire_month') }"></b-form-select>
              <has-error :form="form" field="desire_month" />
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">本人確認の希望連絡先<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                id="radiobox-group-desire_contact_type"
                v-model="form.desire_contact_type"
                class="mt-2"
                :options="desire_contact_options"
                :class="{ 'is-invalid': form.errors.has('desire_contact_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="desire_contact_type" />
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">希望日時<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <div>
                <b-form-radio-group
                  :disabled="disabled"
                  @change="changeDesireDateTimeType"
                  id="radiobox-group-desire_datetime_type"
                  v-model="form.desire_datetime_type"
                  class="mt-2"
                  :options="desire_datetime_options"
                  :class="{ 'is-invalid': form.errors.has('desire_datetime_type') }"
                ></b-form-radio-group>
                <has-error :form="form" field="desire_datetime_type" />
              </div>
              <template v-if="form.desire_datetime_type == 'SPECIAL'">
                <div class="mt-3">
                  <input :disabled="disabled" v-model="form.desire_date" :class="{ 'is-invalid': form.errors.has('desire_date') }" class="form-control" type="date" name="desire_date" id="desire_date" >
                  <has-error :form="form" field="desire_date" />
                </div>
                <div class="mt-3">
                  <div class="row" :class="{ 'is-invalid': form.errors.has('desire_start_h') || form.errors.has('desire_start_m') || form.errors.has('desire_end_h') || form.errors.has('desire_end_m') }">
                    <div class="col-3">
                      <b-form inline>
                        <b-form-select 
                          :disabled="disabled"
                          id="b-form-select-desire_start_h"
                          v-model="form.desire_start_h"
                          :options="hour_options"></b-form-select>
                        <label class="ml-2" for="b-form-select-desire_start_h">時</label>
                      </b-form>
                    </div>
                    <div class="col-3">
                      <b-form inline>
                        <b-form-select 
                          :disabled="disabled"
                          id="b-form-select-desire_start_m"
                          v-model="form.desire_start_m"
                          :options="minute_options"></b-form-select>
                        <label class="ml-2" for="b-form-select-desire_start_m">分～</label>
                      </b-form>
                    </div>
                    <div class="col-3">
                      <b-form inline>
                        <b-form-select 
                          :disabled="disabled"
                          id="b-form-select-desire_end_h"
                          v-model="form.desire_end_h"
                          :options="hour_options"></b-form-select>
                        <label class="ml-2" for="b-form-select-desire_end_h">時</label>
                      </b-form>
                    </div>
                    <div class="col-3">
                      <b-form inline>
                        <b-form-select 
                          :disabled="disabled"
                          id="b-form-select-desire_end_m "
                          v-model="form.desire_end_m"
                          :options="minute_options"></b-form-select>
                        <label class="ml-2" for="b-form-select-desire_end_m">分</label>
                      </b-form>
                    </div>
                  </div>
                  <has-error :form="form" field="desire_start_h" />
                  <has-error :form="form" field="desire_start_m" />
                  <has-error :form="form" field="desire_end_h" />
                  <has-error :form="form" field="desire_end_m" />
                </div>
              </template>
            </div>
          </div>

          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">オプション品選択</label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                id="radiobox-group-product_option_id"
                v-model="form.product_option_id"
                class="mt-2"
                text-field="name_price"
                :options="product_opt_options_filter"
                :class="{ 'is-invalid': form.errors.has('product_option_id') }"
              ></b-form-radio-group>
              <has-error :form="form" field="product_option_id" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">基本取付工賃（13,200円）<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                id="radiobox-group-basic_fee_type"
                v-model="form.basic_fee_type"
                class="mt-2"
                :options="basic_fee_options"
                :class="{ 'is-invalid': form.errors.has('basic_fee_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="basic_fee_type" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">初期費用合計金額</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.initial_price" :class="{ 'is-invalid': form.errors.has('initial_price') }" class="form-control" type="text" name="initial_price" id="initial_price">
              <has-error :form="form" field="initial_price" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">月額料</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" v-model="form.month_price" :class="{ 'is-invalid': form.errors.has('month_price') }" class="form-control" type="text" name="month_price" id="month_price">
              <has-error :form="form" field="month_price" />
            </div>
          </div>
          
          <div class="mb-3 px-3 py-4 bg-light">
            <p class="col-form-label text-md-left"><strong>「特定商取引法に関する法律」第37条第1項及び第2項に定まる書類（概要書面）の交付について</strong><span class="col-form-mark">必須</span></p>
            <b-form-radio-group
              :disabled="disabled"
              id="radiobox-group-commercial_privacy_type"
              v-model="form.commercial_privacy_type"
              :options="commercial_privacy_options"
              :class="{ 'is-invalid': form.errors.has('commercial_privacy_type') }"
            ></b-form-radio-group>
            <has-error :form="form" field="commercial_privacy_type" />

            <p class="col-form-label text-md-left mt-3"><strong>次の内容をご確認の上、同意いただける場合は下部にチェックをいれてください。</strong></p>
            <ul class="text-black-50">
              <li>クーリングオフ、中途解約ルールについて説明を受け、理解しました。</li>
              <li>登録にあたり資格を満たさず、登録を抹消されても異議申し立てはいたしません。</li>
              <li>プランビーが発行する会員規約に従えない方は除名の対象になることを理解しています。</li>
              <li>プランビーの社員及び他の取次店に対して暴言、暴力などを及ぼし、協調のとれない方は除名・強制解約の対象になることを理解しています。</li>
              <li>最低契約期間の説明を受け、十分に理解し、同意いたします。また、月額料金は滞りなく支払います。</li>
              <li>私の月額料金の支払い状況等は上位取次店に開示されることに同意し、万が一、支払いが滞った場合にプランビー及びその代理人からの入金勧奨に対して誠実に対応します。</li>
            </ul>
            <b-form-checkbox
              :disabled="disabled"
              v-model="form.agree"
              value="1"
              unchecked-value="0"
              :class="{ 'is-invalid': form.errors.has('agree') }"
            >上記すべて確認し、同意します。<span class="col-form-mark">必須</span></b-form-checkbox>
            <has-error :form="form" field="agree" />

            <p class="col-form-label text-md-left mt-3"><strong>備考（通信欄）</strong></p>
            <textarea :disabled="disabled" v-model="form.note" :class="{ 'is-invalid': form.errors.has('note') }" class="form-control" rows="3" name="note" id="note"></textarea>
            <has-error :form="form" field="note" />
          </div>
          <div class="mt-5 text-center" v-if="form.confirm">
            <v-button :loading="form.busy">確認</v-button>
          </div>
          <div class="text-center mt-5" v-else>
            <a @click="back_step()" class="btn btn-main mr-2">戻る</a>
            <v-button :loading="form.busy" id="submitButton">送信</v-button>
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
  computed: {
    product_options_filter() {
      return this.product_options.filter(x => x.contract_type == this.form.contract_type)
    },
    product_opt_options_filter() {
      if(this.form.product_id) {
        var product = this.product_options.find(x => x.value == this.form.product_id)
        return this.product_opt_options.filter(x => product.product_field_option_ids.includes(x.value))
      } 
      return []
    }
  },
  components: {
    ZipCode, BankCode, FileUpload
  },

  metaInfo () {
    return { title: 'オンライン登録申請' }
  },

  created () {
    const { uuid } = this.$route.params
    this.uuid = uuid
    this.form.uuid = uuid
    this.fetch()
    this.sex_options = window.config.SexType
    this.contract_options = window.config.ContractType
    this.shipping_address_options = window.config.ShippingAddressType
    this.initial_payment_options = window.config.InitialPaymentType
    this.payment_number_options = window.config.PaymentNumberType
    this.card_company_options = window.config.CardCompanyType
    this.desire_contact_options = window.config.DesireContacType
    this.desire_datetime_options = window.config.DesireDateTimeType
    this.basic_fee_options = window.config.BasicFeeType
    this.commercial_privacy_options = window.config.CommercialPrivacyType
    this.monthly_payment_options = window.config.MonthlyPaymentType
    this.form.sex_type = 'MALE'
    this.form.contract_type = 'NORMAL'
    this.form.shipping_address_type = 'CURRENT'
    this.form.initial_payment_type = 'BANK'
    this.form.desire_contact_type = 'PHONE'
    this.form.desire_datetime_type = 'ALL'
    this.form.basic_fee_type = 'REFUSE'
    this.form.commercial_privacy_type = 'RECEIVED'
    this.form.monthly_payment_type = 'ACCOUNT'
    this.form.desire_month = 1
  },

  data: () => ({
    title: 'オンライン登録申請',
    loading: true,
    uuid: null,
    step: 2,
    confirm: 0,
    show_errors: false,
    disabled: false,
    form: new Form({
      sex_type: null,
      contract_type: null,
      shipping_address_type: null,
      initial_payment_type: null,
      desire_datetime_type: null,
      zip2: null,
      pref2: null,
      city2: null,
      addr2: null,
      receiver_name: null,
      receiver_phone: null,
      desire_month: null,
      confirm: true
    }),
    sex_options: {},
    contract_options: {},
    shipping_address_options: {},
    product_options: [],
    product_opt_options: [],
    deposit_options: [],
    privacies: [],
    pref_options:  [],
    desire_month_options: [1,2,3,4,5,6,7,8,9,10,11,12],
    hour_options: [10, 11, 12, 13, 14, 15, 16],
    minute_options: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59],
  }),

  methods: {
    async fetch() {
      try {
        const { data } = await axios.get(`/api/agency/${this.uuid}`)
        if(data.status == 'success') {
          this.product_options = data.product_options
          this.deposit_options = data.deposit_options
          this.product_opt_options = data.product_opt_options
          this.pref_options = data.pref_options
          this.privacies = data.privacies.map((x) => { x.value = 0; return x; })
          this.form.syoukai_id = data.syoukai_id
          this.form.syoukai_name = data.syoukai_name
          this.form.eva_id = data.eva_id
          this.form.eva_name = data.eva_name
          this.form.sinsei_email = data.sinsei_email
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
            this.$router.push({ name: 'expired' })
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
    next_step() {
      let items = this.privacies.filter((x) => { return x.value == 0})
      if(items.length > 0) {
        this.show_errors = true
      } else {
        this.step = 2
        window.scrollTo(0,0);
      }
    },
    confirm_step() {
      this.disabled = true
      this.form.confirm = false
      window.scrollTo(0,0);
    },
    back_step() {
      this.disabled = false
      this.form.confirm = true
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
        } else if(data.status == "confirmed") {
          this.confirm_step();
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
    changeSex() {
      if(this.form.sex_type == 'CORPORATION') {
        this.form.corp_kanji = null
        this.form.corp_kata = null
        this.form.rep_kanji_sei = null
        this.form.rep_kanji_mei = null
        this.form.rep_kata_sei = null
        this.form.rep_kata_mei = null
      } else {
        this.form.kanji_sei = null
        this.form.kanji_mei = null
        this.form.kata_sei = null
        this.form.kata_mei = null
      }
    },
    changeContractType() {
      if(this.form.contract_type != 'BULK') {
        this.form.shipping_address_type = null
        this.form.zip2 = null
        this.form.pref2 = null
        this.form.city2 = null
        this.form.addr2 = null
        this.form.receiver_name = null
        this.form.receiver_phone = null
      }
      this.form.product_id = null
    },
    changeShippingAddressType() {
      if(this.form.shipping_address_type == 'CURRENT') {
        this.form.zip2 = null
        this.form.pref2 = null
        this.form.city2 = null
        this.form.addr2 = null
      }
    },
    changeInitialPaymentType() {
      if(this.form.initial_payment_type != 'CREDITCARD') {
        this.form.payment_number_type = null
        this.form.card_company_type = null
        this.form.card_number = null
        this.form.card_name = null
        this.form.expiration_date = null
      }
    },
    changeDesireDateTimeType() {
      if(this.form.desire_datetime_type != 'SPECIAL') {
        this.form.desire_date = null
        this.form.desire_start_h = null
        this.form.desire_start_m = null
        this.form.desire_end_h = null
        this.form.desire_end_m = null
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
  }
}
</script>
