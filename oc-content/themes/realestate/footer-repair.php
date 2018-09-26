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

</div>
<!-- /container -->
<!-- footer -->
<footer class="footer clearfix">
    <div class="wrap">
        <ul class="footer__list">
            <li class="footer__left">
                <img src="<?= osc_current_web_theme_url('img/repair/tree.png'); ?>" alt="НОРД ХАУС КОМПАНИ">
            </li>
            <li class="footer__block">
                <p class="footer__caption">Разделы</p>
                <?php if (function_exists(main_menu_repair)) { ?>
                    <ul class="footer__menu">
                        <?php echo main_menu_repair(); ?>
                    </ul>
                <?php } ?>
            </li>
            <li class="footer__contacts">
                <p class="footer__caption">Контакты</p>
                <p class="footer__tel">
                    <a href="tel:83462771077">8 (3462) 77-10-77</a>
                </p>
                <p class="footer__email">
                    <a href="mailto:77-10-11@mail.ru">box:  77-10-11@mail.ru</a>
                </p>
            </li>
            <li class="footer__info">
                <a href="/" class="header-logo header-logo_repair">
                    <p class="header-logo__name header-logo__name_footer">NordHouse</p>
                    <p class="header-logo__sub">строительная компания</p>
                </a>
                <a href="http://com-hmao.ru" class="footer__logoX" target="_blank">
                    <img src="<?= osc_current_web_theme_url('img/repair/logoX.png'); ?>" alt="лого Ком-ХМАО">
                    <p>Создание и продвижение</p>
                </a>
                <p class="footer__copy"><?= date('Y'); ?> &copy; Все права защищены</p>
            </li>
        </ul>
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

<div id="result-success" class="popup mfp-with-anim mfp-hide white-popup">
    <p class="popup__res clearfix"><i class="popup__success"></i><span>Заявка отправлена</span></p>
</div>
<?php
osc_run_hook('footer'); ?>
</body>
</html>