<?php $pages = get_content('content_type=page&subtype=dynamic&limit=1000'); ?>
<?php $posts_parent_page = get_option('data-content-id', $params['id']); ?>
<script type="text/javascript">


    mw.live_edit_load_cats_list = function () {
        CatTabs.set(3);
        mw.load_module('categories/manage', '#mw_add_cat_live_edit', function () {

        });
    }
    mw.load_quick_cat_edit = function ($id) {
        CatTabs.set(3);
        if ($id == undefined) {
            mw.$("#mw_select_cat_to_edit_dd").val();
        }
        mw.$("#mw_quick_edit_category").attr("data-category-id", $id);
        mw.load_module('categories/edit_category', '#mw_quick_edit_category', function () {
            $(mwd.body).removeClass("loading");
        });
    }

    $(mwd).ready(function(){
        CatTabs = mw.tabs({
          nav:'.mw-ui-btn-nav-tabs a',
          tabs:'.tab'
        });
    });
</script>




<div class="mw-ui-box-content" >
    <style scoped="scoped">

    .tab{
      display: none;
    }

    </style>

    <div class="mw-ui-btn-nav mw-ui-btn-nav-tabs">
        <a class="mw-ui-btn active" href="javascript:;">
                <?php _e("Options"); ?>
            </a>
        <a class="mw-ui-btn" href="javascript:;">
                <?php _e("Skin/Template"); ?>
            </a>
        <a class="mw-ui-btn" href="javascript:;" id="mw-live-edit-cats-tab" onclick="mw.live_edit_load_cats_list()">
                <?php _e("Edit categories"); ?>
            </a>
    </div>
    <a href="javascript:mw.load_quick_cat_edit(0);" class="mw-ui-btn"
       style="position: absolute;right: 13px;top: 12px;z-index: 1"><span>
	<?php _e("Add new category"); ?>
	</span></a>

<div class="mw-ui-box mw-ui-box-content">    <div class="tab" style="display: block">
        <label class="mw-ui-label">
            <?php _e("Show Categories From"); ?>
        </label>

        <select name="data-content-id" class="mw-ui-field mw_option_field">
            <option value="0"   <?php if ((0 == intval($posts_parent_page))): ?>   selected="selected"  <?php endif; ?>
                    title="<?php _e("None"); ?>">
                <?php _e("None"); ?>
            </option>
            <?php
            $pt_opts = array();
            $pt_opts['link'] = "{empty}{title}";
            $pt_opts['list_tag'] = " ";
            $pt_opts['list_item_tag'] = "option";

            $pt_opts['active_ids'] = $posts_parent_page;


            $pt_opts['include_categories'] = true;
            $pt_opts['active_code_tag'] = '   selected="selected"  ';



            pages_tree($pt_opts);


            ?>
        </select>

    </div>
    <div class="tab">
        <module type="admin/modules/templates"/>
    </div>
    <div class="tab">
        <div id="mw_add_cat_live_edit"></div>
        <div id="mw_quick_edit_category"></div>
    </div></div>
</div>