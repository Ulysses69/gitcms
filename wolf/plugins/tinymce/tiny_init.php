<?php
//
// Please do not toucht the PHP codes!!
//
// The php in this file is to prevent you from having to manually include/change paths
//

$pluginDir = dirname($_SERVER['PHP_SELF']);
$clientName = 'Blue Horizons';
$clientAddress = 'Blue Horizons Address';
$clientPhone = 'Blue Horizons Phone Number';
$clientEmail = 'Blue Horizons Email Address';

$imagemanagerPlugin = '';
$imagemanagerButton = 'image';
$data = strip_tags(file_get_contents($_SERVER{'DOCUMENT_ROOT'}.'/wolf/plugins/tinymce_imagemanager/status.txt'));
if($data == 'enabled'){
	// Image Manager is enabled
	$imagemanagerPlugin = ',imagemanager';
	$imagemanagerButton = 'insertimage';
}


?>

tinyMCE.init({
    mode : "exact",
	theme : "advanced",
	skin : "o2k7",
	skin_variant : "silver",
	external_image_list_url : "myexternallist.js",
	//plugins : "-snippets,inlinepopups,spellchecker,codeprotect,paste,table,fullscreen,preview,contextmenu,advimage,pagebreak,xhtmlxtras,halfpage",
	plugins : "-snippets,inlinepopups,spellchecker,codeprotect,paste,table,fullscreen,preview,contextmenu,advimage,pagebreak,xhtmlxtras,media,pdw,codemagic<?php echo $imagemanagerPlugin; ?>",
	dialog_type : "modal",
	paste_auto_cleanup_on_paste : true,
	//paste_retain_style_properties : "color,font-weight,font-style,font-variant,border,background,background-color,border-width,border-style,border-color",
	paste_retain_style_properties : "",
	paste_strip_class_attributes : "mso",
	paste_block_drop : true,
	paste_remove_spans : true,
	pagebreak_separator : "<!-- readmore -->",
	forced_root_block : false,
	theme_advanced_blockformats : "h1,h2,h3,h4,p",
	//theme_advanced_buttons1 : "bold,italic,formatselect,styleselect,justifyleft,justifycenter,justifyright,bullist,numlist,|,blockquote,cite,abbr,acronym,|,pasteword,cleanup,removeformat,|,spellchecker",
	//theme_advanced_buttons1 : "snippetsbox,formatselect,styleselect,bold,italic,|,bullist,numlist,|,blockquote,cite,abbr,acronym,|,pasteword,|,spellchecker",
	//theme_advanced_buttons1 : "formatselect,styleselect,bold,italic,|,bullist,numlist,|,blockquote,q,cite,abbr,acronym,|,pasteword,cleanup,selectall,|,spellchecker",
	theme_advanced_buttons1 : "formatselect,|,bold,italic,|,bullist,numlist,|,link,unlink,anchor,|,<?php echo $imagemanagerButton; ?>,media,|,charmap,|,pdw_toggle",
	theme_advanced_buttons2 : "styleselect,|,selectall,|,blockquote,q,cite,abbr,acronym,|,spellchecker,|,tablecontrols,|,undo,redo,|,codemagic,|,fullscreen",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resize_horizontal : false,
	theme_advanced_resizing : true,
	theme_advanced_resizing_min_height : 400,
	pdw_toggle_on : 1,
    pdw_toggle_toolbars : "2",
	//theme_advanced_styles : "Introduction=intro;Popup=popup;Buy=buy;Demo=demo;Trial=trial;Quote=quote",
	<?php
	$styles = $_GET['styles'];
	$styles = str_replace(",", "=", $styles);
	if($styles != '') echo 'theme_advanced_styles : "'.str_replace(array("\r\n","\r","\n"), "", $styles).'",'."\n";
	?>
	plugin_insertdate_dateFormat: "%Y-%m-%d",
	plugin_insertdate_timeFormat: "%H:%M:%S",
	relative_urls: true,
	spellchecker_languages : "+English=en",

	// TinyBrowser
	entities : "",
	language : 'en',
	file_browser_callback : "tinyBrowser",

	// Some performance enhancements according to TinyMCE website
	button_tile_map : true,

    	// Fix for images showing up correctly in editor, but not in final page
    	relative_urls : false,
    	//document_base_url : "/",

    	//Example of how to add your stylesheet styles to the styles dropdown box in TinyMCE
    	//theme_advanced_styles : "Normal text=normaltext, Align left=align-left, Align right=align-right",

    	// Preview content in system\'s style
    	content_css : "<?php echo $pluginDir; ?>/config.php?g=css",

	// Dropdown lists for link/image/media/template dialogs
	external_image_list_url : "<?php echo $pluginDir; ?>/lists/image_list.php",
	external_link_list_url : "<?php echo $pluginDir; ?>/lists/pages_list.php",

	extended_valid_elements : "blockquote[cite|class|id],q[cite|class|id|title],header,footer,section,article,nav,aside,a[href|class|id|name|title|style|rel],img[class|id|src|name|alt=|title|width|height|type],hr[class|width|size|noshade|style],font[face|size|color|style],span[class|id|style],p[class|id|style],div[class|id|style],param[name|value],embed[id|style|width|height|type|src|*],video[*],audio[*],source[*]",
	//valid_elements : "*[*]",
	//extended_valid_elements : "*[*]",

	paste_preprocess : function(pl, o) {
            // Content string containing the HTML from the clipboard
            //alert(o.content);
            //o.content = "-: CLEANED :-\n" + o.content;
        },
        paste_postprocess : function(pl, o) {
            // Content DOM node containing the DOM structure of the clipboard
            //alert(o.node.innerHTML);
            //o.node.innerHTML = o.node.innerHTML + "\n-: CLEANED :-";
        },


	// Client data
	setup : function(ed) {
		
		"adminArticle" in window && ed.onChange.add(adminArticle.onContentChange.bind(adminArticle));


		// Set Minimum Height of Textarea
        ed.onInit.add(function() {
            var e = tinymce.DOM.get(ed.id + '_tbl'), ifr = tinymce.DOM.get(ed.id + '_ifr'), w = ed.getWin(), dh;
            var h = 20; //new height of edit area
            dh = e.clientHeight - ifr.clientHeight; //get the height of the toolbars
			ed.theme.resizeTo(w.clientWidth, 400);
        });
        

		/*
		// Force Paste-as-Plain-Text or Paste-from-word
        ed.onPaste.add( function(ed, e, o) {
            //ed.execCommand('mcePasteText', true);
            ed.execCommand('mcePasteWord', true);
            return tinymce.dom.Event.cancel(e);
        });
        */

		// Client Buttons
		ed.addButton('clientname', {
			title : 'Client Name',
			image : '<?php echo $pluginDir; ?>/images/clientname.gif',
			onclick : function() {
				ed.focus();
				ed.selection.setContent('<strong><?php echo $clientName; ?></strong>');
			}
		});
		ed.addButton('clientaddress', {
			title : 'Client Address',
			image : '<?php echo $pluginDir; ?>/images/clientaddress.gif',
			onclick : function() {
				ed.focus();
				ed.selection.setContent('<strong><?php echo $clientAddress; ?></strong>');
			}
		});
		ed.addButton('clientphone', {
			title : 'Client Telephone Number',
			image : '<?php echo $pluginDir; ?>/images/clientphone.gif',
			onclick : function() {
				ed.focus();
				ed.selection.setContent('<strong><?php echo $clientPhone; ?></strong>');
			}
		});
		ed.addButton('clientemail', {
			title : 'Client Email Address',
			image : '<?php echo $pluginDir; ?>/images/clientemail.gif',
			onclick : function() {
				ed.focus();
				ed.selection.setContent('<strong><?php echo $clientEmail; ?></strong>');
			}
		});
		ed.addButton('bookdemo', {
			title : 'Book a demo ',
			image : '<?php echo $pluginDir; ?>/images/demo.gif',
			onclick : function() {
				ed.focus();
				ed.selection.setContent('<strong>Book a demo</strong>');
			}
		});
	}

});


tinymce.create('tinymce.plugins.SnippetsPlugin', {
    createControl: function(n, cm) {
        switch (n) {
            case 'snippetsbox':
                var mlb = cm.createListBox('snippetsbox', {
                     title : 'Snippets',
                     onselect : function(v) {
                         //tinyMCE.activeEditor.windowManager.alert('Value selected:' + v);
                         tinyMCE.activeEditor.focus();
                         tinyMCE.activeEditor.selection.setContent(v);
                     }
                });

                // Add some values to the list box
                // mlb.add('Client name', 'admin_title');
                // mlb.add('Client address', 'address');
                // mlb.add('Client telephone', 'telephone');

                // Return the new listbox instance
                return mlb;

            case 'mysplitbutton':
                var c = cm.createSplitButton('mysplitbutton', {
                    title : 'My split button',
                    image : 'img/example.gif',
                    onclick : function() {
                        //tinyMCE.activeEditor.windowManager.alert('Button was clicked.');
                    }
                });

                c.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Client name', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

                    m.add({title : 'Client address', onclick : function() {
                        //tinyMCE.activeEditor.windowManager.alert('Some  item 1 was clicked.');
                    }});

                    m.add({title : 'Client telephone', onclick : function() {
                        //tinyMCE.activeEditor.windowManager.alert('Some  item 2 was clicked.');
                    }});
                });

                // Return the new splitbutton instance
                return c;
        }

        return null;
    }
});
tinymce.PluginManager.add('snippets', tinymce.plugins.SnippetsPlugin);