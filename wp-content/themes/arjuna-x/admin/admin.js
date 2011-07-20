// JavaScript Document

function getRadioValue(o) {
	if(!o) return "";
	var rl = o.length;
	if(rl == undefined)
		if(o.checked) return o.value;
		else return "";
	for(var i = 0; i < rl; i++) {
		if(o[i].checked) return o[i].value;
	}
	return "";
}

function headerMenu1_tD(o) {
		var v = getRadioValue(o);
		if(v=='pages') {
			document.getElementById('menus_1_sortBy_categories').style.display = 'none';
			document.getElementById('menus_1_sortBy_pages').style.display = 'block';
			document.getElementById('menus_1_include_categories').style.display = 'none';
			document.getElementById('menus_1_include_pages').style.display = '';
		} else if(v=='categories') {
			document.getElementById('menus_1_sortBy_categories').style.display = 'block';
			document.getElementById('menus_1_sortBy_pages').style.display = 'none';
			document.getElementById('menus_1_include_categories').style.display = '';
			document.getElementById('menus_1_include_pages').style.display = 'none';
		}
}
function headerMenu2_tD(o) {
		var v = getRadioValue(o);
		if(v=='pages') {
			document.getElementById('menus_2_sortBy_categories').style.display = 'none';
			document.getElementById('menus_2_sortBy_pages').style.display = 'block';
			document.getElementById('menus_2_include_categories').style.display = 'none';
			document.getElementById('menus_2_include_pages').style.display = '';
		} else if(v=='categories') {
			document.getElementById('menus_2_sortBy_categories').style.display = 'block';
			document.getElementById('menus_2_sortBy_pages').style.display = 'none';
			document.getElementById('menus_2_include_categories').style.display = '';
			document.getElementById('menus_2_include_pages').style.display = 'none';
		}
}

function customCSS_switch(o) {
	if (o.checked)
		document.getElementById('customCSS_input').style.display = 'block';
	else document.getElementById('customCSS_input').style.display = 'none';
}

function sidebar_twitterURL_switch(o) {
	if (o.checked)
		document.getElementById('sidebar_twitterURL').style.display = 'block';
	else document.getElementById('sidebar_twitterURL').style.display = 'none';
}

function sidebar_facebookURL_switch(o) {
	if (o.checked)
		document.getElementById('sidebar_facebookURL').style.display = 'block';
	else document.getElementById('sidebar_facebookURL').style.display = 'none';
}

function pagination_switch(o) {
		var v = getRadioValue(o);
		if(v=='1')
			document.getElementById('pagination_input').style.display = 'block';
		else if(v=='0')
			document.getElementById('pagination_input').style.display = 'none';
		
}

function enableIncludeMenuItems() {
	
	//First menu
	jQuery("#hm1ic_up").click(function() {
		jQuery("#hm1ec option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm1ic").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	jQuery("#hm1ic_down").click(function() {
		jQuery("#hm1ic option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm1ec").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	
	jQuery("#arjuna_update_theme").submit(function() {
		jQuery("#hm1ec option, #hm1ic option").attr('selected', 'selected');
	});

	jQuery("#hm1ip_up").click(function() {
		jQuery("#hm1ep option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm1ip").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	jQuery("#hm1ip_down").click(function() {
		jQuery("#hm1ip option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm1ep").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	
	jQuery("#arjuna_update_theme").submit(function() {
		jQuery("#hm1ep option, #hm1ip option").attr('selected', 'selected');
	});

	//Second menu
	jQuery("#hm2ic_up").click(function() {
		jQuery("#hm2ec option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm2ic").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	jQuery("#hm2ic_down").click(function() {
		jQuery("#hm2ic option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm2ec").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	
	jQuery("#arjuna_update_theme").submit(function() {
		jQuery("#hm2ec option, #hm2ic option").attr('selected', 'selected');
	});

	jQuery("#hm2ip_up").click(function() {
		jQuery("#hm2ep option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm2ip").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	jQuery("#hm2ip_down").click(function() {
		jQuery("#hm2ip option:selected").each(function() {
			var tmp = '<option value="'+jQuery(this).attr('value')+'">'+jQuery(this).html()+'</option>';
			jQuery("#hm2ep").append(tmp);
			jQuery(this).remove();
		});
		return false;
	});
	
	jQuery("#arjuna_update_theme").submit(function() {
		jQuery("#hm2ep option, #hm2ip option").attr('selected', 'selected');
	});
}

function ajax_savePanel(ID, set) {
	jQuery.ajax({
		type: "GET",
		url: jQuery('#arjuna_themeURL').val() + '/admin/ajax/savePanel.php',
		data: {
			ID: ID,
			set: set
		},
		dataType: 'json',
		success: function(response){
		}
	});
}

tmp_farbtastic = null;

arjuna_CWA = {
	contentWidth: 0,
	constraint: 920,
	sliderConstraint: 500,
	minContentArea: 460,
	maxContentArea: 805,
	minSidebar: 140,
	maxSidebar: 460,
	previewAvailWidth: 86,
	
	init: function() {
		this.setRealContentArea(jQuery('#real-content-area-width').val());
		
		this.moveSlider();
		this.enterCustom();
	},
	
	moveSlider: function() {
		jQuery('#content-area-handle').draggable({
			containment: "#content-area-slider",
			scroll: false,
			drag: function(e, ui) {
				if(jQuery('#content-area-width-slider').hasClass('right'))
					var addToCA = ui.position.left;
				else if(jQuery('#content-area-width-slider').hasClass('left'))
					var addToCA = 250 - Math.floor(arjuna_CWA.minSidebar * (arjuna_CWA.sliderConstraint / arjuna_CWA.constraint)) - ui.position.left;
				//calculate width for content area and sidebar
				//within the 500px slider
				var contentAreaTmp = 250 + addToCA;
				//var sidebarTmp = arjuna_CWA.sliderConstraint - contentAreaTmp;
				
				var contentArea = Math.floor(contentAreaTmp * (arjuna_CWA.constraint / arjuna_CWA.sliderConstraint));
				var sidebar = arjuna_CWA.constraint - contentArea;
				
				arjuna_CWA.contentWidth = contentArea;
				
				jQuery('#content-area-width').val(contentArea);
				jQuery('#sidebar-width').val(sidebar);
				
				arjuna_CWA.adjustPreview(contentArea);
				arjuna_CWA.setHidden(contentArea);
			}
		});
	},
	
	enterCustom: function() {
		jQuery('#content-area-width').change(function() {
			if(jQuery(this).val() < arjuna_CWA.minContentArea)
				jQuery(this).val(arjuna_CWA.minContentArea);
			else if(jQuery(this).val() > arjuna_CWA.maxContentArea)
				jQuery(this).val(arjuna_CWA.maxContentArea);
			
			jQuery('#sidebar-width').val(arjuna_CWA.constraint - jQuery(this).val());
			
			var contentArea = jQuery(this).val();
			
			arjuna_CWA.setSlider(contentArea);
			arjuna_CWA.adjustPreview(contentArea);
			arjuna_CWA.setHidden(contentArea);
		}).keydown(function(e) {
			if (e.keyCode == 13) {
				jQuery(this).blur().change();
				//e.preventDefault();
				//e.stopPropagation();
				return false;
			}
		});
		jQuery('#sidebar-width').change(function() {
			if(jQuery(this).val() < arjuna_CWA.minSidebar)
				jQuery(this).val(arjuna_CWA.minSidebar);
			else if(jQuery(this).val() > arjuna_CWA.maxSidebar)
				jQuery(this).val(arjuna_CWA.maxSidebar);
			
			jQuery('#content-area-width').val(arjuna_CWA.constraint - jQuery(this).val());
			
			var contentArea = jQuery('#content-area-width').val();
			
			arjuna_CWA.setSlider(contentArea);
			arjuna_CWA.adjustPreview(contentArea);
			arjuna_CWA.setHidden(contentArea);
		}).keydown(function(e) {
			if (e.keyCode == 13) {
				jQuery(this).blur().change();
				//e.preventDefault();
				//e.stopPropagation();
				return false;
			}
		});
	},
	
	setRealContentArea: function(realContentArea) {
		this.setSlider(realContentArea);
		this.updateCustom(realContentArea);
		this.adjustPreview(realContentArea);
		this.setHidden(realContentArea);
	},
	
	setSlider: function(contentArea) {
		if(jQuery('#content-area-width-slider').hasClass('right'))
			var left = Math.floor(contentArea * (arjuna_CWA.sliderConstraint / arjuna_CWA.constraint)) - 250;
		else if(jQuery('#content-area-width-slider').hasClass('left'))
			var left = 500 - Math.floor(arjuna_CWA.minSidebar * (arjuna_CWA.sliderConstraint / arjuna_CWA.constraint)) - Math.floor(contentArea * (arjuna_CWA.sliderConstraint / arjuna_CWA.constraint));
		
		jQuery('#content-area-handle').css('left', left);
	},
	
	updateCustom: function(contentArea) {
		jQuery('#content-area-width').val(contentArea);
		jQuery('#sidebar-width').val(arjuna_CWA.constraint - contentArea);
	},
	
	calcRealWidth: function(contentAreaTmp) {
		arjuna_CWA.contentWidth = Math.floor(contentAreaTmp * (arjuna_CWA.constraint / arjuna_CWA.sliderConstraint));
		//var sidebar = arjuna_CWA.constraint - contentArea;
	},
	
	adjustPreview: function(realContentArea) {
		var contentArea = Math.floor(realContentArea * (arjuna_CWA.previewAvailWidth / arjuna_CWA.constraint));
		var sidebar = arjuna_CWA.previewAvailWidth - contentArea;
		jQuery('#preview-content-area').css('width', contentArea);
		jQuery('#preview-sidebar').css('width', sidebar);
	},
	
	setHidden: function(realContentArea) {
		jQuery('#real-content-area-width').val(realContentArea);
	}
};

arjuna_SB = {
	init: function() {
		jQuery('#sidebar-buttons .checkbox').click(function() {
			var s = jQuery(this).closest('tr');
			if(jQuery(this).is(':checked'))
				s.removeClass("disabled");
			else s.addClass("disabled");
		});
		
		jQuery('#sidebar-buttons input[type=text]').focus(function() {
			jQuery(this).closest('tr').removeClass("disabled");
			jQuery(this).closest('tr').find('.checkbox').attr('checked', 'checked');
		});
		
		jQuery('#sidebar-buttons input.URL[type=text]').blur(function() {
			if(jQuery(this).val() == '') {
				jQuery(this).closest('tr').addClass("disabled");
				jQuery(this).closest('tr').find('.checkbox').attr('checked', '');
			}
		});
	}
};

jQuery(function() {
	jQuery('.srsContainer h4.title')
	.click(function() {
		if(jQuery(this).parent().hasClass('srsContainerClosed')) {
			jQuery(this).parent().removeClass('srsContainerClosed');
			ajax_savePanel(jQuery(this).parent().attr('self:ID'), 1);
		} else {
			jQuery(this).parent().addClass('srsContainerClosed');
			ajax_savePanel(jQuery(this).parent().attr('self:ID'), 0);
		}
	})
	.mouseover(function() { jQuery(this).addClass('over'); })
	.mouseout(function() { jQuery(this).removeClass('over'); });
	
	enableIncludeMenuItems();
	
	if(jQuery('#backgroundColor_picker').length > 0) {
		tmp_farbtastic = jQuery.farbtastic('#backgroundColor_picker div.inner', function(color) {
			jQuery('#backgroundColor').val(color);
			jQuery('#backgroundColor_picker').css('background-color', color);
			//jQuery('#backgroundColor_picker div.inner').fadeOut(500);
		}).setColor(jQuery('#backgroundColor').val());
		
		jQuery('#backgroundColor_picker').click(function(e) {
			jQuery('div.inner', this).fadeIn(500);
			jQuery('#backgroundStyle_solid').attr('checked', 'checked');
			e.stopPropagation();
			return false;
		});
		
		jQuery("#backgroundColor_picker div.inner").click(function(e) {
			e.stopPropagation();
			return false;
		});
		jQuery("body").click(function() {
			jQuery('#backgroundColor_picker div.inner').fadeOut(500);
		});
	}
	
	arjuna_CWA.init();
	arjuna_SB.init();
	
	jQuery('#sidebarDisplay_right').click(function() {
		jQuery('#content-area-width-slider').addClass('right').removeClass('left none');
		arjuna_CWA.setRealContentArea(670);
		jQuery('#sidebar-width-panel').show();
	});
	jQuery('#sidebarDisplay_left').click(function() {
		jQuery('#content-area-width-slider').addClass('left').removeClass('right none');
		arjuna_CWA.setRealContentArea(670);
		jQuery('#sidebar-width-panel').show();
	});
	jQuery('#sidebarDisplay_none').click(function() {
		jQuery('#sidebar-width-panel').hide();
		jQuery('#content-area-width-slider').removeClass('left right none');
	});
	
	jQuery('#menus-1-useNavMenus input[name=menus_1_useNavMenus]').change(function() {
		if(jQuery('#menus-1-useNavMenus input[name=menus_1_useNavMenus]:checked').val() == '0')
			jQuery('#menus-1-useNavMenus-legacy').show();
		else jQuery('#menus-1-useNavMenus-legacy').hide();
	});
	
	jQuery('#menus-2-useNavMenus input[name=menus_2_useNavMenus]').change(function() {
		if(jQuery('#menus-2-useNavMenus input[name=menus_2_useNavMenus]:checked').val() == '0')
			jQuery('#menus-2-useNavMenus-legacy').show();
		else jQuery('#menus-2-useNavMenus-legacy').hide();
	});
	
	jQuery('#useFeedburner input[name=useFeedburner]').change(function() {
		if(jQuery('#useFeedburner input[name=useFeedburner]:checked').val() == '1')
			jQuery('#useFeedburner-feedburner').show();
		else jQuery('#useFeedburner-feedburner').hide();
	});
	
	jQuery('#search-enabled').click(function() {
		if(jQuery(this).is(':checked'))
			jQuery('#search-enabled-container').show();
		else jQuery('#search-enabled-container').hide();
	});
	
	jQuery('#enableTwitter input[name=twitterWidget_enabled]').change(function() {
		if(jQuery('#enableTwitter input[name=twitterWidget_enabled]:checked').val() == '1')
			jQuery('#enableTwitter-options').show();
		else jQuery('#enableTwitter-options').hide();
	});
	
	jQuery('#sidebarButtons_RSS_extended').click(function() {
		if(jQuery(this).is(':checked'))
			jQuery('#sidebar-buttons tr.rss').addClass('rss-extended');
		else jQuery('#sidebar-buttons tr.rss').removeClass('rss-extended');
	});
	
	jQuery('#copyright-owner')
	.focus(function() {
		jQuery('#copyright-owner-box input[name=coprightOwnerType][value=custom]').attr('checked', true);
	})
	.blur(function() {
		if(jQuery(this).val() == "")
			jQuery('#copyright-owner-box input[name=coprightOwnerType][value=default]').attr('checked', true);
	});
	
	_colorSchemes = [
		'lightBlue',
		'darkBlue',
		'khaki',
		'seaGreen',
		'lightRed',
		'purple',
		'lightGray',
		'darkGray',
		'regimentalBlue',
		'bristolBlue'
	];
	
	for(var i=0; i<_colorSchemes.length; i++) {
		var color = _colorSchemes[i];
		jQuery('#icon-'+color)
		.attr('color', color)
		.click(function() {
			var color = jQuery(this).attr('color');
			jQuery('#headerImage_'+color).attr('checked', 'checked').change();
		});
		jQuery('#headerImage_'+color)
		.attr('color', color)
		.change(function() {
			var color = jQuery(this).attr('color');
			jQuery('#icon-footerStyle2').removeClass(_colorSchemes.join(' ')).addClass(color);
		});
	}
	
	jQuery('#icon-footerStyle1').click(function() {
		jQuery('#footerStyle_style1').attr('checked', 'checked').change();
	});
	jQuery('#icon-footerStyle2').click(function() {
		jQuery('#footerStyle_style2').attr('checked', 'checked').change();
	});
});
