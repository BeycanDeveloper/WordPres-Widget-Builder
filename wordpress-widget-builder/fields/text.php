<p>
    <label for="<?php echo esc_attr( $this->get_field_id( $key['id'] ) ); ?>">
        <?php echo $key['title']; ?>
    </label>
    <input type="text" class="<?php echo isset( $key['class'] ) ? $key['class'] : null; ?>" id="<?php echo esc_attr( $this->get_field_id( $key['id'] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key['id'] ) ); ?>" value="<?php echo esc_attr( isset( $instance[$key['id']] ) ? $instance[$key['id']] : null ); ?>">
</p>