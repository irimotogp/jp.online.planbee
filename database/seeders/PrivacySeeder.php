<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\IntroducerType;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('privacies')->truncate();
        //
        $data = $this->data();
        \DB::table('privacies')->insert($data);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
    public function data() {
        return [
          [
            'introducer_type' => IntroducerType::AGENCY,
            'title' => "強引・無理矢理な勧誘はなく、商品や契約内容を理解できる説明を受けました。また、何も活動せずに収入が得られるビジネスではないことを理解しました。"
          ],
          [
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "取次店登録費用として支払った初期費用は返金されないことを理解しました。（法定解約時を除きます）",
          ],
          [ 
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "商品および契約書面が届いた日から20日を経過するまでは、書面により無条件で契約の解除を行うことができるクーリング・オフについて説明を受けました。（法人は対象外です）"
          ],
          [ 
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "最低利用期間である1年以内に解約する場合、解約手数料(税込10,450円)を支払うことに同意しました。"
          ],
          [ 
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "支払日は毎月20日(口座振替払いのみ金融機関休業日の場合は翌営業日)です。支払いが25日を過ぎた場合、再請求手数料 (税込800円)が発生し、報酬から相殺または銀行振込にて精算することに同意しました。"
          ],
          [ 
            'introducer_type' =>  IntroducerType::AGENCY, 
            'title' => "3年経過後は、いつでも買取できますが、所定の買取申請が必要です。申請するまで同一条件でレンタル自動継続となる ことに同意しました。"
          ],
          [
            'introducer_type' =>  IntroducerType::AGENCY, 
            'title' => "5年経過後は、いつでも交換プログラム(新品商品に交換または他契約プランへ変更)を利用できますが、所定の申請が必要 です。申請をするまで同一条件でレンタル自動継続となることに同意しました。月額料金のお支払いが翌月以降になった場合、PRVが発生せず遅延回数にカウントされます。 遅延回数が累積5回以上になると、交換プログラムが受けられなくなります。"
          ],
          [
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "取次店特典についての説明を受け理解しました。詳細は概要書面をご確認ください。月額料金に未払いがある場合、全ての取次店特典が受けられません。"
          ],
          [
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "還元水素水の効果・効能が認められているのは、「胃腸症状の改善効果」のみです。汲みたての還元水素水を飲用し続けることで効果が期待できますが、個人差があり、効果を保証するものではありません。 勧誘時、他の病気が治るなどのことは発言しないようにしてください。"
          ],
          [
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "水分摂取やミネラル摂取を制限されている方に還元水素水の飲用をお勧めする場合、還元水素水は水道水に比べてカリウムやカルシウム等のミネラルが多く含まれますが、バナナやアボカドに比べると少量です。 ご心配の場合は、かかりつけの医師にご相談されることをおすすめしてください。詳細は<a href='http://planbee.co.jp/faq/%E9%9B%BB%E8%A7%A3%E6%B0%B4%E7%94%9F%E6%88%90%E5%99%A8%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6/beefine/1310'>こちら</a>からご確認ください"
          ],
          [
            'introducer_type' =>  IntroducerType::AGENCY,
            'title' => "当社の個人情報保護方針を理解し、同意しました。<br>当社の個人情報保護については<a href='http://planbee.co.jp/privacy/'>こちら</a>からご確認ください。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "強引・無理矢理な勧誘はなく、商品や契約内容を理解できる説明を受けました。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "商品および契約書面が届いた日から20日を経過するまでは、書面により無条件で契約の解除を行うことができるクーリング・オフについて説明を受けました。（法人は対象外です）"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "最低利用期間である1年以内に解約する場合、解約手数料(税込10,450円)を支払うことに同意しました。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "支払日は毎月20日(口座振替払いのみ金融機関休業日の場合は翌営業日)です。支払いが25日を過ぎた場合、再請求手数料 (税込800円)が発生し、報酬から相殺または銀行振込にて精算することに同意しました。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "3年経過後は、いつでも買取できますが、所定の買取申請が必要です。申請するまで同一条件でレンタル自動継続となる ことに同意しました。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "5年経過後は、いつでも交換プログラム(新品商品に交換または他契約プランへ変更)を利用できますが、所定の申請が必要 です。申請をするまで同一条件でレンタル自動継続となることに同意しました。月額料金のお支払いが翌月以降になった場合、PRVが発生せず遅延回数にカウントされます。 遅延回数が累積5回以上になると、交換プログラムが受けられなくなります。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "レンタル特典についての説明を受け理解しました。詳細は概要書面をご確認ください。月額料金に未払いがある場合、全ての特典が受けられません。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "還元水素水の効果・効能が認められているのは、「胃腸症状の改善効果」のみです。汲みたての還元水素水を飲用し続けることで効果が期待できますが、個人差があり、効果を保証するものではありません。 勧誘時、他の病気が治るなどのことは発言しないようにしてください。"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "水分摂取やミネラル摂取を制限されている方に還元水素水の飲用をお勧めする場合、還元水素水は水道水に比べてカリウムやカルシウム等のミネラルが多く含まれますが、バナナやアボカドに比べると少量です。 ご心配の場合は、かかりつけの医師にご相談されることをおすすめしてください。詳細は<a href='http://planbee.co.jp/faq/%E9%9B%BB%E8%A7%A3%E6%B0%B4%E7%94%9F%E6%88%90%E5%99%A8%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6/beefine/1310'>こちら</a>からご確認ください"
          ],
          [ 
            'introducer_type' => IntroducerType::CUSTOMER,
            'title' => "当社の個人情報保護方針を理解し、同意しました。<br>当社の個人情報保護については<a href='http://planbee.co.jp/privacy/'>こちら</a>からご確認ください。"
          ],
        ];
    }
}
