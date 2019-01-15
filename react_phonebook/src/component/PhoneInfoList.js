import React, { Component } from 'react';
import PhoneInfo from './PhoneInfo';

class PhoneInfoList extends Component {
	static defaultProps = {
    data: [],
    onRemove: () => console.warn('onRemove not defined'),
    onUpdate: () => console.warn('onUpdate not defined')
  }

  //When return is true(==when next screen data has been changed), rerender component.
  shouldComponentUpdate(nextProps, nextState) {
    console.log("Check whether child component should be changed or not");
    return nextProps.data !== this.props.data;
  }

  render() {
    //When parent component has been changed(rerendering), also child component rerender *Virturally. (parent's rerendering -> child's rerendering) ==> USE SHOULDCOMPONENTUPDATE Function
    console.log("render PhoneInfoList");
    const { data, onRemove, onCreate, onUpdate } = this.props;
    /****MAP (NEED TO STUDY MORE!) ****/
    const list = data.map(
      info => (<PhoneInfo key={info.id} info={info} onRemove={onRemove} onCreate={onCreate} onUpdate={onUpdate}/>)
      );
    return (
      <div>
      {list}
      </div>
    );
  }
}

export default PhoneInfoList;