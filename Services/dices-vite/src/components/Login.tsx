import '../styles.css'
import React from 'react';

import * as Constants from '../constants.tsx';
import * as Functions from '../dices.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx'



interface IProps {
	props?: any;
}

interface IState {
  jsonData?: any[];
  dataItems?: any[];
}
/*
interface ComponentLoginProps {
    variable: string;
    updateVariable: (newValue: string) => void;
}*/



export default class Login extends React.Component<IProps, IState>{
  
  
	constructor(props: any) {
		super(props);

		this.handleSubmitRegisterPlayer = this.handleSubmitRegisterPlayer.bind(this);
		this.registerPlayer = this.registerPlayer.bind(this);

		this.handleSubmitRegisterAdmin = this.handleSubmitRegisterAdmin.bind(this);
		this.registerAdmin = this.registerAdmin.bind(this);

		this.handleSubmitLogin = this.handleSubmitLogin.bind(this);
		this.login = this.login.bind(this);
	}
  
	static contextType = MyContext;
	declare context: MyContextType;
	
	chengeUserType = (newType: string) => {
		// Accessing updateValue function from context
		this.context.updateValue(newType);
	}
	changeNavSection = (newType: string) => {
		// Accessing updateValue function from context
		this.context.updateValueMain(newType);
	}
  
	handleSubmitRegisterPlayer(event: any) {
		event.preventDefault();
		this.registerPlayer(event);
	}
	
	
	async registerPlayerApiCall(event: any){
		
		var registerPlayerURI:string = '/api/register';
		var registerPlayerEndPoint:string = Constants.dices_URL + registerPlayerURI;
		
		
		var name:string = event.target.name.value;
		var email:string = event.target.email.value;
		var password:string = event.target.password.value;
		var password_confirmation:string = event.target.password_confirmation.value;
		
		const response = await fetch( registerPlayerEndPoint, {
			method: 'POST',
			//mode: "no-cors", //Change the mode to cors
			body: JSON.stringify({
				name: name,
				email: email,
				password: password,
				password_confirmation: password_confirmation
			}),
			headers: {
				'Content-Type': 'application/json'
			}
		});
		
		return response;
	}
	
	
	async registerPlayer(event: any){
	
		console.log("Starting Register Player");
		
		let response  = await this.registerPlayerApiCall(event);
		console.log('I Am in registerPlayer Point 1');
		if(response.ok){

			console.log('I Am in registerPlayer Point 2');

			const result = await response.json();
			console.log('I Am in registerPlayer Point 2.2');
			//var jsonResponseBody = JSON.parse(result);
			var jsonResponseBody = result;
			
			console.log('I Am in registerPlayer Point 2.5');

			console.log("Token");
			console.log(jsonResponseBody['jwtoken']);
			console.log("UserID");
			console.log(jsonResponseBody['user_id']);
			
			console.log('I Am in registerPlayer Point 3');

			Functions.setCookie('token', jsonResponseBody['jwtoken'], 90); 
			Functions.setCookie('userid', jsonResponseBody['user_id'], 90); 
			Functions.setCookie('userName', jsonResponseBody['name'], 90); 
			Functions.setCookie('userRole', jsonResponseBody['role'], 90); 
			
			this.setPlayer();
		}else{
			alert('There was an error processing your registration. Either the name or the email are taken, or the passwords are not the same');
		}
	}
  
  
	handleSubmitRegisterAdmin(event: any) {
		event.preventDefault();
		this.registerAdmin(event);
	}
	
	async registerAdminApiCall(event: any){

		var registerAdminURI:string = '/api/registeradmin';
		var registerAdminEndPoint:string = Constants.dices_URL + registerAdminURI;

		var name:string = event.target.name.value;
		var email:string = event.target.email.value;
		var password:string = event.target.password.value;
		var password_confirmation:string = event.target.password_confirmation.value;

		
		const response = await fetch( registerAdminEndPoint, {
			method: 'POST',
			//mode: "no-cors", //Change the mode to cors
			body: JSON.stringify({
				name: name,
				email: email,
				password: password,
				password_confirmation: password_confirmation
			}),
			headers: {
				'Content-Type': 'application/json'
			}
			
		});
		
		return response;	
	}
	
	
  
	async registerAdmin(event: any){
	
		let response =  await this.registerAdminApiCall(event);
		
		if(response.ok){
			const result = await response.json();
			//var jsonResponseBody = JSON.parse(result);
			var jsonResponseBody = result;
			
			Functions.setCookie('token', jsonResponseBody['jwtoken'], 90); 
			Functions.setCookie('userid', jsonResponseBody['user_id'], 90); 
			Functions.setCookie('userName', jsonResponseBody['name'], 90); 
			Functions.setCookie('userRole', jsonResponseBody['role'], 90); 
			
			this.setAdmin();
		//ToDo Version 1 - PopUp When Response is no okay...
		}else{
			alert('There was an error processing your registration. Either the name or the email are taken, or the passwords are not the same');
		}
	}
	
	handleSubmitLogin(event: any) {
		event.preventDefault();
		this.login(event);
	}
	
	async loginApiCall(event: any){
			
		var loginURI:string = '/api/login';
		var loginEndPoint:string = Constants.dices_URL + loginURI;
		
		var email:string = event.target.email.value;
		var password:string = event.target.password.value;

		const response = await fetch( loginEndPoint, {
			method: 'POST',
			//mode: "no-cors", //Change the mode to cors
			body: JSON.stringify({
				email: email,
				password: password
			}),
			headers: {
				'Content-Type': 'application/json'
			}
			
		});
		
		return response;
		
		
	}
	
	async queryOnlyAdmin(){
		var token = Functions.getCookie('token');
		var listPlayersURI:string = '/api/players';
		var listPlayersEndPoint:string = Constants.dices_URL + listPlayersURI;
		
		const response = await fetch( listPlayersEndPoint, {
			method: 'GET',
			//mode: "no-cors", //Change the mode to cors
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token,
			}
			
		});
		return response;
	}
	//For future implementations...
	async queryPlayerAndAdmin(){
		var token = Functions.getCookie('token');
		var playerid = Functions.getCookie('userid');

		//var playerIDContext = this.context.playerID;
		var playerIDCookie = playerid;
		var playerURI:string = '/api/players/'+playerIDCookie+'/games';
		var playerEndPoint:string = Constants.dices_URL + playerURI;
		
		const response = await fetch( playerEndPoint, {
			method: 'GET',
			//mode: "no-cors", //Change the mode to cors
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token,
			}
		});
		return response;
	}
	
	async getRolesWorkAround(){
		let response = await this.queryOnlyAdmin();
		var role = null;
		if(response.ok){
			role = 'Admin';
		}else{
			role = 'Player';
		}
		return role;
		//Because no possible query not modifying data for player was found in the api...
		//Following block actually not possible
		/*
		response = await this.queryOnlyPlayer();
		if(response.ok){
			return 'Player';
		}*/
	}
	
	setAdmin(){
		this.chengeUserType('Admin');
		this.changeNavSection('Home');
	}
	
	setPlayer(){
		this.chengeUserType('Player');
		this.changeNavSection('Home');
	}
	
	
	async login(event: any){

		let response = await this.loginApiCall(event);
		
		if(response.ok){
			const jsonResponseBody = await response.json();

			Functions.setCookie('token', jsonResponseBody['jwtoken'], 90); 
			Functions.setCookie('userid', jsonResponseBody['user_id'], 90); 
			Functions.setCookie('userName', jsonResponseBody['name'], 90); 
			Functions.setCookie('userRole', jsonResponseBody['role'], 90); 
			
			let role = jsonResponseBody['role'];
			
			//OMG WORKAROUND TO CHECK ROLES...
			//let role = await this.getRolesWorkAround();
			//Set role for navigator
			switch(role){
				case 'admin':
					this.setAdmin();
					break;
				case 'player':
					this.setPlayer();
					break;
				default:
					break;
			}
			
		}else{
			alert('There was an error processing your Login. Either the name or the email are wrong.');
		}
	}
	
	//Check if user is already Logged In (Cookies Exists) and Set page:
	async componentDidMount(){
		//Check cookie token and userid
		var userID = Functions.getCookie('userid');
		var token = Functions.getCookie('token');
		var role = Functions.getCookie('userRole');
		
		if(userID != '' && token != ''){
			/*
			// Creating a custom event object
			var customEvent = {
				target: {
					email: { value: 'custom@example.com' },
					password: { value: 'customPassword123' }
				}
			};
			this.login({})*/
			
			//let role = await this.getRolesWorkAround();
			if(role == 'admin'){
				this.setAdmin();
			}else if(role == 'player'){
				var response = await this.queryPlayerAndAdmin();
				if(response.ok){
					this.setPlayer();
				}
			}
		}
	}
  
	render(){
		return (
			<div className="main_container">
				<div className="form_section">
					<h3>
						Login:
					</h3>
					<form id="login_form" className="form_user" onSubmit={this.handleSubmitLogin} >
						
						<label htmlFor="email">
							Email
						</label>
						<input type="email" name="email" required />
						<label htmlFor="password">
							Password
						</label>
						<input type="password" name="password" required />
						
						<input type="submit"  className="submitBttn" value="Submit"/>
					
					</form>			
				</div>
				
				
				<div className="form_section">
					<h3>
						Register as Player:
					</h3>
					<form id="register_player_form" className="form_user" onSubmit={this.handleSubmitRegisterPlayer}>
						<label htmlFor="email">
							Name
						</label>
						<input type="text" name="name" />
						
						<label htmlFor="email">
							Email
						</label>
						<input type="email" name="email" required />
						
						<label htmlFor="password">
							Password
						</label>
						<input type="password" name="password" required />
						
						<label htmlFor="password">
							Password Confirmation
						</label>
						<input type="password" name="password_confirmation" required />
						
						
						<input type="submit" className="submitBttn" value="Submit" />
					
					</form>			
				</div>
				
				
				<div className="form_section">
					<h3>
						Register as Administator:
					</h3>
					<form id="register_admin_form" className="form_user" onSubmit={this.handleSubmitRegisterAdmin}>
						
						<label htmlFor="email">
							Name
						</label>
						<input type="text" name="name" />
						
						<label htmlFor="email">
							Email
						</label>
						<input type="email" name="email" required />
						
						<label htmlFor="password">
							Password
						</label>
						<input type="password" name="password" required />
						
						<label htmlFor="password">
							Password Confirmation
						</label>
						<input type="password" name="password_confirmation" required/>
						
						<input type="submit"   className="submitBttn" value="Submit" />
					
					</form>			
				</div>
			</div>
		)
	}
}

