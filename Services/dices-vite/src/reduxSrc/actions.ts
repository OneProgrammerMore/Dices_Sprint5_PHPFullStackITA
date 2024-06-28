// actions.ts
export const UPDATE_VARIABLE = 'UPDATE_VARIABLE';

export const updateVariable = (newValue: any) => ({
  type: UPDATE_VARIABLE,
  payload: newValue,
});
