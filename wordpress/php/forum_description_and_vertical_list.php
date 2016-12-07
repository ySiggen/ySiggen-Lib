//NOTE: this function is intended to be put in the theme folder
// in a file called "functions.php"

//Changing forum list to a vertical list and also displays forum description
function custom_list_forums( $args = '' ) {

        // Define used variables
        $output = $sub_forums = $topic_count = $reply_count = $counts = '';
        $i = 0;
        $count = array();

        // Parse arguments against default values
        $r = bbp_parse_args( $args, array(
                'before'            => '<ul class="bbp-forums-list">',
                'after'             => '</ul>',
                'link_before'       => '<li class="bbp-forum">',
                'link_after'        => '</li>',
                'count_before'      => ' (',
                'count_after'       => ')',
                'count_sep'         => ', ',
                'separator'         => '',
                'forum_id'          => '',
                'show_topic_count'  => true,//set show topic count
                'show_reply_count'  => false,//set show reply count
        ), 'list_forums' );

        // Loop through forums and create a list
        $sub_forums = bbp_forum_get_subforums( $r['forum_id'] );
        if ( !empty( $sub_forums ) ) {

                // Total count (for separator)
                $total_subs = count( $sub_forums );
                foreach ( $sub_forums as $sub_forum ) {
                        $i++; // Separator count

                        // Get forum details
                        $count     = array();
                        $show_sep  = $total_subs > $i ? $r['separator'] : '';
                        $permalink = bbp_get_forum_permalink( $sub_forum->ID );
                        $title     = bbp_get_forum_title( $sub_forum->ID );
                        $content = bbp_get_forum_content($sub_forum->ID) ;

                        // Show custom message with topic count
                        if ( !empty( $r['show_topic_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
                                $topic_count = bbp_get_forum_topic_count($sub_forum->ID);
                                if( $topic_count === '0' || $topic_count === '1' ){
                                        $count['topic'] = $topic_count . " sujet";
                                }else{
                                        $count['topic'] = $topic_count . " sujets";
                                }
                        }

                        // Show reply count
                        if ( !empty( $r['show_reply_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
                                $count['reply'] = bbp_get_forum_reply_count( $sub_forum->ID );
                        }

                        // Counts to show
                        if ( !empty( $count ) ) {
                                $counts = $r['count_before'] . implode( $r['count_sep'], $count ) . $r['count_after'];
                        }

                        // Build this sub forums link
                        $output .= $r['before'].$r['link_before'] . '<a href="' . esc_url( $permalink ) . '" class="bbp-forum-link">' . $title . $counts . '</a>' . $show_sep . $r['link_after'].'<div class="bbp-forum-content">'.$content.'</div>'.$r['after'];
                }

                // Output the list
                return $output ;
        }
}

add_filter('bbp_list_forums', 'custom_list_forums' );