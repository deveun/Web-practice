import React, { Component } from 'react';

class PhoneForm extends Component {
	state = {
		name: '',
		phone: ''
	}
	handleChange = (e) => {
		this.setState({
			//(1)name: e.target.value
			//(2)Multiple input: using name property
			[e.target.name]: e.target.value
		});
	}
	handleSubmit = (e) => {
		//prevent submit event from deleting data state;
		e.preventDefault();
		this.props.onCreate(this.state);
		this.setState({
			name: '',
			phone: ''
		});
	}
	render() {
		return (
			<form onSubmit={this.handleSubmit}>
			Type name: <input placeholder="name" value={this.state.name}onChange={this.handleChange} name="name"/>

			Type phone: <input placeholder="phone" value={this.state.phone}	onChange={this.handleChange} name="phone"/>
			
			<div>Name: {this.state.name}, Phone: {this.state.phone}</div>
			<button type="submit">SUBMIT</button>
			</form>
			);
	}
}

export default PhoneForm;