<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Initialize Genesis
require_once get_template_directory() . '/lib/init.php';

// Child theme definitions
define( 'CHILD_THEME_NAME', 'Bones for Genesis 2.0' );
define( 'CHILD_THEME_URL', 'http://bonesforgenesis.com/' );
define( 'CHILD_THEME_TEXT_DOMAIN', 'bfg' );

// Developer Tools
require_once CHILD_DIR . '/includes/developer-tools.php';

// Genesis
require_once CHILD_DIR . '/includes/genesis.php';				// Customizations to Genesis-specific functions

// Admin
require_once CHILD_DIR . '/includes/admin/admin-functions.php';	// Customization to admin functionality
require_once CHILD_DIR . '/includes/admin/admin-views.php';		// Customizations to the admin area display
require_once CHILD_DIR . '/includes/admin/admin-branding.php';	// Admin view customizations that specifically involve branding
require_once CHILD_DIR . '/includes/admin/admin-options.php';	// For adding/editing theme options to Genesis
require_once CHILD_DIR . '/includes/admin/admin-socialmedia.php';	// For adding/editing socialmedia options to RVA
require_once CHILD_DIR . '/includes/admin/admin-posts.php';	    // For adding/editing custom post options to RVA
require_once CHILD_DIR . '/includes/admin/admin-ajax.php';	    // For adding/editing ajax API endpoints
require_once CHILD_DIR . '/includes/admin/admin-menu.php';	    // For adding/editing ajax API endpoints
//require_once CHILD_DIR . '/includes/admin/my-settings.php';

// Structure (corresponds to Genesis's lib/structure)
require_once CHILD_DIR . '/includes/structure/advertizing.php';
require_once CHILD_DIR . '/includes/structure/archive.php';
require_once CHILD_DIR . '/includes/structure/comments.php';
require_once CHILD_DIR . '/includes/structure/footer.php';
require_once CHILD_DIR . '/includes/structure/forms.php';
require_once CHILD_DIR . '/includes/structure/header.php';
require_once CHILD_DIR . '/includes/structure/layout.php';
require_once CHILD_DIR . '/includes/structure/loops.php';
require_once CHILD_DIR . '/includes/structure/menu.php';
require_once CHILD_DIR . '/includes/structure/post.php';
require_once CHILD_DIR . '/includes/structure/schema.php';
require_once CHILD_DIR . '/includes/structure/search.php';
require_once CHILD_DIR . '/includes/structure/sidebar.php';

// Activation and deactivation handlers
//require_once CHILD_DIR . '/includes/activate_deactivate.php';

// Shame
require_once CHILD_DIR . '/includes/shame.php';					// For new code snippets that haven't been sorted and commented yet
