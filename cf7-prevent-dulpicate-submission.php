<?php
/*
Plugin Name: CF7 Prevent Duplicate Submission
Description: Disables the form submit button after submit and enable it on response.
 * Version: 1.0
 * Author: Robert Went
 * Author URI: https://robertwent.com
 * License: GPL3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_footer', 'cf7_prevent_duplicate_submission', 9999 );

function cf7_prevent_duplicate_submission() {
	ob_start();
	?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.wpcf7 form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    let submitButton = form.querySelector('input[type="submit"], button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;

                        // Enable the button after 4 seconds if no response is received
                        setTimeout(function () {
                            if (submitButton.disabled) {
                                submitButton.disabled = false;
                            }
                        }, 4000);
                    }
                });

                document.addEventListener('wpcf7submit', function (event) {
                    if (event.detail.unitTag) {
                        let cf7_pds_button = document.getElementById(event.detail.unitTag).querySelector('.wpcf7-submit');
                        if (cf7_pds_button) {
                            cf7_pds_button.disabled = false;
                        }
                    }
                }, false);
            });
        });
    </script>
	<?php

	$script = ob_get_clean();

	echo $script;
}