<?php

/* Security measure */
if ( !defined( 'IN_CMS' ) )
    exit();

if ( !Plugin::isEnabled( 'mm_core' ) ) {
    unset( Plugin::$plugins['csv_import'] );
    Plugin::save();
    Flash::set( 'error', __( '<b>mm_core</b> plugin not found! <br/>
                            Download latest <b>mm_core</b> here: <br/>
                            <a href="http://marekmurawski.pl/en/web/wolf-cms/plugins" target="_blank">http://marekmurawski.pl/en/web/wolf-cms/plugins</a>
                           ' ) );
    exit();
}

Flash::set( 'success', __( 'Succesfully activated csv_import plugin!' ) );
exit();