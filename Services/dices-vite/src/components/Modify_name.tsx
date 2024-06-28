import '../styles.css'
import React from 'react';

import * as Constants from '../constants.tsx';
import * as Functions from '../dices.tsx';


interface IProps {
	props?: any;
}

interface IState {
	jsonData?: any[];
	dataItems?: any[];
}
export default class ModifyName extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);

		this.handleSubmitModifyName = this.handleSubmitModifyName.bind(this);
		this.modifyName = this.modifyName.bind(this);
	}
  
 
	handleSubmitModifyName(event: any) {
		event.preventDefault();
		this.modifyName(event);
	}
  
	async modifyNameApiCall(event: any){

		var token = Functions.getCookie('token');
		var user_id = Functions.getCookie('userid');
		var modifyNameURI:string = '/api/players/' + user_id ;
		var modifyNameEndPoint:string = Constants.dices_URL + modifyNameURI;
		
		var name:string = event.target.name.value;
		var password:string = event.target.password.value;
		
		const response = await fetch( modifyNameEndPoint, {
			method: 'PUT',
			//mode: "no-cors", //Change the mode to cors
			body: JSON.stringify({
				name: name,
				password: password
			}),
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token,
			}
			
		});
		
		return response;
	}
  
  
  
	async modifyName(event: any){
		const response = await this.modifyNameApiCall(event);
		if(response.ok){
			Functions.setCookie('userName', event.target.name.value , 90);
			alert("Your name has been correclty modified");
		}else{
			alert("It was not possible to modify your name. The new name is either taken or the password was wrong");
		}
	}
  
	render(){
		return (
			<div className="main_container">
				<div className="form_section">
					<h3>
						Modify your name:
					</h3>
					<form id="login_form" className="form_user" onSubmit={this.handleSubmitModifyName} >
						
						<label htmlFor="email">
							New Name
						</label>
						<input type="text" name="name" required />
						<label htmlFor="password">
							Password
						</label>
						<input type="password" name="password" required />
						
						<input type="submit"  className="submitBttn" value="Submit" />
					
					</form>			
				</div>

			</div>
		)
	}
}

//export default Login
