<?php
function strathcom_get_color_scheme_css( $c ) {
	ob_start(); ?>
body{background:<?php esc_attr_e( $c['body-bg'] ); ?>}body,body h1,body h2,body h4,body h5,body h6{color:<?php esc_attr_e( $c['body-color'] ); ?>}body h3{color:<?php esc_attr_e( $c['color-black'] ); ?>}.color-light a:focus,.color-light a:hover,.color-light h1,.color-light h2,.color-light h3,.color-light h4,.color-light h5,.color-light h6,.color-light p{color:<?php esc_attr_e( $c['color-white'] ); ?>}.home-colorblock p{color:<?php esc_attr_e( $c['color-white'] ); ?>!important}._bpcolor{color:<?php esc_attr_e( $c['brand-primary'] ); ?>}._bscolor{color:<?php esc_attr_e( $c['brand-secondary'] ); ?>}._bpcolordark{color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>}._bpback{background-color:<?php esc_attr_e( $c['brand-primary'] ); ?>}._bsback{background-color:<?php esc_attr_e( $c['brand-secondary'] ); ?>}._bpbackddark{background-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>}.page-link,a{color:<?php esc_attr_e( $c['brand-links-color'] ); ?>}.page-link:focus,.page-link:hover,a:focus,a:hover{color:<?php esc_attr_e( $c['brand-links-color-hover'] ); ?>}.application_button,.btn-primary,.btn.quick-search-button,.cctor-pro-coupons-content .cctor-pro-filters-wrapper input[type=submit],.gform_button,span.btn{border-color:<?php esc_attr_e( $c['brand-primary'] ); ?>;background-color:<?php esc_attr_e( $c['brand-primary'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}.application_button:active,.application_button:focus,.application_button:focus:active,.application_button:hover,.application_button:hover:active,.application_button:hover:focus,.btn-primary:active,.btn-primary:focus,.btn-primary:focus:active,.btn-primary:hover,.btn-primary:hover:active,.btn-primary:hover:focus,.btn.quick-search-button:active,.btn.quick-search-button:focus,.btn.quick-search-button:focus:active,.btn.quick-search-button:hover,.btn.quick-search-button:hover:active,.btn.quick-search-button:hover:focus,.cctor-pro-coupons-content .cctor-pro-filters-wrapper input[type=submit]:active,.cctor-pro-coupons-content .cctor-pro-filters-wrapper input[type=submit]:focus,.cctor-pro-coupons-content .cctor-pro-filters-wrapper input[type=submit]:focus:active,.cctor-pro-coupons-content .cctor-pro-filters-wrapper input[type=submit]:hover,.cctor-pro-coupons-content .cctor-pro-filters-wrapper input[type=submit]:hover:active,.cctor-pro-coupons-content .cctor-pro-filters-wrapper input[type=submit]:hover:focus,.gform_button:active,.gform_button:focus,.gform_button:focus:active,.gform_button:hover,.gform_button:hover:active,.gform_button:hover:focus,span.btn:active,span.btn:focus,span.btn:focus:active,span.btn:hover,span.btn:hover:active,span.btn:hover:focus{border-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>;background-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}.btn-secondary{border-color:<?php esc_attr_e( $c['brand-secondary'] ); ?>;background-color:<?php esc_attr_e( $c['brand-secondary'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}.btn-secondary:active,.btn-secondary:focus,.btn-secondary:focus:active,.btn-secondary:hover,.btn-secondary:hover:active,.btn-secondary:hover:focus{border-color:<?php esc_attr_e( $c['brand-secondary-darker'] ); ?>;background-color:<?php esc_attr_e( $c['brand-secondary-darker'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}a.btn.btn-ghost{border-color:<?php esc_attr_e( $c['color-black'] ); ?>;color:<?php esc_attr_e( $c['color-black'] ); ?>}a.btn.btn-ghost:focus,a.btn.btn-ghost:hover{border-color:<?php esc_attr_e( $c['brand-primary'] ); ?>;color:<?php esc_attr_e( $c['brand-primary'] ); ?>}.product-tabs .tabs-nav{border-bottom-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>}.product-tabs .tabs-nav a{color:<?php esc_attr_e( $c['color-black'] ); ?>}.product-tabs .tabs-nav a.active,.product-tabs .tabs-nav a.active:focus,.product-tabs .tabs-nav a.active:hover,.product-tabs .tabs-nav a:focus,.product-tabs .tabs-nav a:focus:hover,.product-tabs .tabs-nav a:hover{color:<?php esc_attr_e( $c['color-white'] ); ?>;background-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>}.page-item.active .page-link,.page-item.active .page-link:focus,.page-item.active .page-link:hover{background-color:<?php esc_attr_e( $c['brand-links-color'] ); ?>;border-color:<?php esc_attr_e( $c['brand-links-color'] ); ?>}.site-header{background-color:<?php esc_attr_e( $c['header-bg'] ); ?>;color:<?php esc_attr_e( $c['header-color'] ); ?>}.site-header a{color:<?php esc_attr_e( $c['color-white'] ); ?>}.site-header a:focus,.site-header a:hover{color:<?php esc_attr_e( $c['footer-hover-color'] ); ?>}.site-header .scratchpad-toggle a,.site-header .scratchpad-toggle a:focus,.site-header .scratchpad-toggle a:hover{color:<?php esc_attr_e( $c['color-white'] ); ?>}.site-header .scratchpad-toggle .count{border-color:<?php esc_attr_e( $c['header-bg'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>;background:<?php esc_attr_e( $c['brand-primary'] ); ?>}.site-header .scratchpad-toggle:focus .count,.site-header .scratchpad-toggle:hover .count{color:<?php esc_attr_e( $c['color-white'] ); ?>;background:<?php esc_attr_e( $c['brand-secondary'] ); ?>}.site-navigation{background:<?php esc_attr_e( $c['color-black-darker'] ); ?>}@media (min-width:992px){.site-navigation{background:transparent}}.primary-menu._bpback{background:#f7f7f7}@media (min-width:992px){.primary-menu._bpback{background:transparent}}.primary-menu>li>a{color:<?php esc_attr_e( $c['color-black'] ); ?>}.primary-menu>li>a:hover{color:<?php esc_attr_e( $c['color-white'] ); ?>}@media (min-width:992px){.primary-menu>li>a{color:<?php esc_attr_e( $c['color-white'] ); ?>}.primary-menu>li>a:hover{color:<?php esc_attr_e( $c['brand-primary'] ); ?>}}.primary-menu>li .dropdown-menu{background:<?php esc_attr_e( $c['brand-primary'] ); ?>}@media (max-width:991px){.primary-menu>li .dropdown-menu li{background:#fff}.primary-menu>li .dropdown-menu li a{color:<?php esc_attr_e( $c['color-black'] ); ?>;background:transparent;padding-left:1rem}}.primary-menu>li .dropdown-menu a{color:<?php esc_attr_e( $c['color-white'] ); ?>}@media (max-width:991px){.primary-menu>li .dropdown-menu .dropdown-menu>li{background:#fff}.primary-menu>li .dropdown-menu .dropdown-menu>li a{color:<?php esc_attr_e( $c['body-color'] ); ?>;background:transparent}}.primary-menu>li.mega-menu>.dropdown-menu{background:#f7f7f7;border-top:none}.primary-menu .dropdown-trigger:before,.primary-menu .scratchpad-toggle a{color:<?php esc_attr_e( $c['color-black'] ); ?>}.primary-menu .scratchpad-toggle .count,.primary-menu .scratchpad-toggle .count:hover{color:<?php esc_attr_e( $c['color-white'] ); ?>}.site-footer{background-color:<?php esc_attr_e( $c['footer-bg'] ); ?>}.site-footer,.site-footer p{color:<?php esc_attr_e( $c['footer-color'] ); ?>}.site-footer a{color:<?php esc_attr_e( $c['footer-links-color'] ); ?>}.site-footer a:focus,.site-footer a:hover{color:<?php esc_attr_e( $c['footer-hover-color'] ); ?>}.site-footer h5{color:<?php esc_attr_e( $c['body-bg'] ); ?>}.site-footer .footer-social a:before{color:<?php esc_attr_e( $c['footer-primary'] ); ?>}.scratchpad{color:<?php esc_attr_e( $c['scratchpad-color'] ); ?>;background-color:<?php esc_attr_e( $c['scratchpad-bg'] ); ?>}.scratchpad header h3{color:<?php esc_attr_e( $c['color-black'] ); ?>}.scratchpad header h3 .count{border-color:transparent;color:<?php esc_attr_e( $c['color-white'] ); ?>;background:<?php esc_attr_e( $c['brand-secondary'] ); ?>}.scratchpad a{color:<?php esc_attr_e( $c['scratchpad-color'] ); ?>}.scratchpad a:focus,.scratchpad a:hover{color:<?php esc_attr_e( $c['scratchpad-links-color'] ); ?>}.scratchpad h5{color:<?php esc_attr_e( $c['body-color'] ); ?>}.scratchpad a.close-btn:hover,.scratchpad ul .remove:hover,.scratchpad ul .view:hover{background-color:<?php esc_attr_e( $c['scratchpad-primary'] ); ?>}.scratchpad a.close-btn,.scratchpad ul .remove,.scratchpad ul .view,.scratchpad ul li,.scratchpad ul li:first-child{border-color:<?php esc_attr_e( $c['body-bg-darker'] ); ?>}.single-inventory{background-color:#f5f5f5}.single-inventory,.single-inventory .layout-srp .card-car h5,.single-inventory .layout-srp h2,.single-inventory .layout-srp h3,.single-inventory .layout-srp h4,.single-inventory .layout-srp h5,.single-inventory .layout-vdp .card-car h5,.single-inventory .layout-vdp h2,.single-inventory .layout-vdp h3,.single-inventory .layout-vdp h4,.single-inventory .layout-vdp h5,.single-inventory h1{color:<?php esc_attr_e( $c['color-black'] ); ?>}.filter-stock-type:hover a.state-active:hover,.filter-stock-type a.state-active,.filter-stock-type a:hover{color:<?php esc_attr_e( $c['brand-links-color'] ); ?>}.product-brochure .product-info dt{color:<?php esc_attr_e( $c['brand-primary'] ); ?>}.search-results .special-deal{background:<?php esc_attr_e( $c['brand-tertiary'] ); ?>}.search-results .savings-price{color:<?php esc_attr_e( $c['brand-tertiary'] ); ?>;border-color:<?php esc_attr_e( $c['brand-tertiary'] ); ?>}._bpbackinv{color:<?php esc_attr_e( $c['brand-links-color'] ); ?>;background-color:transparent}._bpbackinv.active,._bpbackinv:focus,._bpbackinv:hover{color:<?php esc_attr_e( $c['color-white'] ); ?>;background-color:<?php esc_attr_e( $c['brand-links-color'] ); ?>}.staff-departments li a{background-color:<?php esc_attr_e( $c['brand-primary'] ); ?>;border-color:<?php esc_attr_e( $c['brand-primary'] ); ?>}.staff-departments li a:active,.staff-departments li a:focus,.staff-departments li a:focus:active,.staff-departments li a:hover,.staff-departments li a:hover:active,.staff-departments li a:hover:focus{background-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>;border-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>}.entry-content .single_job_listing .meta .freelance,.entry-content .single_job_listing .meta .full-time,.entry-content .single_job_listing .meta .internship,.entry-content .single_job_listing .meta .jop-posting,.entry-content .single_job_listing .meta .part-time,.entry-content .single_job_listing .meta .temporary,.staff-member>figure>a span{background-color:<?php esc_attr_e( $c['brand-primary'] ); ?>}.carousel-direction-nav a{color:<?php esc_attr_e( $c['color-white'] ); ?>}.carousel-direction-nav a:before{background-color:<?php esc_attr_e( $c['color-black'] ); ?>}#float-nav a{background-color:<?php esc_attr_e( $c['brand-primary'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}#float-nav a:focus,#float-nav a:hover{background-color:<?php esc_attr_e( $c['brand-tertiary'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}.white-block .container-optional{background:<?php esc_attr_e( $c['color-white'] ); ?>}.home-colorblock,.home-colorblock p,.site-footer,.site-footer p{color:<?php esc_attr_e( $c['footer-color'] ); ?>}.layout-vdp-twenty-seventeen h2{color:<?php esc_attr_e( $c['color-black'] ); ?>}.layout-vdp-twenty-seventeen .vdp-dealer-info .phone-number{background:<?php esc_attr_e( $c['brand-primary'] ); ?>}.srp-vi-filters .filter-payment output .value,.srp-vi-results .actions a:hover,.srp-vi-results .details [data-trigger=price-tooltip]{color:<?php esc_attr_e( $c['brand-primary'] ); ?>}.custom-checkbox-list label,.custom-radio-list label,.srp-vi-results .details{background:<?php esc_attr_e( $c['brand-primary'] ); ?>;border-color:<?php esc_attr_e( $c['brand-primary'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}.custom-checkbox-list label:after,.custom-radio-list label:after,.srp-vi-results .details:after{display:none}.custom-checkbox-list label:focus,.custom-checkbox-list label:hover,.custom-radio-list label:focus,.custom-radio-list label:hover,.srp-vi-results header .table-actions a.active{background:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>;border-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>;color:<?php esc_attr_e( $c['color-white'] ); ?>}.custom-radio-list input:checked+label,.filter-options .checkbox-list input:checked+label,.filter-years .radio-list input:checked+label{border-color:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>;background:<?php esc_attr_e( $c['brand-primary-darker'] ); ?>}
<?php
	return ob_get_flush();
}
