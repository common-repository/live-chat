<?php

//menu options page
function live_chat_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    // Save options if user has posted some information  
    if(isset($_POST['submitted'])){  
		if(isset($_POST['authorlink'])){update_option('live_chat_author_link',"1");}else{update_option('live_chat_author_link',"0");}
		if(isset($_POST['showavatar'])){update_option('live_chat_show_avatar',"1");}else{update_option('live_chat_show_avatar',"0");}
		if(isset($_POST['direction'])){update_option('live_chat_direction',"1");}else{update_option('live_chat_direction',"0");}
		if(isset($_POST['onlymembers'])){update_option('live_chat_only_members',"1");}else{update_option('live_chat_only_members',"0");}
		if(isset($_POST['sendemail'])){update_option('live_chat_send_email',"1");}else{update_option('live_chat_send_email',"0");}

		//set timezone
		if(isset($_POST['timezone'])){
			if( round(intval($_POST['timezone'])) < -24 or round(intval($_POST['timezone'])) > 24 ){
				echo '<div class="error"><p>Invalid Timezone</p></div>';
			}else{
				update_option('live_chat_timezone',round($_POST['timezone']));
			}
		}
	
		//setting saved message
		echo '<div class="updated"><p>Settings saved</p></div>';
	
	}
			
	
	// Delete all the messages
	if(isset($_POST['deletemessages'])){
		lc_delete_all_messages();
		echo '<div class="updated"><p>All the messages have been deleted</p></div>';
	}
	
	// OUTPUT START
	
	?>

	<div class="wrap">

		<?php screen_icon( 'options-general' ); ?>
		<h2>Options</h2>

		<form method="POST" action="" id="dc-ln-options-form" >

			<input type="hidden" name="submitted" value="1">

			<table class="form-table">

				<!-- Author link -->
				<tr valign="top">
					<th scope="row"><label>Link the chat title to the author's website</label></th>
					<td><input name="authorlink" type="checkbox" value="true" <?php if(get_option('live_chat_author_link')=="1"){echo 'checked="checked"';} ?> /></td>
				</tr>

				<!-- Show avatars -->
				<tr valign="top">
					<th scope="row"><label>Select this field to enable the avatars - GD PHP Library Required</label></th>
					<td><input name="showavatar" type="checkbox" value="true" <?php if(get_option('live_chat_show_avatar')=="1"){echo 'checked="checked"';} ?> /></td>
				</tr>

				<!-- Layout direction -->
				<tr valign="top">
					<th scope="row"><label>Set layout direction as Right to Left - Only for Arabic and Hebrew users</label></th>
					<td><input name="direction" type="checkbox" value="true" <?php if(get_option('live_chat_direction')=="1"){echo 'checked="checked"';} ?> /></td>
				</tr>

				<!-- Only registered users -->
				<tr valign="top">
					<th scope="row"><label>Enable only for registered users</label></th>
					<td><input name="onlymembers" type="checkbox" value="true" <?php if(get_option('live_chat_only_members')=="1"){echo 'checked="checked"';} ?> /></td>
				</tr>

				<!-- Send email -->
				<tr valign="top">
					<th scope="row"><label>Email me every new chat message</label></th>
					<td><input name="sendemail" type="checkbox" value="true" <?php if(get_option('live_chat_send_email')=="1"){echo 'checked="checked"';} ?> /></td>
				</tr>

				<!-- Timezone -->
				<tr valign="top">
					<th scope="row"><label>Timezone - Insert a value between -24 and +24</label></th>
					<td><input maxlength="3" name="timezone" type="text" value="<?php echo get_option('live_chat_timezone'); ?>" /></td>
				</tr>

			</table>
		
			<p class="submit">
				<input class="button button-primary" type="submit" value="Save Changes">
			</p>

		</form>

		<h3>Delete Messages</h3>

		<form method="POST" action="">
			
			<table class="form-table">

				<!-- Delete messages -->
				<tr valign="top">
					<th scope="row"><label>Delete all the messages from the database</label></th>
					<td><input type="hidden" name="deletemessages" value="1"><input class="button button-secondary" type="submit" value="Delete"></td>
				</tr>

			</table>

		</form>

	</div>
	
	<!-- OUTPUT END -->
	
	<?php
}

//delete all the messages from the database
function lc_delete_all_messages(){

	global $wpdb;$table_name=$wpdb->prefix."live_chat_table";

	//delete all the record
	$wpdb->get_results("DELETE FROM $table_name");
	
}

?>
