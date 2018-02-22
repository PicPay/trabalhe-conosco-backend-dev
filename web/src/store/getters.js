export const registerStatus = (state) => state.registerStatus;
export const registerFailureMessage =(state) => state.registerFailureMessage;

export const loginStatus = (state) => state.loginStatus;
export const loginFailureMessage =(state) => state.loginFailureMessage;

export const isLoggedIn = (state) => state.isLoggedIn;

export const usersList = (state) => state.usersList;
export const usersPage = (state) => state.usersMeta.page || 0;
export const usersTotalPages = (state) => state.usersMeta.total_pages || 0;
export const usersTotalCount = (state) => state.usersMeta.total_count || 0;
export const getUsersStatus = (state) => state.getUsersStatus;
export const getUsersFailureMessage = (state) => state.getUsersFailureMessage;
