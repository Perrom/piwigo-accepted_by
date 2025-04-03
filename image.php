<?php
// Add an event handler for a prefilter
add_event_handler('loc_begin_picture', 'accepted_by_set_prefilter_add_to_pic_info', 55 );


// Change the variables used by the function that changes the template
add_event_handler('loc_begin_picture', 'accepted_by_add_image_vars_to_template');

// Add the prefilter to the template
function accepted_by_set_prefilter_add_to_pic_info()
{
	global $template;
	$template->set_prefilter('picture', 'accepted_by_add_to_pic_info');
}

// Insert the template for the field display
function accepted_by_add_to_pic_info($content)
{
	// Add the information after the author - so before the createdate
	$search = '#class="imageInfoTable">#';
	
	$replacement = 'class="imageInfoTable">
	<div id="Accepted_by_name" class="imageInfo">
		<dt>{\'Accepted by\'}</dt>
		<dd>
{if $ACCEPTED_BY_NAME}
			<p>{$ACCEPTED_BY_NAME}</p>
{else}
        {\'N/A\'}
{/if}
    </dd>
	</div>';

	return preg_replace($search, $replacement, $content, 1);
}


// Assign values to the variables in the template
function accepted_by_add_image_vars_to_template()
{
	global $page, $template;

	// Show block only on the photo page
	if ( !empty($page['image_id']) )
	{
		// Get the name that belongs to the current media_item
		$query = sprintf('
		  select name
		  FROM %s
		  WHERE accepted_by_id = %s
		;',
		ACCEPTED_BY, $page['image_id']);
		$result = pwg_query($query);
		$row = pwg_db_fetch_assoc($result);
		$name = '';
		// Get the data from the chosen row
		if (isset($row) and count($row) > 0) {
			$name = $row['name'];
		}
		// Sending data to the template
    $template->assign('ACCEPTED_BY_NAME', $name);
	}
}
?>