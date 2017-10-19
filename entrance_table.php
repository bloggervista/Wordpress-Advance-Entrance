<?php
function entrance_result_table() {
   	global $wpdb;
    $wpdb->entrance_result = "{$wpdb->prefix}entrance_result";
}
add_action('init','entrance_result_table',1);

function entrance_table_create(){
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  global $wpdb;
  global $charset_collate;
  entrance_result_table();

    $sql_create_table = "CREATE TABLE {$wpdb->entrance_result} (
        result_id bigint(20) NOT NULL auto_increment,
        user_id bigint(20)  NOT NULL default '0',
        post_id bigint(20)  NOT NULL default '0',
        ip_address varchar(20)  NOT NULL default '0',
        full_marks int(4) NOT NULL,
        pass_marks int(4)  NOT NULL,
        obtained_marks int(4)  NOT NULL,
        percentage int(4)  NOT NULL,
        no_attempted_question int(4)  NOT NULL default '0',
        started_time int(4)  NOT NULL default '0',
        end_time int(4)  NOT NULL default '0',
        correct_questions LONGTEXT,
        incorrect_questions LONGTEXT,
        missed_questions LONGTEXT,
        PRIMARY KEY  (result_id),
        KEY user_id (user_id)
     ) $charset_collate; ";
 
  dbDelta( $sql_create_table );
}