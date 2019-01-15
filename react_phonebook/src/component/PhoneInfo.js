import React, { Component } from 'react';

class PhoneInfo extends Component {
	state = {
		//have to use these variables when modify data
		editing: false,
		name: '',
		phone: ''
	}
	static defaultProps = {
		info: {
			name: 'example',
			phone: '123-123',
			id: 0
		}
	}
	handleRemove = () => {
		const { info, onRemove } = this.props;
		onRemove(info.id);
	}
	handleToggleEdit = () => {
		const { editing } = this.state;
		this.setState({ editing: !editing });
	}
	//typing
	handleChange = (e) => {
		// const { name, value } = e.target;
		// this.setState({
		// 	[name]: value
		// });
		this.setState({
			[e.target.name]: e.target.value
		});
	}
	handleCancel = () => {
		const {info, onRemove } = this.props;
		const {editing} =this.state;
		this.setState({editing: !editing, name: info.name, phone: info.phone});
	}
	//automatically call.
	//call when 'editing' variable was changed.
	componentDidUpdate(prevProps, prevState) {
		const {info, onUpdate} = this.props;
		//pre-editing==false && cur-editing==true
		if(!prevState.editing && this.state.editing) {
			this.setState({
				name: info.name,
				phone: info.phone
			});
		}
		//pre-editing==true && cur-editing==false
		if(prevState.editing && !this.state.editing) {
			onUpdate(info.id, {
				name: this.state.name,
				phone: this.state.phone
			});
		}
	}

	//Render component only when 'info' has been changed && not editing data. 
	shouldComponentUpdate(nextProps, nextState) {
		if (!this.state.editing && !nextState.editing && nextProps.info === this.props.info) {
			return false;
		}
		return true;
	}

	render() {
		console.log("render PhoneInfo" + this.props.info.id);
		const style = {
			border: '1px solid blue',
			padding: '10px',
			margin: '5px'
		};

		const { editing } = this.state;
		if(editing) {
			return (
				<div style={style}>
				<div><input value={this.state.name} name="name" onChange={this.handleChange}/></div>
				<div><input value={this.state.phone} name="phone" onChange={this.handleChange}/></div>
				<button onClick={this.handleToggleEdit}>Confirm</button>
				<button onClick={this.handleCancel}>Cancel</button>
				</div>
				);
		}
		
	{/*get (info)props from parent object and render it.*/}
	const { name, phone } = this.props.info;
	return (
		<div style={style}>
		<div><b>{name}</b></div>
		<div>{phone}</div>
		<button onClick={this.handleRemove}>DELETE</button>
		<button onClick={this.handleToggleEdit}>UPDATE</button>
		</div>
		);
}
}

export default PhoneInfo;