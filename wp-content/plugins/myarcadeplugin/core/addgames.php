<?php
 if ( ! defined( 'ABSPATH' ) ) { exit; } function myarcade_clean_eol( $string ) { return str_replace( array( '\r\n', '\r', '\n'), '', $string ); } function F3EC5FD80BBB0380830A5FDD537A22AB2($R69F05BD3024E3A18B29F11DF8A3E8C79) { global $wpdb; $R8814F4A1B21522478A4F9C3072C0C638 = array( "postid" => NULL, "uuid" => $R69F05BD3024E3A18B29F11DF8A3E8C79->uuid, "game_tag" => $R69F05BD3024E3A18B29F11DF8A3E8C79->game_tag, "game_type" => $R69F05BD3024E3A18B29F11DF8A3E8C79->type, "name" => $R69F05BD3024E3A18B29F11DF8A3E8C79->name, "slug" => $R69F05BD3024E3A18B29F11DF8A3E8C79->slug, "categories" => $R69F05BD3024E3A18B29F11DF8A3E8C79->categs, "description" => myarcade_clean_eol($R69F05BD3024E3A18B29F11DF8A3E8C79->description), "tags" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->tags) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->tags : '', "instructions"=> isset($R69F05BD3024E3A18B29F11DF8A3E8C79->instructions) ? myarcade_clean_eol($R69F05BD3024E3A18B29F11DF8A3E8C79->instructions) : '', "controls" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->control) ? myarcade_clean_eol($R69F05BD3024E3A18B29F11DF8A3E8C79->control) : '', "rating" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->rating) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->rating : '', "height" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->height) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->height : '', "width" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->width) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->width : '', "thumbnail_url" => $R69F05BD3024E3A18B29F11DF8A3E8C79->thumbnail_url, "swf_url" => $R69F05BD3024E3A18B29F11DF8A3E8C79->swf_url, "screen1_url" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->screen1_url) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->screen1_url : '', "screen2_url" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->screen2_url) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->screen2_url : '', "screen3_url" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->screen3_url) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->screen3_url : '', "screen4_url" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->screen4_url) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->screen4_url : '', "video_url" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->video_url) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->video_url : '', "created" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->created) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->created : date( 'Y-m-d h:i:s', time() ), "leaderboard_enabled" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->leaderboard_enabled) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->leaderboard_enabled : '', "highscore_type" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->highscore_type) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->highscore_type : '', "score_bridge" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->score_bridge) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->score_bridge : '', "coins_enabled" => isset($R69F05BD3024E3A18B29F11DF8A3E8C79->coins_enabled) ? $R69F05BD3024E3A18B29F11DF8A3E8C79->coins_enabled : '', "status" => "new", ); if ( F8D7A841BE2BAF925673E60D5753C8806() !== FALSE ) { $wpdb->insert( $wpdb->prefix . 'myarcadegames', $R8814F4A1B21522478A4F9C3072C0C638 ); } } function FA3108B209B262E5BA054E72041A692F3($R69F05BD3024E3A18B29F11DF8A3E8C79) { global $wpdb; $general = get_option('myarcade_general'); if ( $general['single'] ) { $R69F05BD3024E3A18B29F11DF8A3E8C79->categories = array(); $R69F05BD3024E3A18B29F11DF8A3E8C79->categories[0] = $general['singlecat']; } if ( ( ($general['translation'] == 'microsoft') && ( !empty($general['bingid']) && !empty($general['bingsecret']) ) ) || ( ($general['translation'] == 'google') && ( !empty($general['google_id']) ) ) ) { foreach ($general['translate_fields'] as $R4454E360FFF252043E577C8411615F0E) { if ( isset($R69F05BD3024E3A18B29F11DF8A3E8C79->$R4454E360FFF252043E577C8411615F0E) && !empty($R69F05BD3024E3A18B29F11DF8A3E8C79->$R4454E360FFF252043E577C8411615F0E) ) { $R797676A5A4E9FE6F4E82794CE76EACD1 = FD534B171CE70857BCD1CDF656A5850BD($R69F05BD3024E3A18B29F11DF8A3E8C79->$R4454E360FFF252043E577C8411615F0E); if ( $R797676A5A4E9FE6F4E82794CE76EACD1 != false ) { $R69F05BD3024E3A18B29F11DF8A3E8C79->$R4454E360FFF252043E577C8411615F0E = $R797676A5A4E9FE6F4E82794CE76EACD1; } } } } if ($general['use_template'] ) { $R591056A2F4662A99D54E91F9CC2A9BEB = $general['template']; $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%THUMB_URL%", $R69F05BD3024E3A18B29F11DF8A3E8C79->thumb, $R591056A2F4662A99D54E91F9CC2A9BEB); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%THUMB%", '<img src="' . $R69F05BD3024E3A18B29F11DF8A3E8C79->thumb . '" alt="' . $R69F05BD3024E3A18B29F11DF8A3E8C79->name . '" />', $R591056A2F4662A99D54E91F9CC2A9BEB); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%TITLE%", $R69F05BD3024E3A18B29F11DF8A3E8C79->name, $R591056A2F4662A99D54E91F9CC2A9BEB); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%DESCRIPTION%", $R69F05BD3024E3A18B29F11DF8A3E8C79->description, $R591056A2F4662A99D54E91F9CC2A9BEB); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%INSTRUCTIONS%", $R69F05BD3024E3A18B29F11DF8A3E8C79->instructions, $R591056A2F4662A99D54E91F9CC2A9BEB); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%SWF_URL%", $R69F05BD3024E3A18B29F11DF8A3E8C79->file, $R591056A2F4662A99D54E91F9CC2A9BEB); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%WIDTH%", $R69F05BD3024E3A18B29F11DF8A3E8C79->width, $R591056A2F4662A99D54E91F9CC2A9BEB); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%HEIGHT%", $R69F05BD3024E3A18B29F11DF8A3E8C79->height, $R591056A2F4662A99D54E91F9CC2A9BEB); $R379265D71032ADD9E2C0460D1C6F1E7C = explode(',', $R69F05BD3024E3A18B29F11DF8A3E8C79->tags); $REF37DC69113FB414058A5088BC1FA494 = ''; foreach ($R379265D71032ADD9E2C0460D1C6F1E7C as $R7B047B1F72F109F9014E4EC7D823FE83) { $REF37DC69113FB414058A5088BC1FA494 .= trim($R7B047B1F72F109F9014E4EC7D823FE83).', '; } $REF37DC69113FB414058A5088BC1FA494 = substr($REF37DC69113FB414058A5088BC1FA494, 0, strlen($REF37DC69113FB414058A5088BC1FA494) - 2); $R591056A2F4662A99D54E91F9CC2A9BEB = str_replace("%TAGS%", $REF37DC69113FB414058A5088BC1FA494, $R591056A2F4662A99D54E91F9CC2A9BEB); } else { $R591056A2F4662A99D54E91F9CC2A9BEB = '<img src="' . $R69F05BD3024E3A18B29F11DF8A3E8C79->thumb . '" alt="' . $R69F05BD3024E3A18B29F11DF8A3E8C79->name . '" style="float:left;margin-right:5px;">' . $R69F05BD3024E3A18B29F11DF8A3E8C79->description.' '.$R69F05BD3024E3A18B29F11DF8A3E8C79->instructions; } $post = array(); $post['post_title'] = $R69F05BD3024E3A18B29F11DF8A3E8C79->name; $post['post_content'] = $R591056A2F4662A99D54E91F9CC2A9BEB; $post['post_status'] = $R69F05BD3024E3A18B29F11DF8A3E8C79->publish_status; $post['post_author'] = apply_filters( 'myarcade_filter_post_author', $R69F05BD3024E3A18B29F11DF8A3E8C79->user, $R69F05BD3024E3A18B29F11DF8A3E8C79); if ( $general['post_type'] != 'post' && post_type_exists($general['post_type']) ) { $post['post_type'] = $general['post_type']; } else { $post['post_type'] = 'post'; $post['post_category'] = apply_filters( 'myarcade_filter_category', $R69F05BD3024E3A18B29F11DF8A3E8C79->categories, $R69F05BD3024E3A18B29F11DF8A3E8C79 ); if ( !isset($general['disable_game_tags']) || $general['disable_game_tags'] == false ) { $post['tags_input'] = apply_filters( 'myarcade_filter_tags', $R69F05BD3024E3A18B29F11DF8A3E8C79->tags, $R69F05BD3024E3A18B29F11DF8A3E8C79 ); } } $post['post_date'] = $R69F05BD3024E3A18B29F11DF8A3E8C79->date; $post_id = wp_insert_post($post); add_post_meta($post_id, 'mabp_game_type', $R69F05BD3024E3A18B29F11DF8A3E8C79->type); add_post_meta($post_id, 'mabp_description', $R69F05BD3024E3A18B29F11DF8A3E8C79->description); if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->instructions ) { add_post_meta($post_id, 'mabp_instructions', $R69F05BD3024E3A18B29F11DF8A3E8C79->instructions); } add_post_meta($post_id, 'mabp_swf_url', $R69F05BD3024E3A18B29F11DF8A3E8C79->file); add_post_meta($post_id, 'mabp_thumbnail_url', $R69F05BD3024E3A18B29F11DF8A3E8C79->thumb); add_post_meta($post_id, 'mabp_game_tag', $R69F05BD3024E3A18B29F11DF8A3E8C79->game_tag); add_post_meta($post_id, 'mabp_game_uuid', $R69F05BD3024E3A18B29F11DF8A3E8C79->uuid); add_post_meta($post_id, 'mabp_game_slug', $R69F05BD3024E3A18B29F11DF8A3E8C79->slug); if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->height ) { add_post_meta($post_id, 'mabp_height', $R69F05BD3024E3A18B29F11DF8A3E8C79->height); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->width ) { add_post_meta($post_id, 'mabp_width', $R69F05BD3024E3A18B29F11DF8A3E8C79->width); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->rating ) { add_post_meta($post_id, 'mabp_rating', $R69F05BD3024E3A18B29F11DF8A3E8C79->rating); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->screen1_url ) { add_post_meta($post_id, 'mabp_screen1_url', $R69F05BD3024E3A18B29F11DF8A3E8C79->screen1_url); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->screen2_url ) { add_post_meta($post_id, 'mabp_screen2_url', $R69F05BD3024E3A18B29F11DF8A3E8C79->screen2_url); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->screen3_url ) { add_post_meta($post_id, 'mabp_screen3_url', $R69F05BD3024E3A18B29F11DF8A3E8C79->screen3_url); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->screen4_url ) { add_post_meta($post_id, 'mabp_screen4_url', $R69F05BD3024E3A18B29F11DF8A3E8C79->screen4_url); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->video_url ) { add_post_meta($post_id, 'mabp_video_url', $R69F05BD3024E3A18B29F11DF8A3E8C79->video_url); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->leaderboard_enabled ) { add_post_meta($post_id, 'mabp_leaderboard', $R69F05BD3024E3A18B29F11DF8A3E8C79->leaderboard_enabled); add_post_meta($post_id, 'mabp_score_order', $R69F05BD3024E3A18B29F11DF8A3E8C79->highscore_type); } if ( $R69F05BD3024E3A18B29F11DF8A3E8C79->score_bridge ) { add_post_meta($post_id, 'mabp_score_bridge', $R69F05BD3024E3A18B29F11DF8A3E8C79->score_bridge); } if ( $general['featured_image'] ) { F741EF4D4E6192F11E171D12B52378EFD( $post_id, $R69F05BD3024E3A18B29F11DF8A3E8C79->thumb ); } if ( $general['post_type'] != 'post' && post_type_exists($general['post_type']) ) { if ( !empty($general['custom_category']) && taxonomy_exists($general['custom_category']) ) { $R30E38C1F8EC85F8EE8DF620FF3267157 = apply_filters( 'myarcade_filter_category', $R69F05BD3024E3A18B29F11DF8A3E8C79->categories, $R69F05BD3024E3A18B29F11DF8A3E8C79 ); wp_set_object_terms($post_id, $R30E38C1F8EC85F8EE8DF620FF3267157, $general['custom_category']); } if ( !isset($general['disable_game_tags']) || $general['disable_game_tags'] == false ) { if ( !empty($general['custom_tags']) && taxonomy_exists($general['custom_tags']) ) { $R3FA8DA3402B9B24298B2CE820E453C70 = apply_filters( 'myarcade_filter_tags', $R69F05BD3024E3A18B29F11DF8A3E8C79->tags, $R69F05BD3024E3A18B29F11DF8A3E8C79 ); wp_set_post_terms($post_id, $R3FA8DA3402B9B24298B2CE820E453C70, $general['custom_tags']); } } } $wpdb->query( "UPDATE " . $wpdb->prefix . 'myarcadegames' . " SET postid = '{$post_id}' WHERE id = '{$R69F05BD3024E3A18B29F11DF8A3E8C79->id}'" ); do_action( 'myarcade_post_created', $post_id ); return $post_id; } function F5F9EB2BD2DA652CBF122EEF75C2BE581( $R9FE302BDF914868081913A22F58F9E7E = array() ) { global $wpdb, $user_ID, $myarcade_feedback; $general = get_option('myarcade_general'); $R1C087CFC2417747F08C78E3E5D5121E5 = array( 'game_id' => false, 'post_status' => 'publish', 'post_date' => gmdate('Y-m-d H:i:s', ( time() + (get_option('gmt_offset') * 3600 ))), 'download_games' => $general['down_games'], 'download_thumbs' => $general['down_thumbs'], 'download_screens' => $general['down_screens'], 'echo' => true ); $RAA7BB4B05FBD27DB7CA594893F166B47 = wp_parse_args( $R9FE302BDF914868081913A22F58F9E7E, $R1C087CFC2417747F08C78E3E5D5121E5 ); extract($RAA7BB4B05FBD27DB7CA594893F166B47); if ( $echo ) { $R18B9FF5D8D2E831C0C9A41AD46B16D66 = "echo"; } else { $R18B9FF5D8D2E831C0C9A41AD46B16D66 = "return"; } $RE435FF5985415B26D99720ED8C5561DF = array( 'output' => $echo ); if ( ! $game_id ) { $myarcade_feedback->F12C73D1B465E39C31D3A2333B5E23252( __("Game ID not provided.", 'myarcadeplugin') ); $myarcade_feedback->F9410AC7F3C3857FC94CCAA66947E2F34( $RE435FF5985415B26D99720ED8C5561DF ); return false; } $R6448B84C2E3B0C1F0D4E33910AA3EC61 = new StdClass(); if ( $echo && function_exists( 'myarcade_header' ) ) { F94EBD7C16769D03E06E16136FFE5F944($echo); } F27CA820034C3FB0E279A5518739B60BC($echo); $R281A0F7BC3D849F3386A5AC36FB35807 = get_option('myarcade_categories'); $RFFAF54C149652171BCA687930CA13804 = false; if ( ($general['post_type'] != 'post') && post_type_exists($general['post_type']) ) { if ( !empty($general['custom_category']) && taxonomy_exists($general['custom_category']) ) { $RFFAF54C149652171BCA687930CA13804 = true; } } $R69F05BD3024E3A18B29F11DF8A3E8C79 = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . 'myarcadegames' . " WHERE id = '".$game_id."' limit 1"); if ( !$R69F05BD3024E3A18B29F11DF8A3E8C79 ) { $myarcade_feedback->F12C73D1B465E39C31D3A2333B5E23252( __("Can't find the game in the games database table.", 'myarcadeplugin') ); $myarcade_feedback->F9410AC7F3C3857FC94CCAA66947E2F34( $RE435FF5985415B26D99720ED8C5561DF ); return false; } if (md5($R69F05BD3024E3A18B29F11DF8A3E8C79->name . 'import') == $R69F05BD3024E3A18B29F11DF8A3E8C79->uuid) { $download_games = false; $download_thumbs = false; $download_screens = false; } switch ( $R69F05BD3024E3A18B29F11DF8A3E8C79->game_type ) { case 'bigfish': case 'scirra': case 'iframe': case 'embed': case 'gamepix': { $download_games = false; } } $RA1ED191365ABDD5CF62F138014E57648 = array(); $R324992E1D908AE64E82FC7E5043BAFCC = explode(",", $R69F05BD3024E3A18B29F11DF8A3E8C79->categories); if ( $general['firstcat'] == true ) { $R0C210AE4A1EB1149196E17260FA6E46C = $R324992E1D908AE64E82FC7E5043BAFCC[0]; unset($R324992E1D908AE64E82FC7E5043BAFCC); $R324992E1D908AE64E82FC7E5043BAFCC = array(); $R324992E1D908AE64E82FC7E5043BAFCC[0] = $R0C210AE4A1EB1149196E17260FA6E46C; } if ( 'bigfish' == $R69F05BD3024E3A18B29F11DF8A3E8C79->game_type ) { $bigfish = get_option( 'myarcade_bigfish' ); $R281A0F7BC3D849F3386A5AC36FB35807 = $bigfish['categories']; } foreach ($R324992E1D908AE64E82FC7E5043BAFCC as $R43CB7DE4CF52CFD74952A10702266570) { $R27B4DD26AC3317BE69F6A6DFB725A36D = false; foreach ($R281A0F7BC3D849F3386A5AC36FB35807 as $RAE9A4476893066B7B92C648E9F0FDEE8) { if ($RAE9A4476893066B7B92C648E9F0FDEE8['Name'] == $R43CB7DE4CF52CFD74952A10702266570) { $R27B4DD26AC3317BE69F6A6DFB725A36D = true; if (!empty($RAE9A4476893066B7B92C648E9F0FDEE8['Mapping'])) { $R44D5507942BD37F2E8BE220EC293D024 = explode(",", $RAE9A4476893066B7B92C648E9F0FDEE8['Mapping']); foreach ($R44D5507942BD37F2E8BE220EC293D024 as $R925737EF34C80F95F51826BA04A4D3F8) { array_push($RA1ED191365ABDD5CF62F138014E57648, $R925737EF34C80F95F51826BA04A4D3F8); } } else { if ($RFFAF54C149652171BCA687930CA13804) { $R4323303B130B1FD6EF0F31C87DFCC7A5 = get_term_by( 'name', $R43CB7DE4CF52CFD74952A10702266570, $general['custom_category'] ); if ( ! empty( $R4323303B130B1FD6EF0F31C87DFCC7A5->term_id ) ) { array_push( $RA1ED191365ABDD5CF62F138014E57648, $R4323303B130B1FD6EF0F31C87DFCC7A5->term_id ); } else { array_push($RA1ED191365ABDD5CF62F138014E57648, htmlspecialchars( $R43CB7DE4CF52CFD74952A10702266570 ) ); } } else { array_push( $RA1ED191365ABDD5CF62F138014E57648, get_cat_id( htmlspecialchars($R43CB7DE4CF52CFD74952A10702266570 ) ) ); } } break; } } if ($R27B4DD26AC3317BE69F6A6DFB725A36D == false) { if ( $RFFAF54C149652171BCA687930CA13804 ) { $R4323303B130B1FD6EF0F31C87DFCC7A5 = get_term_by( 'name', $R43CB7DE4CF52CFD74952A10702266570, $general['custom_category'] ); if ( ! empty( $R4323303B130B1FD6EF0F31C87DFCC7A5->term_id ) ) { array_push( $RA1ED191365ABDD5CF62F138014E57648, $R4323303B130B1FD6EF0F31C87DFCC7A5->term_id ); } else { array_push($RA1ED191365ABDD5CF62F138014E57648, htmlspecialchars( $R43CB7DE4CF52CFD74952A10702266570 ) ); } } else { array_push($RA1ED191365ABDD5CF62F138014E57648, get_cat_id($R43CB7DE4CF52CFD74952A10702266570)); } } } $R8AEB7B2E251FB4D3274ABB9CC7BBC93B = array( 'url' => __("Use URL provided by the game distributor.", 'myarcadeplugin'), 'thumbnail' => __("Download Thumbnail", 'myarcadeplugin'), 'screen' => __("Download Screenshot", 'myarcadeplugin'), 'game' => __("Download Game", 'myarcadeplugin'), 'failed' => __("FAILED", 'myarcadeplugin'), 'ok' => __("OK", 'myarcadeplugin') ); $RFB526B65F5855576F246DC484BDC7151 = F3DACEAC2AA958620BACA475E15A8207D($R69F05BD3024E3A18B29F11DF8A3E8C79->slug, $R69F05BD3024E3A18B29F11DF8A3E8C79->game_type); if ($download_thumbs == true) { $R09A33463761E506248078D422B1C5226 = F6F8EB9DF17613F857E74D2C8D503672D($R69F05BD3024E3A18B29F11DF8A3E8C79->thumbnail_url, true); if ( empty($R09A33463761E506248078D422B1C5226['error']) ) { $R885DBF1CA3408BA0A6A9486E19A20734 = pathinfo($R69F05BD3024E3A18B29F11DF8A3E8C79->thumbnail_url); $R33D3EC748433467E20D0947C3032E305 = $R885DBF1CA3408BA0A6A9486E19A20734['extension']; $R4C5B71D718D81A27800DE45FCEA33176 = $R69F05BD3024E3A18B29F11DF8A3E8C79->slug . '.' . $R33D3EC748433467E20D0947C3032E305; if (!strncmp($R09A33463761E506248078D422B1C5226['response'], "<!DOCTYPE", 9)) { $R679E9B9234E2062F809DBD3325D37FB6 = false; } else { $R679E9B9234E2062F809DBD3325D37FB6 = file_put_contents( $RFB526B65F5855576F246DC484BDC7151['thumbsdir'] . $R4C5B71D718D81A27800DE45FCEA33176, $R09A33463761E506248078D422B1C5226['response']); } if ($R679E9B9234E2062F809DBD3325D37FB6 == false) { $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['thumbnail'] . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['failed'] . ' - ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['url'] ); } else { $R69F05BD3024E3A18B29F11DF8A3E8C79->thumbnail_url = $RFB526B65F5855576F246DC484BDC7151['thumbsurl'] . $R4C5B71D718D81A27800DE45FCEA33176; $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['thumbnail'] . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['ok'] ); } } else { $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['thumbnail'] . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['failed'] . ' - ' . $R09A33463761E506248078D422B1C5226['error'] . ' - ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['url'] ); } } for ($R0EB57C777E777ED2D292DE0BF33EB4D3 = 1; $R0EB57C777E777ED2D292DE0BF33EB4D3 <= 4; $R0EB57C777E777ED2D292DE0BF33EB4D3++) { $R55BC037E8E1B2BC3453F9F1214B6469E = 'screen' . $R0EB57C777E777ED2D292DE0BF33EB4D3 . "_url"; if (($download_screens == true) && ($R69F05BD3024E3A18B29F11DF8A3E8C79->$R55BC037E8E1B2BC3453F9F1214B6469E)) { $R09A33463761E506248078D422B1C5226 = F6F8EB9DF17613F857E74D2C8D503672D($R69F05BD3024E3A18B29F11DF8A3E8C79->$R55BC037E8E1B2BC3453F9F1214B6469E, true); $R232692C766FDBDC36C50D236CE528F16 = sprintf( __("Downloading Screenshot No. %s", 'myarcadeplugin'), $R0EB57C777E777ED2D292DE0BF33EB4D3); if ( empty($R09A33463761E506248078D422B1C5226['error']) ) { $R885DBF1CA3408BA0A6A9486E19A20734 = pathinfo($R69F05BD3024E3A18B29F11DF8A3E8C79->$R55BC037E8E1B2BC3453F9F1214B6469E); $R33D3EC748433467E20D0947C3032E305 = $R885DBF1CA3408BA0A6A9486E19A20734['extension']; $R4C5B71D718D81A27800DE45FCEA33176 = $R69F05BD3024E3A18B29F11DF8A3E8C79->slug . '_img' . $R0EB57C777E777ED2D292DE0BF33EB4D3 . '.' . $R33D3EC748433467E20D0947C3032E305; if (!strncmp($R09A33463761E506248078D422B1C5226['response'], "<!DOCTYPE", 9)) { $R679E9B9234E2062F809DBD3325D37FB6 = false; } else { $R679E9B9234E2062F809DBD3325D37FB6 = file_put_contents( $RFB526B65F5855576F246DC484BDC7151['thumbsdir'] . $R4C5B71D718D81A27800DE45FCEA33176, $R09A33463761E506248078D422B1C5226['response']); } if ($R679E9B9234E2062F809DBD3325D37FB6) { $R69F05BD3024E3A18B29F11DF8A3E8C79->$R55BC037E8E1B2BC3453F9F1214B6469E = $RFB526B65F5855576F246DC484BDC7151['thumbsurl'] . $R4C5B71D718D81A27800DE45FCEA33176; $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R232692C766FDBDC36C50D236CE528F16 . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['ok'] ); } else { $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R232692C766FDBDC36C50D236CE528F16 . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['failed'] . ' - ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['url'] ); } } else { $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R232692C766FDBDC36C50D236CE528F16 . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['failed'] . ' - ' . $R09A33463761E506248078D422B1C5226['error'] . ' - ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['url'] ); } } $R6448B84C2E3B0C1F0D4E33910AA3EC61->$R55BC037E8E1B2BC3453F9F1214B6469E = apply_filters( 'myarcade_filter_screenshot', $R69F05BD3024E3A18B29F11DF8A3E8C79->$R55BC037E8E1B2BC3453F9F1214B6469E, $R55BC037E8E1B2BC3453F9F1214B6469E ); } if ($download_games == true) { $R69F05BD3024E3A18B29F11DF8A3E8C79->swf_url = strtok($R69F05BD3024E3A18B29F11DF8A3E8C79->swf_url, '?'); $R09A33463761E506248078D422B1C5226 = F6F8EB9DF17613F857E74D2C8D503672D($R69F05BD3024E3A18B29F11DF8A3E8C79->swf_url, true); if ( empty($R09A33463761E506248078D422B1C5226['error']) ) { $R885DBF1CA3408BA0A6A9486E19A20734 = pathinfo($R69F05BD3024E3A18B29F11DF8A3E8C79->swf_url); $R33D3EC748433467E20D0947C3032E305 = $R885DBF1CA3408BA0A6A9486E19A20734['extension']; $R4C5B71D718D81A27800DE45FCEA33176 = $R69F05BD3024E3A18B29F11DF8A3E8C79->slug . '.' . $R33D3EC748433467E20D0947C3032E305; if (!strncmp($R09A33463761E506248078D422B1C5226['response'], "<!DOCTYPE", 9)) { $R679E9B9234E2062F809DBD3325D37FB6 = false; } else { $R679E9B9234E2062F809DBD3325D37FB6 = file_put_contents( $RFB526B65F5855576F246DC484BDC7151['gamesdir'] . $R4C5B71D718D81A27800DE45FCEA33176, $R09A33463761E506248078D422B1C5226['response']); } if ($R679E9B9234E2062F809DBD3325D37FB6 == false) { $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['game'] . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['failed'] . ' - ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['url']); } else { $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['game'] . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['ok'] ); $R69F05BD3024E3A18B29F11DF8A3E8C79->swf_url = $RFB526B65F5855576F246DC484BDC7151['gamesurl'] . $R4C5B71D718D81A27800DE45FCEA33176; } } else { $myarcade_feedback->FA9C1FF81C2FBCE5A09D418A70752BF3E( $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['game'] . ': ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['failed'] . ' - ' . $R09A33463761E506248078D422B1C5226['error'] . ' - ' . $R8AEB7B2E251FB4D3274ABB9CC7BBC93B['url'] ); } } if ($echo) { $myarcade_feedback->F62DD3935DEA0EEDDC85A63DF386943D3( array('output' => 'echo') ); } get_currentuserinfo(); $R6448B84C2E3B0C1F0D4E33910AA3EC61->user = ( !empty($user_ID) ) ? $user_ID : 1; if ( $user_ID && !current_user_can('publish_posts') ) { $post_status = 'draft'; } if ( $post_date ) { $R6448B84C2E3B0C1F0D4E33910AA3EC61->date = $post_date; } else { $R6448B84C2E3B0C1F0D4E33910AA3EC61->date = gmdate('Y-m-d H:i:s', ( time() + (get_option('gmt_offset') * 3600 ))); } $R6448B84C2E3B0C1F0D4E33910AA3EC61->id = $R69F05BD3024E3A18B29F11DF8A3E8C79->id; $R6448B84C2E3B0C1F0D4E33910AA3EC61->uuid = $R69F05BD3024E3A18B29F11DF8A3E8C79->uuid; $R6448B84C2E3B0C1F0D4E33910AA3EC61->name = $R69F05BD3024E3A18B29F11DF8A3E8C79->name; $R6448B84C2E3B0C1F0D4E33910AA3EC61->slug = $R69F05BD3024E3A18B29F11DF8A3E8C79->slug; $R6448B84C2E3B0C1F0D4E33910AA3EC61->file = apply_filters( 'myarcade_filter_game_code', $R69F05BD3024E3A18B29F11DF8A3E8C79->swf_url, $R69F05BD3024E3A18B29F11DF8A3E8C79->game_type ); $R6448B84C2E3B0C1F0D4E33910AA3EC61->width = $R69F05BD3024E3A18B29F11DF8A3E8C79->width; $R6448B84C2E3B0C1F0D4E33910AA3EC61->height = $R69F05BD3024E3A18B29F11DF8A3E8C79->height; $R6448B84C2E3B0C1F0D4E33910AA3EC61->thumb = apply_filters( 'myarcade_filter_thumbnail', $R69F05BD3024E3A18B29F11DF8A3E8C79->thumbnail_url ); $R6448B84C2E3B0C1F0D4E33910AA3EC61->description = $R69F05BD3024E3A18B29F11DF8A3E8C79->description; $R6448B84C2E3B0C1F0D4E33910AA3EC61->instructions = $R69F05BD3024E3A18B29F11DF8A3E8C79->instructions; $R6448B84C2E3B0C1F0D4E33910AA3EC61->video_url = $R69F05BD3024E3A18B29F11DF8A3E8C79->video_url; $R6448B84C2E3B0C1F0D4E33910AA3EC61->tags = $R69F05BD3024E3A18B29F11DF8A3E8C79->tags; $R6448B84C2E3B0C1F0D4E33910AA3EC61->rating = $R69F05BD3024E3A18B29F11DF8A3E8C79->rating; $R6448B84C2E3B0C1F0D4E33910AA3EC61->categories = $RA1ED191365ABDD5CF62F138014E57648; $R6448B84C2E3B0C1F0D4E33910AA3EC61->type = $R69F05BD3024E3A18B29F11DF8A3E8C79->game_type; $R6448B84C2E3B0C1F0D4E33910AA3EC61->publish_status = $post_status; $R6448B84C2E3B0C1F0D4E33910AA3EC61->leaderboard_enabled = $R69F05BD3024E3A18B29F11DF8A3E8C79->leaderboard_enabled; $R6448B84C2E3B0C1F0D4E33910AA3EC61->game_tag = $R69F05BD3024E3A18B29F11DF8A3E8C79->game_tag; $R6448B84C2E3B0C1F0D4E33910AA3EC61->highscore_type = $R69F05BD3024E3A18B29F11DF8A3E8C79->highscore_type; $R6448B84C2E3B0C1F0D4E33910AA3EC61->score_bridge = $R69F05BD3024E3A18B29F11DF8A3E8C79->score_bridge; $post_id = FA3108B209B262E5BA054E72041A692F3($R6448B84C2E3B0C1F0D4E33910AA3EC61); if ( $post_id ) { $wpdb->query( "UPDATE " . $wpdb->prefix . 'myarcadegames' . " SET status = 'published' WHERE id = '".$R69F05BD3024E3A18B29F11DF8A3E8C79->id."'" ); return $post_id; } return false; } function F741EF4D4E6192F11E171D12B52378EFD ($post_id, $R3656889A448A7AF799D2D7955BED2354) { $RE5F9A6B0B4BBE218E83650A53BD26795 = wp_check_filetype( basename($R3656889A448A7AF799D2D7955BED2354), null ); require_once(ABSPATH . 'wp-admin/includes/image.php'); require_once(ABSPATH . 'wp-admin/includes/file.php'); require_once(ABSPATH . 'wp-admin/includes/media.php'); $RCC5C6E696C11A4FDF170ECE8BA9FDC6F = download_url( $R3656889A448A7AF799D2D7955BED2354 ); preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $R3656889A448A7AF799D2D7955BED2354, $R2BC3A0F3554F7C295CD3CC4A57492121); $R16D1B0AC18364ED23DBD4FC59D354CA4['name'] = basename($R3656889A448A7AF799D2D7955BED2354); $R16D1B0AC18364ED23DBD4FC59D354CA4['tmp_name'] = $RCC5C6E696C11A4FDF170ECE8BA9FDC6F; $R16D1B0AC18364ED23DBD4FC59D354CA4['type'] = $RE5F9A6B0B4BBE218E83650A53BD26795['type']; if ( is_wp_error( $RCC5C6E696C11A4FDF170ECE8BA9FDC6F ) ) { @unlink($R16D1B0AC18364ED23DBD4FC59D354CA4['tmp_name']); $R16D1B0AC18364ED23DBD4FC59D354CA4['tmp_name'] = ''; return false; } $RC0B35CFDE091CB252B61C8701CC128E9 = media_handle_sideload($R16D1B0AC18364ED23DBD4FC59D354CA4, $post_id); if ( is_wp_error($RC0B35CFDE091CB252B61C8701CC128E9) ) { @unlink($R16D1B0AC18364ED23DBD4FC59D354CA4['tmp_name']); return $RC0B35CFDE091CB252B61C8701CC128E9; } set_post_thumbnail($post_id, $RC0B35CFDE091CB252B61C8701CC128E9); } function FF09D7482BA5FAADAB6D947666FFD8C43( $R69F05BD3024E3A18B29F11DF8A3E8C79 , $echo = false ) { global $wpdb; if ( F8D7A841BE2BAF925673E60D5753C8806() === FALSE ) { return; } F3EC5FD80BBB0380830A5FDD537A22AB2( $R69F05BD3024E3A18B29F11DF8A3E8C79 ); if ( $echo ) { $R32FB07B9B705048D62F3CE6A86FE4481 = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . 'myarcadegames' . " WHERE uuid = '$R69F05BD3024E3A18B29F11DF8A3E8C79->uuid' LIMIT 1"); F45F5711588CBBE95A6882D30A6F8183B( $R32FB07B9B705048D62F3CE6A86FE4481 ); } } function FC6BC39ED73177ED6BA0A3E5B1C3D6848( $RA1D44C0654A40984A103C270FFB9BF33, $echo = false ) { if ( ! $echo ) { return; } if ( $RA1D44C0654A40984A103C270FFB9BF33 > 0 ) { echo '<p class="mabp_info"><strong>'.sprintf(__("Found %s new game(s).", 'myarcadeplugin'), $RA1D44C0654A40984A103C270FFB9BF33).'</strong></p>'; echo '<p class="mabp_info">'.__("Now, you can publish new games on your site.", 'myarcadeplugin').'</p>'; } else { echo '<p class="mabp_error">'.__("No new games found!", 'myarcadeplugin').'</p>'; } } function F64A2F46BC8BAFD9163DD9691D1207278( $R8409EAA6EC0CE2EA307354B2E150F8C2 ) { $R7C60D7E1C05E3B82EF26F41346F5D850 = sanitize_title($R8409EAA6EC0CE2EA307354B2E150F8C2); $R7C60D7E1C05E3B82EF26F41346F5D850 = strtolower( str_replace(" ", "-", $R8409EAA6EC0CE2EA307354B2E150F8C2 ) ); $R7C60D7E1C05E3B82EF26F41346F5D850 = preg_replace('/-+/', '-', $R7C60D7E1C05E3B82EF26F41346F5D850); $R7C60D7E1C05E3B82EF26F41346F5D850 = preg_replace("/[^\dA-Za-z0-9-]/i", "", $R7C60D7E1C05E3B82EF26F41346F5D850); return $R7C60D7E1C05E3B82EF26F41346F5D850; } function F27CA820034C3FB0E279A5518739B60BC($echo = true) { $RF9BCCEB09F9441E87F7E9B1924BDA95E = 600; $R784A3F868765486A977EF4D29EDEBC4C = "128"; $RBDA44D59273932B6ABE58F1C9F863520 = 600; if( !ini_get('safe_mode') ) { @ini_set("max_execution_time", $RF9BCCEB09F9441E87F7E9B1924BDA95E); $RFED47D15719EF82BD3F83B580230DA5B = ini_get("memory_limit"); $RFED47D15719EF82BD3F83B580230DA5B = substr( $RFED47D15719EF82BD3F83B580230DA5B, 0, 1 ); if ( $RFED47D15719EF82BD3F83B580230DA5B < $R784A3F868765486A977EF4D29EDEBC4C ) { @ini_set("memory_limit", $R784A3F868765486A977EF4D29EDEBC4C."M"); } @set_time_limit($RBDA44D59273932B6ABE58F1C9F863520); } else { if ($echo) { echo '<p class="mabp_error"><strong>'.__("WARNING!", 'myarcadeplugin').'</strong> '.__("Can't make needed settins, because you have Safe Mode active.", 'myarcadeplugin').'</p>'; } } } function myarcade_ajax_publish() { global $myarcade_feedback; @error_reporting( 0 ); header( 'Content-type: application/json' ); $R3584859062EA9ECFB39B93BFCEF8E869 = (int) $_REQUEST['id']; $R971D98E0AD23E0905A3D3F4B08D46579 = $_REQUEST['status']; $R22E989667C4612380F6ABBE42720E5BD = (int) $_REQUEST['schedule']; $RA1D44C0654A40984A103C270FFB9BF33 = (int) $_REQUEST['count']; $download_thumbs = ($_REQUEST['download_thumbs'] == '1') ? true : false; $download_screens = ($_REQUEST['download_screens'] == '1') ? true : false; $download_games = ($_REQUEST['download_games'] == '1') ? true : false; if ( $R971D98E0AD23E0905A3D3F4B08D46579 == 'future') { $R5723D84ABBA9A22D7199267155C6E517 = ($RA1D44C0654A40984A103C270FFB9BF33 - 1) * $R22E989667C4612380F6ABBE42720E5BD; } else { $R5723D84ABBA9A22D7199267155C6E517 = 0; } $R9FE302BDF914868081913A22F58F9E7E = array( 'game_id' => $R3584859062EA9ECFB39B93BFCEF8E869, 'post_status' => $R971D98E0AD23E0905A3D3F4B08D46579, 'post_date' => gmdate('Y-m-d H:i:s', ( time() + ($R5723D84ABBA9A22D7199267155C6E517 * 60) + (get_option('gmt_offset') * 3600 ))), 'download_games' => $download_games, 'download_thumbs' => $download_thumbs, 'download_screens' => $download_screens, 'echo' => false ); $post_id = F5F9EB2BD2DA652CBF122EEF75C2BE581($R9FE302BDF914868081913A22F58F9E7E); $R0EB1982D9BAA9716AC37A8F047D5800D = ''; $RA43A52C3D1634FFA3BF745E85786DC5E = ''; if ( FDA2E343504241894F42B5F23BC2A9227($myarcade_feedback) ) { if ( $myarcade_feedback->F14EF1E7F136C93D51AFCF7379557AD7F() ) { $R0EB1982D9BAA9716AC37A8F047D5800D = $myarcade_feedback->F9410AC7F3C3857FC94CCAA66947E2F34(array('output' => 'string')); } if ( $myarcade_feedback->F298F416F99F9522BC69FCD38DD1B4D88() ) { $RA43A52C3D1634FFA3BF745E85786DC5E = $myarcade_feedback->F62DD3935DEA0EEDDC85A63DF386943D3(array('output' => 'string')); } } if ( $post_id ) { if ( $R971D98E0AD23E0905A3D3F4B08D46579 == 'publish' ) { $RCA93FA22E19E2B6C2C880AC5D758EA72 = '<a href="'.get_permalink($post_id).'" class="button-secondary" target="_blank">View Post</a>'; } else { $RCA93FA22E19E2B6C2C880AC5D758EA72 = '<a href="'.add_query_arg( 'preview', 'true', get_permalink($post_id) ).'" class="button-secondary" target="_blank">Preview Post</a>'; } $R30E38C1F8EC85F8EE8DF620FF3267157 = get_the_category($post_id); $R3910219DF6F8E99780648EFF2D79DA50 = ''; if ( !empty($R30E38C1F8EC85F8EE8DF620FF3267157) ) { $RA1D44C0654A40984A103C270FFB9BF33 = count($R30E38C1F8EC85F8EE8DF620FF3267157); for($RA16D2280393CE6A2A5428A4A8D09E354=0; $RA16D2280393CE6A2A5428A4A8D09E354<$RA1D44C0654A40984A103C270FFB9BF33; $RA16D2280393CE6A2A5428A4A8D09E354++) { if ( ($RA1D44C0654A40984A103C270FFB9BF33 - $RA16D2280393CE6A2A5428A4A8D09E354) > 1) { $R3910219DF6F8E99780648EFF2D79DA50 .= $R30E38C1F8EC85F8EE8DF620FF3267157[$RA16D2280393CE6A2A5428A4A8D09E354]->cat_name . ', '; } else { $R3910219DF6F8E99780648EFF2D79DA50 .= $R30E38C1F8EC85F8EE8DF620FF3267157[$RA16D2280393CE6A2A5428A4A8D09E354]->cat_name; } } } wp_die( json_encode( array( 'success' => '<strong>'.esc_html( get_the_title($post_id) ).'</strong><br />
          <div>
            <div style="float:left;margin-right:5px">
              <img src="'. get_post_meta($post_id, 'mabp_thumbnail_url', true).'" width="80" height="80" alt="">
            </div>
            <div style="float:left">
            <table border="0">
            <tr valign="top">
              <td width="200"><strong>Categories:</strong> '.$R3910219DF6F8E99780648EFF2D79DA50.'<br />'.$R0EB1982D9BAA9716AC37A8F047D5800D.'</td>
              <td width="350">'.$RA43A52C3D1634FFA3BF745E85786DC5E.'</td>
            </tr>
            </table>
             <p><a href="'.get_edit_post_link( $post_id ).'" class="button-secondary" target="_blank">Edit Post</a> '.$RCA93FA22E19E2B6C2C880AC5D758EA72.'</p>
            </div>
          </div>
          <div style="clear:both;"></div>' ) ) ); } else { die(json_encode(array('error' => __("Error: Post can not be created!", 'myarcadeplugin') .' - ' . $RA43A52C3D1634FFA3BF745E85786DC5E ))); } } add_action('wp_ajax_myarcade_ajax_publish', 'myarcade_ajax_publish'); ?>