
import * as types from '../constants/actionTypes';

export const showMessage = (text, show, messageType) => ({
    type: types.SHOW_MESSAGE,
    message: { text, show, messageType }
})