<?php
/*
Template Name: Only Right Sidebar
*/

# This is the right sidebar template
global $wpz_template;
$wpz_template = 'side-right';

# Just include the default page template because it is basically the same
get_template_part('page');
?>