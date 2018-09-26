<?php
$menu = Models_Menu_Repair::newInstance()->getMenu();

foreach ($menu as $key => $value) {
    if ($value['url'] === parse_url(geturl(), PHP_URL_PATH)) { ?>
        <li class="menu__item menu__item_active">
            <a href="<?= $value['url']; ?>"><?= $value['name']; ?></a>
        </li>
    <?php } else { ?>
        <li class="menu__item">
            <a href="<?= $value['url']; ?>"><?= $value['name']; ?></a>
        </li>
    <?php }
}