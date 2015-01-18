<?php
if ( class_exists( 'myCRED_Hook' ) ) {
  // The Hook Class
  class myCRED_Hook_MyArcadePlugin extends myCRED_Hook {

    /**
     * Construct
     *
     * @version 1.1.0
     * @access public
     * @return void
     */
    function __construct( $hook_prefs, $type = 'mycred_default' ) {
        // Define a unique ID and each instances where points might be awarded / deducted
        parent::__construct( array(
            'id'       => 'myarcade',
            'defaults' => array(
                'play'    => array(
                    'creds'  => 1,
                    'log'    => '%plural% for playing a game'
                ),
                'score'    => array(
                    'creds'  => 10,
                    'log'    => '%plural% for submitting score'
                ),
                'highscore'    => array(
                    'creds'  => 30,
                    'log'    => '%plural% for highscore'
                ),
                'medal'    => array(
                    'creds'  => 50,
                    'log'    => '%plural% for new medal'
                )
            )
        ), $hook_prefs, $type );
    }

    /**
     * Hook into MyArcade
     * @since 1.0
     * @version 1.0
     */
    function run() {
        add_action( 'myarcade_game_play',     array( $this, 'game_play' ) );
        add_action( 'myarcade_new_score',     array( $this, 'new_score' ) );
        add_action( 'myarcade_new_highscore', array( $this, 'new_highscore' ) );
        add_action( 'myarcade_new_medal',     array( $this, 'new_medal' ) );
    }

    /**
     * Game Play
     *
     * @version 1.1.0
     * @access public
     * @return void
     */
    function game_play() {
        // Must be logged in
        if ( !is_user_logged_in() ) return;
        $user_id = get_current_user_id();

        // Check for exclusions
        if ( $this->core->exclude_user( $user_id ) ) return;

        // Execute
        $this->core->add_creds(
            'game_play',
            $user_id,
            $this->prefs['play']['creds'],
            $this->prefs['play']['log'],
            '',
            '',
            $this->mycred_type
        );
    }

    /**
     * New Score
     * @since 1.0
     * @version 1.1.0
     */
    function new_score( $score = array() ) {
        // Must be logged in
        if ( !is_user_logged_in() ) return;
        $user_id = get_current_user_id();

        // Check for exclusions
        if ( $this->core->exclude_user( $user_id ) ) return;

        // Execute
        $this->core->add_creds(
            'game_score',
            $user_id,
            $this->prefs['score']['creds'],
            $this->prefs['score']['log'],
            '',
            '',
            $this->mycred_type
        );
    }

    /**
     * New Highscore
     * @since 1.0
     * @version 1.1.0
     */
    function new_highscore( $score = array() ) {
        // Must be logged in
        if ( !is_user_logged_in() ) return;
        $user_id = get_current_user_id();

        // Check for exclusions
        if ( $this->core->exclude_user( $user_id ) ) return;

        // Execute
        $this->core->add_creds(
            'game_highscore',
            $user_id,
            $this->prefs['highscore']['creds'],
            $this->prefs['highscore']['log'],
            '',
            '',
            $this->mycred_type
        );
    }

    /**
     * New Medal
     * @since 1.0
     * @version 1.1.0
     */
    function new_medal( $medaldata = array() ) {
        // Must be logged in
        if ( !is_user_logged_in() ) return;
        $user_id = get_current_user_id();

        // Check for exclusions
        if ( $this->core->exclude_user( $user_id ) ) return;

        // Execute
        $this->core->add_creds(
            'game_medal',
            $user_id,
            $this->prefs['medal']['creds'],
            $this->prefs['medal']['log'],
            '',
            '',
            $this->mycred_type
        );
    }

    /**
     * Preference for this Hook
     * @since 1.0
     * @version 1.0
     */
    public function preferences() {
        $prefs = $this->prefs; ?>

<label class="subheader" for="<?php echo $this->field_id( array( 'play' => 'creds' ) ); ?>"><?php _e( 'Game Play', 'mycred' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'play' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'play' => 'creds' ) ); ?>" value="<?php echo $this->core->format_number( $prefs['play']['creds'] ); ?>" size="8" /></div>
	</li>
	<li class="empty">&nbsp;</li>
	<li>
		<label for="<?php echo $this->field_id( array( 'play' => 'log' ) ); ?>"><?php _e( 'Log template', 'mycred' ); ?></label>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'play' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'play' => 'log' ) ); ?>" value="<?php echo $prefs['play']['log']; ?>" class="long" /></div>
		<span class="description"><?php _e( 'Available template tags: General', 'mycred' ); ?></span>
	</li>
</ol>
<label class="subheader" for="<?php echo $this->field_id( array( 'score' => 'creds' ) ); ?>"><?php _e( 'Submitting Score', 'mycred' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'score' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'score' => 'creds' ) ); ?>" value="<?php echo $this->core->format_number( $prefs['score']['creds'] ); ?>" size="8" /></div>
	</li>
	<li class="empty">&nbsp;</li>
	<li>
		<label for="<?php echo $this->field_id( array( 'score' => 'log' ) ); ?>"><?php _e( 'Log template', 'mycred' ); ?></label>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'score' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'score' => 'log' ) ); ?>" value="<?php echo $prefs['score']['log']; ?>" class="long" /></div>
		<span class="description"><?php _e( 'Available template tags: General', 'mycred' ); ?></span>
	</li>
</ol>
<label class="subheader" for="<?php echo $this->field_id( array( 'highscore' => 'creds' ) ); ?>"><?php _e( 'Highscore', 'mycred' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'highscore' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'highscore' => 'creds' ) ); ?>" value="<?php echo $this->core->format_number( $prefs['highscore']['creds'] ); ?>" size="8" /></div>
	</li>
	<li class="empty">&nbsp;</li>
	<li>
		<label for="<?php echo $this->field_id( array( 'highscore' => 'log' ) ); ?>"><?php _e( 'Log template', 'mycred' ); ?></label>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'highscore' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'highscore' => 'log' ) ); ?>" value="<?php echo $prefs['highscore']['log']; ?>" class="long" /></div>
		<span class="description"><?php _e( 'Available template tags: General', 'mycred' ); ?></span>
	</li>
</ol>
<label class="subheader" for="<?php echo $this->field_id( array( 'medal' => 'creds' ) ); ?>"><?php _e( 'Earning Medal', 'mycred' ); ?></label>
<ol>
	<li>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'medal' => 'creds' ) ); ?>" id="<?php echo $this->field_id( array( 'medal' => 'creds' ) ); ?>" value="<?php echo $this->core->format_number( $prefs['medal']['creds'] ); ?>" size="8" /></div>
	</li>
	<li class="empty">&nbsp;</li>
	<li>
		<label for="<?php echo $this->field_id( array( 'medal' => 'log' ) ); ?>"><?php _e( 'Log template', 'mycred' ); ?></label>
		<div class="h2"><input type="text" name="<?php echo $this->field_name( array( 'medal' => 'log' ) ); ?>" id="<?php echo $this->field_id( array( 'medal' => 'log' ) ); ?>" value="<?php echo $prefs['medal']['log']; ?>" class="long" /></div>
		<span class="description"><?php _e( 'Available template tags: General', 'mycred' ); ?></span>
	</li>
</ol>
<?php
		}
	}
}