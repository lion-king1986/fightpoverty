<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kostia Vahrushev
 * Date: 03.09.13
 * Time: 15:05
 * To change this template use File | Settings | File Templates.
 */
?>
<article<?php print $attributes; ?>>
    <?php print $user_picture; ?>
    <?php print render($title_prefix); ?>
    <?php if (!$page && $title): ?>
        <header>
            <h2<?php print $title_attributes; ?>><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
        </header>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if ($display_submitted): ?>
        <footer class="submitted">
            <?php print $submitted; ?>
        </footer>
    <?php endif; ?>
<!--    <div<?php print $content_attributes; ?>> -->
	<div class="wrapper">
        <?php
        $form = choose_proj_fp();
        echo drupal_render($form);
        // We hide the comments and links now so that we can render them later.
        //hide($content['comments']);
        //hide($content['links']);
        //print render($content);

		$query = db_select('node', 'n');
		$query->fields('n', array('nid', 'title'));
		$query->condition('n.type', 'project', '=');
		$result = $query->execute();
		while($row = $result->fetchAssoc()) {
			$node = node_load($row['nid']);

			$field_description = field_get_items('node', $node, 'field_description');
			$description = field_view_value('node', $node, 'field_description', $field_description[0]);

			$field_image = field_get_items('node', $node, 'field_image1');
			$image = field_view_value('node', $node, 'field_image1', $field_image[0]);

			$field_completed = field_get_items('node', $node, 'field_completed');
			$completed = field_view_value('node', $node, 'field_completed', $field_completed[0]);

			$field_participants = field_get_items('node', $node, 'field_participants');
			$participants = field_view_value('node', $node, 'field_participants', $field_participants[0]);


			//var_dump($completed);

		?>
			<div class="project_block">
				<div class="description"><?php print $description['#markup']; ?></div>
				<div class="cp_container">
					<div id="triangle-topleft">
						<!--<img src="/profiles/commerce_kickstart/themes/commerce_kickstart_theme/images/no_image_50x50.png" class="choose_img" />-->
						<img src="<?php if(!empty($image)) print file_create_url($image['#item']['uri']); ?>" class="choose_img" />
						<p class="project_info"><?php print($node->title); ?></p>
						<p class="project_percentage"><?php print($completed['#markup']); ?>%</p>
					</div>
				</div>
				<p class="fighters_link"><?php print($participants['#markup']); ?> fighters</p>
			</div>
		<?php
		}
		?>
<!--
		<div class="project_content">
			<div class="project_video">
				<?php //print($node->field_video_code['und'][0]['value']); ?>
			</div>
			<a href="#" id="choose_project">Choose this project</a>
			<div class="project_description">
				<?php //print($node->field_description['und'][0]['value']); ?>
			</div>
		</div>
-->
    </div>
<!--
    <div class="clearfix">
        <?php if (!empty($content['links'])): ?>
            <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
        <?php endif; ?>

        <?php print render($content['comments']); ?>
    </div>
-->
</article>
