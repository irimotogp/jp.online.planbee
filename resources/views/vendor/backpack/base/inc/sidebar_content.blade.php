<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('admin') }}'><i class='nav-icon la la-question'></i>管理者リスト</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('introducer') }}'><i class='nav-icon la la-question'></i>登録紹介者リスト</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('agency') }}'><i class='nav-icon la la-question'></i>オンライン登録申請リスト</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('customer') }}'><i class='nav-icon la la-question'></i>オンラインレンタル申し込みリスト</a></li>
<li class='nav-item nav-dropdown'>
  <a href="#" class='nav-link nav-dropdown-toggle'><i class='nav-icon la la-newspaper-o'></i>商品</a>
  <ul class="nav-dropdown-items">
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='nav-icon la la-question'></i>リスト</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('product-option') }}'><i class='nav-icon la la-question'></i>オプション</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('product-field') }}'><i class='nav-icon la la-question'></i>分野</a></li>
  </ul>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('deposit') }}'><i class='nav-icon la la-question'></i>預金種目</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('privacy') }}'><i class='nav-icon la la-question'></i>重要事項確認</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('pdf') }}'><i class='nav-icon la la-question'></i> Pdfs</a></li>