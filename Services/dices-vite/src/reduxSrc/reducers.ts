// reducers.ts
import { combineReducers } from 'redux';
import { UPDATE_VARIABLE } from './actions';

const initialState = {
  sharedVariable: null,
};

const sharedReducer = (state = initialState, action: any) => {
  switch (action.type) {
    case UPDATE_VARIABLE:
      return {
        ...state,
        sharedVariable: action.payload,
      };
    default:
      return state;
  }
};

const rootReducer = combineReducers({
  shared: sharedReducer,
});

export default rootReducer;
