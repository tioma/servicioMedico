function VerificaConceptos ()
{
	if (document.form1.codigos.value == 0)
	{
		alert('Ingrese un codigo');
		document.form1.codigos.focus();
		return false;
	}
	if ((document.form1.AnoHasta.value *12 + document.form1.MesHasta.value *1 - document.form1.AnoDesde.value *12 - document.form1.MesDesde.value *1) < 0 || document.form1.AnoHasta.value == 0 || document.form1.MesHasta.value == 0 || document.form1.AnoDesde.value == 0 || document.form1.MesDesde.value == 0)
	{
		alert('Seleccione fechas válidas');
		return false;
	}
}

function VerificaListador ()
{
	if (document.form1.OptLegajo.value == 0)
	{
		alert('Seleccione Legajo');
		document.form1.OptLegajo.focus();
		return false;
	}
	else if ((document.form1.AnoHasta.value *12 + document.form1.MesHasta.value *1 - document.form1.AnoDesde.value *12 - document.form1.MesDesde.value *1) < 0 || document.form1.AnoHasta.value == 0 || document.form1.MesHasta.value == 0 || document.form1.AnoDesde.value == 0 || document.form1.MesDesde.value == 0)
	{
		alert('Seleccione fechas válidas');
		return false;
	}
	else
	{
		return true;
	}
}

function VerificaIndemniza ()
{
	if (document.form1.OptLegajo.value == 0)
	{
		alert('Seleccione Legajo');
		document.form1.OptLegajo.focus();
		return false;
	}
	else if ((document.form1.AnoHasta.value *12 + document.form1.MesHasta.value *1 - document.form1.AnoDesde.value *12 - document.form1.MesDesde.value *1) < 0 || document.form1.AnoHasta.value == 0 || document.form1.MesHasta.value == 0 || document.form1.AnoDesde.value == 0 || document.form1.MesDesde.value == 0)
	{
		alert('Seleccione fechas válidas');
		document.form1.AnoHasta.focus();
		return false;
	}	
	else if ((document.form1.AnoHasta.value *12 + document.form1.MesHasta.value *1 - document.form1.AnoDesde.value *12 - document.form1.MesDesde.value *1) > 13)
	{
		alert('La diferencia debe ser menor o igual a 1 año');
		document.form1.AnoHasta.focus();
		return false;
	}
	else
	{
		return true;
	}
}

function VerificaCertif ()
{
	if (document.form1.OptLegajo.value == 0)
	{
		alert('Seleccione Legajo');
		document.form1.OptLegajo.focus();
		return false;
	}
	else if ((document.form1.AnoHasta.value *12 + document.form1.MesHasta.value *1 - document.form1.AnoDesde.value *12 - document.form1.MesDesde.value *1) < 0 || document.form1.AnoHasta.value == 0 || document.form1.MesHasta.value == 0 || document.form1.AnoDesde.value == 0 || document.form1.MesDesde.value == 0)
	{
		alert('Seleccione fechas válidas');
		document.form1.MesDesde.focus();
		return false;
	}
	else if (document.form1.AnoHasta.value - document.form1.AnoDesde.value > 10)
	{
		alert('Seleccione un rango de hasta 10 años');
		document.form1.AnoHasta.focus();
		return false;
	}
	else
	{
		return true;
	}
}

function VerificaABMDomicilio ()
{
	if (document.form1.OptLegajo.value == 0)
	{
		alert('Seleccione Legajo');
		document.form1.OptLegajo.focus();
		return false;
	}
	else
	{
		return true;
	}
}

/* ********************************************************** */
/*

Copyright (c) 2009 Dimas Begunoff, http://www.farinspace.com

Licensed under the MIT license
http://en.wikipedia.org/wiki/MIT_License

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

*/

;(function($){

	var scrollbarWidth = 0;

	// http://jdsharp.us/jQuery/minute/calculate-scrollbar-width.php
	function getScrollbarWidth() 
	{
		if (scrollbarWidth) return scrollbarWidth;
		var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div></div>'); 
		$('body').append(div); 
		var w1 = $('div', div).innerWidth(); 
		div.css('overflow-y', 'auto'); 
		var w2 = $('div', div).innerWidth(); 
		$(div).remove(); 
		scrollbarWidth = (w1 - w2);
		return scrollbarWidth;
	}
	
	$.fn.tableScroll = function(options)
	{
		if (options == 'undo')
		{
			var container = $(this).parent().parent();
			if (container.hasClass('tablescroll_wrapper')) 
			{
				container.find('.tablescroll_head thead').prependTo(this);
				container.find('.tablescroll_foot tfoot').appendTo(this);
				container.before(this);
				container.empty();
			}
			return;
		}

		var settings = $.extend({},$.fn.tableScroll.defaults,options);
		
		// Bail out if there's no vertical overflow
		if ($(this).height() <= settings.height)
		{
		  return this;
		}

		settings.scrollbarWidth = getScrollbarWidth();

		this.each(function()
		{
			var flush = settings.flush;
			
			var tb = $(this).addClass('tablescroll_body');

			var wrapper = $('<div class="tablescroll_wrapper"></div>').insertBefore(tb).append(tb);

			// check for a predefined container
			if (!wrapper.parent('div').hasClass(settings.containerClass))
			{
				$('<div></div>').addClass(settings.containerClass).insertBefore(wrapper).append(wrapper);
			}

			var width = settings.width ? settings.width : tb.outerWidth();

			wrapper.css
			({
				'width': width+'px',
				'height': settings.height+'px',
				'overflow': 'auto'
			});

			tb.css('width',width+'px');

			// with border difference
			var wrapper_width = wrapper.outerWidth();
			var diff = wrapper_width-width;

			// assume table will scroll
			wrapper.css({width:((width-diff)+settings.scrollbarWidth)+'px'});
			tb.css('width',(width-diff)+'px');

			if (tb.outerHeight() <= settings.height)
			{
				wrapper.css({height:'auto',width:(width-diff)+'px'});
				flush = false;
			}

			// using wrap does not put wrapper in the DOM right 
			// away making it unavailable for use during runtime
			// tb.wrap(wrapper);

			// possible speed enhancements
			var has_thead = $('thead',tb).length ? true : false ;
			var has_tfoot = $('tfoot',tb).length ? true : false ;
			var thead_tr_first = $('thead tr:first',tb);
			var tbody_tr_first = $('tbody tr:first',tb);
			var tfoot_tr_first = $('tfoot tr:first',tb);

			// remember width of last cell
			var w = 0;

			$('th, td',thead_tr_first).each(function(i)
			{
				w = $(this).width();

				$('th:eq('+i+'), td:eq('+i+')',thead_tr_first).css('width',w+'px');
				$('th:eq('+i+'), td:eq('+i+')',tbody_tr_first).css('width',w+'px');
				if (has_tfoot) $('th:eq('+i+'), td:eq('+i+')',tfoot_tr_first).css('width',w+'px');
			});

			if (has_thead) 
			{
				var tbh = $('<table class="tablescroll_head" cellspacing="0"></table>').insertBefore(wrapper).prepend($('thead',tb));
			}

			if (has_tfoot) 
			{
				var tbf = $('<table class="tablescroll_foot" cellspacing="0"></table>').insertAfter(wrapper).prepend($('tfoot',tb));
			}

			if (tbh != undefined)
			{
				tbh.css('width',width+'px');
				
				if (flush)
				{
					$('tr:first th:last, tr:first td:last',tbh).css('width',(w+settings.scrollbarWidth)+'px');
					tbh.css('width',wrapper.outerWidth() + 'px');
				}
			}

			if (tbf != undefined)
			{
				tbf.css('width',width+'px');

				if (flush)
				{
					$('tr:first th:last, tr:first td:last',tbf).css('width',(w+settings.scrollbarWidth)+'px');
					tbf.css('width',wrapper.outerWidth() + 'px');
				}
			}
		});

		return this;
	};

	// public
	$.fn.tableScroll.defaults =
	{
		flush: true, // makes the last thead and tbody column flush with the scrollbar
		width: null, // width of the table (head, body and foot), null defaults to the tables natural width
		height: 100, // height of the scrollable area
		containerClass: 'tablescroll' // the plugin wraps the table in a div with this css class
	};

})(jQuery);

/* ********************************************************** */

var datePickerDivID = "datepicker";
var iFrameDivID = "datepickeriframe";

var dayArrayShort = new Array('Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa');
var dayArrayMed = new Array('Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab');
var dayArrayLong = new Array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
var monthArrayShort = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
var monthArrayMed = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
var monthArrayLong = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
 
// these variables define the date formatting we're expecting and outputting.
// If you want to use a different format by default, change the defaultDateSeparator
// and defaultDateFormat variables either here or on your HTML page.
var defaultDateSeparator = "/";        // common values would be "/" or "."
var defaultDateFormat = "mdy";    // valid values are "mdy", "dmy", and "ymd"
var dateSeparator = defaultDateSeparator;
var dateFormat = defaultDateFormat;

function displayDatePicker(dateFieldName, displayBelowThisObject, dtFormat, dtSep)
{
  var targetDateField = document.getElementsByName (dateFieldName).item(0);
 
  // if we weren't told what node to display the datepicker beneath, just display it
  // beneath the date field we're updating
  if (!displayBelowThisObject)
    displayBelowThisObject = targetDateField;
 
  // if a date separator character was given, update the dateSeparator variable
  if (dtSep)
    dateSeparator = dtSep;
  else
    dateSeparator = defaultDateSeparator;
 
  // if a date format was given, update the dateFormat variable
  if (dtFormat)
    dateFormat = dtFormat;
  else
    dateFormat = defaultDateFormat;
 
  var x = displayBelowThisObject.offsetLeft;
  var y = displayBelowThisObject.offsetTop + displayBelowThisObject.offsetHeight ;
 
  // deal with elements inside tables and such
  var parent = displayBelowThisObject;
  while (parent.offsetParent) {
    parent = parent.offsetParent;
    x += parent.offsetLeft;
    y += parent.offsetTop ;
  }
 
  drawDatePicker(targetDateField, x, y);
}
function drawDatePicker(targetDateField, x, y)
{
  var dt = getFieldDate(targetDateField.value );
 
  // the datepicker table will be drawn inside of a <div> with an ID defined by the
  // global datePickerDivID variable. If such a div doesn't yet exist on the HTML
  // document we're working with, add one.
  if (!document.getElementById(datePickerDivID)) {
    // don't use innerHTML to update the body, because it can cause global variables
    // that are currently pointing to objects on the page to have bad references
    //document.body.innerHTML += "<div id='" + datePickerDivID + "' class='dpDiv'></div>";
    var newNode = document.createElement("div");
    newNode.setAttribute("id", datePickerDivID);
    newNode.setAttribute("class", "dpDiv");
    newNode.setAttribute("style", "visibility: hidden;");
    document.body.appendChild(newNode);
  }
 
  // move the datepicker div to the proper x,y coordinate and toggle the visiblity
  var pickerDiv = document.getElementById(datePickerDivID);
  pickerDiv.style.position = "absolute";
  pickerDiv.style.left = x + "px";
  pickerDiv.style.top = y + "px";
  pickerDiv.style.visibility = (pickerDiv.style.visibility == "visible" ? "hidden" : "visible");
  pickerDiv.style.display = (pickerDiv.style.display == "block" ? "none" : "block");
  pickerDiv.style.zIndex = 10000;
 
  // draw the datepicker table
  refreshDatePicker(targetDateField.name, dt.getFullYear(), dt.getMonth(), dt.getDate());
}
/*
This is the function that actually draws the datepicker calendar.
*/
function refreshDatePicker(dateFieldName, year, month, day)
{
  // if no arguments are passed, use today's date; otherwise, month and year
  // are required (if a day is passed, it will be highlighted later)
  var thisDay = new Date();
 
  if ((month >= 0) && (year > 0)) {
    thisDay = new Date(year, month, 1);
  } else {
    day = thisDay.getDate();
    thisDay.setDate(1);
  }
 
  // the calendar will be drawn as a table
  // you can customize the table elements with a global CSS style sheet,
  // or by hardcoding style and formatting elements below
  var crlf = "\r\n";
  var TABLE = "<table cols=7 class='dpTable'>" + crlf;
  var xTABLE = "</table>" + crlf;
  var TR = "<tr class='dpTR'>";
  var TR_title = "<tr class='dpTitleTR'>";
  var TR_days = "<tr class='dpDayTR'>";
  var TR_todaybutton = "<tr class='dpTodayButtonTR'>";
  var xTR = "</tr>" + crlf;
  var TD = "<td class='dpTD' onMouseOut='this.className=\"dpTD\";' onMouseOver=' this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
  var TD_title = "<td colspan=5 class='dpTitleTD'>";
  var TD_buttons = "<td class='dpButtonTD'>";
  var TD_todaybutton = "<td colspan=7 class='dpTodayButtonTD'>";
  var TD_days = "<td class='dpDayTD'>";
  var TD_selected = "<td class='dpDayHighlightTD' onMouseOut='this.className=\"dpDayHighlightTD\";' onMouseOver='this.className=\"dpTDHover\";' ";    // leave this tag open, because we'll be adding an onClick event
  var xTD = "</td>" + crlf;
  var DIV_title = "<div class='dpTitleText'>";
  var DIV_selected = "<div class='dpDayHighlight'>";
  var xDIV = "</div>";
 
  // start generating the code for the calendar table
  var html = TABLE;
 
  // this is the title bar, which displays the month and the buttons to
  // go back to a previous month or forward to the next month
  html += TR_title;
  html += TD_buttons + getButtonCode(dateFieldName, thisDay, -1, "&lt;") + xTD;
  html += TD_title + DIV_title + monthArrayLong[ thisDay.getMonth()] + " " + thisDay.getFullYear() + xDIV + xTD;
  html += TD_buttons + getButtonCode(dateFieldName, thisDay, 1, "&gt;") + xTD;
  html += xTR;
 
  // this is the row that indicates which day of the week we're on
  html += TR_days;
  for(i = 0; i < dayArrayShort.length; i++)
    html += TD_days + dayArrayShort[i] + xTD;
  html += xTR;
 
  // now we'll start populating the table with days of the month
  html += TR;
 
  // first, the leading blanks
  for (i = 0; i < thisDay.getDay(); i++)
    html += TD + "&nbsp;" + xTD;
 
  // now, the days of the month
  do {
    dayNum = thisDay.getDate();
    TD_onclick = " onclick=\"updateDateField('" + dateFieldName + "', '" + getDateString(thisDay) + "');\">";
    
    if (dayNum == day)
      html += TD_selected + TD_onclick + DIV_selected + dayNum + xDIV + xTD;
    else
      html += TD + TD_onclick + dayNum + xTD;
    
    // if this is a Saturday, start a new row
    if (thisDay.getDay() == 6)
      html += xTR + TR;
    
    // increment the day
    thisDay.setDate(thisDay.getDate() + 1);
  } while (thisDay.getDate() > 1);
 
  // fill in any trailing blanks
  if (thisDay.getDay() > 0) {
    for (i = 6; i > thisDay.getDay(); i--)
      html += TD + "&nbsp;" + xTD;
  }
  html += xTR;
 
  // add a button to allow the user to easily return to today, or close the calendar
  var today = new Date();
  var todayString = "Today is " + dayArrayMed[today.getDay()] + ", " + monthArrayMed[ today.getMonth()] + " " + today.getDate();
  html += TR_todaybutton + TD_todaybutton;
  html += "<button class='dpTodayButton' onClick='refreshDatePicker(\"" + dateFieldName + "\");'>this month</button> ";
  html += "<button class='dpTodayButton' onClick='updateDateField(\"" + dateFieldName + "\");'>close</button>";
  html += xTD + xTR;
 
  // and finally, close the table
  html += xTABLE;
 
  document.getElementById(datePickerDivID).innerHTML = html;
  // add an "iFrame shim" to allow the datepicker to display above selection lists
  adjustiFrame();
}
/*
Convenience function for writing the code for the buttons that bring us back or forward
a month.
*/
function getButtonCode(dateFieldName, dateVal, adjust, label)
{
  var newMonth = (dateVal.getMonth () + adjust) % 12;
  var newYear = dateVal.getFullYear() + parseInt((dateVal.getMonth() + adjust) / 12);
  if (newMonth < 0) {
    newMonth += 12;
    newYear += -1;
  }
 
  return "<button class='dpButton' onClick='refreshDatePicker(\"" + dateFieldName + "\", " + newYear + ", " + newMonth + ");'>" + label + "</button>";
}


/*
Convert a JavaScript Date object to a string, based on the dateFormat and dateSeparator
variables at the beginning of this script library.
*/
function getDateString(dateVal)
{
  var dayString = "00" + dateVal.getDate();
  var monthString = "00" + (dateVal.getMonth()+1);
  dayString = dayString.substring(dayString.length - 2);
  monthString = monthString.substring(monthString.length - 2);
 
  switch (dateFormat) {
    case "dmy" :
      return dayString + dateSeparator + monthString + dateSeparator + dateVal.getFullYear();
    case "ymd" :
      return dateVal.getFullYear() + dateSeparator + monthString + dateSeparator + dayString;
    case "mdy" :
    default :
      return monthString + dateSeparator + dayString + dateSeparator + dateVal.getFullYear();
  }
}
/*
Convert a string to a JavaScript Date object.
*/
function getFieldDate(dateString)
{
  var dateVal;
  var dArray;
  var d, m, y;
 
  try {
    dArray = splitDateString(dateString);
    if (dArray) {
      switch (dateFormat) {
        case "dmy" :
          d = parseInt(dArray[0], 10);
          m = parseInt(dArray[1], 10) - 1;
          y = parseInt(dArray[2], 10);
          break;
        case "ymd" :
          d = parseInt(dArray[2], 10);
          m = parseInt(dArray[1], 10) - 1;
          y = parseInt(dArray[0], 10);
          break;
        case "mdy" :
        default :
          d = parseInt(dArray[1], 10);
          m = parseInt(dArray[0], 10) - 1;
          y = parseInt(dArray[2], 10);
          break;
      }
      dateVal = new Date(y, m, d);
    } else if (dateString) {
      dateVal = new Date(dateString);
    } else {
      dateVal = new Date();
    }
  } catch(e) {
    dateVal = new Date();
  }
 
  return dateVal;
}
/*
Try to split a date string into an array of elements, using common date separators.
If the date is split, an array is returned; otherwise, we just return false.
*/
function splitDateString(dateString)
{
  var dArray;
  if (dateString.indexOf("/") >= 0)
    dArray = dateString.split("/");
  else if (dateString.indexOf(".") >= 0)
    dArray = dateString.split(".");
  else if (dateString.indexOf("-") >= 0)
    dArray = dateString.split("-");
  else if (dateString.indexOf("\\") >= 0)
    dArray = dateString.split("\\");
  else
    dArray = false;
 
  return dArray;
}
function updateDateField(dateFieldName, dateString)
{
  var targetDateField = document.getElementsByName (dateFieldName).item(0);
  if (dateString)
    targetDateField.value = dateString;
 
  var pickerDiv = document.getElementById(datePickerDivID);
  pickerDiv.style.visibility = "hidden";
  pickerDiv.style.display = "none";
 
  adjustiFrame();
  targetDateField.focus();
 
  // after the datepicker has closed, optionally run a user-defined function called
  // datePickerClosed, passing the field that was just updated as a parameter
  // (note that this will only run if the user actually selected a date from the datepicker)
  if ((dateString) && (typeof(datePickerClosed) == "function"))
    datePickerClosed(targetDateField);
}
function adjustiFrame(pickerDiv, iFrameDiv)
{
  // we know that Opera doesn't like something about this, so if we
  // think we're using Opera, don't even try
  var is_opera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);
  if (is_opera)
    return;
  
  // put a try/catch block around the whole thing, just in case
  try {
    if (!document.getElementById(iFrameDivID)) {
      // don't use innerHTML to update the body, because it can cause global variables
      // that are currently pointing to objects on the page to have bad references
      //document.body.innerHTML += "<iframe id='" + iFrameDivID + "' src='javascript:false;' scrolling='no' frameborder='0'>";
      var newNode = document.createElement("iFrame");
      newNode.setAttribute("id", iFrameDivID);
      newNode.setAttribute("src", "javascript:false;");
      newNode.setAttribute("scrolling", "no");
      newNode.setAttribute ("frameborder", "0");
      document.body.appendChild(newNode);
    }
    
    if (!pickerDiv)
      pickerDiv = document.getElementById(datePickerDivID);
    if (!iFrameDiv)
      iFrameDiv = document.getElementById(iFrameDivID);
    
    try {
      iFrameDiv.style.position = "absolute";
      iFrameDiv.style.width = pickerDiv.offsetWidth;
      iFrameDiv.style.height = pickerDiv.offsetHeight ;
      iFrameDiv.style.top = pickerDiv.style.top;
      iFrameDiv.style.left = pickerDiv.style.left;
      iFrameDiv.style.zIndex = pickerDiv.style.zIndex - 1;
      iFrameDiv.style.visibility = pickerDiv.style.visibility ;
      iFrameDiv.style.display = pickerDiv.style.display;
    } catch(e) {
    }
 
  } catch (ee) {
  }
 
}

function BorrarTxtFecha (dateFieldName)
{
	if (document.getElementsByName (dateFieldName).item(0).value=="Desde" || document.getElementsByName (dateFieldName).item(0).value=="Hasta" || document.getElementsByName (dateFieldName).item(0).value=="Día"  || document.getElementsByName (dateFieldName).item(0).value=="D&iacute;a" || document.getElementsByName (dateFieldName).item(0).value=="Mes" || document.getElementsByName (dateFieldName).item(0).value=="Año"  || document.getElementsByName (dateFieldName).item(0).value=="A&ntilde;o" || document.getElementsByName (dateFieldName).item(0).value=="Caracter de Servicios")
	{
		document.getElementsByName (dateFieldName).item(0).value="";
	}
}

function oculta(id)
{
	if (id == "caracterservicios")
	{
		document.getElementById('csvm').style.display='';
		document.getElementById('cs2').style.display='none';
		document.getElementById('cs3').style.display='none';
		document.getElementById('cs4').style.display='none';
		document.getElementById('cso').style.display='none';
	}
	if (id == "interrupciones")
	{
		document.getElementById('ivm').style.display='';
		document.getElementById('i2').style.display='none';
		document.getElementById('i3').style.display='none';
		document.getElementById('i4').style.display='none';
		document.getElementById('i5').style.display='none';
		document.getElementById('io').style.display='none';
	}
	if (id == "privilegios")
	{
		document.getElementById('pvm').style.display='';
		document.getElementById('p2').style.display='none';
		document.getElementById('p3').style.display='none';
		document.getElementById('p4').style.display='none';
		document.getElementById('p5').style.display='none';
		document.getElementById('p6').style.display='none';
		document.getElementById('p7').style.display='none';
		document.getElementById('p8').style.display='none';
		document.getElementById('p9').style.display='none';
		document.getElementById('p10').style.display='none';
		document.getElementById('po').style.display='none';
	} 
}

function muestra(id)
{
	if (id == "caracterservicios")
	{
		document.getElementById('csvm').style.display='none';
		document.getElementById('cs2').style.display='';
		document.getElementById('cs3').style.display='';
		document.getElementById('cs4').style.display='';
		document.getElementById('cso').style.display='';
	}
	if (id == "interrupciones")
	{
		document.getElementById('ivm').style.display='none';
		document.getElementById('i2').style.display='';
		document.getElementById('i3').style.display='';
		document.getElementById('i4').style.display='';
		document.getElementById('i5').style.display='';
		document.getElementById('io').style.display='';
	}
	if (id == "privilegios")
	{
		document.getElementById('pvm').style.display='none';
		document.getElementById('p2').style.display='';
		document.getElementById('p3').style.display='';
		document.getElementById('p4').style.display='';
		document.getElementById('p5').style.display='';
		document.getElementById('p6').style.display='';
		document.getElementById('p7').style.display='';
		document.getElementById('p8').style.display='';
		document.getElementById('p9').style.display='';
		document.getElementById('p10').style.display='';
		document.getElementById('po').style.display='';
	}
}