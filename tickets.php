<?php
/*
Plugin Name: Tickets
Description: Plugin for tickets
Author: Vasilisa Vaiman
Version: 1.0
Author URI: http://v-vaiman.zzz.com.ua/
*/

/* Підключаємо наш файл з функціями*/
require_once (dirname(__FILE__).'/functions.php');
//require_once (dirname(__FILE__).'/authors_page.php');

add_action( 'admin_init', 'tickets_admin_init' );
add_action( 'admin_menu', 'tickets_admin_menu' );


function tickets_admin_init() {
	/* Реєструємо скрипти. */
	wp_register_style( 'datatables-bundle-css', '//cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/dt-1.10.16/sl-1.2.5/datatables.min.css');
	wp_register_style( 'pnotify-css', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css');
	wp_deregister_script( 'jquery' );
	wp_register_script( 'popper-js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
	wp_register_script( 'pnotify-js', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js');
	wp_register_style( 'bootstrap-css', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
	wp_register_style( 'bootstrap-toggle-css', '//gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css');
	wp_register_script( 'bootstrap-toggle-js', '//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js');
	//wp_register_script( 'bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
	wp_register_script( 'pnotify-js', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js');
	wp_register_script( 'datatables-bundle-js', '//cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/dt-1.10.16/sl-1.2.5/datatables.min.js',  array('popper-js'));
	wp_register_script( 'tickets-plugin-script-js', plugin_dir_url(__FILE__) . '/functions.js');
}

function tickets_admin_menu() {
	/* Реєструємо і додаємо сторінку плагіну в меню адміністратора*/
	$page = add_menu_page( 'Tickets', 'Tickets', 'manage_options', 'tickets_setting_page', 'tickets_admin_page');
	/* Використовуємо зареєстрований плагін для завантаження скрипта */
	add_action( 'admin_print_scripts-' . $page, 'tickets_admin_scripts' );
}

function tickets_admin_scripts() {
	
	/* Підключаємо скрипти до сторінки плагіна */
	wp_enqueue_style( 'pnotify-css' );
	wp_enqueue_style( 'datatables-bundle-css' );
	wp_enqueue_script( 'popper-js' );
	wp_enqueue_script( 'pnotify-js' );
	wp_enqueue_style( 'bootstrap-css' );
	wp_enqueue_script( 'datatables-bundle-js' );
	wp_enqueue_script( 'tickets-plugin-script-js' );
	wp_enqueue_style( 'bootstrap-toggle-css' );
	wp_enqueue_script( 'bootstrap-toggle-js' );
}


/* Наповнюємо сторінку плагіна */
function tickets_admin_page() {
	?>
	<div class="container-fluid" style="padding-top: 24px; padding-right: 35px;">
        <h3>Список оголошень</h3>
        <hr class="my-4">
		<div class="row">
			<!-- Використовуючи  стилі datatables малюємо табличку--> 
			<table id="tickets-table" class="display table" style="width:100%;  border-collapse: collapse !important;"></table>
		</div>
	</div>
<?php

}