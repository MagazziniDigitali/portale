<?php
  add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );

  function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
  }

  //ADD SIDEBAR MENU TO WIDGETS
  function register_custom_widget_area() {
    register_sidebar(
      array(
        'id' => 'sidebar-menu',
        'name' => esc_html__( 'Menu laterali', 'theme-domain' ),
        'description' => esc_html__( 'Widget area per inserire i menu laterali', 'theme-domain' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title-holder"><h6 class="widget-title">',
        'after_title' => '</h6></div>'
      )
    );
  }
  add_action( 'widgets_init', 'register_custom_widget_area' );