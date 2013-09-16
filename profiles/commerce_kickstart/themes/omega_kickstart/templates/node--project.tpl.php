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
    <div<?php print $content_attributes; ?>>
        <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
		//var_dump($content);

		$field_description = field_get_items('node', $node, 'field_description');
		$description = field_view_value('node', $node, 'field_description', $field_description[0]);

		$field_completed = field_get_items('node', $node, 'field_completed');
		$completed = field_view_value('node', $node, 'field_completed', $field_completed[0]);

		$field_participants = field_get_items('node', $node, 'field_participants');
		$participants = field_view_value('node', $node, 'field_participants', $field_participants[0]);
		?>
		<p class="project_participans"><?php print( '<b>' . t('Participants') . ':</b>&nbsp;' . $participants['#markup']); ?></p>
		<p class="project_completed"><?php print('<b>' . t('Completed') . ':</b>&nbsp;' . $completed['#markup']); ?>%</p>
		<div class="project_description"><?php print('<b>' .  t('Description') . ':</b><br />' .  $description['#markup']); ?></div>

		<?php
        //print render($content);
		?>

		<div class="project_video"><?php print($node->field_video_code['und'][0]['value']); ?></div>
    </div>

    <div class="clearfix">
        <?php if (!empty($content['links'])): ?>
            <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
        <?php endif; ?>

        <?php print render($content['comments']); ?>
    </div>
</article>
