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

osc_show_widgets('footer');
?>
</div><!-- /wrap -->
</div>
<!-- /container -->
<!-- footer -->
<footer id="footer" class="footer clearfix">
    <div id="footer-inner" class="wrap">
        <div class="footer__left">
            <?php echo logo_footer(); ?>
            <p class="footer__copy">&copy; • ООО " НОРД ХАУС КОМПАНИ "</p>
        </div>
        <div class="footer__center">
            <p class="footer__caption">Навигация по сайту</p>
            <ul class="footer__menu">
                <?php osc_reset_static_pages();
                while (osc_has_static_pages()) { ?>
                    <li>
                        <a href="<?php echo osc_static_page_url(); ?>"><?php echo osc_static_page_title(); ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="footer__right">
            <p class="footer__sub">Мы в социальных сетях</p>
            <ul class="socials">
                <li class="socials__item socials__item_vk">
                    <a href="https://vk.com/id266070991" target="_blank"><i class="fa fa-vk"></i></a>
                </li>
                <li class="socials__item socials__item_facebook">
                    <a href="https://www.facebook.com/%D0%90%D0%9D-Nord-House-Company-143126272934415/notifications/" target="_blank"><i class="fa fa-facebook"></i></a>
                </li>
                <li class="socials__item socials__item_twitter">
                    <a href="https://twitter.com/NordHouse" target="_blank"><i class="fa fa-twitter"></i></a>
                </li>
                <li class="socials__item socials__item_instagram">
                    <a href="https://www.instagram.com/nord_house_company/" target="_blank">
                        <i class="fa fa-instagram"></i></a>
                </li>
            </ul>
            <a href="http://com-hmao.ru" class="footer__logoX" target="blank">  
                <img src="<?= osc_current_web_theme_url('img/logoX.png'); ?>" alt="лого Ком-ХМАО">
                <span>Разработка сайта Ком-ХМАО</span>
            </a>
        </div>
    </div>
</footer>
<!-- /footer -->
<div id="callback" class="popup mfp-with-anim mfp-hide white-popup">
    <p class="popup__caption">Закажите звонок</p>
    <form class="popup__callback clearfix" action="" method="post">
        <input id="name" class="popup__input" type="text" name="name"
               placeholder="Ваше имя">
        <input id="tel" class="popup__input" type="tel" name="tel"
               placeholder="Ваш телефон">
        <input class="popup__submit button button_green" type="submit" value="Отправить">
    </form>
    <p class="popup__res clearfix"><i></i><span></span></p>
</div>
<div id="order" class="popup mfp-with-anim mfp-hide white-popup">
    <p class="popup__caption">Подать заявку</p>
    <form class="popup__order clearfix" action="" method="post">
        <input id="oname" class="popup__input" type="text" name="name"
               placeholder="Ваше имя">
        <input id="otel" class="popup__input" type="tel" name="tel"
               placeholder="Ваш телефон">
        <select class="popup__select" name="category"
                data-placeholder="Вид объекта"
                data-live-search="true">
            <option value=""></option>
            <?php foreach (osc_get_categories() as $cat) { ?>
                <option class="filter-form__parent"
                        value="<?= $cat['s_name']; ?>"><?= $cat['s_name']; ?></option>
                <?php if (count($cat['categories']) > 0) { ?>
                    <?php foreach ($cat['categories'] as $sub) { ?>
                        <option class="filter-form__child"
                                value="<?= $sub['s_name']; ?>"><?= $sub['s_name']; ?></option>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </select>
        <textarea class="popup__textarea" name="address" id="oaddress" cols="3"
                  rows="2" placeholder="Адрес"></textarea>
        <input id="ocost" class="popup__input" type="number" name="cost" min="100"
               placeholder="Стоимость">
        <textarea class="popup__textarea" name="desc" id="odesc" cols="3" rows="2"
                  placeholder="Описание"></textarea>
        <textarea  class="popup__textarea"name="add" id="oadd" cols="3" rows="2"
                   placeholder="Доп. информация"></textarea>
        <input class="popup__submit button button_green" type="submit" value="Отправить">
    </form>
    <p class="popup__res clearfix"><i></i><span></span></p>
</div>
<div id="result-success" class="popup mfp-with-anim mfp-hide white-popup">
    <p class="popup__res clearfix"><i class="popup__success"></i><span>Заявка отправлена</span></p>
</div>
<?php
osc_run_hook('footer'); ?>
</body>
</html>