var ion = ion || {};
$(function()
{
	$.ionTabs("#tabs_1", {type: "hash",onChange: function(obj){$("#result__2").text(JSON.stringify(obj, "", 4));}});
});

