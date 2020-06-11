<?php
namespace Windzfare\Cptui;

if ( ! defined( 'ABSPATH' ) ) exit;

class CptTax {
    protected $textdomain;
    protected $taxonomies;

    public function __construct ( $textdomain ){
        $this->textdomain = $textdomain;
        $this->taxonomies = [];
        add_action( 'init', [ $this, 'register' ] );
    }

    public function init( $type, $singular_label, $plural_label, $post_types, $manage_categories = 'manage_categories', $settings = [] ){
       
        $default_settings = [
            'labels' => [
                'name' => esc_html__( $plural_label, $this->textdomain ),
                'singular_name'          => esc_html__( $singular_label, $this->textdomain ),
                'add_new_item'           => esc_html__( 'New ' . $singular_label . ' Name', $this->textdomain ),
                'new_item_name'          => esc_html__( 'Add New ' . $singular_label, $this->textdomain ),
                'edit_item'              => esc_html__( 'Edit ' . $singular_label, $this->textdomain ),
                'update_item'            => esc_html__( 'Update ' . $singular_label, $this->textdomain ),
                'add_or_remove_items'    => esc_html__( 'Add or remove '.strtolower( $plural_label ), $this->textdomain ),
                'search_items'           => esc_html__( 'Search ' . $plural_label, $this->textdomain ),
                'popular_items'          => esc_html__( 'Popular ' . $plural_label, $this->textdomain ),
                'all_items'              => esc_html__( 'All ' . $plural_label, $this->textdomain ),
                'parent_item'            => esc_html__( 'Parent ' . $singular_label, $this->textdomain ),
                'choose_from_most_used'  => esc_html__( 'Choose from the most used '.strtolower( $plural_label ), $this->textdomain ),
                'parent_item_colon'      => esc_html__( 'Parent ' . $singular_label, $this->textdomain ),
                'menu_name'              => esc_html__( $singular_label, $this->textdomain ),
            ],
            'capabilities'=> [
                'manage_terms' => $manage_categories,
                'edit_terms'   => $manage_categories,
                'delete_terms' => $manage_categories,
                'assign_terms' => 'edit_posts'
            ],
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => false,
            'show_ui'           => true,
            'rewrite' => [
                'slug' => sanitize_title_with_dashes( $plural_label )
            ]
        ];

        $this->taxonomies[ $type ]['post_types'] = $post_types;
        $this->taxonomies[ $type ][ 'args'] = array_merge( $default_settings, $settings );       
    }

    public function register(){
        foreach( $this->taxonomies as $key => $value ) {
            register_taxonomy( $key, $value['post_types'], $value['args'] );
        }
    }
}