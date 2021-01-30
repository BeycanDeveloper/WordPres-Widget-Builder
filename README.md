# WordPress Widget Buildier

Hello friends, I started developing a class, the purpose of this is that while creating the widget, we are constantly switching between both the update, the view section and the form section, right?

Here to prevent this, and also to create html elements automatically, all we have to do is send the html element data array.

If you examine the example below, you can understand better what I mean.

We send an array to create HTML elements and the class does it for us at the back, both the form part and the update, so every job is done within the class.

All we have to do is send this array and make an html design in the view function and get the data we want with the ids we set while sending the array, so it will be easier to create the html side.

I will try to improve it as I find a gap. I think it will provide a convenience for you. I am waiting for your contributions.

```php
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

    public function fields()
    {
        return array(
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
    }

    public function view() 
    {
        ?>
        {{description}}
        <?php
    }
}
add_action( 'widgets_init', function(){
    register_widget( 'test1' );
});
```
