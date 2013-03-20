<?php
/*
Template Name: Only Left Sidebar
*/

# This is the left sidebar template
global $wpz_template;
$wpz_template = 'side-left';

# Just include the default page template because it is basically the same
get_template_part('page');
?>