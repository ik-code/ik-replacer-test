<?php


namespace App;


class Replacer
{
    private $inputArray = [];
    private $outputArray = [];
    private $postIdArray = [];

    public function __construct()
    {
        add_action('admin_menu', [$this, 'ik_replacer_options_page']);
        add_action('admin_init', [$this, 'ik_replacer_register_input_setting']);
        add_action('admin_init', [$this, 'ik_replacer_register_output_setting']);
        add_action('admin_init', [$this, 'ik_replacer_register_post_id_setting']);
        add_filter('the_content', [$this, 'replace_content']);
    }

    public function ik_replacer_options_page()
    {
        add_menu_page(
          'IK Replacer', // page <title>Title</title>
          'Replacer', // menu link text
          'manage_options', // capability to access the page
          'ik-replacer', // page URL slug
          [$this, 'ik_replacer_page_content'], // callback function /w content
          'dashicons-star-half', // menu icon
          5 // priority
        );
    }

    public function ik_replacer_page_content()
    {
        echo '<div class="wrap">
	<h1>Replacer Settings</h1>
	<p>For the fields \'Input\' and \'Output\' enter any text, word or letter through comma. For the field \'Post ID\', type an integer through comma.</p>
	<form method="post" action="options.php">';

        settings_fields('ik_replacer_settings'); // settings group name
        do_settings_sections('ik-replacer'); // just a page slug
        submit_button('Save');

        echo '</form></div>';
    }

    /*-------------------------------Input---------------------------------*/
    public function ik_replacer_register_input_setting()
    {
        register_setting(
          'ik_replacer_settings', // settings group name
          'ik_replacer_input_text', // option name
          'sanitize_text_field' // sanitization function
        );

        add_settings_section(
          'ik_replacer_id', // section ID
          '', // title (if needed)
          '', // callback function (if needed)
          'ik-replacer' // page slug
        );

        add_settings_field(
          'ik_replacer_input_text',
          'Input text',
          [$this,'ik_replacer_text_field_html'], // function which prints the field
          'ik-replacer', // page slug
          'ik_replacer_id', // section ID
          [
            'label_for' => 'ik_replacer_input_text',
            'class'     => 'ik-replacer', // for <tr> element
          ]
        );
    }

    public  function ik_replacer_text_field_html()
    {
        $text = get_option('ik_replacer_input_text');

        printf(
          '<input type="text" id="ik_replacer_input_text" name="ik_replacer_input_text" value="%s" />',
          esc_attr($text)
        );
    }

    /*-------------------------------Output---------------------------------*/

    public function ik_replacer_register_output_setting()
    {
        register_setting(
          'ik_replacer_settings', // settings group name
          'ik_replacer_output_text', // option name
          'sanitize_text_field' // sanitization function
        );

        add_settings_section(
          'ik_replacer_id', // section ID
          '', // title (if needed)
          '', // callback function (if needed)
          'ik-replacer' // page slug
        );

        add_settings_field(
          'ik_replacer_output_text',
          'Output text',
          [$this,'ik_replacer_output_text_field_html'], // function which prints the field
          'ik-replacer', // page slug
          'ik_replacer_id', // section ID
          [
            'label_for' => 'ik_replacer_output_text',
            'class'     => 'ik-replacer', // for <tr> element
          ]
        );
    }

   public function ik_replacer_output_text_field_html()
    {
        $text = get_option('ik_replacer_output_text');

        printf(
          '<input type="text" id="ik_replacer_output_text" name="ik_replacer_output_text" value="%s" />',
          esc_attr($text)
        );
    }

    /*-------------Post ID------------*/
    public function ik_replacer_register_post_id_setting()
    {
        register_setting(
          'ik_replacer_settings', // settings group name
          'ik_replacer_post_id_text', // option name
          'sanitize_text_field' // sanitization function
        );

        add_settings_section(
          'ik_replacer_id', // section ID
          '', // title (if needed)
          '', // callback function (if needed)
          'ik-replacer' // page slug
        );

        add_settings_field(
          'ik_replacer_post_id_text',
          'Post ID',
          [$this,'ik_replacer_post_id_text_field_html'], // function which prints the field
          'ik-replacer', // page slug
          'ik_replacer_id', // section ID
          [
            'label_for' => 'ik_replacer_post_id_text',
            'class'     => 'ik-replacer', // for <tr> element
          ]
        );
    }

    public function ik_replacer_post_id_text_field_html()
    {
        $text = get_option('ik_replacer_post_id_text');

        printf(
          '<input type="text" id="ik_replacer_post_id_text" name="ik_replacer_post_id_text" value="%s" />',
          esc_attr($text)
        );
    }

    /*---------Replace Content----------*/

   public function replace_content( $text ){

       /*---------Array Input----------*/
       $inputTextOption = get_option('ik_replacer_input_text');
        $this->inputArray = explode( ',', $inputTextOption );

        /*---------Array Output----------*/
       $outputTextOption = get_option('ik_replacer_output_text');
       $this->outputArray = explode( ',', $outputTextOption );

       /*---------Post List----------*/
       $postList = get_option('ik_replacer_post_id_text');
       $this->postIdArray = explode( ',', $postList );

       global $post;

       foreach ($this->postIdArray as $key => $value){
           if($post->ID == $this->postIdArray[$key]){
               foreach ($this->inputArray as $item){
                   $random_int = random_int(1, count($this->outputArray));
                   $text = str_replace($item,  $this->outputArray[$random_int-1], $text);
               }
           }
       }
        return $text;
    }

}