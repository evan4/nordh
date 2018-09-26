<?php
$types_repair = Models_Types_Repair::newInstance()->getMenu();
?>

<section class="remont" id="vidy-remonta">
    <div class="wrap">
        <p class="caption">Виды ремонта</p>
        <p class="text">Комфортное и уютное жилище – мечта каждого. Именно тут мы отдыхаем, набираемся сил, приводим
            нервы в порядок. Понятие уюта и удобства у всех разное – иному достаточно просто аккуратной и
            качественной работы, кто-то не мыслит жизни без дубового паркета и камина. Как бы то ни было, без помощи
            профессиональных отделочников вам не достичь желаемого. Наши специалисты знают все о новинках отделочных
            материалов и технологий, они пристально следят за изменением в строительных нормативах. Наша компания
            выполняет различные виды ремонтных работ:</p>
        <ul class="remont__list">

            <?php foreach ($types_repair as $item){ ?>

            <li class="remont__item">
                <div class="remont__front">
                    <p class="remont__caption"><?= $item['title']; ?></p>
                    <p class="remont__text"><?= $item['description']; ?></p>
                    <p class="remont__link">
                        <a href="#">Подробнее</a>
                    </p>
                </div>

                <ul class="remont__content">
                    <?php
                    $list = explode ("\n",$item['description_list']);
                    foreach ($list as $li){ ?>
                        <li><?= $li; ?></li>
                    <?php } ?>
                    <li>
                        <a class="remont__back" href="#"><i class="fa fa-arrow-left"></i> назад</a>
                    </li>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>