import React, { Component } from 'react';

class NewComponent extends Component {
	static defaultProps = { 
		name: "Default_class"
	}
	render() {
		return (
			<div>
			This is React Example Component.
			This is <b>{this.props.name} type declaration.</b>
			</div>

			);
	}
}


//NewComponent.defaultProps = { name: 'ABC'};

export default NewComponent;