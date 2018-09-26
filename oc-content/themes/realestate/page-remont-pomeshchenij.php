<?php
/*
 *      Osclass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2013 Osclass
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>
<?php osc_current_web_theme_path('header-repair.php');

?>
<div class="page">

    <section class="intro">
        <div class="wrap">
            <h1 class="intro__caption">Ремонт квартир «под ключ» <span>в г. Сургуте</span></h1>
        </div>
    </section>
    <section class="my" id="my">
        <div class="wrap">
            <p class="caption">Измени жизнь к лучшему</p>
            <p class="text">Мы занимаемся разработкой самых разных дизайнов, а также отделкой помещений с 2013 года.
                За это время наше агентство весьма преуспело в выполнении дизайнерских и строительных работ,
                и продолжает динамично развиваться.</p>
            <p class="text">Специалисты могут выполнять работы как частично, так и «под ключ».
                За каждым успешно завершенным проектом стоит команда опытных, компетентных специалистов, которые знают,
                любят свою работу и всегда выполняют ее на высшем уровне.
                Совместная работа профессионалов при выполнении работ «под ключ» позволяет достичь идеального
                результата, при этом ценовая политика нашей компании — ниже рыночной.
            </p>
        </div>
    </section>
    <section class="ehtapy" id="ehtapy">
        <div class="wrap wrap_half">
            <p class="caption caption__ehtapy">Этапы работы</p>
            <ul class="ehtapy__list">
                <li class="ehtapy__item">Заявка или звонок</li>
                <li class="ehtapy__item">Выезд прораба с мастером на объект</li>
                <li class="ehtapy__item">Демонстрация демо-версии</li>
                <li class="ehtapy__item">Презентация ассортимента строительного материала</li>
                <li class="ehtapy__item">Составление сметы</li>
                <li class="ehtapy__item">Подписание договора</li>
                <li class="ehtapy__item">Завоз строй-материала и частичная оплата</li>
                <li class="ehtapy__item">Выполнение ремонтно-отделочных работ</li>
                <li class="ehtapy__item">Приемка – сдача этапов работы</li>
                <li class="ehtapy__item">Итоговая приемка-сдача объекта, оплата</li>
            </ul>
        </div>
    </section>

    <?php if (function_exists(advantages)) {
        echo advantages();
    } ?>

    <?php if (function_exists(repair_types)) {
        echo repair_types();
    } ?>

    <?php if (function_exists(vopros)) {
        echo vopros();
    } ?>

    <section class="raboty" id="raboty">
        <div class="wrap">
            <p class="caption caption_raboty">Наши работы</p>
            <?php if (function_exists(repair)) {
                echo repair();
            } ?>
        </div>
    </section>
    <section class="request">
        <div class="wrap">
            <p class="caption">Оставить заявку</p>
            <form action="" method="post" class="main-contact__form clearfix">
                <input type="text" name="name"
                       id="fname"
                       class="main-contact__input"
                       placeholder="Ваше имя" required>
                <input type="tel" name="tel"
                       id="ftel"
                       class="main-contact__input"
                       placeholder="Ваш телефон" required>
                <textarea name="msg"
                          class="main-contact__textarea"
                          placeholder="Сообщение"></textarea>
                <input type="submit" class="button main-contact__submit"
                       value="Оставить заявку">
            </form>
            <p class="popup__res"><i></i><span></span></p>
        </div>
</div>
<div id="service" class="popup mfp-with-anim mfp-hide white-popup white-popup_services">
    <div class="white-popup__inner">
        <p class="popup__caption popup__caption_services"></p>
        <p class="popup__text"></p>
    </div>
</div>
<?php osc_current_web_theme_path('footer-repair.php'); ?>
