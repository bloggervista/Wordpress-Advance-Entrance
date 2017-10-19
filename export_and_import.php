<?php
class Entrance_Database{
	static $hook_suffix='';
	static function load(){
		add_action('admin_menu', array(__CLASS__,'add_submenu'));
        add_action('admin_init', array(__CLASS__,'maybe_download'));
	}
	static function add_submenu(){
		 self::$hook_suffix =add_submenu_page('edit.php?post_type=entrance', __('Backup','menu-wpt'), __('Backup','menu-wpt'), 'manage_options', 'entrance_backup', array(__CLASS__,'display'));
	}
 
    static function maybe_download(){
    if( empty($_POST['action']) || 'export-result' !== $_POST['action'] )
        return;
 
    /* Check permissions and nonces */
    if( !current_user_can('manage_options') )
        wp_die('');
 
    check_admin_referer( 'wp_entrance_result_data','_wplnonce');
 
    /* Trigger download */
    wptuts_export_logs();

    exit();
    }

    static function display(){
 
    echo '<div class="wrap">';
        screen_icon();
        echo '<h2>' . __( 'Export Activity Logs', 'Shirshak' ) . '</h2>';
        ?>
 
        <form id="wp_export_result" method="post" action="">
            <p>
                <label><?php _e( 'Click to export the entrance results','Shirshak' ); ?></label>
                <input type="hidden" name="action" value="export-result" />
            </p>
            <?php wp_nonce_field('wp_entrance_result_data','_wplnonce') ;?>
            <?php submit_button( __('Download Entrance Results','Shirshak'), 'button' ); ?>
        </form>
    <?php
	}
}
Entrance_Database::load();

function wptuts_export_logs( $args = array() ) {
 	global $wpdb;
    /* Query logs */
    $results = $wpdb->get_results("SELECT * FROM {$wpdb->entrance_result}");

    //print_r($results);die();
 
    /* If there are no logs - abort */
    if( !$results )
        return false;
 
    /* Create a file name */
    $sitename = sanitize_key( get_bloginfo( 'name' ) );
    if ( ! empty($sitename) ) $sitename .= '.';
    $filename = $sitename . 'wptuts-logs.' . date( 'Y-m-d' ) . '.xml';
 
    /* Print header */
    header( 'Content-Description: File Transfer' );
    header( 'Content-Disposition: attachment; filename=' . $filename );
    header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
 
    /* Print comments */
    echo "<!-- This is a export of the Entrance Results -->\n";
    echo "<!-- Just created By Shirshak for easy backup and restore -->\n";
    echo "<!--  Just watch the file carefully AND you will know how thing is good :) -->\n";
 
    /* Print the logs */

    echo '<results>';

	foreach ( $results as $result ) { ?>

	    <item>
	        <result_id><?php echo absint($result->result_id); ?></result_id>
	        <user_id><?php echo absint($result->user_id); ?></user_id>
	        <post_id><?php echo absint($result->post_id); ?></post_id>
	        <ip_address><?php echo sanitize_key($result->ip_address); ?></ip_address>
	        <full_marks><?php echo absint($result->full_marks); ?></full_marks>
	        <pass_marks><?php echo absint($result->pass_marks); ?></pass_marks>
	        <obtained_marks><?php echo absint($result->obtained_marks); ?></obtained_marks>
	        <percentage><?php echo absint($result->percentage); ?></percentage>
	        <no_attempted_question><?php echo absint($result->no_attempted_question); ?></no_attempted_question>
	        <started_time><?php echo absint($result->started_time); ?></started_time>
	        <end_time><?php echo absint($result->end_time); ?></end_time>
	        <correct_questions><?php echo implode(", ",unserialize($result->correct_questions));; ?></correct_questions>
	        <incorrect_questions><?php echo implode(", ",unserialize($result->incorrect_questions)); ?></incorrect_questions>
	        <missed_questions><?php echo implode(", ",unserialize($result->missed_questions)); ?></missed_questions>
	    </item>

	<?php }

	echo '</results>';

}
?>