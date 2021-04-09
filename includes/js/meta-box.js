jQuery( function ( $ ) {
	init_cpaymk_meta();
	$(".cpaymk_customize_cpaymk_donations_field input:radio").on("change", function() {
		init_cpaymk_meta();
	});

	function init_cpaymk_meta(){
		if ("enabled" === $(".cpaymk_customize_cpaymk_donations_field input:radio:checked").val()){
			$(".cpaymk_api_key_field").show();
			$(".cpaymk_collection_id_field").show();
			$(".cpaymk_x_signature_key_field").show();
			$(".cpaymk_description_field").show();
			$(".cpaymk_reference_1_label_field").show();
			$(".cpaymk_reference_1_field").show();
			$(".cpaymk_reference_2_label_field").show();
			$(".cpaymk_reference_2_field").show();
			$(".cpaymk_collect_billing_field").show();
		}
		else {
			$(".cpaymk_api_key_field").hide();
			$(".cpaymk_collection_id_field").hide();
			$(".cpaymk_x_signature_key_field").hide();
			$(".cpaymk_description_field").hide();
			$(".cpaymk_reference_1_label_field").hide();
			$(".cpaymk_reference_1_field").hide();
			$(".cpaymk_reference_2_label_field").hide();
			$(".cpaymk_reference_2_field").hide();
			$(".cpaymk_collect_billing_field").hide();
		}
	}
});
