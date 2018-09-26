<?php if ((!defined('ABS_PATH'))) exit('ABS_PATH is not loaded. Direct access is not allowed.'); ?>
<?php if (!OC_ADMIN) exit('User access is not allowed.');
$advantages = Models_Advantages::newInstance()->getSlides();
?>
<meta Http-Equiv="Cache-Control" Content="no-cache">
<meta Http-Equiv="Pragma" Content="no-cache">
<meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/advantages/assets/css/libs/bootstrap.css">
<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/advantages/assets/css/libs/toastr.min.css">

<link rel="stylesheet"
      href="<?php echo osc_base_url(); ?>/oc-content/plugins/advantages/assets/css/repair.css">
<style>
    input.form-control{
        height: 34px!important;
    }
    .glyphicon{
        cursor: pointer;
    }
    #images li img, #images li i{
        display: inline-block;
    }
    #images li i{
        font-size: 23px;
    }
</style>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/advantages/assets/js/libs/toastr.min.js"></script>
<script>
    //here we hold some usefull info for easy access
    var mySiteAdmin = window.mySiteAdmin || {};

    mySiteAdmin.ajax_add_url = '<?php echo osc_ajax_plugin_url('advantages/helpers/repair_add_ajax.php'); ?>';
    mySiteAdmin.ajax_update_url = '<?php echo osc_ajax_plugin_url('advantages/helpers/repair_edit_ajax.php'); ?>';
    mySiteAdmin.ajax_delete_url = '<?php echo osc_ajax_plugin_url('advantages/helpers/repair_delete_ajax.php'); ?>';

    mySiteAdmin.ajax_delete_img = '<?php echo osc_ajax_plugin_url('advantages/helpers/repair_deleteimg_ajax.php'); ?>';


    mySiteAdmin.csrf_token = '<?php echo osc_csrf_token_url(); ?>';
</script>

<div id="general-setting">

    <h2 class="render-title"><b>Наши преимущества</b></h2>

    <ul id="error_list"></ul>

    <button id="add-district" class="btn btn-primary">Добавить</button>

    <div class="row">
        <div class="col-xs-12">
            <form action="" method="post" id="filter-form-add"
                  class="collapse" enctype="multipart/form-data">
                <div class="form-group" id="filter-form-wrap">
                    <label for="title">Заголовок</label>
                    <textarea type="text" name="title" id="title" class="form-control" rows="3"
                              required></textarea>
                </div>
                <div class="form-group" id="filter-form-wrap">
                    <label for="description">Описание</label>
                    <textarea name="description" id="description"
                           class="form-control" rows="3"></textarea>
                </div>

                <div>
                    <div>
                        <input type="file" name="photo" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <input id="filter-submit" class="btn btn-default"
                           type="submit" value="Добавить">
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <form action="" method="post" id="filter-form_edit" class="collapse">
                <h3 class="filter-form__caption">Правка</h3>
                <div class="form-group">
                    <label for="title_edit">Заголовок</label>
                    <textarea type="text" name="title" id="title_edit"
                              class="form-control" data-id="" rows="3" required></textarea>
                </div>
                <div class="form-group" id="filter-form-wrap">
                    <label for="description_edit">Описание</label>
                    <textarea name="description" id="description_edit"
                           class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group" id="filter-form-wrap">
                    <label for="order_edit">Порядок</label>
                    <input type="number" min="1" name="orderliness" id="order_edit"
                           class="form-control"
                           required>
                </div>
                <div class="form-group" id="filter-form-wrap">
                    <ul class="list-unstyled" id="images">

                    </ul>
                </div>
                <div>
                    <div>
                        <input type="file" name="photo[]" accept="image/*">
                    </div>
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
            <th>Заголовок</th>
            <th>Описание</th>
            <th>Порядок</th>
            <th class="tiny"></th>
            <th class="tiny"></th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($advantages) {
            foreach ($advantages as $res) { ?>
                <tr id="filter-form-<?= $res['id']; ?>"
                    data-src="<?= $res['avatar']; ?>">
                    <td><?= $res['title']; ?></td>
                    <td><?= $res['description']; ?></td>
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
            <?php }
        } ?>
        </tbody>
    </table>

</div>

<script src="<?php echo osc_base_url(); ?>oc-content/plugins/advantages/assets/js//admin.js"></script>
