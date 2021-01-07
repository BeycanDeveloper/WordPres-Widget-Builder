<p>
    <label for="<?php echo esc_attr( $this->get_field_id( $key['id'] ) ); ?>">
            <?php echo $key['title']; ?>
    </label>
    <textarea class="<?php echo isset( $key['class'] ) ? $key['class'] : null; ?>" id="<?php echo esc_attr( $this->get_field_id( $key['id'] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $key['id'] ) ); ?>" cols="30" rows="10"><?php echo esc_html( isset( $instance[$key['id']] ) ? $instance[$key['id']] : null ); ?></textarea>
</p>