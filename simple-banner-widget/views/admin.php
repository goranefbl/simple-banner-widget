<ul class="goran_ads_clone" style="display:none">
	<li style="margin-bottom:15px;">
		<label><?php _e('Ad Image URL', 'lt-ads-widgets'); ?>:</label>
		<input type="text" name="<?php echo $this->get_field_name( 'ad_img' ); ?>[]" class="widefat" />
		<label><?php _e('Ad Link URL', 'lt-ads-widgets'); ?>:</label>
		<input type="text" name="<?php echo $this->get_field_name( 'ad_link' ); ?>[]" class="widefat" />
		<a href="#" class="goran_remove_ad button"><?php _e('Remove this banner', 'lt-ads-widgets'); ?></a>
	</li>
</ul>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Ads Size:' ); ?></label><br/>
	<select class="widefat goran-ad-size" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name('size'); ?>">
		<option <?php selected($instance['size'],'small'); ?> value="small" ><?php _e('Small (125x125px)', 'lt-ads-widgets'); ?></option>
		<option <?php selected($instance['size'],'square'); ?> value="square" ><?php _e('Square (250x250px)', 'lt-ads-widgets'); ?></option>
		<option <?php selected($instance['size'],'square2'); ?> value="square2" ><?php _e('Square2 (300x250px)', 'lt-ads-widgets'); ?></option>
		<option <?php selected($instance['size'],'full'); ?> value="full" ><?php _e('Full (468x60px)', 'lt-ads-widgets'); ?></option>
		<option <?php selected($instance['size'],'leaderboard'); ?> value="leaderboard" ><?php _e('Leaderboard (728x90px)', 'lt-ads-widgets'); ?></option>
		<option <?php selected($instance['size'],'skyscraper'); ?> value="skyscraper" ><?php _e('Skyscraper (120x600px)', 'lt-ads-widgets'); ?></option>
		<option <?php selected($instance['size'],'custom'); ?> value="custom" ><?php _e('Custom', 'lt-ads-widgets'); ?></option>
	</select>
</p>
<?php 
	$custom_display = $instance['size'] == 'custom' ? 'display:block;' : 'display:none'; 
?>
<p style="<?php echo $custom_display; ?>">
	<?php _e('Width', 'lt-ads-widgets'); ?>: 
	<input id="<?php echo $this->get_field_id( 'ad_width' ); ?>" type="text" name="<?php echo $this->get_field_name( 'ad_width' ); ?>" value="<?php echo absint($instance['ad_width']); ?>" class="small-text" />px
	<br/><?php _e('Height', 'lt-ads-widgets'); ?>:
	<input id="<?php echo $this->get_field_id( 'ad_height' ); ?>" type="text" name="<?php echo $this->get_field_name( 'ad_height' ); ?>" value="<?php echo absint($instance['ad_height']); ?>" class="small-text" />px
</p>

<p>
	<ul class="goran_ad_holder">
		<?php foreach ($ads as $ad) { ?>
		<li style="margin-bottom:15px;">
			<label><?php _e('Ad Image URL', 'lt-ads-widgets'); ?>:</label>
			<input type="text" name="<?php echo $this->get_field_name( 'ad_img' ); ?>[]" value="<?php echo $ad['img']; ?>" class="widefat" />
			<label><?php _e('Ad Link URL', 'lt-ads-widgets'); ?>:</label>
			<input type="text" name="<?php echo $this->get_field_name( 'ad_link' ); ?>[]" value="<?php echo $ad['link']; ?>" class="widefat" />
			<a href="#" class="goran_remove_ad button" style="margin-top:5px;"><?php _e('Remove this banner', 'lt-ads-widgets'); ?></a>
		</li>
		<?php } ?>
	</ul>
	<br/><a href="#" class="goran_add_ad button"><?php _e('Add New', 'lt-ads-widgets'); ?></a>
</p>