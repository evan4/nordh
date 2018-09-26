<?php if ((!defined('ABS_PATH'))) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if (!OC_ADMIN) exit('User access is not allowed.');
$residential = Models_Residential::newInstance()->getByCityId(409054);
?>
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/filter_search/assets/css/libs/bootstrap.css">
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/filter_search/assets/css/libs/selectize.css">
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/filter_search/assets/css/libs/toastr.min.css">

<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/filter_search/assets/css/filter_admin.css">

<script src="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/js/libs/selectize.min.js"></script>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/js/libs/toastr.min.js"></script>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/js/libs/toastr.min.js"></script>
<script>
    //here we hold some usefull info for easy access
    var mySiteAdmin = window.mySiteAdmin || {};
    mySiteAdmin.ajax_add_url = '<?php echo osc_ajax_plugin_url('filter_search/helpers/residential/filter_ajax.php'); ?>';
    mySiteAdmin.ajax_get_url = '<?php echo osc_ajax_plugin_url('filter_search/helpers/residential/filter_ajax_get.php'); ?>';
    mySiteAdmin.ajax_update_url = '<?php echo osc_ajax_plugin_url('filter_search/helpers/residential/filter_edit_ajax.php'); ?>';
    mySiteAdmin.ajax_delete_url = '<?php echo osc_ajax_plugin_url('filter_search/helpers/residential/filter_delete_ajax.php'); ?>';

    mySiteAdmin.csrf_token = '<?php echo osc_csrf_token_url(); ?>';
</script>

<div id="general-setting">

    <h2 class="render-title"><b>Жилой комплекс</b></h2>

    <ul id="error_list"></ul>

    <select class="filter-form__select" name="city" id="city-select"
            data-live-search="true">
        <?php
        foreach (getAllCities() as $city) {
            if ($city['pk_i_id'] == '409054') { ?>
                <option value="<?= $city['pk_i_id'] ?>" selected><?= $city['s_name'] ?></option>
            <?php } else { ?>
                <option value="<?= $city['pk_i_id'] ?>"><?= $city['s_name'] ?></option>
            <?php } ?>
        <?php } ?>
    </select>

    <button id="add-district" class="btn btn-primary">Добавить жилой комплекс</button>

    <div class="row">
        <div class="col-xs-12">
            <form action="" method="post" id="filter-form-add"
                  class="collapse">
                <div class="form-group" id="filter-form-wrap">
                    <label for="name">Название</label>
                    <input type="text" name="name" id="name" class="form-control"
                           data-parent="409054"
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
            <th class="tiny"></th>
            <th class="tiny"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($residential as $res) { ?>
            <tr id="filter-form-<?= $res['pk_i_id']; ?>">
                <td><?= $res['s_name']; ?></td>
                <td class="tiny">
                    <span class="glyphicon glyphicon-edit text-info icon_edit"
                          aria-hidden="true" data-id="<?= $res['pk_i_id']; ?>"></span>
                </td>
                <td class="tiny">
                    <span class="glyphicon glyphicon-remove text-danger icon_delete" aria-hidden="true"
                          data-id="<?= $res['pk_i_id']; ?>"></span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<script src="<?php echo osc_base_url(); ?>oc-content/plugins/filter_search/assets/js/filter_admin.js"></script>
