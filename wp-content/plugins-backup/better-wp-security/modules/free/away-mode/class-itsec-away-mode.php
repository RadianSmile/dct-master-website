<?php

class ITSEC_Away_Mode {

	function run() {

		//Execute away mode functions on admin init
		add_filter( 'itsec_logger_modules', array( $this, 'register_logger' ) );
		add_action( 'itsec_admin_init', array( $this, 'execute_away_mode' ) );
		add_action( 'login_init', array( $this, 'execute_away_mode' ) );

		//Register Sync
		add_filter( 'itsec_sync_modules', array( $this, 'register_sync' ) );

	}

	/**
	 * Check if away mode is active
	 *
	 * @since 4.4
	 *
	 * @param array $input     [NULL] Input of options to check if calling from form
	 * @param bool  $remaining will return the number of seconds remaining
	 * @param bool  $override  Whether or not we're calculating override values
	 *
	 * @return mixed true if locked out else false or times until next condition (negative until lockout, positive until release)
	 */
	public static function check_away( $input = null, $remaining = false, $override = false ) {

		global $itsec_globals;

		ITSEC_Lib::clear_caches(); //lets try to make sure nothing is storing a bad time

		$form          = true;
		$has_away_file = @file_exists( $itsec_globals['ithemes_dir'] . '/itsec_away.confg' );
		$status        = false; //assume they're not locked out to start

		//Normal usage check
		if ( $input === null ) { //if we didn't provide input to check we need to get it

			$form  = false;
			$input = get_site_option( 'itsec_away_mode' );

		}

		if ( ( $form === false && ! isset( $input['enabled'] ) ) || ! isset( $input['type'] ) || ! isset( $input['start'] ) || ! isset( $input['end'] ) || ! $has_away_file ) {
			return false; //if we don't have complete settings don't lock them out
		}

		$current_time = $itsec_globals['current_time']; //use current time
		$enabled      = isset( $input['enabled'] ) ? $input['enabled'] : $form;
		$test_type    = $input['type'];
		$test_start   = $input['start'];
		$test_end     = $input['end'];

		if ( $test_type === 1 ) { //daily

			$test_start -= strtotime( date( 'Y-m-d', $test_start ) );
			$test_end -= strtotime( date( 'Y-m-d', $test_end ) );
			$day_seconds = $current_time - strtotime( date( 'Y-m-d', $current_time ) );

			if ( $test_start === $test_end ) {
				$status = false;
			}

			if ( $test_start < $test_end ) { //same day

				if ( $test_start <= $day_seconds && $test_end >= $day_seconds && $enabled === true ) {
					$status = $test_end - $day_seconds;
				}

			} else { //overnight

				if ( ( $test_start < $day_seconds || $test_end > $day_seconds ) && $enabled === true ) {

					if ( $day_seconds >= $test_start ) {

						$status = ( 86400 - $day_seconds ) + $test_end;

					} else {

						$status = $test_end - $day_seconds;

					}

				}

			}

		} else if ( $test_start !== $test_end && $test_start <= $current_time && $test_end >= $current_time && $enabled === true ) { //one time

			$status = $test_end - $current_time;

		}

		//they are al