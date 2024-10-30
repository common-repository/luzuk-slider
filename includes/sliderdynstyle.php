<?php
/**
 * @package Luzuk Premium
 */

function lsp_totalls_dymanic_styles() {

    $lsp_options="";
    $lsp_options = get_option('lsp_options');

    global $post;

      $custom_css = '';


if (isset($lsp_options['ls_sarrowbtn'])){
  $sliderarrowbuttoncolor = $lsp_options['ls_sarrowbtn'];
}else{
  $sliderarrowbuttoncolor = '#000000';
}

if (isset($lsp_options['lsfp_option_bgcolor'])){
  $bgcolor = $lsp_options['lsfp_option_bgcolor'];
}else{
  $bgcolor = '#016efd';
}


if (isset($lsp_options['ls_sprevbtnbg'])){
  $sliderarrowbuttonbgcolor = $lsp_options['ls_sprevbtnbg'];
}else{
  $sliderarrowbuttonbgcolor = '#FFFFFF';
}

if (isset($lsp_options['ls_sarrowbtnhrv'])){
  $sliderarrowbuttonhovercolor = $lsp_options['ls_sarrowbtnhrv'];
}else{
  $sliderarrowbuttonhovercolor = '#FFFFFF';
}


if (isset($lsp_options['ls_sarrowbtnhrvbg'])){
  $sliderarrowbuttonhoverbgcolor = $lsp_options['ls_sarrowbtnhrvbg'];
}else{
  $sliderarrowbuttonhoverbgcolor = '#773afd';
}

if (isset($lsp_options['lsp_option_titlefontsizeslider'])){
  $slidertitilefontsize = $lsp_options['lsp_option_titlefontsizeslider'];
}else{
  $slidertitilefontsize = '55';
}

if (isset($lsp_options['lsp_option_textfontsizeslider'])){
  $slidertextfontsize = $lsp_options['lsp_option_textfontsizeslider'];
}else{
  $slidertextfontsize = '20';
}

if (isset($lsp_options['lsp_option_btntxtfontsizeslider'])){
  $sliderbtntxtfontsize = $lsp_options['lsp_option_btntxtfontsizeslider'];
}else{
  $sliderbtntxtfontsize = '20';
}

// if (isset($lsp_options['lsp_option_imageheight'])){
//   $slidersliderimage= $lsp_options['lsp_option_imageheight'];
// }else{
//   $slidersliderimage= '0';
// }


if (isset($lsp_options['lsfp_fontcase'])){
  $lsfp_fontcase = $lsp_options['lsfp_fontcase'];
}else{
  $lsfp_fontcase = '';
}


if (isset($lsp_options['lsfp_arrowslider'])){
  $lsfp_arrowslider = $lsp_options['lsfp_arrowslider'];
}else{
  $lsfp_arrowslider = 'block';
}



$custom_css .= '

.lsfp_section .swiper-button-next i.fas.fa-chevron-right, 
.lsfp_section .swiper-button-prev i.fas.fa-chevron-left,
.lsfp_section-temp2 .swiper-button-next i.fas.fa-chevron-right, 
.lsfp_section-temp2 .swiper-button-prev i.fas.fa-chevron-left{background-color: '.$sliderarrowbuttonbgcolor.' ;}

.lsfp_section .swiper-button-next i.fas.fa-chevron-right, 
.lsfp_section .swiper-button-prev i.fas.fa-chevron-left,
.lsfp_section-temp2 .swiper-button-next i.fas.fa-chevron-right, 
.lsfp_section-temp2 .swiper-button-prev i.fas.fa-chevron-left{color: '.$sliderarrowbuttoncolor.';}

.lsfp_section .swiper-button-next i.fas.fa-chevron-right:hover, 
.lsfp_section .swiper-button-prev i.fas.fa-chevron-left:hover,
.lsfp_section-temp2 .swiper-button-next i.fas.fa-chevron-right:hover, 
.lsfp_section-temp2 .swiper-button-prev i.fas.fa-chevron-left:hover{ background-color: '.$sliderarrowbuttonhoverbgcolor.' ; }

.lsfp_section .swiper-button-next i.fas.fa-chevron-right:hover, 
.lsfp_section .swiper-button-prev i.fas.fa-chevron-left:hover,
.lsfp_section-temp2 .swiper-button-next i.fas.fa-chevron-right:hover, 
.lsfp_section-temp2 .swiper-button-prev i.fas.fa-chevron-left:hover{color: '.$sliderarrowbuttonhovercolor.' ;}

.lsfp_section .lsfp-title, .lsfp_section-temp2 .lsfp-title-temp2{font-size: '.$slidertitilefontsize.'px !important ;}

.lsfp_section .lsfp-sub-title, .lsfp_section-temp2 .lsfp-sub-title-temp2{font-size: '.$slidertextfontsize.'px !important ;}

.lsfp_section .lsfp-btna .btn5 a, .lsfp_section-temp2 .lsfp-btna-temp2 .btn5 a{font-size: '.$sliderbtntxtfontsize.'px !important ;}

.swiper-button-next, .swiper-button-prev{display: '.$lsfp_arrowslider.' !important ;}

.lsfp-slide-img-temp2{background: '.$bgcolor.' !important ;}




.lsfp_section .lsfp-title, .lsfp_section .lsfp-sub-title, .lsfp_section .lsfp-btna .btn5 a,
.lsfp_section-temp2 .lsfp-title-temp2, .lsfp_section-temp2 .lsfp-sub-title-temp2, .lsfp_section-temp2 .lsfp-btna-temp2 .btn5 a{text-transform: '.$lsfp_fontcase.' !important ;}


';

  return lsfp_css_strip_whitespace($custom_css);

}
