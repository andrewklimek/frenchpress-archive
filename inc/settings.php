<?php
/************************
* Settings Page
**/

add_action( 'rest_api_init', 'frenchpress_register_api_endpoint' );
function frenchpress_register_api_endpoint() {
	register_rest_route( 'frenchpress/v1', '/s', ['methods' => 'POST', 'callback' => 'frenchpress_api_settings', 'permission_callback' => function(){ return current_user_can('import');} ] );
}

function frenchpress_api_settings( $request ) {
	$data = $request->get_params();
	foreach ( $data as $k => $v ) update_option( $k, array_filter($v, 'strlen') );
	return "Saved";
}


add_action( 'admin_menu', 'frenchpress_admin_menu' );
function frenchpress_admin_menu() {
	add_submenu_page( 'themes.php', 'Frenchpress Theme Settings', 'Theme Settings', 'import', 'frenchpress', 'frenchpress_settings_page' );
}

function frenchpress_settings_page() {

	$url = rest_url('frenchpress/v1/');
	$nonce = "x.setRequestHeader('X-WP-Nonce','". wp_create_nonce('wp_rest') ."')";
	?>
<div class=wrap>
	<h1>Frenchpress Settings</h1>
	<form onsubmit="event.preventDefault();var t=this,b=t.querySelector('button'),x=new XMLHttpRequest;x.open('POST','<?php echo $url.'s'; ?>'),<?php echo $nonce; ?>,x.onload=function(){b.innerHTML=JSON.parse(x.response)},x.send(new FormData(t))">
	<?php
	
	$fields = array_fill_keys([
		'inline_css','no_drawer','page_titles','menu_breakpoint','entry_meta','entry_meta_time','entry_meta_byline','image_behind_title','comment_form_unstyle', 'comment_form_website_field'
	],
	[ 'type' => 'checkbox' ]);// defaults

	$fields['menu_breakpoint']['type'] = 'number';
		
	$options = [ 'frenchpress' => $fields ];// can add additional options groups to save as their own array in the options table
	
	echo '<table class=form-table>';
	foreach ( $options as $g => $fields ) {
		$values = get_option($g);
		echo "<input type=hidden name='{$g}[x]' value=1>";// hidden field to make sure things still update if all options are empty (defaults)
		foreach ( $fields as $k => $f ) {
			$v = isset( $values[$k] ) ? $values[$k] : '';
			$l = isset( $f['label'] ) ? $f['label'] : str_replace( '_', ' ', $k );
			$size = !empty( $f['size'] ) ? $f['size'] : 'regular';
			switch ( $f['type'] ) {
				case 'textarea':
					echo "<tr><th><label for='{$g}-{$k}'>{$l}</label><td><textarea id='{$g}-{$k}' name='{$g}[{$k}]' placeholder='' rows=8 class={$size}-text>{$v}</textarea>";
					break;
				case 'checkbox':
					echo "<tr><th><label for='{$g}-{$k}'>{$l}</label><td><input id='{$g}-{$k}' name='{$g}[{$k}]'"; if ( $v ) echo " checked"; echo " type=checkbox >";
					break;
				case 'number':
					$size = !empty( $f['size'] ) ? $f['size'] : 'small';
					echo "<tr><th><label for='{$g}-{$k}'>{$l}</label><td><input id='{$g}-{$k}' name='{$g}[{$k}]' placeholder='' value='{$v}' class={$size}-text type=number>";
					break;
				case 'text':
				default:
					echo "<tr><th><label for='{$g}-{$k}'>{$l}</label><td><input id='{$g}-{$k}' name='{$g}[{$k}]' placeholder='' value='{$v}' class={$size}-text>";
					break;
			}
			if ( !empty( $f['desc'] ) ) echo $f['desc'];
		}
	}
	echo '</table>';

	?><p><button class=button-primary>Save Changes</button>
	</form>
</div>
<?php
}

// add_filter( 'frenchpress_drawer', function(){ return false; });// don't need menu drawer

function frenchpress_full_width( $full_width ) {
	if ( in_category( 'review' ) ) $full_width = true;
	return $full_width;
}
// add_filter( 'frenchpress_full_width', 'frenchpress_full_width' );
// add_filter( 'frenchpress_full_width', '__return_true' );// full width layout

// add_filter( 'frenchpress_featured_image', '__return_true' );// show featured images on single posts


// add a shadow at the top
// add_action('wp_footer',function(){echo "<div style='box-shadow:rgba(0,0,0,.3) 0 0 7px;position:fixed;height:9px;top:0;width:110%;margin:-9px'></div>";});

// set_post_thumbnail_size( '850', '850' );

// update_option( 'medium_large_size_w', 1024 );// width of medium_large picture size. seems more useful than 768 this time. ONly has to run once to update options table

// add_filter('show_admin_bar', function(){ return false; });
// add_filter('show_admin_bar', function($b){ return current_user_can('administrator') ? $b : false; });

// add_filter( 'frenchpress_menu_breakpoint', function(){ return 0; } );// mobile nav breakpoint in pixels

// add_filter( 'frenchpress_main_menu_slug', function(){ return 'main-menu'; } );// which menu should get the mobile drawer?  default is menu with "main" in slug, or failing that, the first menu created

// add_action( 'wp_head', function(){ echo '<meta name="google-site-verification" content="Shav8DEq9RGnBjvv4i0iYkNqUkQQZ3Wpy5xSNTmMGl0">'; });

// add_filter( 'frenchpress_main_menu_align', function(){ return 'left'; } );

// add_filter( 'user_can_richedit' , '__return_false' );// disable visual editor
// add_filter( 'excerpt_length', function(){ return 80; } );// number of words in auto-generated excerpts (default 55)

// Hide various things that don't have options yet
// add_filter( 'frenchpress_page_titles', '__return_false' );// Don't display title on pages
// add_filter( 'frenchpress_sidebar', function($show){ return ( is_archive() || is_home() ) ? false : $show; } );
// add_filter( 'frenchpress_page_layout', function(){ return 'sidebars'; } );// 'sidebars, 'full-width', or 'no-sidebars' (default is no-sidebars on pages)

// add_filter( 'frenchpress_post_navigation', '__return_true' );// show next / prev post at the bottom of articles
// add_filter( 'frenchpress_blog_excerpts', '__return_false' );// show full post on blog home
// add_filter( 'frenchpress_archive_excerpts', '__return_false' );// show full post in archives

// No Meta
// function frenchpress_entry_meta() { return; }
// function frenchpress_entry_footer() { return; }

// set_post_thumbnail_size( 150, 150 );

// add_filter( 'frenchpress_site_branding', function(){return file_get_contents( __DIR__ .'/logo.svg' );} );

// add_filter( 'frenchpress_class_header_main', function(){ return "tray fff fff-middle fff-spacebetween fff-nowrap"; } );

// add_filter( 'frenchpress_title_in_header', '__return_true' );
// add_action('frenchpress_header_bottom', function(){ echo '<h1>' . wp_title('', false) . '</h1>'; } );


// featured image behind title
if ( !empty( $GLOBALS['frenchpress']->image_behind_title ) ) {
	add_filter( 'frenchpress_title_in_header', '__return_true' );
	add_action('wp_footer', 'frenchpress_image_behind_title');
	function frenchpress_image_behind_title(){
			
		global $wp_query;
		if ( empty($wp_query->queried_object_id) )// or get_queried_object_id() with no global needed.. returns 0 if no id
		{
			return;
		}
		$id = $wp_query->queried_object_id;
		
		// $image_url = $image_url ? $image_url[0] : '/wp-content/uploads/2016/08/london-slim-dark-1024x172.jpg';// default pic moved to CSS
		if ( $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' ) ) {
			echo "<style>@media(min-width:769px){#header-title{background-image:url({$image_url[0]})}}</style>";
		}
		
	}
}

if ( empty( $GLOBALS['frenchpress']->comment_form_unstyle ) )
{
	function frenchpress_comment_form_fields( $fields ){
		
		if ( empty( $GLOBALS['frenchpress']->comment_form_website_field ) ) unset( $fields['url'] );

		$req = false === strpos( $fields['email'], 'required' ) ? '' : '*';
		
		$fields['author'] = '<div class="fff fff-magic fff-pad">' 
			. str_replace( 
			['p class="', '</p>', 'label', 'size="30"'], 
			['span class="fffi ', '</span>', 'label class="screen-reader-text"', "placeholder='Name{$req}' style='width:100%'"], 
			$fields['author'] 
			);
		
		$fields['email'] = str_replace( 
			['p class="', '</p>', 'label', 'size="30"'], 
			['span class="fffi ', '</span>', 'label class="screen-reader-text"', "placeholder='Email{$req}' style='width:100%'"], 
			$fields['email'] 
			)  
			. '</div>';
		
		$fields['comment'] = str_replace( ['label', 'cols="45"'], ['label class="screen-reader-text"', "placeholder='Comment' style='width:100%'"], $fields['comment'] );
		
		return $fields;
		
	}
	add_filter( 'comment_form_fields', 'frenchpress_comment_form_fields' );
}
elseif ( empty( $GLOBALS['frenchpress']->comment_form_website_field ) )
{
	add_filter( 'comment_form_fields', function($fields){ unset($fields['url']); return $fields; } );// remove URL field from comment form

}