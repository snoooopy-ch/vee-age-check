<?php

/*
Plugin Name:  Vee Age Verifications
Version: 1.0
Description: embedded age verification form in your WordPress site.
Author: リンセン
Author URI: 
License: GPLv2 or later
License URI: 
*/


define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'MY_HOME_URL', get_home_url() );

require_once MY_PLUGIN_PATH . 'includes/functions.php';

/**
 * [vee_agecheck_view] returns age verification view.
 * @return view buttons
*/
if ( !function_exists('vee_agecheck_view_init')):
function vee_agecheck_view_init(){
    ?>
    <section v-if="!ageVerified" id="age_verification" class="age-verification" style="background: rgb(255, 255, 255);">
        <header style="background:#000"><a class="main-logo" href="https://www.180smoke.ca"><img src="<?= MY_PLUGIN_URL; ?>assets/img/logo.svg" alt="180Smoke"></a></header>
        <div class="container-fluid">
            <div class="age-verification__body row">
                <div class="text-center col">
                    <div class="age-verification__title">Welcome to <strong>180 Smoke</strong></div>
                    <p>Select your province to validate your age.</p>
                    <div class="age-verification__form-state form-group">
                        <select name="state" aria-label="State" required="" id="state" class="form-control" @change="onChangeState($event)">
                            <option selected="" value="">Select your Province</option>
                            <option v-for="(location, idx) in ageVerificationLocations" v-bind:key="location.region_id" v-bind:value="idx">{{ location.name }}</option>
                        </select>
                    </div>
                    <p v-if="selectedStateAge"><strong><u>We only sell to adults age {{selectedStateAge}} years or older in your province.</u></strong></p>
                    <p v-if="selectedStateAge">Please select your birthdate to confirm you are at least {{selectedStateAge}} years of age.</p>
                </div>
            </div>
        </div>
        <div v-if="selectedStateAge" class="age-verification__form-birth row">
            <div class="text-center col">
                <form @submit="handleSubmit">
                    <p><strong>DATE OF BIRTH</strong></p>
                    <div class="form-row">
                        <div class="form-group col">
                            <select name="month" required="" id="month" class="form-control" @change="onChangeMonth($event)">
                                <option value="">Month</option>
                                <option v-for="(month, idx) in months" v-bind:key="idx" v-bind:value="month">{{month}}</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <select name="day" required="" id="day" class="form-control" @change="onChangeDate($event)">
                                <option value="">Day</option>
                                <option v-for="(date, idx) in dates" v-bind:key="idx" v-bind:value="date">{{date}}</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <select name="year" required="" id="year" class="form-control" @change="onChangeYear($event)">
                                <option value="">Year</option>
                                <option v-for="(year, idx) in years" v-bind:key="idx" v-bind:value="year">{{year}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="mt-md-4 form-group col">
                            <p>Yes, I am 19 years or older</p>
                            <button type="submit" class="d-block w-100 uppercase btn btn-primary">Verify</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <?php
}
endif;
add_action('init', 'vee_agecheck_view_init');

function wbiyoka_style_and_scripts() {
    wp_enqueue_script( 'jquery_slim', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', array(), null, true);
    wp_enqueue_script( 'jquery_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', array(), null, true );
    wp_enqueue_script( 'jquery_vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.14', array(), null, true );
    wp_enqueue_script( 'jquery_age', MY_PLUGIN_URL . '/assets/js/age_verification.js', array(), null, true );
    wp_enqueue_script( 'jquery_min', MY_PLUGIN_URL . '/assets/js/jquery-3.4.1.min.js', array(), null, true );
    wp_enqueue_script( 'jquery_main', MY_PLUGIN_URL . '/assets/js/main.min.js', array(), null, true );

    wp_enqueue_style('style_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', array(), '' );
    wp_enqueue_style('style_grid', MY_PLUGIN_URL . '/assets/css/veev-grid.min.css', array(), '' );
	wp_enqueue_style('style_age', MY_PLUGIN_URL . '/assets/css/age-verification.css', array(), '');
}
add_action( 'wp_enqueue_scripts' , 'wbiyoka_style_and_scripts' );

?>