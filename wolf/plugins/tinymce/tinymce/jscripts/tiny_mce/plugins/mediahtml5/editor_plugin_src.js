/*globals tinymce */
/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */
(function () {
	var each = tinymce.each;
	tinymce.create('tinymce.plugins.MediaHtml5Plugin', {
		// Private methods
		_parse: function (s) {
			return tinymce.util.JSON.parse('{' + s + '}');
		},
		_serialize: function (o) {
			return tinymce.util.JSON.serialize(o).replace(/[{}]/g, '');
		},
		_objectsToSpans: function (ed, o) {
			var t = this,
				h = o.content;
			h = h.replace(/<script[^>]*>\s*write(Video|Flash|ShockWave|WindowsMedia|QuickTime|RealMedia)\(\{([^\)]*)\}\);\s*<\/script>/gi, function (a, b, c) {
				var o = t._parse(c);
				return '<img class="mceItem' + b + '" title="' + ed.dom.encode(c) + '" src="' + t.url + '/img/trans.gif" width="' + o.width + '" height="' + o.height + '" />';
			});
			// object/embed/param tag replace
				h = h.replace(/<object([^>]*)>/gi, '<span class="mceItemObject" $1>');
				h = h.replace(/<embed([^>]*)\/?>/gi, '<span class="mceItemEmbed" $1></span>');
				h = h.replace(/<embed([^>]*)>/gi, '<span class="mceItemEmbed" $1>');
				h = h.replace(/<\/(object)([^>]*)>/gi, '</span>');
				h = h.replace(/<\/embed>/gi, '');
				h = h.replace(/<param([^>]*)>/gi, function (a, b) {
					return '<span ' + b.replace(/value=/gi, '_mce_value=') + ' class="mceItemParam"></span>';
				});
				h = h.replace(/\/ class=\"mceItemParam\"><\/span>/gi, 'class="mceItemParam"></span>');
			// video tag replace, some browsers do not support the video/source tags so we use
			// the same scheme we are using for object/embed.
				h = h.replace(/<video([^>]*)>/gi, '<span class="mceItemVideoTag" $1>');
				h = h.replace(/<\/(video)([^>]*)>/gi, '</span>');
				h = h.replace(/<source([^>]*)>/gi, function (a, b) {
					return '<span ' + b.replace(/value=/gi, '_mce_value=') + ' class="mceItemVideoSourceTag"></span>';
				});
				h = h.replace(/\/ class=\"mceItemVideoSourceTag\"><\/span>/gi, 'class="mceItemVideoSourceTag"></span>');
				h = h.replace(/<\/source>/gi, '');
			o.content = h;
		},
		_buildVideoObj: function(o, n) {
			var ob, ed = this.editor,
				dom = ed.dom,
				p = this._parse(n.title),
				s, ss;
			p.width = o.width = dom.getAttrib(n, 'width') || 100;
			p.height = o.height = dom.getAttrib(n, 'height') || 100;
			// create our video obj
			s = {
				_mce_name: 'video',
				style: dom.getAttrib(n, 'style'),
				width: o.width,
				height: o.height
			};
			if (typeof p.id !== "undefined" && p.id > 0) {
				s.id = p.id;
			}
			if (typeof p.title !== "undefined" && p.title.length > 0) {
				s.title = p.title;
			}
			if (typeof p.poster !== "undefined" && p.poster.length > 0) {
				s.poster = p.poster;
			}
			if (typeof p.showcontrols !== "undefined") {
				s.controls = 'controls';
			}
			if (typeof p.autoplay !== "undefined") {
				s.autoplay = 'autoplay';
			}
			if (typeof p.loop === "boolean") {
				s.loop = p.loop;
			}
			if (typeof p.preload !== "undefined") {
				s.preload = 'auto';
			}
			if (typeof p.buffer !== "undefined") {
				s.autobuffer = 'autobuffer';
			}
			ob = dom.create('span', s);
			// create source obj
			ss = {
				_mce_name: 'source'
			};
			each(p, function (v, k) {
				if (/^(src|mimetype|media)$/.test(k)) {
					if (k === 'src' && k.length > 0) {
						ss.src = v;
					}
					if (k === 'mimetype' && k.length > 0) {
						ss.type = v;
					}
					if (k === 'media' && k.length > 0) {
						ss.media = v;
					}
				}
			});
			dom.add(ob, 'span', ss);
			return ob;
		},
		_buildObj: function (o, n) {
			var ob, ed = this.editor,
				dom = ed.dom,
				p = this._parse(n.title),
				stc;
			stc = ed.getParam('media_strict', true) && o.type === 'application/x-shockwave-flash';
			p.width = o.width = dom.getAttrib(n, 'width') || 100;
			p.height = o.height = dom.getAttrib(n, 'height') || 100;
			if (p.src) {
				p.src = ed.convertURL(p.src, 'src', n);
			}
			if (stc) {
				ob = dom.create('span', {
					id: p.id,
					_mce_name: 'object',
					type: 'application/x-shockwave-flash',
					data: p.src,
					style: dom.getAttrib(n, 'style'),
					width: o.width,
					height: o.height
				});
			} else {
				ob = dom.create('span', {
					id: p.id,
					_mce_name: 'object',
					classid: "clsid:" + o.classid,
					style: dom.getAttrib(n, 'style'),
					codebase: o.codebase,
					width: o.width,
					height: o.height
				});
			}
			each(p, function (v, k) {
				if (!/^(width|height|codebase|classid|id|_cx|_cy)$/.test(k)) {
					// Use url instead of src in IE for Windows media
					if (o.type === 'application/x-mplayer2' && k === 'src' && !p.url) {
						k = 'url';
					}
					if (v) {
						dom.add(ob, 'span', {
							_mce_name: 'param',
							name: k,
							'_mce_value': v
						});
					}
				}
			});
			if (!stc) {
				dom.add(ob, 'span', tinymce.extend({
					_mce_name: 'embed',
					type: o.type,
					style: dom.getAttrib(n, 'style')
				}, p));
			}
			return ob;
		},
		_createImg: function (cl, n) {
			var im, dom = this.editor.dom,
				pa = {},
				args;
			args = ['id', 'name', 'width', 'height', 'bgcolor', 'align', 'flashvars', 'src', 'wmode', 'allowfullscreen', 'quality', 'data', 'title', 'poster', 'autoplay', 'autobuffer', 'controls', 'loop', 'preload', 'media', 'type'];
			// Create image
			im = dom.create('img', {
				src: this.url + '/img/trans.gif',
				width: dom.getAttrib(n, 'width') || 100,
				height: dom.getAttrib(n, 'height') || 100,
				style: dom.getAttrib(n, 'style'),
				'class': cl
			});
			// Setup base parameters
			each(args, function (na) {
				var v = dom.getAttrib(n, na);
				if (typeof v === "string" && v.length > 0) {
					pa[na] = v;
				}
			});
			// Add optional parameters
			each(dom.select('span', n), function (n) {
				if (dom.hasClass(n, 'mceItemParam') || dom.hasClass(n, 'mceItemVideoSourceTag')) {
					pa[dom.getAttrib(n, 'name')] = dom.getAttrib(n, '_mce_value');
				}
			});
			// Use src not movie
			if (pa.movie) {
				pa.src = pa.movie;
				delete pa.movie;
			}
			// No src try data
			if (!pa.src && typeof pa.data !== "undefined") {
				pa.src = pa.data;
				delete pa.data;
			}
			// If we have a poster src, then set img src to match
			if (typeof pa.poster === "string" && pa.poster.length > 0 && (/\/img\/trans\.gif/).test(im.src)) {
				im.src = pa.poster;
			}
			// Merge with embed args
			n = dom.select('.mceItemEmbed', n)[0];
			if (n) {
				each(args, function (na) {
					var v = dom.getAttrib(n, na);
					if (v && !pa[na]) {
						pa[na] = v;
					}
				});
			}
			// Merge with source args
			n = dom.select('.mceItemVideoSourceTag', n)[0];
			if (n) {
				each(args, function (na) {
					var v = dom.getAttrib(n, na);
					if (v && !pa[na]) {
						pa[na] = v;
					}
				});
			}
			delete pa.width;
			delete pa.height;
			im.title = this._serialize(pa);
			return im;
		},
		_spansToImgs: function (p) {
			var t = this,
				dom = t.editor.dom,
				ci;
			each(dom.select('span', p), function (n) {
				// Convert object into image
				if (dom.getAttrib(n, 'class') === 'mceItemObject') {
					ci = dom.getAttrib(n, "classid").toLowerCase().replace(/\s+/g, '');
					switch (ci) {
					case 'clsid:d27cdb6e-ae6d-11cf-96b8-444553540000':
						dom.replace(t._createImg('mceItemFlash', n), n);
						break;
					case 'clsid:166b1bca-3f9c-11cf-8075-444553540000':
						dom.replace(t._createImg('mceItemShockWave', n), n);
						break;
					case 'clsid:6bf52a52-394a-11d3-b153-00c04f79faa6':
					case 'clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95':
					case 'clsid:05589fa1-c356-11ce-bf01-00aa0055595a':
						dom.replace(t._createImg('mceItemWindowsMedia', n), n);
						break;
					case 'clsid:02bf25d5-8c17-4b23-bc80-d3488abddc6b':
						dom.replace(t._createImg('mceItemQuickTime', n), n);
						break;
					case 'clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa':
						dom.replace(t._createImg('mceItemRealMedia', n), n);
						break;
					default:
						dom.replace(t._createImg('mceItemFlash', n), n);
					}
					return;
				}
				// Convert embed into image
				if (dom.getAttrib(n, 'class') === 'mceItemEmbed') {
					switch (dom.getAttrib(n, 'type')) {
					case 'application/x-shockwave-flash':
						dom.replace(t._createImg('mceItemFlash', n), n);
						break;
					case 'application/x-director':
						dom.replace(t._createImg('mceItemShockWave', n), n);
						break;
					case 'application/x-mplayer2':
						dom.replace(t._createImg('mceItemWindowsMedia', n), n);
						break;
					case 'video/quicktime':
						dom.replace(t._createImg('mceItemQuickTime', n), n);
						break;
					case 'audio/x-pn-realaudio-plugin':
						dom.replace(t._createImg('mceItemRealMedia', n), n);
						break;
					default:
						dom.replace(t._createImg('mceItemFlash', n), n);
					}
				}
				// Convert video into image
				if (dom.getAttrib(n, 'class') === 'mceItemVideoTag') {
					dom.replace(t._createImg('mceItemVideo', n), n);
				}
				if (dom.getAttrib(n, 'class') === 'mceItemVideoSourceTag') {
					dom.replace(t._createImg('mceItemVideo', n), n);
				}
			});
			
		},
		init: function (ed, url) {
			var t = this;
			t.editor = ed;
			t.url = url;
			function isMediaHtml5Elm(n) {
				return (/^(mceItemVideo|mceItemFlash|mceItemShockWave|mceItemWindowsMedia|mceItemQuickTime|mceItemRealMedia)$/).test(n.className);
			}
			ed.onPreInit.add(function () {
				// Force in _value parameter this extra parameter is required for older Opera versions
				ed.serializer.addRules('param[name|value|_mce_value],video[poster|title|autoplay|controls|height|loop|preload|src|width],source[src|type|media]');
			});
			// Register commands
			ed.addCommand('mceMediaHtml5', function () {
				ed.windowManager.open({
					file: url + '/mediahtml5.htm',
					width: 430 + parseInt(ed.getLang('media.delta_width', 0), 10),
					height: 470 + parseInt(ed.getLang('media.delta_height', 0), 10),
					inline: 1
				}, {
					plugin_url: url
				});
			});
			// Register buttons
			ed.addButton('mediahtml5', {
				title: 'mediahtml5.desc',
				image: url + '/img/mediahtml5.png',
				cmd: 'mceMediaHtml5'
			});
			ed.onNodeChange.add(function (ed, cm, n) {
				cm.setActive('mediahtml5', n.nodeName === 'IMG' && isMediaHtml5Elm(n));
			});
			ed.onInit.add(function () {
				var lo = {
					mceItemVideo: 'video',
					mceItemFlash: 'flash',
					mceItemShockWave: 'shockwave',
					mceItemWindowsMedia: 'windowsmedia',
					mceItemQuickTime: 'quicktime',
					mceItemRealMedia: 'realmedia'
				};
				ed.selection.onSetContent.add(function () {
					t._spansToImgs(ed.getBody());
				});
				ed.selection.onBeforeSetContent.add(t._objectsToSpans, t);
				if (ed.settings.content_css !== false) {
					ed.dom.loadCSS(url + "/css/content.css");
				}
				if (ed.theme && ed.theme.onResolveName) {
					ed.theme.onResolveName.add(function (th, o) {
						if (o.name === 'img') {
							each(lo, function (v, k) {
								if (ed.dom.hasClass(o.node, k)) {
									o.name = v;
									o.title = ed.dom.getAttrib(o.node, 'title');
									return false;
								}
							});
						}
					});
				}
				if (ed && ed.plugins.contextmenu) {
					ed.plugins.contextmenu.onContextMenu.add(function (th, m, e) {
						if (e.nodeName === 'IMG' && /mceItem(Video|Flash|ShockWave|WindowsMedia|QuickTime|RealMedia)/.test(e.className)) {
							m.add({
								title: 'mediahtml5.edit',
								icon: url + '/img/mediahtml5.png',
								image: url + '/img/mediahtml5.png',
								cmd: 'mceMediaHtml5'
							});
						}
					});
				}
			});
			ed.onBeforeSetContent.add(t._objectsToSpans, t);
			ed.onSetContent.add(function () {
				t._spansToImgs(ed.getBody());
			});
			ed.onPreProcess.add(function (ed, o) {
				var dom = ed.dom;
				if (o.set) {
					t._spansToImgs(o.node);
					each(dom.select('IMG', o.node), function (n) {
						var p;
						if (isMediaHtml5Elm(n)) {
							p = t._parse(n.title);
							dom.setAttrib(n, 'width', dom.getAttrib(n, 'width', p.width || 100));
							dom.setAttrib(n, 'height', dom.getAttrib(n, 'height', p.height || 100));
						}
					});
				}
				if (o.get) {
					each(dom.select('IMG', o.node), function (n) {
						var ci, cb, mt;
						if (ed.getParam('media_use_script')) {
							if (isMediaHtml5Elm(n)) {
								n.className = n.className.replace(/mceItem/g, 'mceTemp');
							}
							return;
						}
						switch (n.className) {
						case 'mceItemVideo':
							ci = '';
							cb = '';
							mt = '';
							break;
						case 'mceItemFlash':
							ci = 'd27cdb6e-ae6d-11cf-96b8-444553540000';
							cb = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0';
							mt = 'application/x-shockwave-flash';
							break;
						case 'mceItemShockWave':
							ci = '166b1bca-3f9c-11cf-8075-444553540000';
							cb = 'http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0';
							mt = 'application/x-director';
							break;
						case 'mceItemWindowsMedia':
							ci = ed.getParam('media_wmp6_compatible') ? '05589fa1-c356-11ce-bf01-00aa0055595a' : '6bf52a52-394a-11d3-b153-00c04f79faa6';
							cb = 'http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701';
							mt = 'application/x-mplayer2';
							break;
						case 'mceItemQuickTime':
							ci = '02bf25d5-8c17-4b23-bc80-d3488abddc6b';
							cb = 'http://www.apple.com/qtactivex/qtplugin.cab#version=6,0,2,0';
							mt = 'video/quicktime';
							break;
						case 'mceItemRealMedia':
							ci = 'cfcdaa03-8be4-11cf-b84b-0020afbbccfa';
							cb = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0';
							mt = 'audio/x-pn-realaudio-plugin';
							break;
						}
						if (ci.length > 0) {
							dom.replace(t._buildObj({
								classid: ci,
								codebase: cb,
								type: mt
							}, n), n);
						} else {
							// builds our video tags
							dom.replace(t._buildVideoObj({
								type: ''
							}, n), n);
						}
					});
				}
			});
			ed.onPostProcess.add(function (ed, o) {
				o.content = o.content.replace(/_mce_value=/g, 'value=');
			});
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? ed.dom.decode(n[1]) : '';
			}
			ed.onPostProcess.add(function (ed, o) {
				if (ed.getParam('media_use_script')) {
					o.content = o.content.replace(/<img[^>]+>/g, function (im) {
						var cl = getAttr(im, 'class');
						if (/^(mceTempVideo|mceTempFlash|mceTempShockWave|mceTempWindowsMedia|mceTempQuickTime|mceTempRealMedia)$/.test(cl)) {
							var at = t._parse(getAttr(im, 'title'));
							at.width = getAttr(im, 'width');
							at.height = getAttr(im, 'height');
							im = '<script type="text/javascript">write' + cl.substring(7) + '({' + t._serialize(at) + '});</script>';
						}
						return im;
					});
				}
			});
		},
		getInfo: function () {
			return {
				longname: 'HTML5 Media Plug-In',
				author: 'CJBoCo (Based on the "media" plug-in by Moxiecode Systems AB)',
				authorurl: 'http://www.cjboco.com/',
				infourl: 'http://www.cjboco.com/projects.cfm/project/tinymce-html5-media-plug-in/',
				version: '0.1'
			};
		}
	});
	// Register plugin
	tinymce.PluginManager.add('mediahtml5', tinymce.plugins.MediaHtml5Plugin);
})();