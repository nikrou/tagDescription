<html>
  <head>
    <title><?php echo $page_title; ?></title>
    <?php echo dcPage::jsPageTabs($default_tab);?>
  </head>
  <body>
    <?php echo tagDescriptionTpl::breadcrumb(array(html::escapeHTML($core->blog->name) => '', '<span class="page-title">'.$page_title.'</span>' => ''));?>
    <?php if (!empty($message)) {
  dcPage::success($message);
};?>

    <?php if ($is_super_admin):?>
    <div class="multi-part" id="settings" title="<?php echo __('Settings');?>">
      <h3 class="hidden-if-js"><?php echo __('Settings');?></h3>
      <form action="<?php echo $p_url;?>" method="post" enctype="multipart/form-data">
	<div class="fieldset">
	  <h3><?php echo __('Plugin activation');?></h3>
	  <p>
	    <label class="classic" for="tag_description_active">
	      <?php echo form::checkbox('tag_description_active', 1, $tag_description_active);?>
	      <?php echo __('Enable Tag Description plugin');?>
	    </label>
	  </p>
	</div>

	<p>
	  <input type="hidden" name="p" value="tagDescription"/>
	  <?php echo $core->formNonce();?>
	  <input type="submit" name="saveconfig" value="<?php echo __('Save configuration');?>" />
	</p>
      </form>
    </div>
    <?php endif;?>
    <?php if ($tag_description_active):?>
    <div class="multi-part" id="descriptions" title="<?php echo __('Descriptions');?>">
      <h3 class="hidden-if-js"><?php echo __('Descriptions');?></h3>
      <?php if ($tags_counter==0):?>
      <p><strong><?php echo __('No tag');?></strong></p>
      <?php else:?>
      <p class="infos"><?php printf(__('one tag in database', '%d tags in database', $tags_counter), $tags_counter);?></p>
      <?php $tags_list->display(
      $page_tags, 
      $nb_per_page_tags,
      '<form action="'.$p_url.'" method="post" id="form-tags">'.'%s'.'</form>'
      );?>
      <?php endif;?>
    </div>
    <?php endif;?>
    <?php dcPage::helpBlock('tagDescription'); ?>
  </body>
</html>
