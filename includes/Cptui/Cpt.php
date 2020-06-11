<?php
namespace Windzfare\Cptui;

if ( ! defined( 'ABSPATH' ) ) exit;

class Cpt {

  private $textdomain;
  private $windzfare_posts;

    public function __construct( $textdomain ){
        $this->textdomain = $textdomain;
        $this->windzfare_posts = [];
        add_action( 'init', [ $this, 'register' ] );
    }

    public function init( $type, $singular_label, $plural_label, $settings = [] ){
        
        $default_settings = [
            'labels' => [
                'name'                => esc_html__( $plural_label, $this->textdomain ),
                'singular_name'       => esc_html__( $singular_label, $this->textdomain ),
                'add_new_item'        => esc_html__( 'Add New '.$singular_label, $this->textdomain ),
                'edit_item'           => esc_html__( 'Edit '.$singular_label, $this->textdomain ),
                'new_item'            => esc_html__( 'New '.$singular_label, $this->textdomain ),
                'view_item'           => esc_html__( 'View '.$singular_label, $this->textdomain ),
                'search_items'        => esc_html__( 'Search '.$plural_label, $this->textdomain ),
                'not_found'           => esc_html__( 'No '.$plural_label.' found', $this->textdomain ),
                'not_found_in_trash'  => esc_html__( 'No '.$plural_label.' found in trash', $this->textdomain ),
                'parent_item_colon'   => esc_html__( 'Parent '.$singular_label, $this->textdomain ),
                'menu_name'           => esc_html__( $plural_label,$this->textdomain )
            ],
            'public'         => true,
            'has_archive'    => true,
            'menu_icon'      => '',
            'menu_position'  => 20,
            'supports'       => [
                'title',
                'editor',
                'thumbnail'
            ],
            'rewrite' => [
                'slug' => sanitize_title_with_dashes( $plural_label )
            ]
        ];
        $this->windzfare_posts[ $type ] = array_merge( $default_settings, $settings );
    }

    public function register(){
        foreach( $this->windzfare_posts as $key=>$value ) {
            register_post_type( $key, $value );
            flush_rewrite_rules( false );
        }
    }
}