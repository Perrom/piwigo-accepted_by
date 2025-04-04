<?php

// Add accepted_by drop down menu to the batch manager
add_event_handler('loc_end_element_set_global', 'accepted_by_batch_global');
// Add handler to the submit event of the batch manager
add_event_handler('element_set_global_action', 'accepted_by_batch_global_submit', 50, 2);

function accepted_by_batch_global()
{
	global $template;

	// Assign the template for batch management
	$template->set_filename('accepted_by_batch_global', dirname(__FILE__).'/batch_global.tpl');

	// Add info on the "choose action" dropdown in the batch manager
	$template->append('element_set_global_plugins_actions', array(
		'ID' => 'Accepted_by',				// ID of the batch manager action
		'NAME' => 'Accepted_by',	// Description of the batch manager action
		'CONTENT' => $template->parse('accepted_by_batch_global', true)
		)
	);
}

// Process the submit action
function accepted_by_batch_global_submit($action, $collection)
{
	// If its our plugin that is called
	if ($action == 'Accepted_by')
	{
		$accepted_by_name = $_POST['acceptedByID'];

		// Delete any previously assigned accepted by name
		if (count($collection) > 0) {
			$query = sprintf(
				'DELETE
				FROM %s
				WHERE accepted_by_id IN (%s)
				;',
			ACCEPTED_BY, implode(',', $collection));
			pwg_query($query);
		}

		// If you assign no name, dont put them in the table
		if ($accepted_by_name != '') {
			// Add names from the submit form to an array
			$edits = array();
			foreach ($collection as $image_id) {
				array_push(
					$edits,
					array(
						'accepted_by_id' => $image_id,
						'name' => $accepted_by_name,
					)
				);
			}

			// Insert the array into the database
			mass_inserts(
				ACCEPTED_BY,		// Table name
				array_keys($edits[0]),	// Columns
				$edits					// Data
			);
		}
	}
}

?>