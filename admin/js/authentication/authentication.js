function loadSpinner(type){
	
	switch(type){
	
	case 'add_offer':
		
		var offer_name = document.getElementById('offer-name').value;

		if(offer_name > 0){
			$('#auth').css('opacity', '9');
			$('#load').css('opacity', '9');
			$('#add_offer').css('opacity', 0);
			$('#reset_offer').css('opacity', '0');
		}
	break;


	case 'add_group':
		var gname = document.getElementById('gname').value;
		var permission = document.getElementById('permission').value;

		if(gname.length > 0 && permission.length > 0){
			$('#auth').css('opacity', '9');
			$('#load').css('opacity', '9');
			$('#add_group').css('opacity', '0');
			$('#reset_group').css('opacity', '0');
		}
	break;
			
	case 'delete_group':
		$('#auth').css('opacity', '9');
		$('#load').css('opacity', '9');
		$('#delete_group').css('opacity', '0');	
	break;	


	case 'delete_group_member':
		$('#auth').css('opacity', '9');
		$('#load').css('opacity', '9');
		$('#delete').css('opacity', '0');
	break;

	
	case 'add_group_member':
		$('#add_auth').css('opacity', '9');
		$('add_load').css('opacity', '9');
		$('#send').css('opacity', 0);
		$('#wr').css('display', 'none');
	break;

	case 'add_user':
		
		var name = document.getElementById('name').value;

		if(name.length > 0){
			$('#auth').css('opacity', '9');
			$('#load').css('opacity', '9');
			$('#send').css('opacity', '0');
			$('#reset').css('opacity', '0');
		}
	break;
	
	case 'edit_user':
		
		var username = document.getElementById('username').value;
		var password = document.getElementById('password').value;
		var active = document.getElementById('active').value;
		
		if(username.length > 0 && password.length > 0 && active.length > 0){
			$('#auth').css('opacity', '9');
			$('#load').css('opacity', '9');
			$('#send').css('opacity', '0');
		}
	break;

	case 'delete_user':
		
		$('#dauth').css('opacity', '9');
		$('#dload').css('opacity', '9');
		$('#dsend').css('opacity', 0);
	break;


	case 'add_absent':
		
		var add_reason = document.getElementById('add_reason').value;
		var start = document.getElementById('start').value;
		var end = document.getElementById('end').value;

		if(add_reason.length > 0 && start.length > 0 && end.length > 0){
			$('#add_auth').css('opacity', '9');
			$('#add_load').css('opacity', '9');
			$('#add').css('opacity', '0');
		}
	break;

	case 'edit_absent':
	
		var edit_reason = document.getElementById('edit_reason').value;
		var edit_start = document.getElementById('estart').value;
		var edit_end = document.getElementById('eend').value;
	
		if(edit_reason.length > 0 && edit_start.length > 0 && edit_end.length > 0){
	
			$('#edit_auth').css('opacity', '1');
			$('#edit_load').css('opacity', '1');
			$('#edit').css('opacity', '0');
		}
	break;

	case 'delete_absent':
	
		$('#delete_auth').css('opacity', '9');
		$('#delete_load').css('opacity', '9');
		$('#delete').css('opacity', '0');
	break;


	case 'a_offer':
		
		var offername = document.getElementById('offer-name').value;
		var payout = document.getElementById('payout').value;
		var currency = document.getElementById('currency').value;
		var type = document.getElementById('type').value;
		var network = document.getElementById('network').value;
		var categories = document.getElementById('categories').value;
		var device = document.getElementById('device').value;
		var os = document.getElementById('os').value;
		
		if(offername.length > 0 && payout.length > 0 && currency.length > 0 && type.length > 0 && network.length > 0 && categories.length > 0 && 			device.length > 0 && os.length > 0){
		$('#auth').css('opacity', '9');
		$('#load').css('opacity', '9');
		$('#submit').css('opacity', '0');
		$('#resetoffer').css('opacity', '0');
		}

		break;

	case 'add-lander':

		var lander = document.getElementById('lander').value;
		var url	 = document.getElementById('url').value;
		
		if(lander.length > 0 && url.length > 0){
		$('#auth').css('opacity', '9');
		$('#load').css('opacity', '9');
		$('#sub_lander').css('opacity', '0');
		$('#add-lander').css('opacity', '0');
		}
	break;


	case 'add-camp':
		
		var rotation_name = document.getElementById('rotation_name').value;
		var rule_name = document.getElementById('rule_name').value;
		var camp_name = document.getElementById('camp_name').value;
		var camp_type = document.getElementById('camp_type').value;
		var camp_source = document.getElementById('camp_source').value;
		var camp_cost = document.getElementById('camp_cost').value;
		var cost_model = document.getElementById('cost_model').value;


		if(rotation_name.length > 0 && rule_name.length > 0 && camp_name.length > 0 && camp_type.length > 0 && camp_source.length > 0 && 				camp_cost.length > 0 && cost_model.length > 0){
		$('#c_auth').css('opacity', '9');
		$('#c_load').css('opacity', '9');
		$('#add_campaign').css('opacity', 0);	
		}
	break;



	case 'edit_offer':
		var offerid = document.getElementById('offer-id').value;
		var offername = document.getElementById('offer-name').value;
		var payout = document.getElementById('payout').value;
		var currency = document.getElementById('currency').value;
		var type = document.getElementById('type').value;
		var network = document.getElementById('network').value;
		var categories = document.getElementById('categories').value;
		var device = document.getElementById('device').value;
		var os = document.getElementById('os').value;
		var olid = document.getElementById('offer-link-id').value;
		var olname = document.getElementById('offer-link-name').value;
		var olcountries = document.getElementById('offer-link-countries').value;
		var olpayout = document.getElementById('offer-link-payout').value;
		var olurl = document.getElementById('offer-link-url').value;
	
	
		if(offerid.length > 0 && offername.length > 0 && payout.length > 0 && currency.length > 0 && type.length > 0 &&
			network.length > 0 && categories.length > 0 && device.length > 0 && os.length > 0 && olid.length > 0 &&
			olname.length > 0 && olcountries.length > 0 && olpayout.length > 0 && olurl.length > 0)
			{
		
			$('#oload').css('opacity', '9');
			$('#oauth').css('opacity', '9');
			$('#eoffer').css('opacity', '0');
	
		}
	break;


	case 'add_holiday':
		var hname = document.getElementById('hname').value;
		var holidate = document.getElementById('holidate').value;

		if(hname.length > 0 && holidate.length > 0){
			
			$('#hol_load').css('opacity', '1');
			$('#hol_auth').css('opacity', '1');
			$('#add').css('opacity', '0');	
			}
	
	break;

	case 'edit_holiday':
		var e_hname = document.getElementById('e_hname').value;
		var e_holidate = document.getElementById('e_holidate').value;

		if(e_holidate.length > 0 && e_hname.length > 0)
		{
			$('#ehol_load').css('opacity', '1');
			$('#ehol_auth').css('opacity', '1');
			$('#edit').css('opacity', '0');	
			}
	break;


	case 'delete_holiday':

		$('#dhol_load').css('opacity', '1');
		$('#dhol_auth').css('opacity', '1');
		$('#delete').css('opacity', '0');
	break;

	case 'add_applicant':

		$('#add_load').css('opacity', '1');
		$('#add_auth').css('opacity', '1');
		$('#add').css('opacity', '0');
	break;


	case 'edit_applicant':

		$('#edit_load').css('opacity', '1');
		$('#edit_auth').css('opacity', '1');
		$('#edit').css('opacity', '0');
	break;


	case 'move_active':

		$('#movea_load').css('opacity', '1');
		$('#movea_auth').css('opacity', '1');
		$('#movea').css('opacity', '0');
	break;

	case 'move_interview':

		$('#movei_load').css('opacity', '1');
		$('#movei_auth').css('opacity', '1');
		$('#movie').css('opacity', '0');
	break;

	case 'delete_applicant':

		$('#delete_load').css('opacity', '1');
		$('#delete_auth').css('opacity', '1');
		$('#delete').css('opacity', '0');
	break;

	case 'hire_applicant':

		$('#hire_load').css('opacity', '1');
		$('#hire_auth').css('opacity', '1');
		$('#hire').css('opacity', '0');
	break;

	case 'edit_note':

		$('#note_load').css('opacity', '1');
		$('#note_auth').css('opacity', '1');
		$('#senote').css('opacity', '0');
	break;

	case 'add_cutoff':

		$('#add_load').css('opacity', '1');
		$('#add_auth').css('opacity', '1');
		$('#add').css('opacity', '0');

	break;


	case 'edit_cutoff':
		$('#edit_load').css('opacity', '1');
		$('#edit_auth').css('opacity', '1');
		$('#edit').css('opacity', '0');
	break;


	case 'delete_cutoff':
		$('#del_load').css('opacity', '1');
		$('#del_auth').css('opacity', '1');
		$('#delete_cutoff').css('opacity', '0');

	break;

	case 'add_leave':
		$('#add_load').css('opacity', '1');
		$('#add_auth').css('opacity', '1');
		$('#add').css('opacity', '0');

	break;

	case 'edit_leave':

		$('#edit_load').css('opacity', '1');
		$('#edit_auth').css('opacity', '1');
		$('#edit').css('opacity', '0');
	
	break;

	case 'del_leave':

		$('#delete_load').css('opacity', '1');
		$('#delete_auth').css('opacity', '1');
		$('#delete').css('opacity', '0');

	break;

        case 'load_spinner':


            $('#spinner_load').css('opacity', '1');
            $('#auth_load').css('opacity', '1');
            $('btn-approve').css('opacity', '0');
            $('btn-decline').css('opacity', '0');

            break;

	case 'add_disaction':
	
	    $('#load').css('opacity', '1');
	    $('#auth').css('opacity', '1');
	    $('#add').css('opacity', '0');

	    break;











		}
}