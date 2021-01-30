<?php

class WWB_Widget extends WP_Widget
{

    // Our placeholders
    private $placeholders = array();

    // Widget front-end header
    private $title;

    /**
     * @param string $widget_id Unique widget id
     * @param string $widget_title Title to appear in the list
     * @param string $widget_description Description to appear in the list
     * 
     * @return void
     */
    function __construct( $widget_id, $widget_title, $widget_description )
    {
        // Parse fields id so placeholder
        $this->prepare_placeholders( $this->fields() );

        // Start WP_Widget
        parent::__construct(
            $widget_id,
            $widget_title,
            array( 'description' => $widget_description )
        );

    }

    /**
     * @param array $args Data the widget space sends to us
     * @param array $instance The variable where the form data is kept according to the fields from the subclass
     * 
     * @return void
     */
    public function widget( $args, $instance )
    {
        // Widget before
        echo $args['before_widget'];

        // Widget title
        if ( $this->title != null ) :
            if ( ! empty ( $instance[$this->title] ) ) :
                echo $args['before_title'] . $instance[$this->title] . $args['after_title'];
            endif;
        endif;

        // Widget content
        ob_start();
        $this->view();
        $view = ob_get_clean();
        
        // Replace data with placeholders and hit the screen.
        echo $this->placeholder_replacer( $view, $instance );

        // Widget after
        echo $args['after_widget'];

    }

    /**
     * @param array $new_instance New data submitted from the form
     * @param array $old_instance 
     * We update old data with new ones, our old data are our new data is happening :)
     * 
     * @return array new instance so data
     */
    public function update( $new_instance, $old_instance )
    {
        foreach ( $this->placeholders as $key ) :
            $old_instance[$key] = ! empty( $new_instance[$key] ) ? $new_instance[$key] : null;
        endforeach;
        return $old_instance;
    }

    /**
     * @param array $instance
     * "instance" shaped according to the data from the field and subclass where we 
     * created the form that will appear in the wordpress components section.
     * 
     * @return void
     */
    public function form( $instance ) 
    {
        foreach ( $this->fields() as $key ) :
            if ( $key['type'] == "title" ) :
                $key['type'] = 'text';
            endif;
            $this->get_field( $key['type'], $key, $instance );
        endforeach;
    }

    /**
     * According to the data from the subclass, we bring our ready html fields from our fields folder.
     * 
     * @param string $field HTML field name
     * @param array $key Wigdet infos
     * @param array $instance our data
     * 
     * @see $this->form method
     * 
     * @return void
     */
    private function get_field( $field, $key, $instance ) 
    {
        extract( array( 'key' => $key, 'instance' => $instance ) );
        include __DIR__ . '/fields/'.$field.'.php';
    }

    /**
     * We prepare our placeholders according to the "fields" data from the subclass.
     * @param array $fields Data string submitted by the user
     * 
     * @see $this->__construct
     * 
     * @return void
     */
    private function prepare_placeholders( $fields )
    {
        foreach ( $fields as $key => $field ) :

            foreach ( $field as $key => $value ) :
                if ( $key == "id" ) :
                    $this->placeholders[$value] = $value;
                endif;
            endforeach;

            if ( $field['type'] == "title" ) :
                $this->title = $field['id'];
            endif;

        endforeach;
    }

    /**
     * Replace placeholders with real data in the "view" method sent from the subclass.
     * @param string $view HTML Template
     * @param array $data Our data
     * 
     * @return string
     */
    private function placeholder_replacer( $view, $data ) 
    { 
        return preg_replace_callback( '~\{\{(.*?)}}~', function ( $m ) use ( $data ) {
            return isset( $data[ trim( $m[1] ) ] ) ? $data[ trim( $m[1] ) ] : $m[0]; 
        }, $view );
    }

}