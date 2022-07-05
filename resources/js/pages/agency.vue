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
          <label>プランビーへようこそ！<br>オンライン登録申請に進む前に、重要事項の確認を行なってください。<br>下記の重要事項について説明を受け、了承・同意される場合、□に✔️を入れてください。</label>
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
                <input 
                  :disabled="disabled" 
                  v-model="form.corp_kanji" 
                  :class="{ 'is-invalid': form.errors.has('corp_kanji') }" 
                  class="form-control" 
                  type="text" 
                  name="corp_kanji" 
                  placeholder="法人名">
                <has-error :form="form" field="corp_kanji" />
                <input 
                  :disabled="disabled" 
                  @change="changeKana('corp_kata')" 
                  v-model="form.corp_kata" 
                  :class="{ 'is-invalid': form.errors.has('corp_kata') }" 
                  class="form-control mt-3" 
                  type="text" 
                  name="corp_kata" 
                  placeholder="ﾎｳｼﾞﾝﾒｲ">
                <has-error :form="form" field="corp_kata" />
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">代表者<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-8">
                <div class="row" :class="{ 'is-invalid': form.errors.has('rep_kanji_sei') || form.errors.has('rep_kanji_mei') }">
                  <div class="col-6">
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('rep_kanji_sei') }"
                      v-model="form.rep_kanji_sei" 
                      class="form-control" 
                      type="text" 
                      name="rep_kanji_sei" 
                      placeholder="姓">
                  </div>
                  <div class="col-6">
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('rep_kanji_mei') }"
                      v-model="form.rep_kanji_mei" 
                      class="form-control" 
                      type="text" 
                      name="rep_kanji_mei" 
                      placeholder="名">
                  </div>
                </div>
                <has-error :form="form" field="rep_kanji_sei" />
                <has-error :form="form" field="rep_kanji_mei" />
                
                <div class="row  mt-3" :class="{ 'is-invalid': form.errors.has('rep_kata_sei') || form.errors.has('rep_kata_mei') }">
                  <div class="col-6">
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('rep_kata_sei') }"
                      @change="changeKana('rep_kata_sei')" 
                      v-model="form.rep_kata_sei" 
                      class="form-control" 
                      type="text" 
                      name="rep_kata_sei" 
                      placeholder="ｾｲ">
                  </div>
                  <div class="col-6">
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('rep_kata_mei') }"
                      @change="changeKana('rep_kata_mei')" 
                      v-model="form.rep_kata_mei" 
                      class="form-control" 
                      type="text" 
                      name="rep_kata_mei" 
                      placeholder="ﾒｲ">
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
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('kanji_sei') }"
                      v-model="form.kanji_sei" 
                      class="form-control" 
                      type="text" 
                      name="kanji_sei" 
                      placeholder="姓">
                  </div>
                  <div class="col-6">
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('kanji_mei') }"
                      v-model="form.kanji_mei" 
                      class="form-control" 
                      type="text" 
                      name="kanji_mei" 
                      placeholder="名">
                  </div>
                </div>
                <has-error :form="form" field="kanji_sei" />
                <has-error :form="form" field="kanji_mei" />
                
                <div class="row mt-3" :class="{ 'is-invalid': form.errors.has('kata_sei') || form.errors.has('kata_mei') }">
                  <div class="col-6">
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('kata_sei') }"
                      @change="changeKana('kata_sei')" 
                      v-model="form.kata_sei" 
                      class="form-control" 
                      type="text" 
                      name="kata_sei" 
                      placeholder="ｾｲ">
                  </div>
                  <div class="col-6">
                    <input 
                      :disabled="disabled" 
                      :class="{ 'is-invalid': form.errors.has('kata_mei') }"
                      @change="changeKana('kata_mei')" 
                      v-model="form.kata_mei" 
                      class="form-control" 
                      type="text" 
                      name="kata_mei" 
                      placeholder="ﾒｲ">
                  </div>
                </div>
                <has-error :form="form" field="kata_sei" />
                <has-error :form="form" field="kata_mei" />
              </div>
            </div>
          </template>
            
          <birth-day
            @update="updateBirthday"
            :form="form"
            :disabled="disabled"
            :need="true"
            name="birthday"
            label="生年月日"
          ></birth-day>

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
              <input :disabled="disabled" @change="changePhone('home_phone')" v-model="form.home_phone" :class="{ 'is-invalid': form.errors.has('phone_any') || form.errors.has('home_phone') }" class="form-control" type="text" name="home_phone" id="home_phone" placeholder="012-3456-7890">
              <has-error :form="form" field="home_phone" />
              <has-error :form="form" field="phone_any" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">FAX番号</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" @change="changePhone('fax')" v-model="form.fax" :class="{ 'is-invalid': form.errors.has('fax') }" class="form-control" type="text" name="fax" id="fax" placeholder="012-3456-7890">
              <has-error :form="form" field="fax" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">携帯電話<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-6">
              <input :disabled="disabled" @change="changePhone('mobile_phone')" v-model="form.mobile_phone" :class="{ 'is-invalid': form.errors.has('phone_any') || form.errors.has('mobile_phone') }" class="form-control" type="text" name="mobile_phone" id="mobile_phone" placeholder="012-3456-7890">
              <has-error :form="form" field="mobile_phone" />
              <has-error :form="form" field="phone_any" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">携帯電話（予備）</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" @change="changePhone('mobile_phone2')" v-model="form.mobile_phone2" :class="{ 'is-invalid': form.errors.has('mobile_phone2') }" class="form-control" type="text" name="mobile_phone2" id="mobile_phone2" placeholder="012-3456-7890">
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
            
          <template v-if="form.sex_type != 'CORPORATION'">
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
                <input :disabled="disabled" @change="changePhone('work_place_phone')" v-model="form.work_place_phone" :class="{ 'is-invalid': form.errors.has('work_place_phone') }" class="form-control" type="text" name="work_place_phone" id="work_place_phone" placeholder="012-3456-7890">
                <has-error :form="form" field="work_place_phone" />
              </div>
            </div>
          </template>
          
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

            <template v-if="form.shipping_address_type != 'CURRENT'">
              <zip-code 
                :disabled="disabled"
                zip_t="zip2"
                pref_t="pref2"
                city_t="city2"
                addr_t="addr2"
                :pref_options="pref_options"
                :form="form"
                @update="updateZipCode2"/>
                
              <div class="mb-3 row">
                <div class="col-md-4 "><label class="col-form-label text-md-right">宛名<span class="col-form-mark">必須</span></label></div>
                <div class="col-md-6">
                  <input :disabled="disabled" v-model="form.receiver_name" :class="{ 'is-invalid': form.errors.has('receiver_name') }" class="form-control" type="text" name="receiver_name" id="receiver_name">
                  <has-error :form="form" field="receiver_name" />
                </div>
              </div>
                
              <div class="mb-3 row">
                <div class="col-md-4 "><label class="col-form-label text-md-right">宛先電話番号<span class="col-form-mark">必須</span></label></div>
                <div class="col-md-6">
                  <input :disabled="disabled" @change="changePhone('receiver_phone')" v-model="form.receiver_phone" :class="{ 'is-invalid': form.errors.has('receiver_phone') }" class="form-control" type="text" name="receiver_phone" id="receiver_phone" placeholder="012-3456-7890">
                  <has-error :form="form" field="receiver_phone" />
                </div>
              </div>
            </template>
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
                @change="changePayment"
                id="radiobox-group-initial_payment_type"
                v-model="form.initial_payment_type"
                class="mt-2"
                :options="initial_payment_options"
                :class="{ 'is-invalid': form.errors.has('initial_payment_type') }"
              ></b-form-radio-group>
              <has-error :form="form" field="initial_payment_type" />
            </div>
          </div>

          <template v-if="form.contract_type != 'BULK'">
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">月額料支払方法<span class="col-form-mark">必須</span></label></div>
              <div class="col-md-8">
                <b-form-radio-group
                  :disabled="disabled"
                  @change="changePayment"
                  id="radiobox-group-monthly_payment_type"
                  v-model="form.monthly_payment_type"
                  class="mt-2"
                  :options="monthly_payment_options"
                  :class="{ 'is-invalid': form.errors.has('monthly_payment_type') }"
                ></b-form-radio-group>
                <has-error :form="form" field="monthly_payment_type" />
              </div>
            </div>
          </template>

          <template v-if="form.initial_payment_type == 'CREDITCARD' || form.monthly_payment_type == 'CREDITCARD' ">
            <div class="mb-3 row">
              <div class="col-md-4 "><label class="col-form-label text-md-right">支払い回数（初期費用）<span class="col-form-mark">必須</span></label></div>
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
                <input :disabled="disabled" v-model="form.expiration_date" @change="changeMMYY('expiration_date')" type="text" :class="{ 'is-invalid': form.errors.has('expiration_date') }" class="form-control"  name="expiration_date" id="expiration_date" placeholder="MM/YY">
                <has-error :form="form" field="expiration_date" />
              </div>
            </div>
          </template>
          
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">契約商品<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-select 
                :disabled="disabled"
                id="radiobox-group-product_id"
                @change="changeProduct"
                v-model="form.product_id"
                :options="product_options_filter"
                :class="{ 'is-invalid': form.errors.has('product_id') }"></b-form-select>
              <has-error :form="form" field="product_id" />
            </div>
          </div>

          <div class="mb-3 row">
            <label class="offset-md-4 col-md-8 col-form-label text-md-left">報酬振込先口座情報（税法・税務上の理由により登録名義以外の口座は指定できません）</label>
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
            :need="true"
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
                id="radiobox-group-desire_month"
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
                  <div :class="{ 'is-invalid': form.errors.has('desire_auth_month') || form.errors.has('desire_auth_day') || form.errors.has('desire_start_h') || form.errors.has('desire_start_m') || form.errors.has('desire_end_h') || form.errors.has('desire_end_m') }">
                    <div class="form-row">
                      <div class="col-3">
                        <b-form-select
                          @change="init_desire_auth_day_options"
                          :disabled="disabled" 
                          v-model="form.desire_auth_month"
                          :options="desire_auth_month_options"
                          :class="{ 'is-invalid': form.errors.has('desire_auth_month') }"></b-form-select>
                      </div>
                      <div class="col-3">
                        <b-form-select
                          :disabled="disabled" 
                          v-model="form.desire_auth_day"
                          :options="desire_auth_day_options"
                          :class="{ 'is-invalid': form.errors.has('desire_auth_day') }"></b-form-select>
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <b-col class="flex-grow-1">
                        <b-form-select
                          :disabled="disabled" 
                          v-model="form.desire_start_h"
                          :options="desire_start_h_options"
                          :class="{ 'is-invalid': form.errors.has('desire_start_h') }"></b-form-select>
                      </b-col>
                      <b-col class="flex-grow-1">
                        <b-form-select
                          :disabled="disabled" 
                          v-model="form.desire_start_m"
                          :options="desire_start_m_options"
                          :class="{ 'is-invalid': form.errors.has('desire_start_m') }"></b-form-select>
                      </b-col>
                      <b-col class="flex-grow-0">
                        <label>~</label>
                      </b-col>
                      <b-col class="flex-grow-1">
                        <b-form-select
                          :disabled="disabled" 
                          v-model="form.desire_end_h"
                          :options="desire_end_h_options"
                          :class="{ 'is-invalid': form.errors.has('desire_end_h') }"></b-form-select>
                      </b-col>
                      <b-col class="flex-grow-1">
                        <b-form-select
                          :disabled="disabled" 
                          v-model="form.desire_end_m"
                          :options="desire_end_m_options"
                          :class="{ 'is-invalid': form.errors.has('desire_end_m') }"></b-form-select>
                      </b-col>
                    </div>
                  </div>
                  <has-error :form="form" field="desire_auth_month" />
                  <has-error :form="form" field="desire_auth_day" />
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
              <b-form-checkbox-group
                :disabled="disabled"
                @change="changePrice"
                id="checkbox-group-product_option_ids"
                v-model="form.product_option_ids"
                class="mt-2"
                text-field="name_price"
                :options="product_opt_options_filter"
                :class="{ 'is-invalid': form.errors.has('product_option_ids') }"
              ></b-form-checkbox-group>
              <has-error :form="form" field="product_option_ids" />
            </div>
          </div>
          
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">基本取付工賃（13,200円）<span class="col-form-mark">必須</span></label></div>
            <div class="col-md-8">
              <b-form-radio-group
                :disabled="disabled"
                id="radiobox-group-basic_fee_type"
                @change="changePrice"
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
              <input :disabled="disabled" readonly :value="form.initial_price" :class="{ 'is-invalid': form.errors.has('initial_price') }" class="form-control" type="text" name="initial_price" id="initial_price">
              <has-error :form="form" field="initial_price" />
            </div>
          </div>
            
          <div class="mb-3 row">
            <div class="col-md-4 "><label class="col-form-label text-md-right">月額料</label></div>
            <div class="col-md-6">
              <input :disabled="disabled" readonly :value="form.month_price" :class="{ 'is-invalid': form.errors.has('month_price') }" class="form-control" type="text" name="month_price" id="month_price">
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
          <div class="mt-3 text-center" v-if="form.confirm">
            <v-button :loading="form.busy">確認</v-button>
          </div>
          <div class="text-center mt-3" v-else>
            <a @click="back_step()" class="btn btn-main mr-2">戻る</a>
            <v-button :loading="form.busy" id="submitButton">送信</v-button>
          </div>
          <template v-if="form.errors.any()">
            <div class="help-block invalid-feedback mt-3" style="display: block;">入力エラーがあります。上にスクロールしてエラー項目に再度入力してください。</div>
          </template>
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
import BirthDay from '~/components/BirthDay'

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
    },
    // product_cashback_on_check() {
    //   if(this.form.product_id) {
    //     var product = this.product_options.find(x => x.value == this.form.product_id)
    //     if(product.cashback != 1) {
    //       this.updateCashback()
    //       return false;
    //     } else {
    //       return true;
    //     }
    //   }
    //   return false
    // },
  },

  components: {
    ZipCode, BankCode, FileUpload, BirthDay
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
    this.form.birthday = '1990-01-01'
    this.form.contract_type = 'NORMAL'
    this.form.shipping_address_type = 'CURRENT'
    this.form.initial_payment_type = 'BANK'
    this.form.desire_contact_type = 'PHONE'
    this.form.desire_datetime_type = 'ALL'
    this.form.basic_fee_type = 'REFUSE'
    this.form.commercial_privacy_type = 'NOTRECEIVED'
    this.form.monthly_payment_type = 'ACCOUNT'

    const curretMonth = (new Date()).getMonth() + 1;
    this.form.desire_month = curretMonth
    this.desire_month_options = Array.from(Array(2).keys()).map((x) => ({ value: x + curretMonth, text: `${(x + curretMonth - 1) % 12 + 1}月`}))
    this.desire_auth_month_options = Array.from(Array(12).keys()).map((x) => ({ value: x + 1, text: `${x + 1}月`}))
    this.desire_start_h_options = Array.from(Array(7).keys()).map((x) => ({ value: x + 10, text: `${x + 10}時`}))
    this.desire_start_m_options = Array.from(Array(4).keys()).map((x) => ({ value: x * 15, text: `${x * 15}分`}))
    this.desire_end_h_options = Array.from(Array(7).keys()).map((x) => ({ value: x + 10, text: `${x + 10}時`}))
    this.desire_end_m_options = Array.from(Array(4).keys()).map((x) => ({ value: x * 15, text: `${x * 15}分`}))
    this.desire_auth_day_options = []
  },

  data: () => ({
    title: 'オンライン登録申請',
    loading: true,
    uuid: null,
    step: 1,
    confirm: 0,
    show_errors: false,
    disabled: false,
    form: new Form({
      kanji_sei: null,
      kanji_mei: null,
      kata_sei: null,
      kata_mei: null,
      corp_kanji: null,
      corp_kata: null,
      rep_kanji_sei: null,
      rep_kanji_mei: null,
      rep_kata_sei: null,
      rep_kata_mei: null,
      work_place_name: null,
      work_place_phone: null,
      sex_type: null,
      contract_type: null,
      shipping_address_type: null,
      initial_payment_type: null,
      monthly_payment_type: null,
      desire_datetime_type: null,
      zip2: null,
      pref2: null,
      city2: null,
      addr2: null,
      receiver_name: null,
      receiver_phone: null,
      desire_month: null,
      confirm: true,
      product_id: null,
      product_option_ids: [],
      initial_price: '￥0',
      month_price: '￥0',
      payment_number_type: null,
      card_company_type: null,
      card_number: null,
      card_name: null,
      expiration_date: null,
      desire_auth_month: null,
      desire_auth_day: null,
      desire_start_h: null,
      desire_start_m: null,
      desire_end_h: null,
      desire_end_m: null,
      account_name: null
    }),
    sex_options: {},
    contract_options: {},
    shipping_address_options: {},
    product_options: [],
    product_opt_options: [],
    deposit_options: [],
    privacies: [],
    pref_options:  [],
    desire_month_options: [],
    desire_auth_month_options: [],
    desire_start_h_options: [],
    desire_start_m_options: [],
    desire_end_h_options: [],
    desire_auth_day_options: [],
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
      Swal.fire({
        type: 'alert',
        title: "",
        text: "確認し、内容に間違いなければ送信してください。",
        confirmButtonText: i18n.t('閉じる'),
      })
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
            this.$router.push({ name: 'thanks_o' })
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
      let value = this.form[name]
      if(value == null) return
      const charDict = {
        zenkaku: [
          'ア','イ','ウ','エ','オ','カ','キ','ク','ケ','コ'
          ,'サ','シ','ス','セ','ソ','タ','チ','ツ','テ','ト'
          ,'ナ','ニ','ヌ','ネ','ノ','ハ','ヒ','フ','ヘ','ホ'
          ,'マ','ミ','ム','メ','モ','ヤ','ヰ','ユ','ヱ','ヨ'
          ,'ラ','リ','ル','レ','ロ','ワ','ヲ','ン'
          ,'ガ','ギ','グ','ゲ','ゴ','ザ','ジ','ズ','ゼ','ゾ'
          ,'ダ','ヂ','ヅ','デ','ド','バ','ビ','ブ','ベ','ボ'
          ,'パ','ピ','プ','ペ','ポ'
          ,'ァ','ィ','ゥ','ェ','ォ','ャ','ュ','ョ','ッ'
          ,'゛','°','、','。','「','」','ー','・',
          '０', '１', '２', '３', '４', '５', '６', '７', '８', '９',
          'Ａ', 'Ｂ', 'Ｃ', 'Ｄ', 'Ｅ', 'Ｆ', 'Ｇ', 'Ｈ', 'Ｉ', 'Ｊ', 'Ｋ', 'Ｌ', 'Ｍ', 'Ｎ',
          'Ｏ', 'Ｐ', 'Ｑ', 'Ｒ', 'Ｓ', 'Ｔ', 'Ｕ', 'Ｖ', 'Ｗ', 'Ｘ', 'Ｙ', 'Ｚ',
          'ａ', 'ｂ', 'ｃ', 'ｄ', 'ｅ', 'ｆ', 'ｇ', 'ｈ', 'ｉ', 'ｊ', 'ｋ', 'ｌ', 'ｍ', 'ｎ',
          'ｏ', 'ｐ', 'ｑ', 'ｒ', 'ｓ', 'ｔ', 'ｕ', 'ｖ', 'ｗ', 'ｘ', 'ｙ', 'ｚ'
        ],
        hankaku: [
          'ｱ','ｲ','ｳ','ｴ','ｵ','ｶ','ｷ','ｸ','ｹ','ｺ'
          ,'ｻ','ｼ','ｽ','ｾ','ｿ','ﾀ','ﾁ','ﾂ','ﾃ','ﾄ'
          ,'ﾅ','ﾆ','ﾇ','ﾈ','ﾉ','ﾊ','ﾋ','ﾌ','ﾍ','ﾎ'
          ,'ﾏ','ﾐ','ﾑ','ﾒ','ﾓ','ﾔ','ｲ','ﾕ','ｴ','ﾖ'
          ,'ﾗ','ﾘ','ﾙ','ﾚ','ﾛ','ﾜ','ｦ','ﾝ'
          ,'ｶﾞ','ｷﾞ','ｸﾞ','ｹﾞ','ｺﾞ','ｻﾞ','ｼﾞ','ｽﾞ','ｾﾞ','ｿﾞ'
          ,'ﾀﾞ','ﾁﾞ','ﾂﾞ','ﾃﾞ','ﾄﾞ','ﾊﾞ','ﾋﾞ','ﾌﾞ','ﾍﾞ','ﾎﾞ'
          ,'ﾊﾟ','ﾋﾟ','ﾌﾟ','ﾍﾟ','ﾎﾟ'
          ,'ｧ','ｨ','ｩ','ｪ','ｫ','ｬ','ｭ','ｮ','ｯ'
          ,'ﾞ','ﾟ','､','｡','｢','｣','ｰ','･',
          '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
          'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
          'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
          'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n',
          'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
        ]
      }

      const regExp = new RegExp(`(${charDict.zenkaku.join('|')})`, 'g')

      value = value.replace(/[\u3041-\u3096]/g, function(s){ // ひらがなー＞カタカナ
        if(s) return String.fromCharCode(s.charCodeAt(0) + 0x60);
        return
      });

      const result = value.replace(regExp, match => {
        const index = charDict.zenkaku.indexOf(match)
        return charDict.hankaku[index]
      })
      this.form[name] = result
    },
    changeSex() {
      if(this.form.sex_type == 'CORPORATION') {
        this.form.kanji_sei = null
        this.form.kanji_mei = null
        this.form.kata_sei = null
        this.form.kata_mei = null
        this.form.work_place_name = null
        this.form.work_place_phone = null
      } else {
        this.form.corp_kanji = null
        this.form.corp_kata = null
        this.form.rep_kanji_sei = null
        this.form.rep_kanji_mei = null
        this.form.rep_kata_sei = null
        this.form.rep_kata_mei = null
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
      } else {
        this.form.monthly_payment_type = null
        this.changePayment()
      }
      this.form.product_id = null
      // this.updateCashback()
    },
    changeShippingAddressType() {
      if(this.form.shipping_address_type == 'CURRENT') {
        this.form.zip2 = null
        this.form.pref2 = null
        this.form.city2 = null
        this.form.addr2 = null
        this.receiver_name = null
        this.receiver_phone = null
      }
    },
    changePayment() {
      if(this.form.initial_payment_type != 'CREDITCARD' || this.form.monthly_payment_type != 'CREDITCARD') {
        this.form.payment_number_type = null
        this.form.card_company_type = null
        this.form.card_number = null
        this.form.card_name = null
        this.form.expiration_date = null
      }
    },
    changeDesireDateTimeType() {
      if(this.form.desire_datetime_type != 'SPECIAL') {
        this.form.desire_auth_month = null
        this.form.desire_auth_day = null
        this.form.desire_start_h = null
        this.form.desire_start_m = null
        this.form.desire_end_h = null
        this.form.desire_end_m = null
      } else {
        const date = new Date();
        this.form.desire_auth_month = date.getMonth() + 1
        this.init_desire_auth_day_options()
        this.form.desire_auth_day = date.getDate()
      }
    },
    changeProduct() {
      this.form.product_option_ids = []
      this.changePrice()
    },
    changePrice() {
      var initial_price = 0;
      var month_price = 0;
      if(this.form.product_id) {
        var product = this.product_options.find(x => x.value == this.form.product_id)
        initial_price += product.initial_price
        month_price += product.month_price
        if(this.form.product_option_ids && this.form.product_option_ids.length > 0) {
          var options =  this.product_opt_options.filter(x => this.form.product_option_ids.includes(x.value))
          options.forEach(x => initial_price += x.price);
        }
      } 
      if(this.form.basic_fee_type == 'APPLY') {
        initial_price += 13200
      }
      this.form.initial_price = "￥" + this.changeNumberWithCommas(initial_price)
      this.form.month_price = "￥" + this.changeNumberWithCommas(month_price)
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
    // updateCashback() {
    //   this.updateBank()
    //   this.updateBranch()
    //   this.form.deposit_id = null
    //   this.form.account_number = null
    //   this.form.deposit_id = null
    //   this.form.account_name = null
    // },
    updateBank(bank) {
      this.form.bank = bank
      this.form.bank_name = bank ? bank.kana : null
      this.form.bank_code = bank ? bank.code : null
      this.changeKana('bank_name')
    },
    updateBranch(branch) {
      this.form.branch = branch
      this.form.branch_name = branch ? branch.kana : null
      this.form.branch_code = branch ? branch.code : null
      this.changeKana('branch_name')
    },
    updateBirthday(birthday) {
      this.form.birthday = birthday
    },
    updateImage(name, image) {
      this.form[name] = image
    },
    init_desire_auth_day_options: function () {
      const currentYear = new Date().getFullYear()
      const desire_auth_day_max = new Date(currentYear, this.form.desire_auth_month, 0).getDate();
      this.desire_auth_day_options = Array.from(Array(desire_auth_day_max).keys()).map((x) => ({ value: x + 1, text: `${x + 1}日`}))
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
    changePhone(name) {
      var changedPhoneNumber = this.changedPhoneNumber(name)
      if(changedPhoneNumber) {
        this.form[name] = changedPhoneNumber
      }
    },
    changedPhoneNumber(name){
      var value = this.form[name]
      var strict = false;
      // 市外局番のグループ定義
      // データは http://www.soumu.go.jp/main_sosiki/joho_tsusin/top/tel_number/number_shitei.html より入手後、整形
      var group = {
        5 : {
          "01267" : 1, "01372" : 1, "01374" : 1, "01377" : 1, "01392" : 1, "01397" : 1, "01398" : 1, "01456" : 1, "01457" : 1, "01466" : 1, "01547" : 1,
          "01558" : 1, "01564" : 1, "01586" : 1, "01587" : 1, "01632" : 1, "01634" : 1, "01635" : 1, "01648" : 1, "01654" : 1, "01655" : 1, "01656" : 1,
          "01658" : 1, "04992" : 1, "04994" : 1, "04996" : 1, "04998" : 1, "05769" : 1, "05979" : 1, "07468" : 1, "08387" : 1, "08388" : 1, "08396" : 1,
          "08477" : 1, "08512" : 1, "08514" : 1, "09496" : 1, "09802" : 1, "09912" : 1, "09913" : 1, "09969" : 1,
        },
        4 : {
          "0123" : 2, "0124" : 2, "0125" : 2, "0126" : 2, "0133" : 2, "0134" : 2, "0135" : 2, "0136" : 2, "0137" : 2, "0138" : 2, "0139" : 2, "0142" : 2,
          "0143" : 2, "0144" : 2, "0145" : 2, "0146" : 2, "0152" : 2, "0153" : 2, "0154" : 2, "0155" : 2, "0156" : 2, "0157" : 2, "0158" : 2, "0162" : 2,
          "0163" : 2, "0164" : 2, "0165" : 2, "0166" : 2, "0167" : 2, "0172" : 2, "0173" : 2, "0174" : 2, "0175" : 2, "0176" : 2, "0178" : 2, "0179" : 2,
          "0182" : 2, "0183" : 2, "0184" : 2, "0185" : 2, "0186" : 2, "0187" : 2, "0191" : 2, "0192" : 2, "0193" : 2, "0194" : 2, "0195" : 2, "0197" : 2,
          "0198" : 2, "0220" : 2, "0223" : 2, "0224" : 2, "0225" : 2, "0226" : 2, "0228" : 2, "0229" : 2, "0233" : 2, "0234" : 2, "0235" : 2, "0237" : 2,
          "0238" : 2, "0240" : 2, "0241" : 2, "0242" : 2, "0243" : 2, "0244" : 2, "0246" : 2, "0247" : 2, "0248" : 2, "0250" : 2, "0254" : 2, "0255" : 2,
          "0256" : 2, "0257" : 2, "0258" : 2, "0259" : 2, "0260" : 2, "0261" : 2, "0263" : 2, "0264" : 2, "0265" : 2, "0266" : 2, "0267" : 2, "0268" : 2,
          "0269" : 2, "0270" : 2, "0274" : 2, "0276" : 2, "0277" : 2, "0278" : 2, "0279" : 2, "0280" : 2, "0282" : 2, "0283" : 2, "0284" : 2, "0285" : 2,
          "0287" : 2, "0288" : 2, "0289" : 2, "0291" : 2, "0293" : 2, "0294" : 2, "0295" : 2, "0296" : 2, "0297" : 2, "0299" : 2, "0422" : 2, "0428" : 2,
          "0436" : 2, "0438" : 2, "0439" : 2, "0460" : 2, "0463" : 2, "0465" : 2, "0466" : 2, "0467" : 2, "0470" : 2, "0475" : 2, "0476" : 2, "0478" : 2,
          "0479" : 2, "0480" : 2, "0493" : 2, "0494" : 2, "0495" : 2, "0531" : 2, "0532" : 2, "0533" : 2, "0536" : 2, "0537" : 2, "0538" : 2, "0539" : 2,
          "0544" : 2, "0545" : 2, "0547" : 2, "0548" : 2, "0550" : 2, "0551" : 2, "0553" : 2, "0554" : 2, "0555" : 2, "0556" : 2, "0557" : 2, "0558" : 2,
          "0561" : 2, "0562" : 2, "0563" : 2, "0564" : 2, "0565" : 2, "0566" : 2, "0567" : 2, "0568" : 2, "0569" : 2, "0572" : 2, "0573" : 2, "0574" : 2,
          "0575" : 2, "0576" : 2, "0577" : 2, "0578" : 2, "0581" : 2, "0584" : 2, "0585" : 2, "0586" : 2, "0587" : 2, "0594" : 2, "0595" : 2, "0596" : 2,
          "0597" : 2, "0598" : 2, "0599" : 2, "0721" : 2, "0725" : 2, "0735" : 2, "0736" : 2, "0737" : 2, "0738" : 2, "0739" : 2, "0740" : 2, "0742" : 2,
          "0743" : 2, "0744" : 2, "0745" : 2, "0746" : 2, "0747" : 2, "0748" : 2, "0749" : 2, "0761" : 2, "0763" : 2, "0765" : 2, "0766" : 2, "0767" : 2,
          "0768" : 2, "0770" : 2, "0771" : 2, "0772" : 2, "0773" : 2, "0774" : 2, "0776" : 2, "0778" : 2, "0779" : 2, "0790" : 2, "0791" : 2, "0794" : 2,
          "0795" : 2, "0796" : 2, "0797" : 2, "0798" : 2, "0799" : 2, "0820" : 2, "0823" : 2, "0824" : 2, "0826" : 2, "0827" : 2, "0829" : 2, "0833" : 2,
          "0834" : 2, "0835" : 2, "0836" : 2, "0837" : 2, "0838" : 2, "0845" : 2, "0846" : 2, "0847" : 2, "0848" : 2, "0852" : 2, "0853" : 2, "0854" : 2,
          "0855" : 2, "0856" : 2, "0857" : 2, "0858" : 2, "0859" : 2, "0863" : 2, "0865" : 2, "0866" : 2, "0867" : 2, "0868" : 2, "0869" : 2, "0875" : 2,
          "0877" : 2, "0879" : 2, "0880" : 2, "0883" : 2, "0884" : 2, "0885" : 2, "0887" : 2, "0889" : 2, "0892" : 2, "0893" : 2, "0894" : 2, "0895" : 2,
          "0896" : 2, "0897" : 2, "0898" : 2, "0920" : 2, "0930" : 2, "0940" : 2, "0942" : 2, "0943" : 2, "0944" : 2, "0946" : 2, "0947" : 2, "0948" : 2,
          "0949" : 2, "0950" : 2, "0952" : 2, "0954" : 2, "0955" : 2, "0956" : 2, "0957" : 2, "0959" : 2, "0964" : 2, "0965" : 2, "0966" : 2, "0967" : 2,
          "0968" : 2, "0969" : 2, "0972" : 2, "0973" : 2, "0974" : 2, "0977" : 2, "0978" : 2, "0979" : 2, "0980" : 2, "0982" : 2, "0983" : 2, "0984" : 2,
          "0985" : 2, "0986" : 2, "0987" : 2, "0993" : 2, "0994" : 2, "0995" : 2, "0996" : 2, "0997" : 2,
          "0180" : 3, "0570" : 3, "0800" : 3, "0990" : 3, "0120" : 3,
        },
        3 : {
          "011" : 3, "015" : 3, "017" : 3, "018" : 3, "019" : 3, "022" : 3, "023" : 3, "024" : 3, "025" : 3, "026" : 3, "027" : 3, "028" : 3, "029" : 3,
          "042" : 3, "043" : 3, "044" : 3, "045" : 3, "046" : 3, "047" : 3, "048" : 3, "049" : 3, "052" : 3, "053" : 3, "054" : 3, "055" : 3, "058" : 3,
          "059" : 3, "072" : 3, "073" : 3, "075" : 3, "076" : 3, "077" : 3, "078" : 3, "079" : 3, "082" : 3, "083" : 3, "084" : 3, "086" : 3, "087" : 3,
          "088" : 3, "089" : 3, "092" : 3, "093" : 3, "095" : 3, "096" : 3, "097" : 3, "098" : 3, "099" : 3,
          "050" : 4, "020" : strict ? 3 : 4, "070" : strict ? 3 : 4, "080" : strict ? 3 : 4, "090" : strict ? 3 : 4,
        },
        2 : {
          "03" : 4, "04" : 4, "06" : 4,
        }
      };
      // 市外局番の桁数を取得して降順に並べ替える
      var code = [];
      for(var num in group){
        code.push(num * 1);
      }
      code.sort(function($a, $b){ return ($b - $a); });
      // 入力文字から数字以外を削除してnumber変数に格納する
      var number = String(value).replace(/[０-９]/g, function($s){
                        return String.fromCharCode($s.charCodeAt(0) - 65248);
                    }).replace(/\D/g, "");
      // 電話番号が10～11桁じゃなかったらfalseを返して終了する
      if(number.length < 10 || number.length > 11){
        return false;
      }
      // 市外局番がどのグループに属するか確認していく
      for(var i = 0, n = code.length; i < n; i++){
        var leng = code[i];
        var area = number.substr(0, leng);
        var city = group[leng][area];
        // 一致する市外局番を見付けたら整形して整形後の電話番号を返す
        if(city){
          return area + "-"
                  + number.substr(leng, city)
                    + (number.substr(leng + city) !== "" ?
                        "-" + number.substr(leng + city) : "");
        }
      }
    },
    changeNumberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    changeMMYY(name) {
      const x = this.form[name]
      const index = x.indexOf('/')
      if(index == -1 && x.length >= 3) {
        this.form[name] = x.substring(0, 2) + "/" + x.substring(2, x.length)
      }
    }
  }
}
</script>
