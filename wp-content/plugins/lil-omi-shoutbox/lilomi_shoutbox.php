<?php
/*
Plugin Name: Lil-Omi Shoutbox
Plugin URI: www.lilomi.com
Description: A simple shoutbox with customizable avatars that you can change the emotions of.
Version: 1.0
Author: gdeglin
*/

include("JSON.php");

class LilomiShoutboxWidget
{


    function control()
    {
    }

    function widget($args)
    {

        global $current_user;

        if (strpos(get_bloginfo('wpurl', 'raw'), 'local.lilomi.com') === FALSE) {
            $lilomiPath = 'http://scenes.lilomi.com';
        } else {
            $lilomiPath = 'http://local.lilomi.com';
        }

        get_currentuserinfo();

        $options = get_option('lilomi_options');

        $path = $lilomiPath . '/shoutbox/shouts?api_key=' . $options['lilomi_api_key'];

        if ($current_user->user_level == 10) {
            $path .= ("&key=" . substr($options['lilomi_secret_key'], 0, 15));
        }
        if($options['default_text']) {
            $path .= ("&default_text=" . $options['default_text']);
        }

        echo "<iframe frameborder='0' style='border:0px;width:200px;height:300px' scrolling='no' src='" . $path . "' ></iframe >";

    }

    function register()
    {
        register_sidebar_widget('LilOmi Shoutbox', array('LilomiShoutboxWidget', 'widget'));
        register_widget_control('LilOmi Shoutbox', array('LilomiShoutboxWidget', 'control'));
    }
}

if (!class_exists('LilomiShoutbox')) {
    class LilomiShoutbox
    {
        //This is where the class variables go, don't forget to use @var to tell what they're for
        /**
         * @var string The options string name for this plugin
         */
        var $optionsName = 'lilomi_options';

        var $lilomiPath = '';
        /**
         * @var array $options Stores the options for this plugin
         */
        var $options = array();

        //Class Functions
        /**
         * PHP 4 Compatible Constructor
         */
        function lilomi()
        {
            $this->__construct();
        }

        /**
         * PHP 5 Constructor
         */
        function __construct()
        {

            //Initialize the options
            $this->getOptions();

            // Set the path correctly for development
            if (strpos(get_bloginfo('wpurl', 'raw'), 'local.lilomi.com') === FALSE) {
                $this->lilomiPath = 'http://scenes.lilomi.com';
            } else {
                $this->lilomiPath = 'http://local.lilomi.com';
            }


            if (!$this->options['lilomi_owner_email'] && !$_POST['lilomi_owner_email']) {
                add_action('admin_notices', array(&$this, 'lilomi_activation_notice'), 10, 4);
            } else {
                add_action("widgets_init", array('LilomiShoutboxWidget', 'register'));
            }
            add_action("admin_menu", array(&$this, "admin_menu_link"));

        }


        /**
         * @desc Adds the options subpanel
         */
        function admin_menu_link()
        {

            //If you change this from add_options_page, MAKE SURE you change the filter_plugin_actions function (below) to
            //reflect the page filename (ie - options-general.php) of the page your plugin is under!
            add_options_page('LilOmiShoutbox', 'LilOmiShoutbox', 10, basename(__FILE__), array(&$this, 'admin_options_page'));
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2);
        }

        /* Called upon plugin activation. Makes an API call to LilOmi to establish a new api and secret key for this app */
        function setKeys()
        {
            if (!$this->options['lilomi_api_key'] || $this->options['lilomi_api_key'] = "") {

                $out = wp_remote_post($this->lilomiPath . "/buddypress/secret_keys?domain=" . get_bloginfo('wpurl', 'raw'));
                $response = json_decode($out['body'], true);

                $this->options['lilomi_api_key'] = $response['secret_key']['api_key'];
                $this->options['lilomi_secret_key'] = $response['secret_key']['secret_key'];

                if (!$this->options['lilomi_api_key'] || ($this->options['lilomi_api_key'] == "")) {
                    echo print_r($out);
                    wp_die("Failed to set api key :(. Please report this error to support@lilomi.com");
                }

                $this->saveAdminOptions();
            }
        }

        /**
         * @desc Adds the Settings link to the plugin activate/deactivate page
         */
        function filter_plugin_actions($links, $file)
        {
            //If your plugin is under a different top-level menu than Settiongs (IE - you changed the function above to something other than add_options_page)
            //Then you're going to want to change options-general.php below to the name of your top-level page
            $settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
            array_unshift($links, $settings_link); // before other links

            return $links;
        }

        function lilomi_activation_notice()
        {
            ?>
        <div id="message" class="updated fade">
            <p style="line-height: 150%"><?php printf(__("<strong>Lil'Omi Shoutbox is almost ready</strong>. You'll need to enter your email on the Lil'Omi <a href='%s'>settings page</a> to complete the activation.", 'buddypress'), admin_url('options-general.php?page=lilomi_shoutbox.php')) ?></p>
        </div>
        <?php

        }

        /**
         * Adds settings/options page
         */
        function admin_options_page()
        {
            ?>
        <div class="wrap">
            <table style="margin-top: 20px; margin-bottom: 5px;">
                <tr valign="middle">

                    <td>
                        <div style="font-size: 18px;">Lil'Omi</div>
                    </td>
                </tr>

            </table>

            <?php
            if ($_POST['lilomi_set_email']) {
            if (!wp_verify_nonce($_POST['_wpnonce'], 'lilomi-update-options')) die('Whoops! There was a problem with the data you posted. Please go back and try again.');


            if (!$this->options['lilomi_api_key'] || $this->options['lilomi_api_key'] == "") {
                $this->setKeys();
            }

            $body = array(
                'owner_email' => $_POST['lilomi_owner_email']
            );
            $url = $this->lilomiPath . "/buddypress/secret_keys/update_email?id=" . $this->options['lilomi_secret_key'] . "&owner_email=" . $_POST['lilomi_owner_email'];
            $request = new WP_Http;
            $result = $request->request($url);
            if (is_wp_error($result)) {
                echo "ERROR: " . $result->get_error_message();
                echo "<br/>Please report this error to support@lilomi.com.";
            }
            if ($result['errors']) {
                wp_die($result['errors']);
            }
            $response = json_decode($result['body'], true);

            if ($response['error']) {
                echo '<div class="updated"><p>Error: ' . $response['error'] . '!</p></div>';
            } else {
                $this->options['lilomi_owner_email'] = $response['secret_key']['owner_email'];
                $this->options['default_text'] = htmlentities($_POST['default_text']);

                $this->saveAdminOptions();
                echo '<div class="updated"><p>Success! Your changes were successfully saved!</p></div>';
            }
        }
            ?>

            <div style="margin-left: 25px; margin-right: 25px;">

            </div>
            <form method="post" id="lilomi_options">
                <?php wp_nonce_field('lilomi-update-options'); ?>
                <table width="100%" cellspacing="2" cellpadding="5" class="form-table">
                    <tr valign="top">
                        <th><b>Your email<br/></b>(Will be used to contact you if any required updates are released)
                        </th>
                        <td><input type="text" size="60" name="lilomi_owner_email"
                                   value="<?php echo $this->options['lilomi_owner_email'] ?>"></input><br/></td>
                    </tr>
                    <tr valign="top">
                        <th><b>Default Shoutbox Message</b><br/>Short text prompting users to leave a message.</th>
            <?php
                                    if ($this->options['default_text']) {
                        echo  '<td><input type="text" size="60" name="default_text" value="' . $this->options['default_text'] . '"></input><br/></td>';
                    } else {
                        echo  '<td><input type="text" size="60" name="default_text" value="' . "Type a message here and press enter..." . '"></input><br/></td>';
                    }
                        ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' name='lilomi_set_email' value='Save'/>
                            Have questions or need help? Contact support@lilomi.com
                        </td>
                    </tr>
                </table>
            </form>
            <?php

        }

        /**
         * Retrieves the plugin options from the database.
         * @return array
         */
        function getOptions()
        {
            //Don't forget to set up the default options
            if (!$theOptions = get_option($this->optionsName)) {
                $theOptions = array('default' => 'options');
                update_option($this->optionsName, $theOptions);
            }
            $this->options = $theOptions;
        }

        /**
         * Saves the admin options to the database.
         */
        function saveAdminOptions()
        {
            return update_option($this->optionsName, $this->options);
        }


    }
}

//instantiate the class
if (class_exists('LilomiShoutbox')) {
    global $lilomi_shoutbox_var;
    $lilomi_shoutbox_var = new LilomiShoutbox();
}

// Future-friendly json_encode
if (!function_exists('json_encode')) {
    function json_encode($data)
    {
        $json = new Shoutbox_Services_JSON();
        return ($json->encode($data));
    }
}

// Future-friendly json_decode
if (!function_exists('json_decode')) {
    function json_decode($data)
    {
        $json = new Shoutbox_Services_JSON();
        return ($json->decode($data));
    }
}


?>