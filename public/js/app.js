const $ = {
	qS: e => document.querySelector(e),
	qA: e => document.querySelectorAll(e)
};

document.onload = function()
{
	$.noConflict();
};