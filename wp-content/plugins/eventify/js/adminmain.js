/*jquery based form editions*/

jQuery("document").ready(function()
			 {
			     
			     jQuery("input.em_repeats").click(function(e){
				 
				 if(jQuery('input.em_repeats:checked').val()=="yes")
				 {
				     jQuery(".repeat_event").show();
				 }
				 else
				 {
				     jQuery(".repeat_event").hide();
				 }
			     });
			 });

/*ajax calls*/

