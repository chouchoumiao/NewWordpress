<?php

//******************************************************************************************
//wuiayu 20160305
//给爆料者/上传者 开放媒体库功能
// if ( current_user_can('contributor') && !current_user_can('upload_files') )
//   add_action('admin_init', 'allow_contributor_uploads');

// function allow_contributor_uploads() {
//   $contributor = get_role('contributor');
//   $contributor->add_cap('upload_files');
// }
//给资源库添加分类
function ludou_add_categories_to_attachments() {
   register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'ludou_add_categories_to_attachments' );
// //禁用页面的评论功能
// function disable_page_comments( $posts ) {
//   if ( is_page()) {
//     $posts[0]->comment_status = 'disabled';
//     $posts[0]->ping_status = 'disabled';
//   }
//   return $posts;
// }
// add_filter( 'the_posts', 'disable_page_comments' );

// //爆料者只能看到自己的文章，其他可以编辑其他人文章的具体看到自己部门所有文章的功能设置 20160409
// function wpjam_parse_query_useronly( $wp_query ) {
//     if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
//         if ( !current_user_can( 'edit_others_posts' ) ) {
//             global $current_user;
//             $wp_query->set( 'author', $current_user->id );
//         }
//     }
// }
// add_filter('parse_query', 'wpjam_parse_query_useronly' );


// add_filter('manage_posts_columns', 'v7v3_attachment_count', 5);
// add_action('manage_posts_custom_column','v7v3_columns_attachment_count', 5, 2);

// function v7v3_attachment_count($defaults){
//     $defaults['wps_post_attachments'] = __('附件数量');
//     return $defaults;
// }
// function v7v3_columns_attachment_count($column_name, $id){
//     if($column_name === 'wps_post_attachments'){
//     $attachments = get_children(array('post_parent'=>$id));
//     $count = count($attachments);
//     if($count !=0){echo $count;}
//     }
// }


//在文章编辑页面的[添加媒体]只显示用户自己上传的文件 20160409
function my_upload_media( $wp_query_obj ) {
  global $current_user, $pagenow;
  if( !is_a( $current_user, 'WP_User') )
    return;
  if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
    return;
  if( !current_user_can( 'edit_others_posts' ) )
    $wp_query_obj->set('author', $current_user->ID );
  return;
}
add_action('pre_get_posts','my_upload_media');
 
// //在[媒体库]只显示用户上传的文件 20160409 无用 待删除
// function my_media_library( $wp_query ) {
//     if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false ) {
//         if ( !current_user_can( 'edit_others_posts' ) ) {
//             global $current_user;
//             $wp_query->set( 'author', $current_user->id );
//         }
//     }
// }
// add_filter('parse_query', 'my_media_library' );

//未登录状态查看前台首页时候，显示登录画面 20160410
function liveme_if_login(){
    if ( !is_user_logged_in() ){
        auth_redirect();
    }
}

// //屏蔽后台左上LOGO
// function annointed_admin_bar_remove() {
//   global $wp_admin_bar;
//   /* Remove their stuff */
//   $wp_admin_bar->remove_menu('wp-logo');
// }
// add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);

// //删除wordpress网站head 中的无用代码
// remove_action('wp_head', 'rsd_link');
// remove_action('wp_head', 'wlwmanifest_link');
// remove_action('wp_head', 'wp_generator');
// remove_action('wp_head', 'start_post_rel_link');
// remove_action('wp_head', 'index_rel_link');
// remove_action('wp_head', 'adjacent_posts_rel_link');


// //Add dashboard widgets
// if ( ! function_exists( 'add_dashboard_widgets' ) ) :
//   function welcome_dashboard_widget_function() {
//     echo "<ul><li><a href='post-new.php'>发布内容</a></li><li><a href='edit.php'>修改内容</a></li></ul>";
//   }
//   function add_dashboard_widgets() {
//     wp_add_dashboard_widget('welcome_dashboard_widget', '常规任务', 'welcome_dashboard_widget_function');
//   }
//   add_action('wp_dashboard_setup', 'add_dashboard_widgets' );
// endif;

// //隐藏版本更新
// add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );

// //屏蔽ordPress后台“显示选项”和“帮助”选项卡
// function remove_screen_options(){ return false;}
// add_filter('screen_options_show_screen', 'remove_screen_options');
// add_filter( 'contextual_help', 'wpse50723_remove_help', 999, 3 );
// function wpse50723_remove_help($old_help, $screen_id, $screen){
//   $screen->remove_help_tabs();
//   return $old_help;
// }


// //remove menus
// function remove_menus() {
//   global $menu;
//   $restricted = array(__('Dashboard'),  __('Links'), __('Pages'), __('Comments'));
//   end ($menu);
//   while (prev($menu)){
//     $value = explode(' ',$menu[key($menu)][0]);
//     if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
//   }
// }
// if ( is_admin() ) {
//   add_action('admin_menu', 'remove_menus');
// }

// function remove_submenu() {
// // 删除”设置”下面的子菜单”隐私”
//   remove_submenu_page('options-general.php', 'options-privacy.php');
// // 删除”外观”下面的子菜单”编辑”
//   remove_submenu_page('themes.php', 'theme-editor.php');
// }
// if (is_admin()){
// //删除子菜单
//   add_action('admin_init','remove_submenu');
// }

// //屏蔽后台更新
// function wp_hide_nag() {
//   remove_action( 'admin_notices', 'update_nag', 3 );
// }
// add_action('admin_menu','wp_hide_nag');

//******************************************************************************************

/**
 * Theme-Functions 主要函数
 *
 * @package 	  ZanBlog
 * @subpackage  Include
 * @since 		  3.0.0
 * @author      YEAHZAN
 */

// 注册加载JS & CSS文件
add_action( 'wp_enqueue_scripts', 'zan_register_scripts' );

// 设定后台特色图像
add_theme_support( 'post-thumbnails' );

// 开启链接管理（包括友情链接）
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

// 去除WordPress版本显示
add_filter( 'the_generator', 'remove_version' );

// 禁用谷歌字体链接
add_filter( 'gettext_with_context', 'disable_open_sans', 888, 4 );

// 隐藏admin bar
add_filter( 'show_admin_bar', '__return_false' );

/**
 * 注册CSS & JS文件
 *
 * @since  2.0.0
 * @return void
 */
function zan_register_scripts() {
	// 注册bootstrap.min.js
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/ui/js/bootstrap.min.js', 'jquery', '3.1.1', true );

	// 注册jquery.flexslider.js
	wp_register_script( 'flexslider', get_template_directory_uri() . '/ui/flexslider/jquery.flexslider.js', 'jquery', '3.0.0', true );

	// 注册jquery.validate.js
	wp_register_script( 'validate', get_template_directory_uri() . '/ui/js/jquery.validate.js', 'jquery', '3.0.0', true );

  // 注册audiojs.min.js
  wp_register_script( 'audiojs', get_template_directory_uri() . '/ui/audiojs/audio.min.js', 'jquery', '3.0.0', true );

  // 注册shine.min.js
  wp_register_script( 'shine', get_template_directory_uri() . '/ui/js/shine.min.js', 'jquery', '3.0.0', true );

	// 注册zan.js
	wp_register_script( 'zan', get_template_directory_uri() . '/ui/js/zan.js', 'jquery', '3.0.0', true );

	// 注册用户自定义custom.js
	wp_register_script( 'custom', get_template_directory_uri() . '/ui/js/custom.js', 'jquery', '3.0.0', true );

	// 注册bootstrap.min.css
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/ui/css/bootstrap.min.css', '', '3.1.1' );

	// 注册font-awesome.min.css
	wp_register_style( 'fontawesome', get_template_directory_uri() . '/ui/font-awesome/css/font-awesome.min.css', '', '4.0.1' );

	// 注册flexslider.css
	wp_register_style( 'flexslider', get_template_directory_uri() . '/ui/flexslider/flexslider.css', '', '2.0' );

	// 注册zan.css
	wp_register_style( 'zan', get_template_directory_uri() . '/ui/css/zan.css', '', '3.0.0' );

	// 注册用户自定义custom.css
	wp_register_style( 'custom', get_template_directory_uri() . '/ui/css/custom.css', '', '3.0.0' );

	// 调用加载函数
	zan_enqueue_scripts();
}

/**
 * 加载CSS & JS文件
 *
 * @since  3.0.0
 * @return void
 */
function zan_enqueue_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap' );
  wp_enqueue_script( 'flexslider' );
  wp_enqueue_script( 'validate' );
  wp_enqueue_script( 'audiojs' );
  wp_enqueue_script( 'shine' );
	wp_enqueue_script( 'zan' );
	wp_enqueue_script( 'custom' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'fontawesome' );
  wp_enqueue_style( 'flexslider' );
	wp_enqueue_style( 'zan' );
	wp_enqueue_style( 'custom' );
}

/**
 * 获取最热文章
 *
 * @since 3.0.0
 * @return array [最热文章数组]
 */
function zan_get_hotest_posts($num) {
	$args = array(
		'posts_per_page'   => $num,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'comment_count',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true
	);

	return get_posts($args);
}

/**
 * 获取最新文章
 *
 * @since 3.0.0
 * @return array [最新文章数组]
 */
function zan_get_latest_posts($num) {
  $args = array(
    'posts_per_page'   => $num,
    'offset'           => 0,
    'category'         => '',
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'include'          => '',
    'exclude'          => '',
    'meta_key'         => '',
    'meta_value'       => '',
    'post_type'        => 'post',
    'post_mime_type'   => '',
    'post_parent'      => '',
    'post_status'      => 'publish',
    'suppress_filters' => true
  );

  return get_posts($args);
}

/**
 * 获取最新评论（排除作者评论）
 *
 * @since 3.0.0
 * @return array [最新评论数组]
 */
function zan_get_latest_comments($num) {
	// $args = array(
	// 	'author_email' => '',
	// 	'ID' => '',
	// 	'karma' => '',
	// 	'number' => $num,
	// 	'offset' => '',
	// 	'orderby' => 'comment_date',
	// 	'order' => 'DESC',
	// 	'parent' => '',
	// 	'post_id' => 0,
	// 	'post_author' => '',
	// 	'post_name' => '',
	// 	'post_parent' => '',
	// 	'post_status' => 'publish',
	// 	'post_type' => '',
	// 	'status' => 'approve',
	// 	'type' => 'comment',
	// 	'user_id' => '',
	// 	'search' => '',
	// 	'count' => false,
	// 	'meta_key' => '',
	// 	'meta_value' => '',
	// 	'meta_query' => '',
	// ); 

	// return get_comments($args);
}

/**
 * 获取文章分类列表
 *
 * @since 3.0.0
 * @return array [文章分类列表]
 */
function zan_get_posts_category($exclude) {
  $args = array(
    'show_option_all'    => '',
    'orderby'            => 'name',
    'order'              => 'ASC',
    'style'              => 'none',
    'show_count'         => 0,
    'hide_empty'         => 1,
    'use_desc_for_title' => 1,
    'child_of'           => 0,
    'feed'               => '',
    'feed_type'          => '',
    'feed_image'         => '',
    'exclude'            => $exclude,
    'exclude_tree'       => '',
    'include'            => '',
    'hierarchical'       => 1,
    'title_li'           => __( 'Categories' ),
    'show_option_none'   => '',
    'number'             => null,
    'echo'               => 1,
    'depth'              => 1,
    'current_category'   => 0,
    'pad_counts'         => 0,
    'taxonomy'           => 'category',
    'walker'             => null
  );

  return wp_list_categories($args);
}

/**
 * 获取评论列表
 *
 * @since 3.0.0
 * @return array [评论列表]
 */
function zan_get_commments_list($size) {
	// $args = array(
	// 	'walker'            => null,
	// 	'max_depth'         => '',
	// 	'style'             => 'ol',
	// 	'callback'          => null,
	// 	'end-callback'      => null,
	// 	'type'              => 'all',
	// 	'reply_text'        => '回复',
	// 	'page'              => '',
	// 	'avatar_size'       => $size,
	// 	'reverse_top_level' => null,
	// 	'reverse_children'  => '',
	// 	'format'            => 'html5',
	// 	'short_ping'        => false,
 //    'echo'              => true 
	// );

 //  return wp_list_comments($args);
}

/**
 * 获取评论分页
 *
 * @since 3.0.0
 * @return array [评论分页]
 */
function zan_comments_pagination() {
  // $args = array(
  //   'prev_text'    => __( '«' ),
  //   'next_text'    => __( '»' )
  // );

  // return paginate_comments_links($args);
}

/**
 * 评论表单
 *
 * @since 3.0.0
 * @return array [自定义表单]
 */
function zan_comments_form() {
  // $args = array(
  //   'title_reply'          => '<i class="fa fa-pencil"></i> 欢迎留言',
  //   'title_reply_to'       => __( '回复 %s' ),
  //   'cancel_reply_link'    => __( '取消' ),
  //   'fields'               => array(
  //                       'author' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" name="author" id="author" placeholder="* 昵称"></div>',
  //                       'email'  => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope-o"></i></span><input type="text" name="email" id="email" placeholder="* 邮箱"></div>',
  //                       'url'    => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span><input type="text" name="url" id="url" placeholder="网站"></div>'
  //   ),
  //   'comment_field'        => '<textarea id="comment" placeholder="赶快发表你的见解吧！" name="comment" cols="45" rows="8" aria-required="true"></textarea>',
  //   'comment_notes_before' => '<div id="commentform-error" class="alert hidden"></div>'
  // );
  // return comment_form($args);
}

/**
 * 可支持分类的分页功能
 *
 * @since 2.0.0
 * @return void
 */
if ( !function_exists( 'paginate' ) ):
  function paginate( $args = null ) {
    $range_gap = 3;         
    if (get_option( 'zan_paginate_num' ) != '' && intval( get_option( 'zan_paginate_num' ) ) > 0) {
      $range_gap = intval( get_option( 'zan_paginate_num' ) );
    }        
    $defaults = array( 'page'=>null, 'pages'=>null, 'range'=>$range_gap, 'gap'=>$range_gap, 'anchor'=>1, 'echo'=>1 );        
    $r = wp_parse_args( $args, $defaults );
    extract($r, EXTR_SKIP);       
    if ( !$page && !$pages ) {
      global $wp_query;           
      $page = get_query_var( 'paged' );
      $page = ! empty( $page ) ? intval( $page ) : 1;            
      $posts_per_page = intval( get_query_var( 'posts_per_page' ) );
      $pages = intval( ceil( $wp_query->found_posts / $posts_per_page ) );
    }
    
    $output = "";
    if ( $pages > 1 ) {
      $ellipsis = "<li><a>...</a></li>";            
      $min_links = $range * 2 + 1;
      $block_min = min( $page - $range, $pages - $min_links );
      $block_high = max( $page + $range, $min_links );
      $left_gap = ( ( $block_min - $anchor - $gap ) > 0 ) ? true : false;
      $right_gap = ( ( $block_high + $anchor + $gap ) < $pages ) ? true : false;            
      if ( $left_gap && !$right_gap ) {
        $output .= sprintf( '%s%s%s', paginate_loop( 1, $anchor ), $ellipsis, paginate_loop( $block_min, $pages, $page ) );
      } else if ( $left_gap && $right_gap ) {
        $output .= sprintf( '%s%s%s%s%s', paginate_loop( 1, $anchor ), $ellipsis, paginate_loop( $block_min, $block_high, $page ), $ellipsis, paginate_loop( ( $pages - $anchor + 1 ), $pages ) );
      } else if ( $right_gap && !$left_gap ) {
        $output .= sprintf( '%s%s%s', paginate_loop( 1, $block_high, $page ), $ellipsis, paginate_loop( ( $pages - $anchor + 1 ), $pages ) );
      } else {
        $output .= paginate_loop( 1, $pages, $page );
      }
    }        
    if ( $echo ) {
      echo $output;
    }       
    return $output;
  }
endif;
if ( !function_exists( 'paginate_loop' ) ):
  function paginate_loop( $start, $max, $page = 0 ) {
    $output = "";
    for ( $i = $start; $i <= $max; $i++ ) {
      $output .= ( $page === intval( $i ) ) ? "<li class='active'><a href='javascript:void(0)' class='inactive' >$i</a></li>" : "<li><a href='".get_pagenum_link($i)."'>$i</a></li>";
    }
    return $output;
  }
endif;
if ( !function_exists( 'show_paginate' ) ):
  function show_paginate() {
?>
<div id="zan-page" class="clearfix">
	<ul class="pagination pagination-zan pull-right">
	  <?php
		  echo "<li>";
		  previous_posts_link( __( '&laquo;', '' ), 0 );
		  echo "</li>";
		  if ( function_exists( "paginate" ) )  paginate();

		  echo "<li>";
		  next_posts_link( __( '&raquo;', '' ), 0);
		  echo "</li>";
		  wp_link_pages();
	  ?>
	</ul>
</div>
<?php
}
endif;

/**
 * 禁用谷歌字体链接
 *
 * @since 3.0.0
 * @return string
 */
function disable_open_sans($translations, $text, $context, $domain) {
    if( 'Open Sans font: on or off' == $context && 'on' == $text ) {
        $translations = 'off';
    }
    return $translations;
}

/**
 * 去除WordPress版本显示
 *
 * @since 3.0.0
 * @return string
 */
function remove_version() {
	return '';
}