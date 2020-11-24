<div class="wrap">
    <h1>IDX Boost - Alerts</h1>

    <div id="flex-idx-status"></div>
    
    <form method="post" id="flex_idx_client_form">
        <input type="hidden" name="action" value="flex_connect">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="flex-idx-settings-client-id">Name Page Unsubscribe</label>
                    </th>
                    <td>
                        <input type="text" id="flex-idx-settings-client-id" name="flex_idx_registration_unsubscribe" value="" class="widefat" required>
                        <p class="description">Enter your name page Unsubscribed in the text field above.</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="flex-idx-settings-client-id">Name Page Edit Information</label>
                    </th>
                    <td>
                        <input type="text" id="flex-idx-settings-client-id" name="flex_idx_registration_editinformation" value="" class="widefat" required>
                        <p class="description">Enter your name page edit information in the text field above.</p>
                    </td>
                </tr>

            </tbody>
        </table>
        <p class="submit">
            <input type="submit" value="Save Changes" id="flex_idx_verify_alerts_point" class="button button-primary">
        </p>
    </form>
</div>