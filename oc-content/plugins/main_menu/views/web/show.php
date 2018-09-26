<?php
$menu = Models_Menu::newInstance()->getMenu();
?>
<nav class="menu clearfix">
    <div class="wrap">
        <a class="mobile" href="#"><span class="fa fa-bars"></span></a>
        <ul class="menu__list">
            <?php
            foreach ($menu as $key => $value) {
                if ($value['url'] === parse_url(geturl(), PHP_URL_PATH)){ ?>
                    <li class="menu__item menu__item_active">
                        <a href="<?= $value['url']; ?>"><?= $value['name']; ?></a>
                    </li>
                <?php }else { ?>
                    <li class="menu__item">
                        <a href="<?= $value['url']; ?>"><?= $value['name']; ?></a>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>
</nav>
