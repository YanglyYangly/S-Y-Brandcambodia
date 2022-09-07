<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */
 
add_action( 'customize_register', 'options_theme_customizer_register' );

function options_theme_customizer_register($wp_customize) {

	/**
	 * This is optional, but if you want to reuse some of the defaults
	 * or values you already have built in the options panel, you
	 * can load them into $options for easy reference
	 */
	 
	$options = optionsframework_options();
	
	/* Basic */

	$wp_customize->add_section( 'options_theme_customizer_basic', array(
		'title' => __( 'Basic', 'megashop' ),
		'priority' => 100
	) );
	
	$wp_customize->add_setting( 'options_theme_customizer[example_text]', array(
		'default' => $options['example_text']['std'],
		'type' => 'option',
                'sanitize_callback' => 'options_theme_customizer[example_text]'
	) );

	$wp_customize->add_control( 'options_theme_customizer_example_text', array(
		'label' => $options['example_text']['name'],
		'section' => 'options_theme_customizer_basic',
		'settings' => 'options_theme_customizer[example_text]',
		'type' => $options['example_text']['type']
	) );
	
	$wp_customize->add_setting( 'options_theme_customizer[example_select]', array(
		'default' => $options['example_select']['std'],
		'type' => 'option',
                'sanitize_callback' => 'options_theme_customizer[example_select]'
	) );

	$wp_customize->add_control( 'options_theme_customizer_example_select', array(
		'label' => $options['example_select']['name'],
		'section' => 'options_theme_customizer_basic',
		'settings' => 'options_theme_customizer[example_select]',
		'type' => $options['example_select']['type'],
		'choices' => $options['example_select']['options']
	) );
}
?>
