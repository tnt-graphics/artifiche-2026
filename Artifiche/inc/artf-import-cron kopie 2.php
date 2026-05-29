<?php



/*

  * Set trigger for EN after DE import

  */

function artf_trigger_en_import( $import_id ) {

	// Replace  with the ID of the DE import.

	$logger = wc_get_logger();
	
	if (isset($response) && is_array($response) && isset($response['body'])) {
		$logger->debug('wp all import testing' . $response['body'], array('source' => 'artf-all-import-log'));
	} 

	if ( $import_id == 114 ) { // brand EN.

		// use the trigger URL of your EN import here.

		$cron_status = get_option( 'cron_status' );

		if ( $cron_status != 'started' ) {

			update_option( 'cron_status', 'started' );

		}

		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=115&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing brand en' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 115 ) { // kunstler DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=57&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing kunstler de' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 57 ) { // kunstler EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=59&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing kunstler en' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 59 ) { // Land DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=122&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing land de' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 122 ) { // Land EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=123&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing land en' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}

	if ( $import_id == 123 ) { // Stilrichtung_DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=136&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Stilrichtung_DE' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 136 ) { // Stilrichtung_EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=137&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Stilrichtung_EN' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 137 ) { // Kategorien_DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=138&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Kategorien_DE' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 138 ) { // Kategorien_EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=139&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Kategorien_EN' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 139 ) { // Drucktechnik_DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=140&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Drucktechnik_DE' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 140 ) { // Drucktechnik_EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=141&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Drucktechnik_EN' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 141 ) { // Publikationen_DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=142&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Publikationen_DE' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 142 ) { // Publikationen_EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=143&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Publikationen_EN' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 143 ) { // Kollektionen_DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=152&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Kollektionen_DE' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 152 ) { // Kollektionen_EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=145&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Kollektionen_EN' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}

	if ( $import_id == 145 ) { // Plakatexport_DE.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=146&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Plakatexport_DE' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



	if ( $import_id == 146 ) { // Plakatexport_EN.



		$trigger_url = site_url() . '/wp-cron.php?import_key=1UhjOBTd&import_id=147&action=trigger';

		$response    = wp_remote_get( $trigger_url );

		$logger->debug( 'wp all import testing Plakatexport_EN' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );

	}

	if ( $import_id == 147 ) { // Plakatexport_EN.

		update_option( 'cron_status', 'completed' );

		$logger->debug( 'import completed' . $response ['body'], array( 'source' => 'artf-all-import-log' ) );



	}



}

 add_action( 'pmxi_after_xml_import', 'artf_trigger_en_import', 999, 1 );

