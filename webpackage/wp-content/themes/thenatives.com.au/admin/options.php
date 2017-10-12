<?php
add_action('init','of_options');
if (!function_exists('of_options'))
{
	function of_options()
    {
        $of_sidebars = array();
        global $default_sidebars;
        if ($default_sidebars) {
            foreach ($default_sidebars as $key => $_sidebar) {
                $of_sidebars[$_sidebar['id']] = $_sidebar['name'];
            }
        }

        $logo = THEME_IMAGES . '/logo.png';
        $favicon = THEME_IMAGES . '/favicon.png';

        //More Options
        $body_repeat = array("no-repeat", "repeat-x", "repeat-y", "repeat");
        $body_pos = array("top left", "top center", "top right", "center left", "center center", "center right", "bottom left", "bottom center", "bottom right");

        $default_font_size = array(
            "10px",
            "11px",
            "12px",
            "13px",
            "14px",
            "15px",
            "16px",
            "17px",
            "18px",
            "19px",
            "20px",
            "21px",
            "22px",
            "23px",
            "24px",
            "25px",
            "26px",
            "27px",
            "28px",
            "29px",
            "30px",
            "31px",
            "32px",
            "33px",
            "34px",
            "35px",
            "36px",
            "37px",
            "38px",
            "39px",
            "40px",
            "41px",
            "42px",
            "43px",
            "44px",
            "45px",
            "46px",
            "47px",
            "48px",
            "49px",
            "50px",
        );

        $faces = array(
            'custom' => 'Custom',
            'arial' => 'Arial',
            'verdana' => 'Verdana',
            'fantasy' => 'Fantasy',
            'georgia' => 'Georgia',
            'times' => 'Times New Roman',
            'tahoma' => 'Tahoma',
            'monospace' => 'Monospace',
            'helvetica' => 'Helvetica',
            'cursive' => 'Cursive',
        );

        define('ADMIN_ASSETS_IMG_DIR', ADMIN_DIR . 'assets/images/');

        $default_font_size = array_combine($default_font_size, $default_font_size);

        $url = ADMIN_DIR . 'assets/images/';

        /***************** Thenatives : GENERAL ****************/
        global $of_options, $thenatives_google_fonts;

        $of_options = array();

        $of_options[] = array(
            "name" => "General",
            "type" => "heading",
            "icon" => '<i class="fa fa-globe" aria-hidden="true"></i>'
        );

        $of_options[] = array(
            "name" => "Logo & Favicon",
            "id" => "logo_and_favicon",
            "type" => "info",
        );

        $of_options[] = array(
            "name" => "Logo image",
            "desc" => "Change your logo.",
            "id" => "thenatives_logo",
            "std" => $logo,
            "type" => "media",
        );

        $of_options[] = array(
            "name" => "Favicon image",
            "desc" => "Accept ICO files, PNG files",
            "id" => "thenatives_favicon",
            "std" => $favicon,
            "type" => "media",
        );

        $of_options[] = array(
            "name" => "Global",
            "id" => "info_global",
            "type" => "info",
        );

        $of_options[] = array(
            "name" => "Google Analytic Code",
            "desc" => "Add code Google Analytic",
            "id" => "thenatives_google_analytic_code",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Enable Totop button",
            "desc" => "Enable/Disable Totop Button on site",
            "id" => "thenatives_totop",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        /***************** Thenatives : SOCIAL MEDIA ****************/
        $of_options[] = array(
            "name" => "Social Media",
            "type" => "heading",
            "icon" => '<i class="fa fa-twitter" aria-hidden="true"></i>',
        );

        $of_options[] = array(
            "name" => "Social Media Icons",
            "id" => "info_social_media",
            "type" => "info",
        );

        $of_options[] = array(
            "name" => "Facebook",
            "desc" => "Enter URL to your Facebook Account",
            "id" => "thenatives_facebook",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Twitter",
            "desc" => "Enter URL to your Twitter Account",
            "id" => "thenatives_twitter",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Google Plus",
            "desc" => "Enter URL to your Google Plus Account",
            "id" => "thenatives_google_plus",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Youtube",
            "desc" => "Enter URL to your Youtube Account",
            "id" => "thenatives_youtube",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Tumblr",
            "desc" => "Enter URL to your Tumblr Account",
            "id" => "thenatives_tumblr",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Pinterest",
            "desc" => "Enter URL to your Pinterest Account",
            "id" => "thenatives_pinterest",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "LinkedIn",
            "desc" => "Enter URL to your LinkedIn Account",
            "id" => "thenatives_linked_in",
            "std" => "",
            "type" => "text",
        );

        /***************** Thenatives : ShareBox ****************/
        $of_options[] = array(
            "name" => "Social ShareBox",
            "type" => "heading",
            "icon" => '<i class="fa fa-share" aria-hidden="true"></i>',
        );

        $of_options[] = array(
            "name" => "List ShareBox",
            "id" => "info_list_sharebox",
            "type" => "info",
        );

        $of_options[] = array(
            "name" => "Facebook",
            "desc" => "Enable/Disable share Facebook",
            "id" => "thenatives_share_facebook",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        $of_options[] = array(
            "name" => "Twitter",
            "desc" => "Enable/Disable share Twitter",
            "id" => "thenatives_share_twitter",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        $of_options[] = array(
            "name" => "Google Plus",
            "desc" => "Enable/Disable share Google Plus",
            "id" => "thenatives_share_google_plus",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        $of_options[] = array(
            "name" => "Tumblr",
            "desc" => "Enable/Disable share Tumblr",
            "id" => "thenatives_share_tumblr",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        $of_options[] = array(
            "name" => "Pinterest",
            "desc" => "Enable/Disable share Pinterest",
            "id" => "thenatives_share_pinterest",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        $of_options[] = array(
            "name" => "LinkedIn",
            "desc" => "Enable/Disable share LinkedIn",
            "id" => "thenatives_share_linked_in",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        $of_options[] = array(
            "name" => "E-Mail",
            "desc" => "Enable/Disable share E-Mail",
            "id" => "thenatives_share_email",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        /***************** Thenatives : Footer ****************/
        $of_options[] = array(
            "name" => "Footer",
            "type" => "heading",
            "icon" => '<i class="fa fa-hourglass-end" aria-hidden="true"></i>',
        );

        $of_options[] = array(
            "name" => "General",
            "id" => "info_general",
            "type" => "info",
        );

        $of_options[] = array(
            "name" => "Copyright",
            "desc" => "Copyright",
            "id" => "thenatives_footer_copyright",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Show Social",
            "desc" => "Enable/Disable Social",
            "id" => "thenatives_footer_social",
            "on" => "Enable",
            "off" => "Disable",
            "std" => 1,
            "type" => "switch",
        );

        $of_options[] = array(
            "name" => "Information",
            "id" => "info_general",
            "type" => "info",
        );

        $of_options[] = array(
            "name" => "Address",
            "desc" => "Address",
            "id" => "thenatives_footer_address",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Hotline",
            "desc" => "Address",
            "id" => "thenatives_footer_hotline",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Email",
            "desc" => "Address",
            "id" => "thenatives_footer_email",
            "std" => "",
            "type" => "text",
        );

        $of_options[] = array(
            "name" => "Website",
            "desc" => "Website",
            "id" => "thenatives_footer_website",
            "std" => "",
            "type" => "text",
        );

        /***************** Thenatives : Custom CSS ****************/
        $of_options[] = array(
            "name" => "Custom CSS",
            "type" => "heading",
            "icon" => '<i class="fa fa-css3" aria-hidden="true"></i>',
        );

        $of_options[] = array(
            "name" => "Custom CSS",
            "id" => "info_custom_css",
            "type" => "info",
        );

        $of_options[] = array("name" => "CSS Code",
            "desc" => "Quickly add some CSS to your theme by adding it to this block.",
            "id" => "thenatives_custom_css",
            "std" => "",
            "type" => "textarea",
        );
    }
}