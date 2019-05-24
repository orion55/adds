<?php
add_action('admin_init', 'child_plugin');
function child_plugin()
{
    if (is_admin() && current_user_can('activate_plugins') && !is_plugin_active('carbon-fields/carbon-fields-plugin.php')) {
        add_action('admin_notices', 'child_plugin_notice');

        deactivate_plugins(plugin_basename(__FILE__));

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
    }
}

function child_plugin_notice()
{ ?>
    <div class="notice notice-error is-dismissible">Извините, но этот плагин требует установки
        плагина Carbon Field 3.x и его активации.
    </div>
    <?php
}
