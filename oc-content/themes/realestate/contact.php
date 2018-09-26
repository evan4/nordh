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
<?php osc_current_web_theme_path('header.php'); ?>
<h1 class="caption caption_page">Контакты</h1>
<section class="contact clearfix">
    <ul class="contact__left">
        <li><i class="fa fa-map-marker"></i>г. Сургут, пр. Ленина, д.21, 4 эт.
		<p style="padding-left:20px;">кабинет 425 - администрация </p>
		<p style="padding-left:20px;">кабинет 426 - отдел продаж </p>
		<p style="padding-left:20px;">кабинет 427 - отдел продаж по работе с VIP недвижимостью </p>
		<p style="padding-left:20px;">кабинет 424 - отдел продаж по работе с коммерческой недвижимостью </p>
		<p style="padding-left:20px;">кабинет 423- приемная </p>
		<p style="padding-left:20px;">кабинет 422 - юридический отдел </p></li>
        <li><i class="fa fa-phone"></i><a href="tel:+73462771077">+7 (3462) 77-10-77</a></li>
        <li><i class="fa fa-envelope"></i><a href="mailto:77-10-77@mail.ru">77-10-77@mail.ru</a></li>
    </ul>
    <form action="" method="post" class="main-contact__form contact__right">
        <div class="contact__wrap clearfix">
            <div class="contact__wrapinput">
                <input type="text" name="name"
                       id="fname"
                       class="main-contact__input main-contact__input_contact"
                       placeholder="Ваше имя" required>
            </div>
            <div class="contact__wrapinput contact__wrapinput_last">
                <input type="tel" name="tel"
                       id="ftel"
                       class="main-contact__input main-contact__input_contact"
                       placeholder="Ваш телефон"
                       title="Номер должен быть более 6 цифр"
                       pattern="[+#*\(\)\[\]]*([0-9][ ext+-pw#*\(\)\[\]]*){7,15}" required>
            </div>

        </div>
        <textarea name="msg"
                  class="main-contact__textarea main-contact__textarea_contact"
                  rows="10"
                  placeholder="Ваше сообщение" required></textarea>
        <input type="submit" class="button button_green main-contact__submit"
               value="Отправить">
        <p class="form__res"></p>
    </form>
</section>
<div class="clearfix">
    <div id="map"></div>
</div>

<?php osc_current_web_theme_path('footer.php'); ?>
<script src="<?= osc_current_web_theme_js_url('contact.js'); ?>"></script>
