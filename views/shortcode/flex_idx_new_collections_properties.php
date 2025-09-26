<?php 
if (false === $GLOBALS['flex_idx_lead']): ?>
<style>
  .flex-not-logged-in-msg {}
  .flex-not-logged-in-msg p {
  font-size: 50px;
  margin: 50px 0;
  text-align: center;
  }
  .flex-not-logged-in-msg p a {
  background: #0072ac;
  color: #fff;
  text-decoration: none;
  padding: 10px;
  border-radius: 5px;
  text-transform: uppercase;
  font-size: 40px;
  }
</style>
<div class="gwr flex-not-logged-in-msg">
  <p><?php echo __("You need to", IDXBOOST_DOMAIN_THEME_LANG); ?> <a class="flex-login-link" role="button"><?php echo __("login", IDXBOOST_DOMAIN_THEME_LANG); ?></a> <?php echo __("to view this page.", IDXBOOST_DOMAIN_THEME_LANG); ?></p>
</div>
<?php else: ?>
<script>
	// window.idxtoken = "<?php echo $access_token_service; ?>";
	window.idx_collections_settings = {
		client_type: "lead",
		collections_path: "collections",
		detail_path: "collection"
	}
</script>

<div id="collections" class="<?php echo $flex_idx_lead ?>"></div>

<?php endif; ?>