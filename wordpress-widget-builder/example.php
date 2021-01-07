<?php

require_once __DIR__ . '/wordpress-widget-builder.php';

class test1 extends WWB_Widget 
{
    private $widget_id = "test1";
    private $widget_title = "#Test widget 1";
    private $widget_description = "Test widget 1";

    function __construct()
    {
        parent::__construct(
            $this->widget_id,
            $this->widget_title,
            $this->widget_description
        );
    }
    // Widget fields
    public function fields()
    {
        $fields = array(
            array(
                'id' => 'title',
                'type' => 'title',
                'title' => 'Title:',
				'class' => 'widefat'
			),
            array(
				'id' => 'description',
				'type' => 'textarea',
				'title' => 'Description:',
				'class' => 'widefat'
			)
        );

        // Return fields
        return $fields;
    }

    // The html field that will appear in the front end.
    public function view() 
    {
        ?>
        {{description}}
        <?php
    }
}

class test2 extends WWB_Widget 
{
    private $widget_id = "test2";
    private $widget_title = "#Test widget 2";
    private $widget_description = "Test widget 2";

    function __construct()
    {
        parent::__construct(
            $this->widget_id,
            $this->widget_title,
            $this->widget_description
        );
    }
    
    // Widget fields
    public function fields()
    {
        $fields = array(
            array(
                'id' => 'title',
                'type' => 'title',
                'title' => 'Title:',
				'class' => 'widefat'
			),
            array(
				'id' => 'your_name',
				'type' => 'text',
				'title' => 'Your name:',
				'class' => 'widefat'
            ),
            array(
				'id' => 'test',
				'type' => 'text',
				'title' => 'Your name:',
				'class' => 'widefat'
			)
        );

        // Return fields
        return $fields;
    }

    // The html field that will appear in the front end.
    public function view() 
    {
        ?>
        {{your_name}} {{test}}
        <?php
    }

}
add_action( 'widgets_init', function(){
    register_widget( 'test1' );
    register_widget( 'test2' );
});