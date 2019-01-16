import React, { Component } from 'react';
import './index.css'

class Square extends Component {
	//CLick Handler
	handleClick= () => {
		const {item, onMark} = this.props;
		if(!item.value)
			onMark(item.id);
	}

	render() {
		const {item} = this.props;
		return (
			<button className="square" onClick={this.handleClick}>
			{item.value}
			</button>
			);
	}
}

export default Square;