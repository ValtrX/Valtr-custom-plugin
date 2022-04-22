<?php

/**
 * Plugin Name: Valtr Custom Plugin
 * Description: this is a plugin where I do my tests
 * 
 */

function valtr_custom_js()
{
   wp_enqueue_script('valtr-custom-js', plugin_dir_url(__FILE__) . 'js/main.js', array(), true, false);
}

add_action('wp_enqueue_scripts', 'valtr_custom_js');



// function that runs when shortcode is called
function prefix_add_api_endpoints()
{
    add_rewrite_tag( '%user_id%', '([0-9]+)' );
    add_rewrite_rule( 'ajax-api/users/([0-9]+)/?', 'index.php?user_id=$matches[1]', 'top' );
}
add_action('init', 'prefix_add_api_endpoints');


function prefix_do_api() {
   
   global $wp_query;
   
   $user_id = $wp_query->get('user_id');
   
   if (!empty($user_id)) {
      $user = get_user_by('ID', $user_id);
      
      wp_send_json([
         'first_name' => $user->first_name,
         'last_name' => $user->last_name,
         'email' => $user->user_email,
      ]);
      
   }
}

add_action('template_redirect', 'prefix_do_api');


// Intento de hacer que se cree un endpoint para todos los usuarios

// function prefix_add_api_endpoints_all_users()
// {
//    add_rewrite_rule('ajax-api/users/', 'index.php', 'top');
// }

// add_action('init', 'prefix_add_api_endpoints_all_users');

// function prefix_do_api_all_users()
// {

//    $users = get_users();
//    $list = array();
//    $i = 0;
//    foreach ($users as $user) {
//       $list[$i]['id'] = $user->ID;
//       $list[$i]['email'] = $user->user_email;
//       $list[$i]['first_name'] = $user->first_name;
//       $i++;
//    }

//    wp_send_json_success($list);
// }

// add_action('template_redirect', 'prefix_do_api_all_users');
