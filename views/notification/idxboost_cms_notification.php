<?php if ( is_user_logged_in() ) : ?>
    <div class="clidxboost-msg-info">
		Your <strong><?php echo $atts['message']; ?></strong> is currently inactive. 
		<a href="<?php echo esc_url( 'https://www.idxboost.com/support' ); ?>" target="_blank">
			Please contact support to activate it.
		</a>
	</div>
<?php else: ?>
	<script>
        (() => {
            const propertiesSection = document.getElementById('<?php echo $atts['id']; ?>');
            if (propertiesSection) propertiesSection.style.display = 'none';
        })();
    </script>
<?php endif; ?>