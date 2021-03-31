//----------------------------------------------------------------------
// BASIC innerHTML Swap used to replace text
	function swapTextInElemID(sText, theID) 
	{
		var swapObj = document.getElementById(theID);
		if (swapObj != null)
			swapObj.innerHTML = sText;
	}
//----------------------------------------------------------------------
// Open a pop-up window
function OpenWin()
{
	// Set default values
	var winName = "newWin";
	var intHt = 500;
	var intWd = 500;
	var intXPos = -1;
	var intYpos = -1;

	var bTool = 'no';
	var	bLoc = 'no';
	var bStatus = 'no';
	var bMenu = 'no';
	var bScroll = 'yes';
	var bResize = 'yes';
	var bHist = 'no';
	
	var strProp = "";  // Properties of the opened window
	
	// If there are no arguaments passed to the function then use the above defaults.
	
	if (OpenWin.arguments[0]){
		var url = OpenWin.arguments[0];
	
		if (OpenWin.arguments[1])
			winName = OpenWin.arguments[1];
		
		if (OpenWin.arguments[2])
			intHt = OpenWin.arguments[2];
	
		if (OpenWin.arguments[3])
			intWd = OpenWin.arguments[3];
			
		if (OpenWin.arguments[4])
			intXPos = OpenWin.arguments[4];
			
		if (OpenWin.arguments[5])
			intYpos = OpenWin.arguments[5];
			
		if (OpenWin.arguments[6])
			bTool = OpenWin.arguments[6];
			
		if (OpenWin.arguments[7])
			bLoc = OpenWin.arguments[7];
			
		if (OpenWin.arguments[8])
			bStatus = OpenWin.arguments[8];
			
		if (OpenWin.arguments[9])
			bMenu = OpenWin.arguments[9];
			
		if (OpenWin.arguments[10])
			bScroll = OpenWin.arguments[10];
			
		if (OpenWin.arguments[11])
			bResize = OpenWin.arguments[11];
			
		if (OpenWin.arguments[12])
			bHist = OpenWin.arguments[12];
			
		if (intXPos < 1 ) 
			intXPos = window.screenLeft + 10;

		if (intYpos < 1) 
			intYpos = window.screenTop - 20;		
		strProp = '';
		strProp	= strProp + "toolbar=" + bTool + ",location=" + bLoc + ",status=" + bStatus + ",menubar=" + bMenu + ","
		strProp	= strProp + "scrollbars=" + bScroll + ",resizable=" + bResize + ",copyhistory=" + bHist + ",";
		strProp	= strProp + "width=" + intWd + ",height=" + intHt + ",left=" + intXPos + ",top=" + intYpos + "";

		popupWin = window.open(url, winName,strProp);
	}
	else
	{
		alert("Please provide the URL.")
	}
}
//---------------------------- End Window Open Template ---------------------------- //

function InfoWin(url)
{
	OpenWin(url, "infoWin",600,500,10,20);
}
