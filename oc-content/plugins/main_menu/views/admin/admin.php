<?php if ((!defined('ABS_PATH'))) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if (!OC_ADMIN) exit('User access is not allowed.');
$menu = Models_Menu::newInstance()->getMenu();
?>
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/main_menu/assets/css/libs/bootstrap.css">
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/main_menu/assets/css/libs/toastr.min.css">

<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/main_menu/assets/css/main_menu.css">

<script src="<?php echo osc_base_url(); ?>oc-content/plugins/main_menu/assets/js/libs/toastr.min.js"></script>
<script>
    //here we hold some usefull info for easy access
    var mySiteAdmin = window.mySiteAdmin || {};

    mySiteAdmin.ajax_add_url = '<?php echo osc_ajax_plugin_url('main_menu/helpers/repair_add_ajax.php'); ?>';
    mySiteAdmin.ajax_update_url = '<?php echo osc_ajax_plugin_url('main_menu/helpers/repair_edit_ajax.php'); ?>';
    mySiteAdmin.ajax_delete_url = '<?php echo osc_ajax_plugin_url('main_menu/helpers/repair_delete_ajax.php'); ?>';

    mySiteAdmin.csrf_token = '<?php echo osc_csrf_token_url(); ?>';
</script>

<div id="general-setting">

    <h2 class="render-title"><b>Пункты главного меню</b></h2>

    <ul id="error_list"></ul>

    <button id="add-district" class="btn btn-primary">Добавить</button>

    <div class="row">
        <div class="col-xs-12">
            <form action="" method="post" id="filter-form-add"
                  class="collapse">
                <div class="form-group" id="filter-form-wrap">
                    <label for="name">Название</label>
                    <input type="text" name="name" id="name" class="form-control"
                           required>
                </div>
                <div class="form-group" id="filter-form-wrap">
                    <label for="url">Url</label>
                    <input type="text" name="url" id="url" class="form-control"
                           required>
                </div>
                <div class="form-group">
                    <input id="filter-submit" class="btn btn-default" type="submit" value="Добавить">
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <form action="" method="post" id="filter-form_edit" class="collapse">
                <h3 class="filter-form__caption">Правка</h3>
                <div class="form-group">
                    <label for="name_edit">Название</label>
                    <input type="text" name="name" id="name_edit"
                           class="form-control" data-id="" required>
                </div>
                <div class="form-group" id="filter-form-wrap">
                    <label for="url_edit">Url</label>
                    <input type="text" name="url" id="url_edit" class="form-control"
                           required>
                    <div class="form-group" id="filter-form-wrap">
                        <label for="order_edit">Порядок</label>
                        <input type="number" min="1" name="orderliness" id="order_edit"
                               class="form-control"
                               required>
                    </div>
                    <input type="hidden" value="" name="id" id="id">
                <div class="form-group">
                    <input id="filter-submit-edit" class="btn btn-default" type="submit" value="Сохранить">
                </div>
            </form>
        </div>
    </div>

    <table id="data-districts" class="table table-bordered table-striped" cellspacing="0">
        <thead>
        <tr>
            <th>Название</th>
            <th>URL</th>
            <th>Порядок</th>
            <th class="tiny"></th>
            <th class="tiny"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($menu as $res) { ?>
            <tr id="filter-form-<?= $res['id']; ?>">
                <td><?= $res['name']; ?></td>
                <td><?= $res['url']; ?></td>
                <td><?= $res['orderliness']; ?></td>
                <td class="tiny">
                    <span class="glyphicon glyphicon-edit text-info icon_edit"
                          aria-hidden="true" data-id="<?= $res['id']; ?>"></span>
                </td>
                <td class="tiny">
                    <span class="glyphicon glyphicon-remove text-danger icon_delete" aria-hidden="true"
                          data-id="<?= $res['id']; ?>"></span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<script src="<?php echo osc_base_url(); ?>oc-content/plugins/main_menu/assets/js//main_menu.js"></script>
