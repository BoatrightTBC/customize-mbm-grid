// MBM add excerpt and authors to overlay div in book grid. 

add_filter( 'mbdb_book_grid_pre_image', 'rick_boatright_add_info_to_grid', 10, 2);
add_filter( 'mbdb_book_grid_pre_placeholder_image', 'rick_boatright_add_info_to_grid', 10, 2); 
function rick_boatright_add_info_to_grid( $content, $book_id ) {
	
	$content .= '<div class="overlay"><div class="text">';	
	
  	$authors = MBDBMA()->authors->get_authors_by_book( $book_id );
	$author_names = '';
	if ( $authors !== false ) {
		$author_names =  mbdbma_get_author_names( $authors ); // author names will be comma-delimited string of author names
	}
	$content .= '<p>by ' . str_replace(',', ' &',esc_html($author_names)) .'</p>'; 
	
	$book = MBDB()->book_factory->create_book( $book_id );
	$summary = $book->summary;
	$morePos = strpos($summary,'<!--more-->');
	if ($morePos > 0) {
	    $summary = substr($summary,0,$morePos) . "...";
	}
	
	global $wp_embed;
	$summary = $wp_embed->autoembed( $summary );
	$summary = $wp_embed->run_shortcode( $summary );
	$summary = wpautop( $summary );
	$summary = do_shortcode( $summary );
	
	$content .= $summary; 
	
	$content .= '</div></div>';
	return $content;
}
