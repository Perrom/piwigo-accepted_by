<?php 

// Add a prefilter
add_event_handler('loc_begin_admin', 'accepted_by_set_prefilter_modify', 50 );

add_event_handler('loc_begin_admin_page', 'accepted_by_modify_submit', 45 );

// Change the variables used by the function that changes the template
add_event_handler('loc_begin_admin_page', 'accepted_by_add_modify_vars_to_template');

function accepted_by_set_prefilter_modify()
{
	global $template;
	$template->set_prefilter('picture_modify', 'accepted_by_modify');
}

function accepted_by_modify($content)
{
	$search = "#<strong>{'Creation date'#"; 

	$replacement = '<strong>{\'Accepted by\'}</strong>
		<br>
			<input type="text" id="acceptedByID" name="acceptedByID" maxlength="100"
{if $accepted_name}
			value="{$accepted_name}"
{/if}  		
			/>
		</p>
	
	</p>
  <p>
		<strong>{\'Creation date\'';

    return preg_replace($search, $replacement, $content);
}


function accepted_by_add_modify_vars_to_template()
{
	if (isset($_GET['page']) and 'photo' == $_GET['page'] and isset($_GET['image_id']))
	{
		global $template;
		
		// Get the current name
		$image_id = $_GET['image_id'];
		$query = sprintf(
			'SELECT `name`
			FROM %s
			WHERE `accepted_by_id` = %d
			;',
			ACCEPTED_BY, $image_id);
			$result = pwg_query($query);
			$row = pwg_db_fetch_assoc($result);
			$name = '';
			// Get the data from the chosen row
			if (isset($row) and count($row) > 0) {
				$name = $row['name'];
			}
			// Sending data to the template
		$template->assign('accepted_name', $name);
	}
}


function accepted_by_modify_submit()
{
    if (isset($_GET['page']) and 'photo' == $_GET['page'] and isset($_GET['image_id']))
	{
		if (isset($_POST['submit']))
		{
			// The data from the submit
			$image_id = $_GET['image_id'];
			$accepted_by_name = $_POST['acceptedByID'];

			// Delete the name if there already is one
			$query = sprintf(
				'DELETE
				FROM %s
				WHERE `accepted_by_id` = %d
				;',
				ACCEPTED_BY, $image_id);
			pwg_query($query);

			// If you assign no name, don't put it in the table
			if ($accepted_by_name != '') {
				// Insert the name
				$query = sprintf(
					'INSERT INTO %s
					VALUES (%d, "%s")
					;',
					ACCEPTED_BY, $image_id, $accepted_by_name);
				pwg_query($query);
			}
		}
	}
}

?>