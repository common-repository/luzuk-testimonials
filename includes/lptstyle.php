<?php
/**
 * @package Luzuk Premium
**/

function ltestip_totallt_dymanic_styles() {

$ltestip_options="";
$ltestip_options = get_option('ltestip_options');

global $post;

$custom_css = '';


if (isset($ltestip_options['testimonial_namecolor'])){
    $testimonialname_color = $ltestip_options['testimonial_namecolor'];
}else{
    $testimonialname_color = '#383838';
}

if (isset($ltestip_options['testimonial_testcolor'])){
    $testimonialtest_color = $ltestip_options['testimonial_testcolor'];
}else{
    $testimonialtest_color = '#383838';
}

if (isset($ltestip_options['testimonial_socialcolor'])){
    $testimonialsocialicon_color = $ltestip_options['testimonial_socialcolor'];
}else{
    $testimonialsocialicon_color = '#6a6a6a';
}

if (isset($ltestip_options['ltestip_option_imgheighttesti'])){
    $testimonialimg_width = $ltestip_options['ltestip_option_imgheighttesti'];
}else{
    $testimonialimg_width = '100';
}

if (isset($ltestip_options['ltestip_option_imgwidthtesti'])){
    $testimonialimg_height = $ltestip_options['ltestip_option_imgwidthtesti'];
}else{
    $testimonialimg_height = '300';
}

if (isset($ltestip_options['ltestip_option_imgwidthtesti1t'])){
    $testimonialimg_widthpost = $ltestip_options['ltestip_option_imgwidthtesti1t'];
}else{
    $testimonialimg_widthpost = '100';
}

if (isset($ltestip_options['ltestip_option_imgheighttesti1t'])){
    $testimonialimg_heightpost = $ltestip_options['ltestip_option_imgheighttesti1t'];
}else{
    $testimonialimg_heightpost = '360';
}


$custom_css = '

#innerpage-box #content-box #slider_testimony h4, #slider_testimony h4{color: '. $testimonialname_color.' !important;}

#innerpage-box #content-box #slider_testimony p,
#innerpage-box #content-box #slider_testimony .testimony-member-designation,
#slider_testimony .testimony-member-designation,
#slider_testimony p{color: '. $testimonialtest_color.' !important;}

#innerpage-box #content-box #slider_testimony a.social_testi i.fab,
#slider_testimony a.social_testi i.fab{color: '. $testimonialsocialicon_color.' !important;}

#innerpage-box #content-box #slider_testimony .card-testimony img.imgpostslider,
#slider_testimony .card-testimony img.imgpostslider{width: '. $testimonialimg_width.'% !important;}

#innerpage-box #content-box #slider_testimony .card-testimony img.imgpostslider,
#slider_testimony .card-testimony img.imgpostslider{height: '. $testimonialimg_height.'px !important;}

#innerpage-box #content-box #slider_testimony .card-testimony img.imgpost,
#slider_testimony .card-testimony img.imgpost{width: '. $testimonialimg_widthpost.'% !important;}

#innerpage-box #content-box #slider_testimony .card-testimony img.imgpost,
#slider_testimony .card-testimony img.imgpost{height: '. $testimonialimg_heightpost.'px !important;}

';

return ltestip_css_strip_whitespace($custom_css);

}