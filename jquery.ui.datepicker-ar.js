/* Arabic Translation for jQuery UI date picker plugin for Egypt, Sudan, Kuwait, KSA, Qatar, UAE, Bahrain, Oman and Yemen */
/* Adnan Yawar -- adnanmn@gmail.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name فبراير - يناير and there isn't any Arabic roots for these months */
jQuery(function($){
	$.datepicker.regional['ar'] = {
		closeText: 'إغلاق',
		prevText: '&#x3c;السابق',
		nextText: 'التالي&#x3e;',
		currentText: 'اليوم',
		monthNames: ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو',
		'يوليو', 'أغسطس', 'سبتمبر',	'أكتوبر', 'نوفمبر', 'ديسمبر'],
		monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
		dayNames: ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
		dayNamesShort: ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
		dayNamesMin: ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
		weekHeader: 'أسبوع',
		dateFormat: 'yy-mm-dd',
		firstDay: 7,
  		isRTL: true,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ar']);
});