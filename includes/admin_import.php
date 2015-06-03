<?php

add_action('admin_menu', function() {
			
		//run import
		if (isset($_POST['tsml_import'])) {
			//verify nonce
			//if (!isset($_POST['tsml_nonce'])) return;
			//if (!wp_verify_nonce($_POST['tsml_nonce'], $tsml_nonce)) return;
						
			tsml_import($_POST['tsml_import'], $_POST['tsml_delete']);
		}
		
	//import text file
	add_submenu_page('edit.php?post_type=meetings', 'Import Meetings', 'Import', 'manage_options', 'import', function(){
		global $tsml_types, $tsml_nonce, $tsml_days;

	    ?>
		<div class="wrap">
		    <h2>Import Spreadsheet Data</h2>
		    
		    <div id="poststuff">
			    <div id="post-body" class="columns-2">
				    <div id="post-body-content">
					    <div class="postbox">
							<h3>Instructions</h3>
						    <div class="inside">
								<p>You can import a spreadsheet of meetings by pasting into the field below. <a href="<?php echo plugin_dir_url(__FILE__) . '../template.csv'?>">Here is a spreadsheet</a> you can use as a template. The header row must kept in place.</p>
								<ul class="ul-disc">
									<li><strong>Time</strong> is required and should be in the format 6:00 AM.</li>
									<li><strong>Day</strong> is required and should either Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, or Saturday. Meetings that occur on multiple days should be listed separately. 'Daily' or 'Mondays' will not work.</li>
 									<li><strong>Address</strong> is required and will be corrected by Google, so it may look different afterward. Ideally, every address for the same location should be exactly identical, and not contain extra information about the address, such as the building name or descriptors like 'around back.'</li>
									<li><strong>Name</strong> is the name of the meeting, and is optional, although it's valuable information for the user. In the event it's missing, a name will be created by combining the location, day, and time.</li>
									<li><strong>Location</strong> is the name of the location, and is optional. Generally it's the group or building name. In the event it's missing, the address will be used. In the event that there are multiple location names for the same address, the first location name will be used.</li>
									<li><strong>City</strong>, <strong>State</strong>, and <strong>Country</strong> are optional, but might be useful if your addresses sound ambiguous to Google.</li>
									<li><strong>Notes</strong> are freeform notes that will show up publicly. This is where 'around back' is useful.</li>
									<li><strong>Types</strong> should be a comma-separated list of the following options. Either O or Open will work to mark a meeting Open.
										<ul style="margin-top:10px;overflow:auto;">
										<?php foreach ($tsml_types as $key=>$value) {?>
											<li style="margin-bottom:0;width:33.33%;float:left;"><?php echo $key?>: <?php echo $value?></li>
										<?php }?>
										</ul>
									</li>
								</ul>
						    </div>
					    </div>
					    <div class="postbox">
							<h3>Import</h3>
							<div class="inside">
								<form method="post" action="edit.php?post_type=meetings&page=import">
									<?php wp_nonce_field($tsml_nonce, 'tsml_nonce', false)?>
									<p>This will take a while, please be patient. Importing 500 meetings takes about one minute.</p>
									<textarea name="tsml_import" class="widefat" rows="5" placeholder="Paste spreadsheet data here"></textarea>
									<!--
									<div style="margin-top:10px;"><label><input type="radio" name="tsml_delete" value="nothing" disabled> Don't overwrite anything that's in the system already</label></div>
									<div><label><input type="radio" name="tsml_delete" value="individual" disabled> Replace meetings at the same time and place with new data</label></div>
									-->
									<div style="margin-top:10px;"><label><input type="radio" name="tsml_delete" value="everything" checked> Start fresh: delete all meetings and locations</label></div>
									<div style="margin-top:12px;"><input type="submit" class="button button-primary" value="Begin"></div>
								</form>
						    </div>
					    </div>
					</div>
				    <div id="postbox-container-1" class="postbox-container">
						<div class="postbox">
							<h3>Where's My Info?</h3>
							<div class="inside">
								<p>Your meeting list page is <a href="<?php echo get_post_type_archive_link('meetings'); ?>">right here</a>. 
								Link this page from your site's nav menu to make it visible to the public.</p>
							</div>
						</div>
						<div class="postbox">
							<h3>About this Plugin</h3>
							<div class="inside">
								<p>This plugin was developed by AA volunteers in <a href="http://aasanjose.org/technology">Santa 
									Clara County</a> to help provide accessible, accurate information about meetings to 
									those who need it.</p>
								<p>Get in touch by sending email to <a href="mailto:web@aasanjose.org">web@aasanjose.org</a>.</p>
							</div>
						</div>
				    </div>
			    </div>
		    </div>
		    
		<?php
	});
});
