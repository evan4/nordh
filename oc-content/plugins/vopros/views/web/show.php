<?php
$vopros = Models_Vopros::newInstance()->getMenu();
?>
<section class="popular-question">
    <div class="wrap">
        <p class="caption">Популярные вопросы</p>
        <ul class="popular-question__list">
            <?php foreach ($vopros as $item){ ?>
            <li class="popular-question__parent">
                <a href="#" class="list-group-item category-accordion__parentlink">
                    <?= $item['title']; ?>
                </a>
            </li>
            <li class="popular-question__item">
                <?= $item['description']; ?>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>
