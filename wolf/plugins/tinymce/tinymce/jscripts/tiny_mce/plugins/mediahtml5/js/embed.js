/*globals document,console */
/**
 * This script contains embed functions for common plugins. This scripts are complety free to use for any purpose.
 */

function writeVideo(p) {
	var h = '',
		n;
	h += '<video';
	h += typeof p.id !== "undefined" ? ' id="' + p.id + '"' : '';
	h += typeof p.poster !== "undefined" ? ' poster="' + p.poster + '"' : '';
	h += typeof p.title !== "undefined" ? ' title="' + p.title + '"' : '';
	h += typeof p.width !== "undefined" ? ' width="' + p.width + '"' : '';
	h += typeof p.height !== "undefined" ? ' height="' + p.height + '"' : '';
	h += '>';
	h += typeof p.controls !== "undefined" ? ' controls="controls"' : '';
	h += typeof p.autoplay !== "undefined" ? ' autoplay="autoplay"' : '';
	h += typeof p.preload !== "undefined" ? ' preload="auto"' : '';
	h += typeof p.autobuffer !== "undefined" ? ' autobuffer="autobuffer"' : '';
	h += '<source src="' + p.src;
	h += typeof p.mimetype !== "undefined" ? '" type="' + p.type + '"' : '';
	h += ' />';
	h += '</video>';
	document.write(h);
}

function writeEmbed(cls, cb, mt, p) {
	var h = '',
		n;
	h += '<object classid="clsid:' + cls + '" codebase="' + cb + '"';
	h += typeof(p.id) != "undefined" ? 'id="' + p.id + '"' : '';
	h += typeof(p.name) != "undefined" ? 'name="' + p.name + '"' : '';
	h += typeof(p.width) != "undefined" ? 'width="' + p.width + '"' : '';
	h += typeof(p.height) != "undefined" ? 'height="' + p.height + '"' : '';
	h += typeof(p.align) != "undefined" ? 'align="' + p.align + '"' : '';
	h += '>';
	for (n in p) {
		if (typeof n !== "undefined") {
			h += '<param name="' + n + '" value="' + p[n] + '">';
		}
	}
	h += '<embed type="' + mt + '"';

	for (n in p) {
		if (typeof n !== "undefined") {
			h += n + '="' + p[n] + '" ';
		}
	}
	h += '></embed></object>';
	document.write(h);
}


function writeFlash(p) {
	writeEmbed('D27CDB6E-AE6D-11cf-96B8-444553540000', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0', 'application/x-shockwave-flash', p);
}

function writeShockWave(p) {
	writeEmbed('166B1BCA-3F9C-11CF-8075-444553540000', 'http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0', 'application/x-director', p);
}

function writeQuickTime(p) {
	writeEmbed('02BF25D5-8C17-4B23-BC80-D3488ABDDC6B', 'http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0', 'video/quicktime', p);
}

function writeRealMedia(p) {
	writeEmbed('CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0', 'audio/x-pn-realaudio-plugin', p);
}

function writeWindowsMedia(p) {
	p.url = p.src;
	writeEmbed('6BF52A52-394A-11D3-B153-00C04F79FAA6', 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701', 'application/x-mplayer2', p);
}

function writeVideoMedia(p) {
	writeVideo(p);
}