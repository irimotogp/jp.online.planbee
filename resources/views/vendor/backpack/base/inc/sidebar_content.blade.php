<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<?php if(backpack_user()->hasRole('super')) : ?>
<li class='nav-item'><a class='nav-link' href="{{ backpack_url('admin') }}"><i class='nav-icon la la-user'></i>ユーザー</a></li>
<li class='nav-item nav-dropdown'>
    <a href="#" class='nav-link nav-dropdown-toggle'><i class='nav-icon la la-newspaper-o'></i>ニュース</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('post') }}'><i class='nav-icon la la-question'></i>投稿</a></li>
    </ul>
</li>
<?php endif; ?>
<?php if(backpack_user()->hasRole('super') || backpack_user()->hasRole('store')) : ?>
<li class='nav-item nav-dropdown'>
    <a href="#" class='nav-link nav-dropdown-toggle'><i class='nav-icon la la-newspaper-o'></i>店舗情報</a>
    <ul class="nav-dropdown-items">
        <?php if(backpack_user()->hasRole('super')) : ?>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('store') }}'><i class='nav-icon la la-question'></i>店舗</a></li>
        <?php endif; ?>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee') }}'><i class='nav-icon la la-question'></i>従業員</a></li>
        <?php if(backpack_user()->hasRole('super')) : ?>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('area') }}'><i class='nav-icon la la-question'></i>エリア</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('charge') }}'><i class='nav-icon la la-question'></i>担当領域</a></li>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('type') }}'><i class='nav-icon la la-question'></i>店舗種別</a></li>
        <?php endif; ?>
    </ul>
</li>
<li class='nav-item nav-dropdown'>
    <a href="#" class='nav-link nav-dropdown-toggle'><i class='nav-icon la la-newspaper-o'></i>口コミ</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('review') }}'><i class='nav-icon la la-question'></i>リスト</a></li>
        <?php if(backpack_user()->hasRole('super')) : ?>
            <li class='nav-item'><a class='nav-link' href='{{ backpack_url('rating_field') }}'><i class='nav-icon la la-question'></i>評価項目</a></li>
        <?php endif; ?>
    </ul>
</li>
<?php endif; ?>

<?php if(backpack_user()->hasRole('super')) : ?>
<li class='nav-item nav-dropdown'>
    <a href="#" class='nav-link nav-dropdown-toggle'><i class='nav-icon la la-newspaper-o'></i>お問い合わせ</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact') }}'><i class='nav-icon la la-question'></i>お問い合わせ</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('store_contact') }}'><i class='nav-icon la la-question'></i>店舗お問い合わせ</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('employee_contact') }}'><i class='nav-icon la la-question'></i>従業員お問い合わせ</a></li>
    </ul>
</li>
<?php endif; ?>