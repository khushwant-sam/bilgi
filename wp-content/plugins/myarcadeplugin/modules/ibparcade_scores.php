<?php
 $RFEE6FD8A6D4876C7A2B5478AEB8AEE3A = isset($_GET['act']) ? strtolower($_GET['act']) : false; $R1C096022D5294397018415D5001BC89E = isset($_GET['autocom']) ? strtolower($_GET['autocom']) : false; $R49FC76D0829BFAA538F6EFF77D3A3651 = isset($_GET['do']) ? strtolower($_GET['do']) : false; if ( ($RFEE6FD8A6D4876C7A2B5478AEB8AEE3A == 'arcade') || ($R1C096022D5294397018415D5001BC89E == 'arcade') ) { global $user_ID, $wpdb; if ( defined( 'MYARCADE_DEBUG' ) && MYARCADE_DEBUG ) { F627A0F242E003858EA19A5D9DD5EBE5A('IBP/PHPBB Game Submitted Data: ' ."\n". 'POST: ' . print_r($_POST, true) ."\n". 'GET: ' . print_r($_GET, true) ); } switch ($R49FC76D0829BFAA538F6EFF77D3A3651) { case 'verifyscore' : { $_SESSION['time'] = time(); $_SESSION['rand1'] = rand(1, 100); $_SESSION['rand2'] = rand(1, 100); echo '&randchar=', $_SESSION['rand1'] ,'&randchar2=', $_SESSION['rand2'] ,'&savescore=1&blah=OK'; if ( defined( 'MYARCADE_DEBUG' ) && MYARCADE_DEBUG ) { F627A0F242E003858EA19A5D9DD5EBE5A('Verify Score: ' . print_r($_SESSION, true) ); } die(); } break; case 'savescore': { if ( defined( 'MYARCADE_DEBUG' ) && MYARCADE_DEBUG ) { F627A0F242E003858EA19A5D9DD5EBE5A('IBP/PHP Save Score'); } $R64151BCD211855F655EF77B7038C9FF3 = $_POST['gname']; $R69F05BD3024E3A18B29F11DF8A3E8C79 = FB3407172EA02D628A6A26D68A0B5CA27( $R64151BCD211855F655EF77B7038C9FF3 ); if ( ! $R69F05BD3024E3A18B29F11DF8A3E8C79 || empty( $R69F05BD3024E3A18B29F11DF8A3E8C79['post_id'] ) || empty( $R69F05BD3024E3A18B29F11DF8A3E8C79['game_tag'] ) || empty( $R69F05BD3024E3A18B29F11DF8A3E8C79['score_order'] ) ) { header('Location: ' . $_SERVER['HTTP_REFERER']); die(); } if ( isset($_SESSION['time']) ) { $RD94C2157798BCCE313068BF1BF25A119 = (float)(!empty($_POST['score']) ? $_POST['score'] : $_POST['gscore']); $R1F66B67A97583629581945D27A05AC03 = $RD94C2157798BCCE313068BF1BF25A119 * $_SESSION['rand1'] ^ $_SESSION['rand2']; get_currentuserinfo(); if ( (!empty($user_ID)) && ($user_ID == $_SESSION['uuid']) ) { if ($R1F66B67A97583629581945D27A05AC03 == $_POST['enscore']) { $R53740C11C1930560D0EC6A4938F16AD0 = array( 'session' => $_SESSION['time'], 'date' => date('Y-m-d'), 'datatype' => 'number', 'game_tag' => $R69F05BD3024E3A18B29F11DF8A3E8C79['game_tag'], 'user_id' => $user_ID, 'score' => $RD94C2157798BCCE313068BF1BF25A119, 'sortorder' => $R69F05BD3024E3A18B29F11DF8A3E8C79['score_order'], ); F007F675CEB78537E7BF8DAFCBBA7AEF0( $R53740C11C1930560D0EC6A4938F16AD0 ); } } } $RC91035FD8512F06F108CEE51D9F7F62F = get_permalink( $R69F05BD3024E3A18B29F11DF8A3E8C79['post_id'] ); header( 'Location: '.$RC91035FD8512F06F108CEE51D9F7F62F); die(); } break; case 'newscore': { if ( defined( 'MYARCADE_DEBUG' ) && MYARCADE_DEBUG ) { F627A0F242E003858EA19A5D9DD5EBE5A('IBP/PHPBB New Score'); } $R64151BCD211855F655EF77B7038C9FF3 = trim(!empty($_POST['game_name']) ? $_POST['game_name'] : $_POST['gname']); $R69F05BD3024E3A18B29F11DF8A3E8C79 = FB3407172EA02D628A6A26D68A0B5CA27( $R64151BCD211855F655EF77B7038C9FF3 ); if ( ! $R69F05BD3024E3A18B29F11DF8A3E8C79 || empty( $R69F05BD3024E3A18B29F11DF8A3E8C79['post_id'] ) || empty( $R69F05BD3024E3A18B29F11DF8A3E8C79['game_tag'] ) || empty( $R69F05BD3024E3A18B29F11DF8A3E8C79['score_order'] ) ) { header('Location: ' . $_SERVER['HTTP_REFERER']); die(); } get_currentuserinfo(); if ( !empty($user_ID) ) { $RD94C2157798BCCE313068BF1BF25A119 = (float)(!empty($_POST['score']) ? $_POST['score'] : $_POST['gscore']); if ( empty($_SESSION['time']) ) { $RA337D38989275B85567BAE0C78786D01 = time(); } else { $RA337D38989275B85567BAE0C78786D01 = $_SESSION['time']; } $R53740C11C1930560D0EC6A4938F16AD0 = array( 'session' => $RA337D38989275B85567BAE0C78786D01, 'date' => date('Y-m-d'), 'datatype' => 'number', 'game_tag' => $R69F05BD3024E3A18B29F11DF8A3E8C79['game_tag'], 'user_id' => $user_ID, 'score' => $RD94C2157798BCCE313068BF1BF25A119, 'sortorder' => $R69F05BD3024E3A18B29F11DF8A3E8C79['score_order'], ); F007F675CEB78537E7BF8DAFCBBA7AEF0( $R53740C11C1930560D0EC6A4938F16AD0 ); } $RC91035FD8512F06F108CEE51D9F7F62F = get_permalink( $R69F05BD3024E3A18B29F11DF8A3E8C79['post_id'] ); header( 'Location: '.$RC91035FD8512F06F108CEE51D9F7F62F); die(); } break; } } function FB3407172EA02D628A6A26D68A0B5CA27( $R64151BCD211855F655EF77B7038C9FF3 ) { global $wpdb; $post_id = $wpdb->get_var( "SELECT p.ID FROM {$wpdb->posts} AS p
      INNER JOIN {$wpdb->postmeta} AS m
       ON m.post_id = p.ID
        WHERE m.meta_key = 'mabp_game_slug'
         AND  m.meta_value = '{$R64151BCD211855F655EF77B7038C9FF3}'" ); if ( $post_id ) { $score_order = get_post_meta( $post_id,'mabp_score_order', true ); if ( ! $score_order ) { $score_order = 'DESC'; } $game_tag = get_post_meta( $post_id, 'mabp_game_tag', true ); } else { $R69F05BD3024E3A18B29F11DF8A3E8C79 = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix . 'myarcadegames'." WHERE slug = '$R64151BCD211855F655EF77B7038C9FF3' LIMIT 1"); if ( ! $R69F05BD3024E3A18B29F11DF8A3E8C79 ) { return false; } $post_id = $R69F05BD3024E3A18B29F11DF8A3E8C79->postid; $score_order = $R69F05BD3024E3A18B29F11DF8A3E8C79->highscore_type; $game_tag = $R69F05BD3024E3A18B29F11DF8A3E8C79->game_tag; } if ( ! $score_order || 'high' == $score_order ) { $score_order = "DESC"; } elseif ( 'low' == $score_order ) { $score_order = "ASC"; } return compact( 'post_id', 'score_order', 'game_tag' ); } ?>