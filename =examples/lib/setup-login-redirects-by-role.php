/**
 * Set login redirects by user role
 */
/*
function login_redirect( $redirect_to, $request, $user ) {
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		// Administrator role
		if ( in_array( 'administrator', $user->roles ) ) {
			return $redirect_to;
    // Editor role
		} elseif ( in_array( 'editor', $user->roles ) ) {
			return $redirect_to;
    // Author role
    } elseif ( in_array( 'author', $user->roles ) ) {
			return $redirect_to;
    // Contributor role
		} elseif ( in_array( 'contributor', $user->roles ) ) {
			return $redirect_to;
    // Subscriber role
		} else {
			return $redirect_to;
		}
	} else {
		return $redirect_to;
	}
}
add_filter( 'login_redirect', __NAMESPACE__ . '\\login_redirect', 20, 3 );
*/
