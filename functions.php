<?PHP

define('SETTING_ID_BEIAN_ICP', 'zh_cn_l10n_icp_num');
define('SETTING_ID_BEIAN_GONGAN', 'zh_cn_l10n_gongan_num');

// 增加主题选项
add_action( 'customize_register', 'catxn_customize_register' );
function catxn_customize_register( $wp_customize ) {    

	// ICP 备案信息
    $wp_customize->add_setting( SETTING_ID_BEIAN_ICP, array(
        'default'        => '浙ICP备0000000号',
        'type'           => 'option',
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh'
    ) );

    $wp_customize->add_control( new WP_Customize_Control( 
    	$wp_customize, SETTING_ID_BEIAN_ICP, array(
        'label'      => __( 'ICP备案号', 'catxn-onepress' ),
        'section'    => 'title_tagline',
        'settings'   => SETTING_ID_BEIAN_ICP,
    ) ) );

    // 公安备案信息
    $wp_customize->add_setting( SETTING_ID_BEIAN_GONGAN, array(
        'default'        => '浙公网安备00000000000000号',
        'type'           => 'option',
        'capability'     => 'edit_theme_options',
        'transport'      => 'refresh'
    ) );

    $wp_customize->add_control( new WP_Customize_Control( 
    	$wp_customize, SETTING_ID_BEIAN_GONGAN, array(
        'label'      => __( '公安备案号', 'catxn-onepress' ),
        'section'    => 'title_tagline',
        'settings'   => SETTING_ID_BEIAN_GONGAN,
    ) ) );

}

// 增加备案信息
function add_icp_num($wp_customize)  {  
	$beian_icp = get_option( SETTING_ID_BEIAN_ICP );
	$beian_gongan = get_option( SETTING_ID_BEIAN_GONGAN );
	echo 'Copyright &copy; ' . date('Y') . ' ' . get_bloginfo();
    echo ' <a href="https://beian.miit.gov.cn/" rel="external nofollow" target="_blank">' . $beian_icp . '</a>';
    echo ' <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=' . $beian_gongan . '">' . $beian_gongan . '</a>';
}
add_action('onepress_footer_site_info', 'add_icp_num', 20); 
function remove_origin_siteinfo() {
	remove_action( 'onepress_footer_site_info', 'onepress_footer_site_info' );
}
add_action('init', 'remove_origin_siteinfo');

// 登录表单shortcode
function catxn_login_form_shortcode() {
    if ( is_user_logged_in() )
        return '';
    return wp_login_form( array( 'echo' => false ) );
}
// 重定向简码
function catxn_redirect_shortcode($params) {
    extract(shortcode_atts(array(
	'url' => '/',
	), $params));

    header('Location: '.$url);
}
// 注册简码
function catxn_add_shortcodes() {
    add_shortcode( 'catxn-login-form', 'catxn_login_form_shortcode' );
    add_shortcode( 'catxn-redirect', 'catxn_redirect_shortcode' );
}
add_action( 'init', 'catxn_add_shortcodes' );

// 隐藏工具条
if ( !is_admin() ) {  
    add_filter('show_admin_bar', '__return_false'); 
}
?>