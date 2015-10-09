<html>
  <head>
    <title><?php echo $page_title.' - '.__('Tag'); ?></title>
  </head>
  <body>
    <?php
       echo dcPage::breadcrumb(array(html::escapeHTML($core->blog->name) => '', $page_title => $p_url, __('Update description') => ''));

    if (!empty($message)) {
    dcPage::success($message);
    }
    ?>
    <form action="<?php echo $p_url;?>" method="post" id="tag-form">
      <p class="field">
	<span class="bold"><?php echo __('Tag:');?></span>
	<?php echo html::escapeHTML($tag['meta_id']);?>
	<?php echo form::hidden('tag_meta_id', html::escapeHTML($tag['meta_id']));?>
      </p>
      <p class="form-note"><?php echo __('Update tag on the original page');?></p>
      <p class="area" id="tag-desc">
	<label for="tag_desc"><strong><?php echo __('Description:');?></strong></label>
	<?php echo form::textarea('tag_meta_desc',50,5,html::escapeHTML($tag['meta_desc']));?>
      </p>
      <p>
	<?php echo form::hidden('p', 'tagDescription');?>
	<?php echo form::hidden('object', 'tag');?>
	<?php echo form::hidden('action', $action);?>
	<?php echo $core->formNonce();?>
	<input type="submit" name="save_tag" value="<?php echo __('Save'); ?>"/>
      </p>
    </form>
  </body>
</html>
