/**
* quote.js
*
**/






function init() {
	SXE.initElementDialog('blockquote');
	if (SXE.currentAction == "update") {
		SXE.showRemoveButton();
	}
}

function insertBlockquote() {
	SXE.insertElement('blockquote');
	tinyMCEPopup.close();
}

function removeBlockquote() {
	SXE.removeElement('blockquote');
	tinyMCEPopup.close();
}

tinyMCEPopup.onInit.add(init);
