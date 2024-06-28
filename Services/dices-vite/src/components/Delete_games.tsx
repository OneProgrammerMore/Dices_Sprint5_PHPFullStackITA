import '../styles.css'
import React from 'react';

import * as Constants from '../constants.tsx';
import * as Functions from '../dices.tsx';

export default class Delete extends React.Component{
  
	constructor(props: any) {
		super(props);

		this.handleSubmitDelete = this.handleSubmitDelete.bind(this);
		this.playerDelete = this.playerDelete.bind(this);
	}
  
  
	handleSubmitDelete(event: any) {
		event.preventDefault();
		this.playerDelete();
	}
	
	async playerDeleteApiCall(){
			
		//ToDo - Version 1 - Improve Cookies
		var token = Functions.getCookie('token');
		var user_id = Functions.getCookie('userid');
		var registerPlayerURI:string = '/api/players/' + user_id + '/games';
		var deletePlayerEndPoint:string = Constants.dices_URL + registerPlayerURI;
		
		const response = await fetch( deletePlayerEndPoint, {
			method: 'DELETE',
			//mode: "no-cors", //Change the mode to cors
			body: JSON.stringify({
			}),
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token,
			}
		});
		
		return response;
	}

	async playerDelete(){
	
		const response = await this.playerDeleteApiCall();
		
		if(!response.ok){
			alert('Something went wrong');
		}
	
	}
  
	render(){
		return (
			<div className="main_container">
				<div className="form_section">
					<h3>
					Delete all your games!
					</h3>
					<form id="login_form" className="form_user" onSubmit={this.handleSubmitDelete}>
						
						<input type="submit"  className="submitBttn" value="Submit" />
					
					</form>			
				</div>
			</div>
		)
	}
}

