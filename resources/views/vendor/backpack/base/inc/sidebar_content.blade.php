<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<?php if(backpack_user()->hasRole('super')) : ?>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('introducer') }}'><i class='nav-icon la la-question'></i>登録紹介者リスト</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('agency') }}'><i class='nav-icon la la-question'></i>オンライン取次店登録申請リスト</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('customer') }}'><i class='nav-icon la la-question'></i>オンラインレンタル申し込みリスト</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='nav-icon la la-question'></i>商品</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('shipping-address') }}'><i class='nav-icon la la-question'></i>発送先</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('deposit') }}'><i class='nav-icon la la-question'></i>預金種目</a></li>
<?php endif; ?>