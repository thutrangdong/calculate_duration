$(document).ready(function() {
	configure_datepicker();

	function configure_datepicker(){
		$( "#datepicker" ).datepicker({
			maxDate: '0',
			dateFormat: "MM d yy",
			onSelect: function(dateText, inst) {
				var dateArr = dateText.split(' ')
				var suffix = "";

				switch(inst.selectedDay) {
					case '1': case '21': case '31': suffix = 'st'; break;
					case '2': case '22': suffix = 'nd'; break;
					case '3': case '23': suffix = 'rd'; break;
					default: suffix = 'th';
				}

				$("input[name=date]").val(dateArr[0] +' '+ dateArr[1] + suffix + ", " + dateArr[2]);

				$(".submit-button").click();
			}
		})


		$(".pick-another").click(function() {
			$("#datepicker").focus();
		});

		$("#datepicker").change(function() {
			$(".pick-another").html($("#datepicker").val());
		});
	}
});