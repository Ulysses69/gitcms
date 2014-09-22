<?php

/*
 * CSV Import Plugin for Wolf CMS
 * Import .csv, .tsv and .txt spreadsheet files into Wolf CMS pages and page parts.
 *
 * @package Plugins
 * @subpackage multiedit
 *
 * @author Marek Murawski <http://marekmurawski.pl>
 * @copyright Marek Murawski, 2013
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */

/* Security measure */
if ( !defined( 'IN_CMS' ) ) {
	exit();
}


class CsvImportController extends PluginController {

	const VIEW_FOLDER = "../../plugins/csv_import/views/";

	public static $options = array(
				'encoding'		   => 'UTF-8',
				'folder'			 => 'public',
				'escape'			 => 'doublequote',
				'delimeter'		  => 'semicolon',
				'enclosure'		  => 'doublequote',
				'status_id'		  => Page::STATUS_PUBLISHED,
				'layout_id'		  => '1',
				'is_protected'	   => '0',
				'needs_login'		=> '2',
				'behavior_id'		=> '',
				'file_locale'		=> 'en_GB.UTF-8',
				'create_empty_parts' => '0',
				'default_filter'	 => '',
				'fileurl'			=> '',
	);
	public static $translators		 = array(
				'comma'	   => ",",
				'semicolon'   => ";",
				'pipe'		=> "|",
				'singlequote' => "'",
				'doublequote' => '"',
				'tabulator'   => '\t',
				'backslash'   => '\\',
	);
	public static $encodings	= array(
				'ISO-8859-1'   => "ISO-8859-1",
				'ISO-8859-2'   => "ISO-8859-2",
				'ISO-8859-3'   => "ISO-8859-3",
				'ISO-8859-4'   => "ISO-8859-4",
				'ISO-8859-5'   => "ISO-8859-5",
				'ISO-8859-6'   => "ISO-8859-6",
				'ISO-8859-7'   => "ISO-8859-7",
				'ISO-8859-8'   => "ISO-8859-8",
				'ISO-8859-9'   => "ISO-8859-9",
				'ISO-8859-10'   => "ISO-8859-10",
				'WINDOWS-1250' => "Windows 1250",
				'WINDOWS-1251' => "Windows 1251",
				'WINDOWS-1252' => "Windows 1252",
				'WINDOWS-1253' => "Windows 1253",
				'WINDOWS-1254' => "Windows 1254",
				'WINDOWS-1255' => "Windows 1255",
				'WINDOWS-1256' => "Windows 1256",
				'WINDOWS-1257' => "Windows 1257",
				'WINDOWS-1258' => "Windows 1258",
				'UTF-8'		=> "UTF-8",
	);
	public static $locales	   = array(
				'ca_ES',
				'cs_CZ',
				'da_DK',
				'de_AT',
				'de_CH',
				'de_DE',
				'de_LI',
				'de_LU',
				'en_GB',
				'en_US',
				'es_ES',
				'fi_FI',
				'fr_FR',
				'hu_HU',
				'ja_JP',
				'lt_LT',
				'lv_LV',
				'nl_NL',
				'pl_PL',
				'ro_RO',
				'ru_RU',
				'sk_SK',
				'sv_SE',
				'uk_UA',
	);
	private static $defaultPageFields = array(
				'id',
				'title',
				'slug',
				'breadcrumb',
				'keywords',
				'description',
				'content',
				'parent_id',
				'layout_id',
				'behavior_id',
				'status_id',
				'parent',
				'created_on',
				'published_on',
				'valid_until',
				'updated_on',
				'created_by_id',
				'updated_by_id',
				'position',
				'is_protected',
				'needs_login',
				'url',
				'level',
				'tags',
				'author',
				'author_id',
				'updater',
				'updater_id',
				'created_by_name',
				'updated_by_name',
				'part',
	);
	public static $importablePageFields = array(
				'title',
				'slug',
				'breadcrumb',
				'keywords',
				'description',
				'created_on',
				'published_on',
				'valid_until',
				'tags',
	);
	private static $pagesList = array( );

	public function __construct() {
		
		/* Fix for DS warnings */
		if (!defined('DS')) {
		    define("DS", URL_PUBLIC);
		}

		$this->setLayout( 'backend' );
		$lang = ( $user = AuthUser::getRecord() ) ? strtolower( $user->language ) : 'en';
		if ( !file_exists( PLUGINS_ROOT . DS . 'csv_import/views/documentation/sidebar/' . $lang . '.php' ) ) {
			$lang			= 'en';
		}
		$sidebarContents = new View( self::VIEW_FOLDER . 'documentation/sidebar/' . $lang );
		$this->assignToLayout( 'sidebar', new View( self::VIEW_FOLDER . 'sidebar', array(
								'sidebarContents' => $sidebarContents
								) ) );

	}


	/**
	 *
	 * @return type
	 */
	public function getFolder() {
		return '/' . self::$options['folder'];

	}


	/**
	 *
	 * @return string
	 */
	public function getEncoding() {
		//$key = self::$options['encoding'];
		return self::$options['encoding'];

	}


	/**
	 *
	 * @return string
	 */
	public function getEscape() {
		$key = self::$options['escape'];
		return self::$translators[$key];

	}


	/**
	 *
	 * @return string
	 */
	public function getDelimeter() {
		$key = self::$options['delimeter'];
		return self::$translators[$key];

	}


	/**
	 *
	 * @return string
	 */
	public function getEnclosure() {
		$key = self::$options['enclosure'];
		return self::$translators[$key];

	}


	/**
	 * Retrieve options from $_POST['options'] global
	 */
	public static function setSavedOptions() {
		if ( $opts = Plugin::getAllSettings('csv_import') ) {
			foreach ( $opts as $k => $v ) {
				self::$options[$k] = $v;
			}
		}

	}
	/**
	 * Retrieve options from $_POST['options'] global
	 */
	public static function setPostOptions() {
		if ( isset( $_POST['options'] ) ) {
			$arr = $_POST['options'];
			foreach ( $arr as $k => $v ) {
				self::$options[$k] = $v;
			}
		}

	}


	/**
	 * Prepare imported file as array
	 *
	 * @param String $source_path
	 * @return Array
	 */
	private function getStructure( $source_path ) {

		$raw_file = file_get_contents( $source_path );

		if ( $this->getEncoding() !== 'UTF-8' ) {
			$trans_file = iconv( $this->getEncoding(), "UTF-8", $raw_file );
		} else {
			$trans_file = $raw_file;
		}

		$contents = $this->csvToArray( $trans_file, $this->getEscape(), $this->getEnclosure(), $this->getDelimeter() );

		$header	= array_shift( $contents );
		$row_count = count( $contents );

		foreach ($contents as $k => $v) {
			if (count($v) < count($header)) {
				for ( $i = 0; $i < count( $header ) - count($v); $i++ ) {
					$contents[$k][] = '';
				}
			}
		}
		// remove last empty row
		//if ( (count( $contents[$row_count - 1] )) < 2 ) {
			array_pop( $contents );
			$row_count--;
		//}

		return array(
					'col_count' => count( $header ),
					'row_count' => $row_count,
					'raw_file'  => $trans_file,
					'header'	=> $header,
					'contents'  => $contents,
		);

	}


	public function index() {

		if ( isset( $_POST['save_settings'] ) ) {
			if ( Plugin::setAllSettings( $_POST['options'], 'csv_import' ) ) {
				Flash::set( 'success', __( 'Settings saved!' ) );
				redirect( get_url( 'plugin/csv_import' ) );
			} else {
				Flash::set( 'error', __( 'Error saving settings!' ) );
				redirect( get_url( 'plugin/csv_import' ) );
			}
		}

		// pre-populate global page properties
		self::setSavedOptions();

		// get options override from $_POST
		self::setPostOptions();

		// setting locale for string / date conversions
		// trying different variants...
		$locale_variants = array(
					self::$options['file_locale'], //en_US.UTF-8
					str_replace( '_', '-', self::$options['file_locale'] ), //en-US.UTF-8
					str_replace( '-', '', self::$options['file_locale'] ), //en_US.UTF8
					substr( self::$options['file_locale'], 0, 2 ), //en_US.UTF8
		);

		setlocale( LC_ALL, $locale_variants );

		if ( isset( $_POST['import'] ) || isset( $_POST['preview'] ) ) {
			if ( (!isset( $_POST['filename'] )) && (strlen( trim( $_POST['options']['fileurl'] ) ) === 0) ) {
				Flash::set( 'error', __( 'File not specified' ) );
				redirect( get_url( 'plugin/csv_import' ) );
			};

			if ( strlen( trim( $_POST['options']['fileurl'] ) ) > 0 ) {
				$filename = 'URL';
				$source   = $_POST['options']['fileurl'];
			} else {
				$filename = trim( $_POST['filename'] );
				$source   = CMS_ROOT . $this->getFolder() . DS . $filename;
				if ( !file_exists( $source ) ) {
					Flash::set( 'error', __( 'File not found: :file:', array( ':file:' => $filename ) ) );
					redirect( get_url( 'plugin/csv_import' ) );
				}
			}


			if ( !$parent_page_id = (int) $_POST['parent_page_id'] ) {
				Flash::set( 'error', __( 'Parent page not specified' ) );
				redirect( get_url( 'plugin/csv_import' ) );
			}
		}


		if ( isset( $_POST['import'] ) ) {
			$messages = array( );

			// prepare timestamp
			$now_datetime = date( 'Y-m-d H:i:s' );

			// USED SLUGS - store duplicate slugs in table
			$used_slugs = array( );

			$structure = $this->getStructure( $source );
			$headers   = $structure['header'];

			// sanitizing part names
			$part_names = array_diff( $headers, self::$defaultPageFields );

			foreach ( $part_names as $key => $name ) {

				//check if it's core field
				if ( in_array( $name, self::$defaultPageFields ) ) {
					// unset it
					unset( $part_names[$key] );
					$messages[] = array( 'error',
								'PART NAME FORBIDDEN - "<b>' . $name . '</b>" - this is Wolf Core field and cannot be imported.'
					);
				}

				// check name validity
				if ( !CsvImportController::checkPartName( $name ) ) {
					unset( $part_names[$key] );
					$messages[] = array( 'error',
								'INVALID PART NAME - "<b>' . $name . '</b>" - will be ignored'
					);
				}
			} // $part_names iterator

			$current_row = 0;
			foreach ( $structure['contents'] as $row ) {
				$current_row += 1;

				if ( in_array( 'slug', $headers ) ) {
					$key	  = array_search( 'slug', $headers );
					$the_slug = CsvImportController::slugify( $row[$key] );
				} else {
					Flash::set( 'error', __( 'Column "slug" not found in table!' ) );
					redirect( get_url( 'plugin/csv_import' ) );
				}

				// check for empty slugs
				if (strlen($the_slug)>0) {

				if ( !in_array( $the_slug, $used_slugs ) ) {

					$existingPage = Record::findOneFrom( 'Page', 'slug=? AND parent_id=?', array( $the_slug, $parent_page_id ) );

					if ( !$existingPage ) {

						$new_page = new Page();
						// setting importable values
						foreach ( $headers as $head_key => $head_name ) {
							if ( in_array( $head_name, self::$importablePageFields ) ) {
								$new_page->$head_name = trim( $row[$head_key] );
							}
						}
						// fix slug
						$new_page->slug	   = $the_slug;

						// globally set values
						$new_page->parent_id	 = $parent_page_id;
						$new_page->layout_id	 = (int) self::$options['layout_id'];
						$new_page->status_id	 = (int) self::$options['status_id'];
						$new_page->is_protected  = (int) self::$options['is_protected'];
						$new_page->behavior_id   = (int) self::$options['behavior_id'];
						$new_page->needs_login   = (int) self::$options['needs_login'];
						$new_page->created_by_id = AuthUser::getId();
						$new_page->position	  = '0';


						if ( !self::checkDateTime( $new_page->created_on ) )
							$new_page->created_on   = $now_datetime;
						if ( !self::checkDateTime( $new_page->published_on ) )
							$new_page->published_on = $now_datetime;

						if ( strlen( $new_page->valid_until ) > 0 && !CsvImportController::checkDateTime( $new_page->valid_until ) ) {
							$new_page->valid_until  = NULL;
						}

						//$new_page->updated_by_id = $user_id;

						if ( strlen( $new_page->breadcrumb ) === 0 ) {
							$new_page->breadcrumb = $new_page->slug;
						}
						if ( strlen( $new_page->title ) === 0 ) {
							$new_page->title = $new_page->slug;
						}

						if ( $new_page->save() ) {

							$messages[] = array( 'success',
										__( 'Row' ) . ' ' . $current_row . ': ' .
										'PAGE IMPORTED - <b>' . $new_page->slug . '</b> <i>' . $new_page->title . '</i>'
							);

							// store slug for detecting duplicates
							$used_slugs[] = $new_page->slug;

							foreach ( $part_names as $head_key => $part_name ) {
								$new_page_part = new PagePart();

								$new_page_part->name	  = $part_name;
								$new_page_part->page_id   = $new_page->id();
								// ========================== TODO: allow per column overrides
								$new_page_part->filter_id = self::$options['default_filter'];

								if ( (strlen( trim( $row[$head_key] ) ) !== 0) || self::$options['create_empty_parts'] === '1' ) {
									if ( isset( $row[$head_key] ) ) {
										$new_page_part->content = $row[$head_key];
									} else {
										$new_page_part->content = '';
									}

									if ( $new_page_part->save() ) {
										$messages[] = array( 'success',
													__( 'Row' ) . ' ' . $current_row . ': ' .
													__( 'Page' ) . ' <b>' . $new_page->slug . '</b>: ' .
													'PART IMPORTED - <b>' . $new_page_part->name . '</b>'
										);
									} else
										$messages[] = array( 'warning',
													__( 'Row' ) . ' ' . $current_row . ': ' .
													'FAILED TO SAVE PART ' . $new_page_part->name . ' for page [' . $parent_page_id . ']'
										);
								} else
									$messages[] = array( 'info',
												__( 'Row' ) . ' ' . $current_row . ': ' .
												'PART EMPTY ' . $new_page_part->name . ' - NOT ADDED'
									);
							} // endforeach $part_names
						} else
							$messages[] = array( 'error',
										__( 'Row' ) . ' ' . $current_row . ': ' .
										'Page not saved!'
							);
					} else
						$messages[] = array( 'warning',
									__( 'Row' ) . ' ' . $current_row . ': ' .
									'PAGE ALREADY EXISTS! slug = <b>' . $the_slug . '</b>'
						);
				} else
					$messages[] = array( 'warning',
								__( 'Row' ) . ' ' . $current_row . ': ' .
								'DUPLICATE SLUG - <b>' . $the_slug . '</b> - row ignored!'
					);
				} else
							$messages[] = array( 'error',
										__( 'Row' ) . ' ' . $current_row . ': ' .
										'EMPTY SLUG - row ignored!'
							);

				Flash::setNow( 'messages', $messages );
			}
		}

		self::makePagesListRecursive( 1 );

		if ( isset( $_POST['preview'] ) ) {
			$structure = $this->getStructure( $source );

			$this->display( 'csv_import/views/index', array(
						'pagesList' => self::$pagesList,
						'options'   => self::$options,
						'directory' => $this->getFolder(),
						'files'	 => $this->getFiles( $this->getFolder() ),
						'structure' => $structure,
						'filename'  => $filename,
			) );
		} else {
			$this->display( 'csv_import/views/index', array(
						'pagesList' => self::$pagesList,
						'options'   => self::$options,
						'directory' => $this->getFolder(),
						'files'	 => $this->getFiles( $this->getFolder() ),
						'structure' => NULL,
			) );
		}

	}


	/**
	 * Converts a csv file into an array of lines and columns.
	 * khelibert@gmail.com
	 * from PHP.NET comments
	 *
	 * @param $fileContent String
	 * @param string $escape String
	 * @param string $enclosure String
	 * @param string $delimiter String
	 * @return array
	 */
	private function csvToArray( $fileContent, $escape = '\\', $enclosure = '"', $delimiter = ';' ) {
		$lines = array( );
		$fields = array( );

		if ( $escape == $enclosure ) {
			$escape	  = '\\';
			$fileContent = str_replace( array( '\\', $enclosure . $enclosure, "\r\n", "\r" ), array( '\\\\', $escape . $enclosure, "\n", "\n" ), $fileContent );
		}
		else
			$fileContent = str_replace( array( "\r\n", "\r" ), array( "\n", "\n" ), $fileContent );

		$nb		  = strlen( $fileContent );
		$field	   = '';
		$inEnclosure = false;
		$previous	= '';

		for ( $i = 0; $i < $nb; $i++ ) {
			$c = $fileContent[$i];
			if ( $c === $enclosure ) {
				if ( $previous !== $escape )
					$inEnclosure ^= true;
				else
					$field .= $enclosure;
			}
			else if ( $c === $escape ) {
				$next = $fileContent[$i + 1];
				if ( $next != $enclosure && $next != $escape )
					$field .= $escape;
			}
			else if ( $c === $delimiter ) {
				if ( $inEnclosure )
					$field .= $delimiter;
				else {
					//end of the field
					$fields[] = $field;
					$field	= '';
				}
			} else if ( $c === "\n" ) {
				$fields[] = $field;
				$field	= '';
				$lines[]  = $fields;
				$fields   = array( );
			}
			else
				$field .= $c;
			$previous = $c;
		}
		//we add the last element
		if ( true || $field !== '' ) {
			$fields[] = $field;
			$lines[]  = $fields;
		}
		return $lines;

	}

	private static function getAllChildren( $page_id ) {
		// Prepare SQL
		$sql   = 'SELECT page.* '
					. 'FROM ' . TABLE_PREFIX . 'page AS page '
					. 'WHERE parent_id = ' . (int) $page_id
					. " ORDER BY page.position, page.id";
		$pages = array( );
		Record::logQuery( $sql );
		if ( $stmt = Record::getConnection()->prepare( $sql ) ) {
			$stmt->execute();
			while ( $object  = $stmt->fetchObject() )
				$pages[] = $object;
		}

		return $pages;

	}


	private static function countAllChildren( $page_id ) {
		// Prepare SQL
		$sql  = 'SELECT COUNT(*) AS nb_rows '
					. 'FROM ' . TABLE_PREFIX . 'page AS page '
					. 'WHERE parent_id = ' . (int) $page_id;
		Record::logQuery( $sql );
		$stmt = Record::getConnection()->prepare( $sql );
		$stmt->execute();
		return (int) $stmt->fetchColumn();

	}


	public static function makePagesListRecursive( $page_id = 1 ) {
		$children = self::getAllChildren( $page_id );
		static $nestLevel; //for storing level, faster than ->level()
		if ( count( $children ) > 0 ) {
			$nestLevel++;
			foreach ( $children as $childpage ) {
				$childCount = self::countAllChildren( $childpage->id );
				if ( true ) {
					self::$pagesList[] = array(
								'label' => str_replace( " ", "- ", str_pad( ' ', $nestLevel, " ", STR_PAD_LEFT ) ) . ' ' . $childpage->title,
								'id'	=> $childpage->id,
								'count' => $childCount,
								'breadcrumb' => $childpage->breadcrumb,
					);
					self::makePagesListRecursive( $childpage->id );
				}
			}
			$nestLevel--;
		}

	}

	/**
	 * Convert string to valid slug
	 *
	 * @param String $str
	 * @return String
	 */
	public static function slugify( $str ) {
		$forbiddenChars = array( '#', '$', '%', '^', '&', '*', '!', '~', '"', '\'', '=', '?', '/', '[', ']', '(', ')', '|', '<', '>', ';', ':', '\\' );

		$str = str_replace( $forbiddenChars, '', $str );
		$str = str_replace( ' ', '-', $str );

		$str = iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', $str );
		$str = trim( $str );
		$str = mb_strtolower( $str, 'UTF-8' );
		$str = preg_replace( '/[^a-zA-Z0-9\-\.]/', '-', $str );
		$str = preg_replace( '/-{2,}/', '-', $str );
		return $str;

	}

	/**
	 * Check if string is valid part name
	 *
	 * @param String $string
	 * @return boolean
	 */
	public static function checkPartName( $string ) {
		return ( preg_match( "/[^a-zA-Z0-9\-_]/", $string ) !== 1 );

	}

	/**
	 * Check if string is valid DateTime
	 *
	 * @param type $sDate
	 * @return boolean
	 */
	public static function checkDateTime( $sDate ) {
		if ( (preg_match( '/^([0-9]{4})[-_]([0-9]{2})[-_]([0-9]{2}) ([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/D', (string) $sDate, $bits ) &&
					checkdate( $bits[2], $bits[3], $bits[1] )) === true ) {
			return true;
		}
		else
			return false;

	}


	/**
	 * getFiles
	 *
	 * Retrieves an array of all files
	 */
	protected function getFiles( $dir ) {
		$scandir = scandir( $_SERVER{'DOCUMENT_ROOT'} . URL_PUBLIC . trim( $dir, '/' ) );
		//$scandir = scandir( CMS_ROOT . DS . trim( $dir, '/' ) );
		foreach ( $scandir as $k => $v ) {
			if (
						strpos( strtolower( trim( $v ) ), '.csv' ) === false &&
						strpos( strtolower( trim( $v ) ), '.tsv' ) === false &&
						strpos( strtolower( trim( $v ) ), '.txt' ) === false
			) {
				unset( $scandir[$k] );
			}
		}
		return $scandir;

	}


}