<?php

/*
Plugin Name: contactform
Plugin URI: https://wordpress.com
Description:Just another contact form plugin. Simple but flexible.
Version:  3.5.6
Author: Contact
Author URI: https://wordpress.com
*/


function html_form_code()
{
    $contact_form__options = array(
        "nom" => get_option("nom_input"),
        "prenom" => get_option("prenom_input"),
        "tel" => get_option("tel_input"),
        "email" => get_option("email_input"),
        "addresse" => get_option("addresse_input"),
        "message" => get_option("message_input"),
    );


    $content = '<style>.cf-form{max-width:500px;}.cf-form .form-group{display:flex;flex-flow:wrap;align-items:center;margin-bottom:20px;}.cf-form .input-group{position: relative;
        display: flex;margin-left: auto;width:70%;} .cf-form label{display:inline-block;margin-bottom:10px;
    }.cf-form input{width:100%;display:block;}.cf-form [type="submit"]{max-width:150px}.cf-form .w-100{width:100%}</style>';
    $content .= '<script>function deleteFormEl(el){el.closest(".form-group").remove();console.log(el)}</script>';
    $content .= '<form method="post" action="#" class="cf-form">';

    if ($contact_form__options["nom"] === "true") {
        $content .= '<div class="form-group">
                        <label for="nom">Nom</label>';
        $content .= '   <div class="input-group">
                            <input type="text" id="nom" name="option_nom" class="form-control" required/>
                            <button onclick="deleteFormEl(this)" type="button" class="btn-delete">&times;</button>
                        </div>
                     </div>';
    }
    if ($contact_form__options["prenom"] === "true") {
        $content .= '<div class="form-group">
                        <label for="prenom">Prenom</label>';
        $content .= '   <div class="input-group">
                            <input type="text" id="prenom" name="option_prenom" class="form-control" required />
                            <button onclick="deleteFormEl(this)" type="button" class="btn-delete">&times;</button>
                        </div>
                    </div>';
    }
    if ($contact_form__options["tel"] === "true") {
        $content .= '<div class="form-group">
                        <label for="tel">Tel</label>';
        $content .= '   <div class="input-group">
                            <input type="tel" id="tel" name="option_tel" class="form-control" required />
                            <button onclick="deleteFormEl(this)" type="button" class="btn-delete">&times;</button>
                        </div>
                    </div>';
    }
    if ($contact_form__options["email"] === "true") {
        $content .= '<div class="form-group">
                        <label for="email">Email</label>';
        $content .= '   <div class="input-group">
                            <input type="email" id="email" name="option_email" class="form-control" required/>
                        </div>
                    </div>';
    }
    if ($contact_form__options["addresse"] === "true") {
        $content .= '<div class="form-group">
                        <label for="addresse">Addresse</label>';
        $content .= '   <div class="input-group">
                            <input type="text" id="addresse" name="option_addresse" class="form-control" required/>
                            
                        </div>
                     </div>';
    }
    if ($contact_form__options["message"] === "true") {
        $content .= '<div class="form-group">
                        <label for="message">Message</label>';
        $content .= '   <div class="input-group w-100">
                            <textarea cols="7" rows="7" id="message" name="option_message" class="form-control" required></textarea>
                        </div>
                    </div>';
    }
    $content .= '<input  type="submit" name="form_submit" value="Envoyer" class="btn btn-md btn-primary"/>';
    $content .= "</form>";
    if (in_array("true", $contact_form__options)) {
        echo $content;
    }
}

function cf_shortcode()
{
    ob_start();
    html_form_code();

    return ob_get_clean();
}


add_shortcode('cf_form', 'cf_shortcode');



class ContactForm
{
    private $contact_form__options;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'contact_form__add_plugin_page'));
        add_action('admin_init', array($this, 'contact_form__page_init'));
    }

    public function contact_form__add_plugin_page()
    {
        add_menu_page(
            'Contact Form ', // page_title
            'Contact Form ', // menu_title
            'manage_options', // capability
            'contact-form', // menu_slug
            array($this, 'contact_form__create_admin_page'), // function
            'dashicons-admin-generic', // icon_url
            2 // position
        );
    }

    public function contact_form__create_admin_page()
    {
        $this->contact_form__options = get_option('contact_form__option_name'); ?>

        <div class="wrap">
            <h2>Contact Form </h2>
            <p></p>
            <?php settings_errors(); ?>
            <p>décochez la case pour désactiver les éléments de formulaire.
            </p>
            <form method="post" action="options.php">
                <?php
                settings_fields('contact_form__option_group');
                do_settings_sections('contact-form-admin');
                ?>
                <p>code d'activation du formulaire <code>[cf_form]</code>
                </p>
                <?php
                submit_button();
                ?>
            </form>

        </div>
<?php }

    public function contact_form__page_init()
    {
        register_setting(
            'contact_form__option_group', // option_group
            'contact_form__option_name', // option_name
            array($this, 'contact_form__sanitize') // sanitize_callback
        );

        add_settings_section(
            'contact_form__setting_section', // id
            'Settings', // title
            array($this, 'contact_form__section_info'), // callback
            'contact-form-admin' // page
        );

        add_option('nom_input', 'true', '', 'yes');
        add_option('prenom_input', 'true', '', 'yes');
        add_option('tel_input', 'true', '', 'yes');
        add_option('email_input', 'true', '', 'yes');
        add_option('addresse_input', 'true', '', 'yes');
        add_option('message_input', 'true', '', 'yes');

        add_settings_field(
            'nom_input_0', // id
            'Nom input', // title
            array($this, 'nom_input_0_callback'), // callback
            'contact-form-admin', // page
            'contact_form__setting_section' // section
        );

        add_settings_field(
            'prenom_input_1', // id
            'Prenom input', // title
            array($this, 'prenom_input_1_callback'), // callback
            'contact-form-admin', // page
            'contact_form__setting_section' // section
        );

        add_settings_field(
            'tel_input_2', // id
            'Tel input', // title
            array($this, 'tel_input_2_callback'), // callback
            'contact-form-admin', // page
            'contact_form__setting_section' // section
        );

        add_settings_field(
            'email_input_3', // id
            'Email input', // title
            array($this, 'email_input_3_callback'), // callback
            'contact-form-admin', // page
            'contact_form__setting_section' // section
        );

        add_settings_field(
            'addresse_input_4', // id
            'Addresse input', // title
            array($this, 'addresse_input_4_callback'), // callback
            'contact-form-admin', // page
            'contact_form__setting_section' // section
        );

        add_settings_field(
            'message_input_5', // id
            'Message input', // title
            array($this, 'message_input_5_callback'), // callback
            'contact-form-admin', // page
            'contact_form__setting_section' // section
        );
    }

    public function contact_form__sanitize($input)
    {
        $sanitary_values = array();


        if (isset($input['nom_input_0'])) {
            update_option("nom_input", "true");
            $sanitary_values['nom_input_0'] = $input['nom_input_0'];
        } else {
            update_option("nom_input", "false");
        }

        if (isset($input['prenom_input_1'])) {
            update_option("prenom_input", "true");
            $sanitary_values['prenom_input_1'] = $input['prenom_input_1'];
        } else {
            update_option("prenom_input", "false");
        }

        if (isset($input['tel_input_2'])) {
            update_option("tel_input", "true");
            $sanitary_values['tel_input_2'] = $input['tel_input_2'];
        } else {
            update_option("tel_input", "false");
        }

        if (isset($input['email_input_3'])) {
            update_option("email_input", "true");
            $sanitary_values['email_input_3'] = $input['email_input_3'];
        } else {
            update_option("email_input", "false");
        }

        if (isset($input['addresse_input_4'])) {
            update_option("addresse_input", "true");
            $sanitary_values['addresse_input_4'] = $input['addresse_input_4'];
        } else {
            update_option("addresse_input", "false");
        }

        if (isset($input['message_input_5'])) {
            update_option("message_input", "true");
            $sanitary_values['message_input_5'] = $input['message_input_5'];
        } else {
            update_option("message_input", "false");
        }

        return $sanitary_values;
    }

    public function contact_form__section_info()
    {
    }
    // add_option('nom_input', 'true', '', 'yes');
    // add_option('prenom_input', 'true', '', 'yes');
    // add_option('tel_input', 'true', '', 'yes');
    // add_option('email_input', 'true', '', 'yes');
    // add_option('addresse_input', 'true', '', 'yes');
    // add_option('message_input', 'true', '', 'yes');
    public function nom_input_0_callback()
    {

        printf(
            '<input type="checkbox" name="contact_form__option_name[nom_input_0]" id="nom_input_0" value="nom_input_0" %s>',
            get_option("nom_input") === "true" ? 'checked' : ''
        );
    }

    public function prenom_input_1_callback()
    {
        printf(
            '<input type="checkbox" name="contact_form__option_name[prenom_input_1]" id="prenom_input_1" value="prenom_input_1" %s>',
            get_option("prenom_input") === "true" ? 'checked' : ''
        );
    }

    public function tel_input_2_callback()
    {
        printf(
            '<input type="checkbox" name="contact_form__option_name[tel_input_2]" id="tel_input_2" value="tel_input_2" %s>',
            get_option("tel_input") === "true" ? 'checked' : ''
        );
    }

    public function email_input_3_callback()
    {
        printf(
            '<input type="checkbox" name="contact_form__option_name[email_input_3]" id="email_input_3" value="email_input_3" %s>',
            get_option("email_input") === "true" ? 'checked' : ''
        );
    }

    public function addresse_input_4_callback()
    {
        printf(
            '<input type="checkbox" name="contact_form__option_name[addresse_input_4]" id="addresse_input_4" value="addresse_input_4" %s>',
            get_option("addresse_input") === "true" ? 'checked' : ''
        );
    }

    public function message_input_5_callback()
    {
        printf(
            '<input type="checkbox" name="contact_form__option_name[message_input_5]" id="message_input_5" value="message_input_5" %s>',
            get_option("message_input") === "true" ? 'checked' : ''
        );
    }
}
if (is_admin())
    $contact_form_ = new ContactForm();
