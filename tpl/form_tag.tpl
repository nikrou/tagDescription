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
		<a href="<?php echo $core->adminurl->get('admin.plugin.tags', array('tag' => $tag['id'], 'm' => 'tag_posts'));?>">
		    <?php echo html::escapeHTML($tag['id']);?>
		</a>
		<?php echo form::hidden('tag_id', html::escapeHTML($tag['id']));?>
	    </p>
	    <p class="form-note"><?php echo __('Update tag on the original page');?></p>
	    <p class="title">
		<label for="tag_title"><strong><?php echo __('Title:');?></strong></label>
		<?php echo form::field('tag_title', 20, 255, html::escapeHTML($tag['title']),'maximal');?>
	    </p>
	    <p class="area" id="tag-desc">
		<label for="tag_desc"><strong><?php echo __('Description:');?></strong></label>
		<?php echo form::textarea('tag_desc',50,5,html::escapeHTML($tag['desc']));?>
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
