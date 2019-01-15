import React from 'react';

//***Class type Declaration
// class NewComponent2 extends Component {
// 	render() {		return (		);	}}

//*** Functional Declaration
const NewComponent2 = ({ name }) => {
	return (
		<div>
		Hello! I declared component using <b>{name}</b>;
	</div>
);
};

// Set Default properities
NewComponent2.defaultProps = {
	name: "Default_Funtional"
};

export default NewComponent2;