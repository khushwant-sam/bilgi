<?php
 class MyArcade_Feedback { var $R0EB1982D9BAA9716AC37A8F047D5800D = array(); var $RA43A52C3D1634FFA3BF745E85786DC5E = array(); public function __construct( $R65DFACB39960C22313740A131148FB81 = '', $R157A6826A8BF1F36EBBE3DEC02351744 = '' ) { switch ($R65DFACB39960C22313740A131148FB81) { case 'message': { $this->messages[] = $R157A6826A8BF1F36EBBE3DEC02351744; } break; case 'error': { $this->errors[] = $R157A6826A8BF1F36EBBE3DEC02351744; } break; default: { return; } } } public function F9410AC7F3C3857FC94CCAA66947E2F34( $R9FE302BDF914868081913A22F58F9E7E = array() ) { $R1C087CFC2417747F08C78E3E5D5121E5 = array( 'wrap_begin' => '<p class="mabp_error">', 'wrap_end' => '</p>', 'output' => 'return' ); $RAA7BB4B05FBD27DB7CA594893F166B47 = wp_parse_args( $R9FE302BDF914868081913A22F58F9E7E, $R1C087CFC2417747F08C78E3E5D5121E5 ); extract($RAA7BB4B05FBD27DB7CA594893F166B47); if ( !is_bool($output) && ($output == 'return') ) { return $this->errors; } $R79962116CBACD02DA057AFC638D2AA1C = ''; if ( $this->F14EF1E7F136C93D51AFCF7379557AD7F() ) { foreach ( $this->errors as $R157A6826A8BF1F36EBBE3DEC02351744 ) { $R79962116CBACD02DA057AFC638D2AA1C .= $wrap_begin.$R157A6826A8BF1F36EBBE3DEC02351744.$wrap_end; } if ( ( is_bool($output) && ($output === true) ) || ($output == 'echo' ) ) { echo $R79962116CBACD02DA057AFC638D2AA1C; } elseif ( $output == 'string') { return $R79962116CBACD02DA057AFC638D2AA1C; } } } public function F62DD3935DEA0EEDDC85A63DF386943D3( $R9FE302BDF914868081913A22F58F9E7E = array() ) { $R1C087CFC2417747F08C78E3E5D5121E5 = array( 'wrap_begin' => '<p class="mabp_info">', 'wrap_end' => '</p>', 'output' => 'return', ); $RAA7BB4B05FBD27DB7CA594893F166B47 = wp_parse_args( $R9FE302BDF914868081913A22F58F9E7E, $R1C087CFC2417747F08C78E3E5D5121E5 ); extract($RAA7BB4B05FBD27DB7CA594893F166B47); if ( !is_bool($output) && ($output == 'return') ) { return $this->messages; } $R79962116CBACD02DA057AFC638D2AA1C = ''; if ( $this->F298F416F99F9522BC69FCD38DD1B4D88() ) { foreach ( $this->messages as $R157A6826A8BF1F36EBBE3DEC02351744 ) { $R79962116CBACD02DA057AFC638D2AA1C .= $wrap_begin.$R157A6826A8BF1F36EBBE3DEC02351744.$wrap_end; } if ( ( is_bool($output) && ($output === true) ) || ($output == 'echo') ) { echo $R79962116CBACD02DA057AFC638D2AA1C; } elseif ( $output == 'string') { return $R79962116CBACD02DA057AFC638D2AA1C; } } else { return false; } } function F12C73D1B465E39C31D3A2333B5E23252( $R157A6826A8BF1F36EBBE3DEC02351744 ) { $this->errors[] = $R157A6826A8BF1F36EBBE3DEC02351744; } function FA9C1FF81C2FBCE5A09D418A70752BF3E($R157A6826A8BF1F36EBBE3DEC02351744) { $this->messages[] = $R157A6826A8BF1F36EBBE3DEC02351744; } function F14EF1E7F136C93D51AFCF7379557AD7F() { if ( empty($this->errors) ) { return false; } else { return true; } } function F298F416F99F9522BC69FCD38DD1B4D88() { if ( empty($this->messages) ) { return false; } else { return true; } } } function FDA2E343504241894F42B5F23BC2A9227( $R5A2C33066CB2CA88C04437414AA14AFE ) { if ( is_object($R5A2C33066CB2CA88C04437414AA14AFE) && is_a($R5A2C33066CB2CA88C04437414AA14AFE, 'MyArcade_Feedback') ) { return true; } else { return false; } } global $myarcade_feedback; if ( !FDA2E343504241894F42B5F23BC2A9227($myarcade_feedback) ) { $myarcade_feedback = new MyArcade_Feedback(); } ?>