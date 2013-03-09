function showBarcode(url) {
	document.body.innerHTML += '<a id="barcode-block" href="javascript:hideBarcode()"></a>';
	var barcodeBlock = document.getElementById('barcode-block');
	var imageHorizontalMargin = 50;
	var imageVerticalMargin = 50;
	var imageWidth = window.innerWidth - (2 * imageHorizontalMargin);
	var imageHeight = window.innerHeight - (2 * imageVerticalMargin);
	if (imageWidth < imageHeight) {
		imageHeight = imageWidth;
		imageVerticalMargin = (window.innerHeight - imageHeight) / 2;
	} else {
		imageWidth = imageHeight;
		imageHorizontalMargin = (window.innerWidth - imageWidth) / 2;
	}
	barcodeBlock.innerHTML = '<div class="loading" style="margin-left: ' + imageHorizontalMargin + 'px; margin-top: ' + imageVerticalMargin + 'px; width: '+ imageWidth +'px; height: '+ imageHeight +'px;"></div>';
	barcodeBlock.innerHTML += '<img src="http://qrcode.kaywa.com/img.php?s=8&d=' + escape(url) + '" style="margin-left: ' + imageHorizontalMargin + 'px; margin-top: ' + imageVerticalMargin + 'px; width: '+ imageWidth +'px;"></img>';
}


function hideBarcode() {
	var barcodeBlock = document.getElementById('barcode-block');
	barcodeBlock.parentNode.removeChild(barcodeBlock);
}
