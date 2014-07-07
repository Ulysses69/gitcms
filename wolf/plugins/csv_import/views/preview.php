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
$messages = array( );
?>
<h3><?php echo __( 'Import preview' ); ?>: <?php echo $filename; ?></h3>
<p><?php echo __( 'Please review the table to see if data will be correctly interpreted. Pay special attention to <i>language-specific characters, quotes, commas etc</i>. If data isn\'t displayed correctly, change settings above.' ); ?></p>
<p>
    <?php echo __( 'columns' ); ?>: <b><?php echo $structure['col_count']; ?></b>,
    <?php echo __( 'rows' ); ?>: <b><?php echo $structure['row_count']; ?></b>,
    <?php echo __( 'locale' ); ?>: <b><?php echo setlocale( LC_ALL, 0 ); ?></b>
</p>

<div id="table-preview-container" class="full">
    <table class="preview">
        <thead>
            <?php
            echo '<tr>' . PHP_EOL;
            echo '<th class="text-center">#</th>' . PHP_EOL;
            foreach ( $structure['header'] as $key => $cell ) {
                $hClass = '';
                if ( in_array( $cell, CsvImportController::$importablePageFields ) )
                    $hClass = ' importable';
                if ( !CsvImportController::checkPartName( $cell ) ) {
                    $hClass       = ' invalid';
                }
                echo '<th class="' . $hClass . '">';
                echo $cell;
                echo '</th>';
            }
            echo '</tr>' . PHP_EOL;
            ?>
        </thead>
        <?php
        $now_datetime = '<span style="white-space:nowrap">' . date( 'Y-m-d H:i:s' ) . '</span>';
        $current_row  = 0;
        foreach ( $structure['contents'] as $rows ):
            $current_row += 1;
            if ( in_array( 'slug', $structure['header'] ) ) {
                $key        = array_search( 'slug', $structure['header'] );
                $valid_slug = CsvImportController::slugify( $rows[$key] );
            }

            echo '<tr>' . PHP_EOL;
            echo '<td class="text-center">' . $current_row . '</td>' . PHP_EOL;

            foreach ( $rows as $key => $cell ) {
                $cell_override = false;
                $cell          = trim( $cell );


                $column_name = $structure['header'][$key];

                if ( ($column_name === 'slug') && $valid_slug !== $cell ) {
                    $cell_override = CsvImportController::slugify( $cell );
                }

                if ( ($column_name === 'slug') && (strlen( $cell ) === 0) && (strlen( $cell_override ) === 0) ) {
                    $messages[] = array( 'warning',
                                __( 'Row' ) . ': <b>' . $current_row . '</b> - ' .
                                'SLUG EMPTY! - <b>row will be ignored</b>'
                    );
                }

                if ( $column_name === 'breadcrumb' && strlen( $cell ) === 0 ) {
                    $cell_override = $valid_slug;
                }
                if ( $column_name === 'title' && strlen( $cell ) === 0 ) {
                    $cell_override = $valid_slug;
                }

                if ( ($column_name === 'created_on' || $column_name === 'published_on' ) ) {
                    if ( !CsvImportController::checkDateTime( $cell ) )
                        $cell_override = $now_datetime;
                }
                if ( ($column_name === 'valid_until' ) ) {
                    if ( strlen( $cell ) !== 0 && !CsvImportController::checkDateTime( $cell ) ) {
                        $cell_override = $now_datetime;
                    }
                }
                //check required fields
                $requiredClass = ( $column_name == 'slug' ) ? 'required' : '';

                $emptyClass = ((strlen( $cell ) === 0) && (strlen( $cell_override ) === 0)) ? ' empty' : '';

                echo '<td class="' . $requiredClass . $emptyClass . '">';
                if ( $cell_override ) {
                    $messages[] = array( 'info',
                                __( 'Row' ) . ': <b>' . $current_row . '</b> - ' .
                                __( 'Cell' ) . ' <b>' . $column_name . '</b> ' .
                                __( 'will be replaced with' ) . ' <b>' . $cell_override . '</b>'
                    );
                    $delO = '<del>';
                    $delC = '</del>';
                } else {
                    $delO = '';
                    $delC = '';
                }
                echo '<div>' . $delO . htmlentities( $cell, ENT_COMPAT, 'UTF-8' ) . $delC . '</div>';
                if ( $cell_override ) {
                    echo '<div style="color: red" title="' . __( 'this cell will be replaced' ) . '"><b>' . $cell_override . '</b></div>';
                }
                echo '</td>';
            }
            echo '</tr>' . PHP_EOL;
        endforeach;
        ?>
    </table>
</div>
<?php
if ( count( $messages ) > 0 ) {
    Flash::setNow( 'messages', $messages );
}
?>
<h3><?php echo __( 'Raw file preview' ); ?>: <?php echo $filename; ?></h3>
<div id="raw-preview-container" class="full">
    <pre><?php
echo htmlentities( $structure['raw_file'], ENT_COMPAT, 'UTF-8' );
?></pre>
</div>