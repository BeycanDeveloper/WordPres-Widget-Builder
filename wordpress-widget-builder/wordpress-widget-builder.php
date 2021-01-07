<?php

class WWB_Widget extends WP_Widget{

    private $variables = array();
    private $title;

    function __construct( $widget_id, $widget_title, $widget_description )
    {
        // Parse fields id
        $this->fields_instance( $this->fields() );

        // Start WP_Widget
        parent::__construct(
            $widget_id,
            $widget_title,
            array( 'description' => $widget_description )
        );

    }

    public function widget( $args, $instance )
    {
        // Widget before
        echo $args['before_widget'];
        // Widget title
        if ( $this->title != null ) {
            if ( ! empty ( $instance[$this->title] ) ) {
                echo $args['before_title'] . $instance[$this->title] . $args['after_title'];
            }
        }
        // Widget content
        ob_start();
        $this->view();
        $view = ob_get_clean();
        foreach ( $this->variables as $key) {
            $variable = '{{'.$key.'}}';
            $view = str_replace( $variable, $instance[$key], $view );
        }
        echo $view;
        // Widget after
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        foreach ( $this->variables as $key ) {
            $instance[$key] = ! empty( $new_instance[$key] ) ? $new_instance[$key] : '';
        }
        return $instance;
    }

    public function form( $instance ) 
    {
        foreach ( $this->fields() as $key ) :
            if ( $key['type'] == "title" ) :
                $key['type'] = 'text';
            endif;
            $this->get_field( $key['type'], $key, $instance );
        endforeach;
    }

    private function get_field( $field, $key, $instance ) 
    {
        extract( array( 'key' => $key, 'instance' => $instance ) );
        include __DIR__ . '/fields/'.$field.'.php';
    }

    private function fields_instance( $fields )
    {
        foreach ( $fields as $key => $field )
        {
            foreach ( $field as $key => $value ) {
                if ( $key == "id" ) {
                    $this->variables[] = $value;
                }
            }
            if ( $field['type'] == "title" ) {
                $this->title = $field['id'];
            }
        }
    }

}