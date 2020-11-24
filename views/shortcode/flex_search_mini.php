<div class="ib-mini-search-wrapper">
  <div class="ib-mini-search-col">
    <h4><?php echo __("Search Condos", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
    <form id="ib-mini-search-condos" method="post">
      <div>
        <input type="radio" name="rental" id="ib-mini-search-c-rental_0" checked value="0">
        <label for="ib-mini-search-c-rental_0"><?php echo __("For Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
      </div>
      <div>
        <input type="radio" name="rental" id="ib-mini-search-c-rental_1" value="1">
        <label for="ib-mini-search-c-rental_1"><?php echo __("For Rent", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
      </div>
      <div>
        <select name="city">
          <option value="--" selected><?php echo __("Search by City", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          <?php foreach ($flex_idx_info['search']['cities'] as $city): ?>
          <option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <button type="submit"><?php echo __("Search", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      </div>
    </form>
  </div>
  <div class="ib-mini-search-col">
    <h4><?php echo __("Search Homes", IDXBOOST_DOMAIN_THEME_LANG); ?></h4>
    <form id="ib-mini-search-homes" method="post">
      <div>
        <input type="radio" name="rental" id="ib-mini-search-h-rental_0" checked value="0">
        <label for="ib-mini-search-h-rental_0"><?php echo __("For Sale", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
      </div>
      <div>
        <input type="radio" name="rental" id="ib-mini-search-h-rental_1" value="1">
        <label for="ib-mini-search-h-rental_1"><?php echo __("For Rent", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
      </div>
      <div>
        <select name="city">
          <option value="--" selected><?php echo __("Search by City", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
          <?php foreach ($flex_idx_info['search']['cities'] as $city): ?>
          <option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <button type="submit"><?php echo __("Search", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
      </div>
    </form>
  </div>
</div>
