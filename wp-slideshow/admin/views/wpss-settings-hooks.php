<?php
/*********************** All Hooks Start ***************************/
// add action to add general settings tab 	-  5
add_action( 'wpss_settings_panel_tab', 'wpss_general_setting_tab', 	5 	);
do_action( 'wpss_settings_panel_tab_after_ba' );



// add action to add general settings tab content 	-  5
add_action( 'wpss_settings_panel_tab_content', 'wpss_general_setting_tab_content', 	5 	);
do_action( 'wpss_settings_panel_tab_content_after_ba' );
/*********************** All Hooks End ***************************/