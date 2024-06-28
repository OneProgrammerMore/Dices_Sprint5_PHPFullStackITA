import '../styles.css'
import React from 'react';


interface IProps {
	props?: any;
}
interface IState {
  jsonData?: any[];
  dataItems?: any[];
}

export default class FooterDiv extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);	
	}
	
	//ToDo - Version 2  - Add Links Footer And Sections
	
	render(){
		return (
			<footer>
				<div className="footerLink">
					Home
				</div>
				<div className="footerLink">
					About Us
				</div>
				<div className="footerLink">
					Contact
				</div>
				<div className="footerLink">
					Legal
				</div>
			
			</footer>
		)
	}
}
