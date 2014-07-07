// Used keywords
var keyword_hash = {};

page_metadata_remove = function(keyword_css_id, keyword) {
  // Hide the row with the data
  $(keyword_css_id).fadeOut();
  // Clear value, backend will remove the keyword with empty values
  $(keyword_css_id+'-field').attr('value', '2');
  // Remove from the keyword hash, so that the keyword can be added again
  delete(keyword_hash[keyword]);
}

page_metadata_add = function(_url, i18n_keyword, i18n_value) {
  keyword = $('#Page-metadata-new-keyword').val();
  value = $('#Page-metadata-new-value').val();
  
  // Keyword empty or already used?
  // NOTE: empty values don't care
  if (keyword == '' || keyword_hash[keyword]) {
    $('#Page-metadata-new-popup-error').show();
    return false;
  }

  $.post(_url, { "keyword": keyword, "value": value }, function(data){
              $('#Page-metadata-container').append(data);
   });

  // Add keyword to hash
  keyword_hash[keyword] = true;

  // Hide form
  $('#Page-metadata-new-popup').hide();
  $('#Page-metadata-new-popup-error').hide();

  // Set back to default values
  $('#Page-metadata-new-keyword').val(i18n_keyword);
  $('#Page-metadata-new-value').val(i18n_value);
};


(function($) {
  // Document load
  $(function() {
    // Build an hash with the (existing) keywords to avoid duplicate entries
    $('#Page-metadata-container label').each(function() {
      keyword = ($(this).text());
      if (keyword) {
        keyword_hash[keyword] = true;
      }
    });
  });
})(jQuery);