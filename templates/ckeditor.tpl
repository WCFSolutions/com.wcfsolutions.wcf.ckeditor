<script type="text/javascript" src="{@RELATIVE_WCF_DIR}js/3rdParty/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	//<![CDATA[
	document.observe('dom:loaded', function() {
		CKEDITOR.replace('{$htmlID|encodeJS}', {
			{implode from=$configOptions key=name item=value}{$name|encodeJS}: {$value}{/implode}
		});
	});
	//]]>
</script>