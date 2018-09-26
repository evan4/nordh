<?php
$arr = [
    'Главная' => '/',
    'О нас' => '/about-p24',
    'Каталог недвижимости' => '/catalog-p30',
    'Контакты' => '/contact',
    'Продавцу' => '/seller-p31',
    'Карьера' => '/career-p32',
    'Франшиза' => '/franchise-p33',
];
 ?>
<nav class="menu clearfix">
        <div class="wrap">
            <a class="mobile" href="#"><span class="fa fa-bars"></span></a>
            <ul class="menu__list">
<?php
foreach ($arr as $key => $value) {
    if ($value === parse_url(geturl(), PHP_URL_PATH)){ ?>
    <li class="menu__item menu__item_active">
        <a href="<?= $value; ?>"><?= $key; ?></a>
    </li>
    <?php }else { ?>
        <li class="menu__item">
            <a href="<?= $value; ?>"><?= $key; ?></a>
        </li>
    <?php }
} ?>
            </ul>
        </div>
</nav>
