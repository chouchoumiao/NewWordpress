<?php
/**
 * Custom-Dashboard 自定义仪表盘
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */

/**
 * 移除仪表盘内容
 */
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);    //WordPress China 博客
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);  //其它WordPress新闻
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);  //近期草稿
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);//链入链接
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);     //保留概况 wujiayu 20160306
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);   //插件
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); //去除评论 wujiayu 20160306
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);  //去除快速发布 wujiayu 20160306

    global $menu;
    $restricted = array(__('Dashboard'),  __('Links'), __('Pages'),  __('Tools'),  __('Comments'));
    end ($menu);
    while (prev($menu)){
        $value = explode(' ',$menu[key($menu)][0]);
        if(strpos($value[0], '<') === FALSE) {
            if(in_array($value[0] != NULL ? $value[0]:"" , $restricted)){
                unset($menu[key($menu)]);
            }
        }
        else {
            $value2 = explode('<', $value[0]);
            if(in_array($value2[0] != NULL ? $value2[0]:"" , $restricted)){
                unset($menu[key($menu)]);
            }
        }
    }

}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

function remove_some_wp_widgets(){
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init','remove_some_wp_widgets', 1);


//删除子菜单
//remove submenus
function remove_submenus() {
    global $submenu;
    unset($submenu['index.php'][10]); // Removes 'Updates'.
    unset($submenu['themes.php'][5]); // Removes 'Themes'.
    unset($submenu['options-general.php'][15]); // Removes 'Writing'.
    unset($submenu['options-general.php'][25]); // Removes 'Discussion'.
    unset($submenu['options-general.php'][40]); // Removes 'Permalinks'.
    unset($submenu['edit.php'][16]); // Removes 'Tags'.
}
add_action('admin_menu', 'remove_submenus');