<?php

/* Функція для обробки даних вибраних з бази даних */
function getTicketsData() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'posts';

	$ticket_rows = $wpdb->get_results( "SELECT * FROM $table_name where post_type = 'arenda' " );

	$url = get_admin_url(null, 'admin.php?page=tickets_setting_page&author=');
	$file = "authors_page.php";

	/* Присвоюємо нашій табличці значення */
	foreach ( $ticket_rows as $ticket_row ) {
		$ticket_row->count_posts	= count_user_posts ( get_post_field( 'post_author', $ticket_row -> ID), 'arenda' );
		$ticket_row->post_id       =  $ticket_row -> ID;
		$ticket_row->post_url       = "<a href=" . get_edit_post_link($ticket_row -> ID) . " target=\"_blank\" >" . get_the_title($ticket_row -> ID) . "</a>";
		$ticket_row->author_url     = "<a href=" . $file .  " target=\"_blank\" >" . get_the_author_meta( "login", get_post_field( 'post_author', $ticket_row -> ID )) . "</a>";
		$ticket_row->date           = get_post_field( 'post_date', $ticket_row -> ID );
	
}

	wp_send_json( $ticket_rows);
}

add_action( 'wp_ajax_get_tickets_data', "getTicketsData" );

function deleteTicket() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'posts';
	$post_id  = $_POST['post_id'];
	$wpdb->delete( $table_name, array( 'ID' => $post_id ) );
}

add_action( 'wp_ajax_delete_ticket', "deleteTicket" );

function updatePostStatusHide() {
	global $wpdb;
	$table_name      = $wpdb->prefix . 'post';
	$post_id         = $_POST['post_id'];
	$new_status_hide = $_POST['new_status_hide'];



	$wpdb->update( $table_name, array( 'post_type' => $new_ticket_status_code ), array( 'ID' => $post_id ) );
}

add_action( 'wp_ajax_update_status_post_hide', "updatePostStatusHide" );


       