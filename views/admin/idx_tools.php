<?php
	wp_enqueue_script('flex-idx-tools-js');
    wp_enqueue_style('flex-idx-admin');

        $environment_deco=['status'=>false,'environment'=>'production'];
        $idx_boost_setting=FLEX_IDX_PATH.'feed/idx_boost_setting.json';
        if (file_exists($idx_boost_setting)) {
            $environment=file_get_contents($idx_boost_setting);
            if (!empty($environment)) {
                $environment_deco= json_decode($environment,true);
            }
        }
?>
<div class="wrap">
    <h1>IDX Boost - Tools</h1>

    <div id="flex-idx-status"></div>
    
    <form method="post" id="flex_idx_client_tools_form">
        <input type="hidden" name="action" value="flex_connect">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="flex-idx-settings-client-id">Style Map idxboost</label>
                    </th>
                    <td>
                    	<textarea class="idx_map_style" name="idx_map_style" style="margin-top: 0px;margin-bottom: 0px;height: 361px;width: 100%;"><?php if (!empty($descr_tools_map_style)) { echo $descr_tools_map_style; } ?></textarea>
                        <p class="description">Enter the style map for all site.</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="flex-idx-settings-client-id">Environment site</label>
                    </th>
                    <td>
                        <select class="idx_environment_site" name="idx_environment_site" style="width: 250px; font-size: 15px; text-align: center;" >
                            <option 
                            <?php  if ($environment_deco['environment']=='production' ) { echo 'selected'; } ?>
                            value="production">Production</option>
                            <option 
                            <?php  if ($environment_deco['environment']=='staging' ) {echo 'selected';} ?>
                            value="staging">Staging</option>
                        </select>
                        <p class="description">Enter the environment site.</p>
                    </td>
                </tr>

            </tbody>
        </table>
        <p class="submit">
            <input type="submit" value="Save Changes" id="idx_button_tools" class="button button-primary">
        </p>
        <input type="hidden" name="action" value="idx_save_tools_admin_form">
    </form>
</div>
<script type="text/javascript">
	var flex_idx_xhr_status = false;
</script>