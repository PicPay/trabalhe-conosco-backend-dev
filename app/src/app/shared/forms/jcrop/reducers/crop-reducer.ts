import {CropActions} from "../actions/crop.actions";

const clone = require('clone')


const checkBadStoreId = (state, action)=> {
  return (state.storeId && !action.storeId) || (state.storeId && state.storeId != action.storeId)
};


export const defaultCropState = (storeId = null) => {
  return {
    selection: {
      x: null,
      y: null,
      w: null,
      h: null,
      x1: null,
      x2: null
    },
    change: {
      x: null,
      y: null,
      w: null,
      h: null,
      x1: null,
      x2: null
    },
    storeId: storeId
  }
};

export const cropReducer = (state = defaultCropState(), action) => {

  if (checkBadStoreId(state, action)) {
    return state
  }


  switch (action.type) {
    case CropActions.CROP_CHANGE:
      return Object.assign({}, state, {
        change: clone(action.crop)
      });

    case CropActions.CROP_SELECT:
    case CropActions.CROP_RANDOM_SELECTION:
      return Object.assign({}, state, {
        selection: clone(action.crop)
      });

    case CropActions.CROP_FIELD_CHANGE:
      const update = clone(state.selection);
      update[action.field] = action.value;
      return Object.assign({}, state, {
        selection: update
      });


    default:
      return state;
  }
}
