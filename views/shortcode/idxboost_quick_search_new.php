      <div class="wp-quick-search animated">
        <div class="in-quick-search">
          <div class="group-flex2">
            <div class="col">
              <h2><?php echo __("Condo quick search", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
                <div class="row-sel">
                  <select name="cbo_building_top" id="cbo_building_top">
                    <option value="--"><?php echo __("Top 100 Buildings", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <option value="--"><?php echo __("All Buildings", IDXBOOST_DOMAIN_THEME_LANG); ?></option> 
                    <?php foreach ($list_top_building as $building): ?>
                    <option value="<?php echo get_site_url().'/'.$path_building.'/'.$building["post_name"]; ?>"><?php echo $building["post_title"]; ?></option>
                    <?php endforeach; ?>                                                                              
                  </select>
                </div>
                <div class="row-sel">
                  <select name="cbo_filter_name" id="cbo_filter_name">
                    <option value="--"><?php echo __("All Buildings", IDXBOOST_DOMAIN_THEME_LANG); ?></option> 
                    <?php foreach ($loop_building as $building): ?>
                    <option value="<?php echo get_site_url().'/'.$path_building.'/'.$building["post_name"]; ?>"><?php echo $building["post_title"]; ?></option>
                    <?php endforeach; ?>                                                          
                  </select>
                </div>
                <div class="row-sel">
                  <select name="cbo_filter_by_area" id="cbo_filter_by_area2">
                    <option value="--"><?php echo __("Buildings By Area", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <?php foreach ($flex_idx_info['search']['cities'] as $city): ?>
                    <option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
                    <?php endforeach; ?>                                      
                  </select>
                </div>
            </div>
            <div class="col">
              <h2><?php echo __("Search for homes", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
              <form id="ib-mini-search-homes" method="post">
                <div class="tabs-for-sale group-flex2">
                  <div>
                    <input type="radio" name="rental" value="0" id="c_sale" checked="">
                    <label for="c_sale" class="tab-home-sale  "><?php echo __("For sale", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </div>
                  <div>
                    <input type="radio" name="rental" value="1" id="c_rent">
                    <label for="c_rent" class="tab-home-rent"><?php echo __("for rent", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </div>
                  

                  <!--<a href="" class="tab-home-sale active "></a><a href="" class="tab-home-rent"></a>-->
                </div>
                <div class="row-sel">
                  <select name="city" id="cbo_city_homes">
                    <option value="--"><?php echo __("Homes by City / Neighborhood", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                    <?php foreach ($flex_idx_info['search']['cities'] as $city): ?>
                    <option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
                    <?php endforeach; ?>                  
                  </select>
                </div>
                <button class="btn-search search-homes" type="submit"><?php echo __("Search homes", IDXBOOST_DOMAIN_THEME_LANG); ?></button>
              </form>
            </div>
            <div class="col">
              <h2><?php echo __("Search for condos", IDXBOOST_DOMAIN_THEME_LANG); ?></h2>
              <form id="ib-mini-search-condos" method="post">
                <div class="tabs-for-sale group-flex2">
                  
                  <div>
                    <input type="radio" name="rental" value="0" id="c_sale" checked="">
                    <label for="c_sale" class="tab-condo-sale"><?php echo __("For sale", IDXBOOST_DOMAIN_THEME_LANG); ?></label>
                  </div>
                  
                  <div>
                    <input type="radio" name="rental" value="1" id="c_rent">
                    <label for="c_rent" class="tab-condo-rent"><?php echo __("for rent", IDXBOOST_DOMAIN_THEME_LANG); ?></label>                    
                  </div>
                  

                </div>
                <div class="row-sel">
                  <select name="city" id="cbo_city_condos">
                    <option value="--"><?php echo __("Homes by City / Neighborhood", IDXBOOST_DOMAIN_THEME_LANG); ?></option>
                      <?php foreach ($flex_idx_info['search']['cities'] as $city): ?>
                      <option value="<?php echo $city["name"]; ?>"><?php echo $city["name"]; ?></option>
                      <?php endforeach; ?>
                  </select>
                </div>
                <button class="btn-search search-condos" type="submit"><?php echo __("Search Condos", IDXBOOST_DOMAIN_THEME_LANG); ?></button>                                  
              </form>

            </div>
            <div class="col">
              <h2>quick links</h2>
              <?php wp_nav_menu(array('theme_location' => 'menu-quick-home', 'menu_class' => 'list-link', 'container' => false)); ?>
            </div>
            
          </div>
        </div>
      </div>