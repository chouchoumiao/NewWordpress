<?php
/**
 * 404 错误页面
 *
 * @package    YEAHZAN
 * @subpackage ZanBlog
 * @since      ZanBlog 3.0.0
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><html <?php language_attributes(); ?>><![endif]-->
<html <?php language_attributes(); ?>>
<head>
<title>
  <?php if ( is_home() ) { ?><?php bloginfo( 'name' ) ?> | <?php bloginfo( 'description' ); ?><?php } ?>
  <?php if ( is_search() ) { ?>Search Results | <?php bloginfo( 'name' ); ?><?php } ?>
  <?php if ( is_author() ) { ?>Author Archives | <?php bloginfo( 'name' ); ?><?php } ?>
  <?php if ( is_single() ) { ?><?php wp_title(''); ?> | <?php bloginfo( 'name' ); ?><?php } ?>
  <?php if ( is_page() ) { ?><?php wp_title(''); ?> | <?php bloginfo( 'name' ); ?><?php } ?>
  <?php if ( is_category() ) { ?><?php single_cat_title(); ?> | <?php bloginfo( 'name' ); ?><?php } ?>
  <?php if ( is_month() ) { ?><?php the_time( 'F' ); ?> | <?php bloginfo( 'name' ); ?><?php } ?>
  <?php if ( function_exists( 'is_tag' ) ) { if ( is_tag() ) { ?><?php bloginfo( 'name' ); ?> | Tag Archive | <?php single_tag_title( "", true ); } } ?>
</title> 
<?php
  if ( is_home() ) {
    $description = get_option( 'zan_description' );
    $keywords = get_option( 'zan_keywords' );

  } elseif ( is_single() ) {
    if ( $post->post_excerpt ) {
      $description  = $post->post_excerpt;
    } else {
      if( preg_match('/<p>(.*)<\/p>/iU',trim( strip_tags( $post->post_content,"<p>" ) ), $result ) ) {
        $post_content = $result['1'];
      } else {
        $post_content_r = explode("\n",trim( strip_tags( $post->post_content ) ) );
        $post_content = $post_content_r['0'];
      }
      $description = substr( $post_content, 0, 220 ); 
    }
    $keywords = "";
    $tags = wp_get_post_tags( $post->ID );
    foreach ($tags as $tag ) {
       $keywords = $keywords . $tag->name . ",";
    }
  }
?>
<meta charset="utf-8">
<meta content="<?php echo trim( $description ); ?>" name="description"/>
<meta content="<?php echo rtrim( $keywords,',' ); ?>" name="keywords"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
<?php wp_head(); ?>
<!--[if lt IE 9]>
  <script src="<?php echo get_template_directory_uri(); ?>/ui/js/modernizr.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/ui/js/respond.min.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/ui/js/html5shiv.js"></script>
<![endif]-->
</head>
<body class="error-body">
  <nav class="navbar navbar-inverse">
    <div class="container clearfix">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">下拉框</span>
        <span class="fa fa-reorder fa-lg"></span>
      </button>
      <div class="navbar-collapse collapse">
        <?php
          $defaults = array(
            'container' => '',
            'menu_class' => 'nav navbar-nav',
            'walker' => new Zan_Nav_Menu('')
          );
          wp_nav_menu( $defaults );
        ?>
      </div>
    </div>
  </nav>
  <div id="error-page">404</div>
  <div id="home-link"><a class="btn btn-lg btn-zan-solid-iw" href="http://blog.zanwp.com">返回网站首页</a></div>
  <?php wp_footer(); ?>
  <script type="text/javascript">
  var config = new shinejs.Config({
    numSteps: 4,
    opacity: 0.3,
    shadowRGB: new shinejs.Color(10, 10, 10)
  });
  var shine = new Shine(document.getElementById('error-page'), config);

  function handleMouseMove(event) {
    shine.light.position.x = event.clientX;
    shine.light.position.y = event.clientY;
    shine.draw();
  }

  window.addEventListener('mousemove', handleMouseMove, false);
  </script>
</body>
</html>