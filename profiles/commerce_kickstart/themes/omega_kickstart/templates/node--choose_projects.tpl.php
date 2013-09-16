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
	<div class="wrapper">

        <?php
		global $user;

		if($user->uid) {
			$users_choice = db_select('field_data_field_choosed_project', 'chp')
				->fields('chp', array('field_choosed_project_value'))
				//->condition('chp.type', 'page')
				->condition('chp.entity_id', $user->uid)
				->execute()
				->fetchField()
			;
		}

        drupal_add_library('system', 'drupal.ajax');
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

			$field_triangle_background = field_get_items('node', $node, 'field_triangle_s_background');
			$triangle_background = field_view_value('node', $node, 'field_triangle_s_background', $field_triangle_background[0]);

		?>
			<div class="project_block">
				<div class="description"><?php print $description['#markup']; ?></div>
				<div class="cp_container">
					<div id="triangle-topleft" style="border-bottom: 200px solid #<?php print($triangle_background['#item']); ?>">
						<!--<img src="/profiles/commerce_kickstart/themes/commerce_kickstart_theme/images/no_image_50x50.png" class="choose_img" />-->
						<img src="<?php if(!empty($image)) print file_create_url($image['#item']['uri']); ?>" class="choose_img" />
						<p class="project_info"><?php print($node->title); ?></p>
						<p class="project_percentage"><?php print($completed['#markup']); ?>%</p>
					</div>
				</div>
				<p class="fighters_link"><?php print($participants['#markup']) . '&nbsp;' . t('fighters'); ?></p>
				<?php
					if(!empty($users_choice) && $users_choice == $row['nid']) {
						$display_message = "display:block";
						$display_link = "display:none";
					} else {
						$display_message = "display:none";
						$display_link = "display:block";
					}
				?>
                <div id="div<?php echo $row['nid'];?>" style="<?php echo $display_message; ?>">You have chosen this project</div>
				
				
				<?php
						$form = choose_proj_fp($row['nid'], $display_link);
						echo drupal_render($form);
				?>
		    </div>
		<?php
		}
		?>
		<div class="clearfix"></div>
    </div>
</article>
